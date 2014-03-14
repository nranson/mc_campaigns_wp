<?php
function mcWPclear(){
	?>
	<div>
		<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
			<input type="hidden" name="clear" value="Y">
			<input type="submit" value="<?php echo __('Clear API Key', 'mcWP');?>">
		</form>
	</div>
	<?
};
function mcWPstats(){
	$mcWP = get_option('mcWP');
	?><h1>You're connected.</h1><?
	foreach($mcWP['lists'] as $list){
		echo $list['name']."<br />";
	}
	?></ul></td>
</tr>
</table><?
};
mcWPstats();
mcWPclear();