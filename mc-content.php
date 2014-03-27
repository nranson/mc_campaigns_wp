<div>Alright!  You're in the right place to start building your campaign.  We've pulled in your site's RSS feed, automagically.</div>
<?php
$mcWP = get_option('mcWP');
function mcCampaign(){
	$mcWP = get_option('mcWP');
	if($_POST['subject_line'] && empty($_POST['content'])){
		?><div class="error">Uh oh.  We're missing some valueable stuff, here.  Make sure you've filled out the required area AND added content!</div><?
	};
	if($_POST['content']){
		try{
			include(plugin_dir_path( __FILE__ ).'/lib/Mailchimp.php');
			//$mcWP = get_option('mcWP');
			$content = str_replace("\\", "", html_entity_decode(implode("<br /><div style=\"clear:both;\" /><hr /></div><br />", $_POST['content']), ENT_NOQUOTES,'UTF-8'));

			$api = new Mailchimp($mcWP['apikey']);

			$type = 'regular';

			$opts['list_id'] = $_POST['list_id'];
			$opts['subject'] = $_POST['subject_line'];
			$opts['from_email'] = $_POST['from_email'];
			$opts['from_name'] = $_POST['from_name'];
			$opts['base_template_id'] = 12;
			$opts['tracking']=array('opens' => true, 'html_clicks' => true, 'text_clicks' => true);
			$opts['authenticate'] = true;
			$opts['generate_text'] = true;

			$mc_content = array(
					'sections' => array(
						'std_content00' => $content));

			$campaign = $api->campaigns->create($type, $opts, $mc_content);
			?><div class="success">Awesome!  We've created your campaign!  <a href="http://login.mailchimp.com" target="_blank">Log in</a> to your MailChimp account to make any final changes.</div><?
		}catch (Mailchimp_Error $e){
			if($e->getMessage()){
				?><div class="error"><?php echo $e->getMessage();?></div><?
			}
		}
	}
};

function mcWPfeed(){

	/*
	Hey there --

	If you're looking at this line, you are probably in need
	of some extra articles to include in your feed to test
	with.  If that's the case, you'll want to un-comment the
	first "$feed" variable below and comment out the second
	"$feed" variable with two forward slashes.  You can also
	replace the MailChimp blog with any URL you want to test
	with.

	Thanks for playing along!
	*/

	//$feed = 'http://blog.mailchimp.com/?feed=rss2';
	$feed = get_bloginfo_rss('rss_url');
	$open = simplexml_load_file($feed) or die("<div class=\"error\">Couldn't access your feed. Please check to make sure your feed is public.  If it is publicly accessible, make sure the feed also <a href=\"http://validator.w3.org/feed\">validates</a>.</div>");
	?><ul id="sortable1" class="connectedSortable" style="cursor:move;"><li></li><?
		foreach ($open->channel->item as $item){
			$title = '<h2 class="title"><a href="'.$item->link.'">'.$item->title.'</a></h2>';
			$pubdate = '<small><label class="label label-info">Published:</label> '.date("D M j g:i", strtotime($item->pubDate)).'</small><br />';
			$content = $item->children('http://purl.org/rss/1.0/modules/content/');
			$full = $title.$pubdate.$item->description;
			$encode = htmlentities($full, ENT_QUOTES | ENT_IGNORE, "UTF-8");
			echo '<li class="ui-state-default"><div class="item" style="display:block;clear:both;">'.$full;
			echo '<p><input checked type="hidden" name="content[]" value="'.$encode.'"></p><hr /></div></li>';
		};
	?></ul><?
};
?>
<div>
	<div style="max-width:50%;float:left;" id="content">
		<style>
		img {
			max-width:100%;
		}
		</style>
<?
mcCampaign();
mcWPfeed();?>
	</div>
	<div style="width:50%;float:right;">
		<h1>Campaign Content</h1>
		<strong>Settings</strong><small><a href="http://kb.mailchimp.com/article/how-do-i-change-the-subject-reply-to-address-and-from-name-on-my-signup-for#tips" target="_blank">[?]</a></small><br/>
		<form method="post" action="<? echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);?>&campaign=publish" accept-charset="UTF-8">
		<input type="text" placeholder="From Email" name="from_email" required><br />
		<input type="text" placeholder="From Name" name="from_name" required><br />
		<input type="text" placeholder="Subject Line" name="subject_line" required><br />
		<select name="list_id">
<?
foreach($mcWP['lists'] as $list){
	?>
			<option value="<?php echo $list['id']?>"><?php echo $list['name'];?></option><?
};?>
		</select>
		<br />
		<div>
			<small>Drag your content to this area.</small>
			<ul id="sortable2" class="connectedSortable" draggable="false" style="max-width:400px;overflow-y:scroll;max-height:500px;cursor:move;">
			<li></li>
			</ul>
		</div>
		<input type="submit">
		</form>
	</div>
	<div style="width:100%;clear:both;">
	</div>
</div>
