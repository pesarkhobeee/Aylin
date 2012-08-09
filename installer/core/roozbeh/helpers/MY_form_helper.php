<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * Parse out the attributes
 *
 * Some of the functions use this
 *
 * @access	private
 * @param	array
 * @param	bool
 * @return	string
 */
if ( ! function_exists('_parse_attributes'))
{
	function _parse_attributes($attributes, $javascript = FALSE)
	{
		if (is_string($attributes))
		{
			return ($attributes != '') ? ' '.$attributes : '';
		}

		$att = '';
		foreach ($attributes as $key => $val)
		{
			if ($javascript == TRUE)
			{
				$att .= $key . '=' . $val . ',';
			}
			else
			{
				$att .= ' ' . $key . '="' . $val . '"';
			}
		}

		if ($javascript == TRUE AND $att != '')
		{
			$att = substr($att, 0, -1);
		}

		return $att;
	}
}


if ( ! function_exists('form_numeric_input'))
{
	function form_numeric_input($data = '', $value = '', $extra = '')
	{
		$data['class'] = 'numeric';
		$data['onkeypress'] = 'return isNumberKey(event)';
		return form_input($data, $value, $extra);
	}
	
}


if ( ! function_exists('form_ltr_input'))
{
	function form_ltr_input($data = '', $value = '', $extra = '')
	{
		$data['class'] = 'ltr-text';
		return form_input($data, $value, $extra);
	}
	
}


if ( ! function_exists('form_user_id'))
{
	function form_user_id($data = '', $value = '', $extra = '')
	{
	$CI =& get_instance();
	$value = $CI->session->userdata('id');
	//$value = $_session['user_id'];
	$controler = form_hidden($data,$value);

		return $controler;
	}
	
}

if ( ! function_exists('form_upload'))
{
	function form_upload($data = '', $value = '', $extra = '')
	{
	
	$controler = form_input($data, $value, $extra);
		$temp='
	<input type="button" value="ارسال عکس" onclick=\'var temp = window.open("'.base_url().'index.php/aylin/upload/false","mywindow","menubar=1,resizable=1,width=350,height=650");\' />
		';
		return $temp.$controler;
	}
}

if ( ! function_exists('form_password'))
{
	function form_password($data = '', $value = '', $extra = '')
	{
		if ( ! is_array($data))
		{
			$data = array('name' => $data);
		}

		$data['type'] = 'password';
		if(!isset($data['class']))
			$data['class'] = 'ltr-text';
		return form_input($data, $value, $extra);
	}
}


if ( ! function_exists('form_jalali_date_input'))
{
	function form_jalali_date_input($data = '', $value = '', $extra = ''){
		$date_input = "\n";
		
		$data['class'] = 'jdate-entry';
		
		$date_input .= '<div class="jdate-box">';
		$date_input .= "\t".form_input($data, $value, $extra)."\n";
		$date_input .= "\t".'<input type="image" id="'.$data['id'].'-btn" name="'.$data['name'].'-btn" src="'.base_url().'assets/img/calendar.png" style="width:25px" class="jdate-image" />'."\n";
		$date_input .= '</div>';
		
		$date_input .= '<script type="text/javascript">'."\n";
		$date_input .= "\t".'Calendar.setup({'."\n";
		$date_input .= "\t".'inputField	:	"'.$data['id'].'",   // id of the input field'."\n";
		$date_input .= "\t".'button		:	"'.$data['id'].'-btn",   // trigger for the calendar (button ID)'."\n";
		$date_input .= "\t".'ifFormat	:	"%Y-%m-%d",       // format of the input field'."\n";
		$date_input .= "\t".'dateType	:	"jalali",'."\n";
		$date_input .= "\t".'weekNumbers	: 	false'."\n";
		$date_input .= "\t".'});'."\n";
		$date_input .= '</script>'."\n";
		
		return $date_input;
	}
	
}

if ( ! function_exists('form_fk_dropdown'))
{
	function form_fk_dropdown($name = '', $options = array(), $selected = array(), $extra = '', $page_link = ''){
		$fk_dropdown = "\n";
		
		$extra .= ' '.'class="fk-dropdown"';
		
		$fk_dropdown .= '<div>';
		$fk_dropdown .= '<div class="fk-dropdown-box">';
		$fk_dropdown .= "\t".form_dropdown($name, $options, $selected , $extra)."\n";
		$fk_dropdown .= '</div>';
		$fk_dropdown .= anchor($page_link,
								'<span>'.img(array('src' => base_url().'styles/images/add.png','class' => 'fk-dropdown-image')).'</span>');
		$fk_dropdown .= '</div>';
				
		return $fk_dropdown;
	}
	
}

if ( ! function_exists('form_tinymce_editor'))
{
	function form_tinymce_editor($data = '', $value = '', $extra = ''){
		$tinymce = "\n";
				
		$tinymce .= form_textarea($data, $value, $extra)."\n";
		$tinymce .= '<script type="text/javascript">'."\n";
		$tinymce .= 'tinyMCE.init({'."\n";
		$tinymce .= 'plugins : "style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,"+ '."\n";
		$tinymce .= '"searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",'."\n";
		$tinymce .= 'themes : "simple,advanced",'."\n";
		$tinymce .= 'mode : "exact",'."\n";
		$tinymce .= 'elements : "'.$data['id'].'",'."\n";
		$tinymce .= 'theme : "advanced",'."\n";
		$tinymce .= '// Theme options'."\n";
		$tinymce .= 'theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",'."\n";
		$tinymce .= 'theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",'."\n";
		$tinymce .= 'theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",'."\n";
		$tinymce .= 'theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",'."\n";
		$tinymce .= 'theme_advanced_toolbar_location : "top",'."\n";
		$tinymce .= 'theme_advanced_toolbar_align : "right",'."\n";
		$tinymce .= 'theme_advanced_statusbar_location : "bottom",'."\n";
		$tinymce .= 'theme_advanced_resizing : true,'."\n";
		$tinymce .= 'directionality: "rtl"'."\n";
		$tinymce .= '});'."\n";
		$tinymce .= '</script>'."\n";
		
		return $tinymce;
	}
	
}

if ( ! function_exists('form_label'))
{
	function form_label($label_text = '', $id = '', $attributes = array())
	{

		$label = '<label';

		if ($id != '')
		{
			 $label .= " for=\"$id\"";
		}

		$label .= _parse_attributes($attributes);

		$label .= ">$label_text</label>";

		return $label;
	}
}


/* End of file MY_form_helper.php */
/* Location: ./system/application/helpers/MY_form_helper.php */
