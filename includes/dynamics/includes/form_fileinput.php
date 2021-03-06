<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) PHP-Fusion Inc
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: form_fileinput.php
| Author: Frederick MC CHan (Hien)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
/* http://gregpike.net/demos/bootstrap-file-input/demo.html*/
function form_fileinput($title = FALSE, $input_name, $input_id, $upload_path, $input_value = FALSE, $options = FALSE) {
	global $locale;
	$title = (isset($title) && (!empty($title))) ? stripinput($title) : "";
	$title2 = (isset($title) && (!empty($title))) ? stripinput($title) : ucfirst(strtolower(str_replace("_", " ", $input_name)));
	$input_name = (isset($input_name) && (!empty($input_name))) ? stripinput($input_name) : "";

	if (!defined('form_fileinput')) {
		add_to_head("<link href='".DYNAMICS."assets/fileinput/css/fileinput.min.css' media='all' rel='stylesheet' type='text/css' />");
		add_to_footer("<script src='".DYNAMICS."assets/fileinput/js/fileinput.min.js' type='text/javascript'></script>");
		define('form_fileinput', TRUE);
	}

	if (!is_array($options)) {
		$required = 0;
		$safemode = 1;
		$deactivate = '';
		$width = '';
		$label = $locale['browse'];
		$btn_class = 'btn-default';
		$class = '';
		$error_text = '';
		$inline = '';
		$url = '';
		$type = 'all';
		$thumbnail = '';
		$thumbnail_db = '';
	} else {
		$deactivate = isset($options['deactivate']) && $options['deactivate'] == 1 ? $options['deactivate'] : '';
		$label = isset($options['label']) && $options['label'] ? $options['label'] : $locale['browse'];
		$btn_class = isset($options['btn_class']) && $options['btn_class'] ? $options['btn_class'] : 'btn-default';
		$class = isset($options['class']) && $options['class'] ? $options['class'] : "";
		$required = isset($options['required']) && $options['required'] == 1 ? 1 : 0;
		$safemode = isset($options['safemode']) && $options['safemode'] == 1 ? 1 : 0; // we also use SAFEMODE. - maybe increment on this later.
		$width = isset($options['width']) && $options['width'] ? $options['width'] : "";
		$error_text = isset($options['error_text']) && $options['error_text'] ? $options['error_text'] : "";
		$inline = isset($options['inline']) && $options['inline'] == 1 ? 1 : 0;
		$url = isset($options['url']) && $options['url'] ? $options['url'] : ''; // for ajax uplaod file path when used with form_sanitizer();
		$type = 'all';
		if (isset($options['image']) && $options['image'] == 1) {
			$type = 'image';
		} // can add type here with elseif like video upload etc.
		$thumbnail = isset($options['thumbnail_path']) && $options['thumbnail_path'] ? $options['thumbnail_path'] : '';
		$thumbnail_db = isset($options['thumbnail_db']) && $options['thumbnail_db'] ? $options['thumbnail_db'] : ''; // not yet supported to auto name thumbnail folder
	}

	$html = "<div id='$input_id-field' class='form-group clearfix m-b-10 $class'>\n";
	$html .= ($title) ? "<label class='control-label ".($inline ? "col-xs-12 col-sm-3 col-md-3 col-lg-3 p-l-0" : '')."' for='$input_id'>$title ".($required == 1 ? "<span class='required'>*</span>" : '')."</label>\n" : '';
	$html .= ($inline) ? "<div class='col-xs-12 col-sm-12 col-md-6 col-lg-6'>\n" : "";
	$html .= "<input type='file' name='".$input_name."' id='".$input_id."' class='file-preview-image' ".($deactivate ? 'readonly' : '')." />\n";
	$html .= "<div id='$input_id-help'></div>";
	$html .= ($inline) ? "</div>\n" : "";
	$html .= "</div>\n";
	$html .= "<input type='hidden' name='def[$input_name]' value='[type=$type],[title=$title2],[id=$input_id],[required=$required],[safemode=$safemode],[path=$upload_path],[thumbnail=$thumbnail],[thumbnail_db=$thumbnail_db]".($error_text ? ",[error_text=$error_text]" : '')."' readonly>\n";

	add_to_jquery("
        $('#".$input_id."').fileinput({
        previewFileType: 'any',
        browseClass: 'btn $btn_class button',
        uploadClass: 'btn btn-default button',
        captionClass : '',
        removeClass : 'btn btn-default button',
        browseLabel: '$label',
        browseIcon: '<i class=\"entypo upload-cloud m-r-10\"></i>',
        ".($url ? "uploadUrl : '$url'," : '')."
        ".($url ? '' : 'showUpload: false')."
        });
    ");
	return $html;
}
?>