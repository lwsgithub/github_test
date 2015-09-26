<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content" class="login_bg"><?php echo $content_top; ?>
<div class="breadcrumb"><?php foreach ($breadcrumbs as $breadcrumb) { ?>
<?php echo $breadcrumb['separator']; ?><a
	href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
<?php } ?></div>
<!--<h1><?php echo $heading_title; ?>ss</h1>
--><?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?> <?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="login-content">
<div class="left" >
<!--<h2><?php echo $text_new_customer; ?></h2>
--><div>
<!--<p><?php echo $text_register_account; ?></p>
<a href="<?php echo $register; ?>" class="button"><span><?php echo $button_register; ?>zz</span></a>-->
</div>
</div>
<div class="right" >
<!--<fieldset style="background-color:#f5f5f5; border:1px solid #e5e5e5;"><legend>
--><h2 style="color:#dd4b39;"><?php echo $text_returning_customer; ?></h2>
<!--</legend>
--><form action="<?php echo $action; ?>" method="post"
	enctype="multipart/form-data" id="login">
<div style="width:361px; margin:0; padding:0 10% 0 0; text-align:right;">
<b><?php echo $entry_email; ?></b>
<input type="text" name="email" value="" style="width:300px;" /><br />
<br />
<b><?php echo $entry_password; ?></b>
<input type="password" name="password" value="" style="width:300px;" /><br />

<a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
<br />
<div style="text-align:right;">
<a onclick="$('#login').submit();"  class="button login_bbg"><span><?php echo $button_login; ?></span></a><!-- <a href="<?php echo $register; ?>" class="button login_bbg"><span><?php //echo $button_register; ?></span></a> -->
</div>
<?php if ($redirect) { ?> <input type="hidden" name="redirect"
	value="<?php echo $redirect; ?>" /> <?php } ?></div>
</form>
<!--</fieldset>
--></div>
</div>
<?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('#login input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#login').submit();
	}
});
//--></script>
<?php echo $footer; ?>