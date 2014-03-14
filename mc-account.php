
<div class="content">
	<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<input type="text" name="mcapi" placeholder="MailChimp API Key" required>
		<input type="submit" class="">
	</form>
</div>