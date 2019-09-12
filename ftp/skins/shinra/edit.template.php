<?php defined("NET2FTP") or die("Direct access to this location is not allowed."); ?>
<style>
.btn {
  display: inline-block;
  margin-bottom: 0;
  font-weight: 400;
  text-align: center;
  vertical-align: middle;
  cursor: pointer;
  background-image: none;
  border: 1px solid transparent;
  white-space: nowrap;
  padding: 6px 12px;
  font-size: 14px;
  line-height: 1.428571429;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  -o-user-select: none;
  user-select: none;
}
.btn-primary, .btn-primary:focus, .btn-hover-primary:hover, .btn-hover-primary:active, .btn-hover-primary.active, .btn.btn-active-primary:active, .btn.btn-active-primary.active, .dropdown.open>.btn.btn-active-primary, .btn-group.open .dropdown-toggle.btn.btn-active-primary {
  background-color: #579ddb;
  border-color: #5fa2dd;
  color: #fff;
}
</style>
<link rel="stylesheet" type="text/css" href="/application/public/assets/global/plugins/bootstrap-toastr/toastr.min.css">
	<script src="/application/public/assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
	<script src="/application/public/assets/admin/pages/scripts/ui-toastr.js"></script>
<!-- Template /skins/shinra/edit.template.php begin -->

<form id="<?php echo $formname; ?>" action="" method="post">
<?php	printLoginInfo(); ?>
<input type="hidden" name="state"        value="edit" />
<input type="hidden" name="state2"       value="" />
<input type="hidden" name="directory"    value="<?php echo $net2ftp_globals["directory_html"]; ?>" />
<input type="hidden" name="screen"       value="2" />
<input type="hidden" name="textareaType" value="<?php echo $textareaType; ?>" />
<table style="padding: 2px; width: 97%; height: 100%; border: 0px;">

	<tr>
		<td colspan="3" style="vertical-align: top; text-align: <?php echo __("left"); ?>;">
			<div style="margin-<?php echo __("left"); ?>: 0px; text-align: <?php echo __("left"); ?>;">
<?php /* ----- Plain textarea ----- */ ?>
<?php 		if ($textareaType == "" || $textareaType == "plain") { ?>
<?php // Do not use style="white-space: nowrap;" because then IE strips the carriage-return + linefeeds (tested on IE version 6.0) ?>
				<textarea name="text" class="edit" rows="33" style="color: #FFF;
background-color: #121921;
font-family: Inconsolata;width: 100%; height: 400px;margin-bottom: 10px;" wrap="off" onkeydown="TabText()"><?php echo $text ?></textarea>
<?php 		} 
	/* ----- CKEditor or TinyMCE ----- */
			elseif ($textareaType == "ckeditor" || $textareaType == "tinymce") { ?>
				<div id="header_hidden"></div>
				<div id="header_shown" style="display: none;"><textarea name="text_splitted[top]" style="width: 100%; height: 200px;"><?php echo $text_splitted["top"]; ?></textarea></div>

				<div id="body_hidden"></div>
				<div id="body_shown" style="display: block;"><textarea cols="120" rows="35" id="text_splitted[middle]" name="text_splitted[middle]"><?php echo $text_splitted["middle"]; ?></textarea></div>

				<div id="footer_hidden"></div>
				<div id="footer_shown" style="display: none;"><textarea name="text_splitted[bottom]" style="width: 100%; height: 200px;"><?php echo $text_splitted["bottom"]; ?></textarea></div>
<?php			}
	/* ----- Ace ----- */
			elseif ($textareaType == "ace") { ?>
				<input type="hidden" name="text" value="" />
				<div id="editor" name="text"><?php echo $text; ?></div>
				<script type="text/javascript">
					var editor = ace.edit("editor");
					editor.setTheme("ace/theme/<?php echo $ace_theme; ?>");
					editor.getSession().setMode("ace/mode/<?php echo $ace_mode; ?>");
				</script>
<?php 		} ?>
			</div>
		</td>
	</tr>
		<tr color="#c3c3c3">
		<td style="vertical-align: top; text-align: <?php echo __("left"); ?>; width: 25%;">
		<button onClick="document.forms['<?=$formname?>'].screen.value=3; " class="btn btn-primary">Сохранить</button>
		</td> 

	</tr>
</table>
</form>
						  <script type="text/javascript">
$(function(){
$('#<?=$formname?>').submit(function(e){
//отменяем стандартное действие при отправке формы
e.preventDefault();
//берем из формы метод передачи данных
var m_method=$(this).attr('method');
//получаем адрес скрипта на сервере, куда нужно отправить форму
var m_action=$(this).attr('action');
//получаем данные, введенные пользователем в формате input1=value1&input2=value2...,то есть в стандартном формате передачи данных формы
var m_data=$(this).serialize();
$.ajax({
type: m_method,
url: m_action,
data: m_data,
success: function(result){
$('#status').html(result);
toastr.success('</b> Конфиг успешно сохранен!');
}
});
});
});
</script>
<!-- Template /skins/shinra/edit.template.php end -->
