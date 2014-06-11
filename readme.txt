=== MailChimp Campaign Builder for WordPress ===
Contributors: mc_nate
Tags: MailChimp, MailChimp campaigns, email, drag and drop, mailchimp templates
Requires at least: 3.8
Tested up to: 3.9
Stable tag: 1.02
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create MailChimp campaigns out of your WordPress posts by dragging and dropping individual posts.

== Description ==

MailChimp Campaigns pulls the descriptions from your WordPress's RSS feed and lets you drag them into a MailChimp campaign.  You can configure the list, campaign settings, and drag/drop to rearrange the content within your WordPress dashboard.  MailChimp Campaigns then builds the campaign right within your MailChimp account.  You can navigate back to MailChimp to add the finishing touches to your content, modify your template, or add some extra images before you send.
== Installation ==

1. Upload `mailchimp-campaigns` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Connect your MailChimp account in *Settings > MailChimp Campaigns*.

== Frequently Asked Questions ==

= Where can I find my MailChimp API Key? =

From your MailChimp dashboard:

* Click your profile name to expand the Account Panel and choose Account Settings.
* Click the Extras menu and choose API keys.
* Copy an existing API key or click the Create A Key button.
* Label your key to keep your keys organized.

[Where can I find my API Key?](http://kb.mailchimp.com/article/where-can-i-find-my-api-key)

= Does MailChimp Campaigns actually *send* campaigns from WordPress? =

MailChimp Campaigns does not send any campaigns.  It just builds a skeleton campaign out of your WordPress posts.  To send the campaign, you'll have to log in to your MailChimp account to edit your final draft.

== Screenshots ==

1. Connect with your MailChimp API Key.
2. Drag and drop WordPress items into a MailChimp campaign.

== Changelog ==
= 1.01 =
* Thanks to our rad QA team, I fixed a host of issues.
* Added clearer success/error messaging on campaign building step.
* Fixed required fields for campaign builder.
* Added cursor CSS to make it clear what's drag/drop-able.
* Added a way to refresh lists on the Setup without having to disconnect/reconnect.

= 1.0 =
* Initial release of MailChimp Campaigns for WordPress.
