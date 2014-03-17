<?php
$mcWP = get_option('mcWP');
function mcWPcontent(){
	$mcWP = get_option('mcWP');
	if(empty($mcWP['apikey'])){
		include(plugin_dir_path( __FILE__ ).'/mc-account.php');
	} else {
		include(plugin_dir_path( __FILE__ ).'/mc-connected.php');
	}
};

?>

<div class="wrap">
<?php

if($_POST['clear']){
	delete_option('mcWP');
}elseif($_POST['mcapi']){
	include(plugin_dir_path( __FILE__ ).'/lib/Mailchimp.php');
	$mc_apikey = trim(strip_tags($_POST['mcapi']));
	try{
		$api = new Mailchimp($mc_apikey);
		$lists = $api->lists->getList();
		foreach($lists['data'] as $list){
			$options['lists'][] = array(
				'id' => $list['id'],
				'name' => $list['name'],
				'count' => $list['stats']['member_count']);
		}
		$options['apikey'] = $mc_apikey;
		$options['content'] == false;
		update_option('mcWP', $options);
	}
	catch(Mailchimp_Error $e){
		if($e->getMessage()){
			?><div class="error"><?php echo $e->getMessage();?></div><?
			delete_option('mcWP');
		}
	}
};
if($_POST['full']){
	$options['content'] = true;
	update_option('mcWP', $options);
}elseif($_POST['desc']){
	$options['content'] = false;
	update_option('mcWP', $options);
};

mcWPcontent();
