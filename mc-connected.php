<?php
function mcWPclear(){
	?>
	<div>
		<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
			<input type="hidden" name="clear" value="Y">
			<input type="submit" value="<?php echo __('Disconnect MailChimp', 'mcWP');?>">
		</form>
	</div>
	<?
};
function mcWPstats(){
	$mcWP = get_option('mcWP');
	?><h1>You're connected.</h1>
	<div>Awesome!  We're able to connect with your MailChimp account.  Just to serve as proof, here's some lists that we pulled in as evidence.</div>
	<table style="width:60%;">
		<tr style="background-color:#52BAD5;color:white;">
			<th>List Name</th><th>Number of Subscribers</th>
		</tr>
		<?
	foreach($mcWP['lists'] as $list){
		?><tr><td><?echo $list['name'];?></td><td style="text-align:center;"><?echo $list['count'];?></td></tr><?
	}
	?>
</table>
<br />
<div>To start building campaigns from your WordPress posts, navigate to the "Posts" tab from the admin panel. From there, click "Build New Campaign."</div><br /><br />
<?
};
mcWPstats();
mcWPclear();
