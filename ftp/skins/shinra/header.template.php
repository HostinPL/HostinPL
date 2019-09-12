<?php defined("NET2FTP") or die("Direct access to this location is not allowed."); ?>
<!-- Template /skins/shinra/header.template.php begin -->

	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- ENDS HEADER -->
			
		<!-- MAIN -->
		<div id="main">

			<!-- content -->
			<div id="content">
				
				<!-- title -->

					<div style="text-align: right; margin-top: 10px;">
						<form id="StatusbarForm" method="post" action="<?php echo $net2ftp_globals["action_url"]; ?>">
<?php						printLoginInfo(); ?>
						<input type="hidden" name="state"         value="browse" />
						<input type="hidden" name="state2"        value="main" />
						<input type="hidden" name="directory"     value="<?php echo $net2ftp_globals["directory_html"]; ?>" />
						<input type="hidden" name="url_withpw"    value="<?php echo printPHP_SELF("bookmark_withpw"); ?>" />
						<input type="hidden" name="url_withoutpw" value="<?php echo printPHP_SELF("bookmark_withoutpw"); ?>" />
						<input type="hidden" name="text"          value="net2ftp <?php echo $net2ftp_globals["ftpserver"]; ?>" />
						</form>

				</div>
				<!-- ENDS title -->

<!-- Template /skins/shinra/header.template.php end -->
