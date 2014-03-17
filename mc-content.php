<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
  <script>
    $(function() {
    $( "#sortable1, #sortable2" ).sortable({
      connectWith: ".connectedSortable"
    }).disableSelection();
  });
  </script>
<div style="background-color:#52BAD5;color:white;max-width:60%">Alright!  You're in the right place to start building your campaign.  We've pulled in your site's RSS campaign automagically.  From here, drag the article summaries you want to the green area to the right.  Don't worry, that background color won't come through to your campaign.</div>

<?php
$mcWP = get_option('mcWP');
function mcCampaign(){
	$mcWP = get_option('mcWP');
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
		}catch (Mailchimp_Error $e){
		    if($e->getMessage()){
	            ?><div class="error"><?php echo $e->getMessage();?></div><?
            }
        }
	}
};

function mcWPfeed(){
	$feed = 'http://blog.mailchimp.com/?feed=rss2';
	//$feed = get_bloginfo_rss('rss_url');
	$open = simplexml_load_file($feed) or die("<div class=\"error\">Couldn't access your feed. Please check to make sure your feed is public.  If it is publicly accessible, make sure the feed also <a href=\"http://validator.w3.org/feed\">validates</a>.</div>");
	?><ul id="sortable1" class="connectedSortable"><li></li><?
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
		<strong>Settings</strong><small><a href="http://kb.mailchimp.com/article/how-do-i-change-the-subject-reply-to-address-and-from-name-on-my-signup-for#tips">[?]</a></small><br/>
		<form method="post" action="<? echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);?>&campaign=publish" accept-charset="UTF-8">
			<input type="text" placeholder="From Email" name="from_email"><br />
			<input type="text" placeholder="From Name" name="from_name"><br />
   			<input type="text" placeholder="Subject Line" name="subject_line"><br />
   			<select name="list_id">
				<?
				foreach($mcWP['lists'] as $list){
					?><option value="<?php echo $list['id']?>"><?php echo $list['name'];?></option><?
				};?></select><br />
        <div style="background-color:#C5E5DE;max-width:400px;padding:20px;border-radius:10px;">
          <small>Drag your content to this area.</small>
    			<ul id="sortable2" class="connectedSortable" draggable="false" style="max-width:400px;overflow-y:scroll;max-height:500px;">
    			     <li></li>
    			</ul>
        </div>
  			<input type="submit">
     	</form>
  	</div>
<div style="width:100%;clear:both;">
</div>
</div>
