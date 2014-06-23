<?php
/**
 * Plugin Name: DFP Mediatrends - newhustlemedia.com
 * Plugin URI: http://mediatrends.cl
 * Description: Personalizacion de ads
 * Version: 1.0
 * Author: Mediatrends
 * Author URI: http://mediatrends.cl
 */

// Define current version constant
define( 'EXT-ADS', '0.1' );

add_action('wp_head', 'head_setup_mt');

function head_setup_mt() {
?>
	<script type='text/javascript'>
	var googletag = googletag || {};
	googletag.cmd = googletag.cmd || [];
	(function() {
	var gads = document.createElement('script');
	gads.async = true;
	gads.type = 'text/javascript';
	var useSSL = 'https:' == document.location.protocol;
	gads.src = (useSSL ? 'https:' : 'http:') + 
	'//www.googletagservices.com/tag/js/gpt.js';
	var node = document.getElementsByTagName('script')[0];
	node.parentNode.insertBefore(gads, node);
	})();
	</script>

	<script type='text/javascript'>
	googletag.cmd.push(function() {
	googletag.defineSlot('/20099485/Chic_INX_content', [728,90], 'zona-78070005').addService(googletag.pubads());googletag.defineSlot('/20099485/Chic_INX_sidebar', [300,250], 'zona-78070125').addService(googletag.pubads());
	googletag.pubads().enableSingleRequest();
	googletag.enableServices();
	});
	</script>
	<script type='text/javascript'>
	// Only do anything if jQuery isn't defined
	if (typeof jQuery == 'undefined') {
		if (typeof $ == 'function') {
			// warning, global var
			thisPageUsingOtherJSLibrary = true;
		}
		
		function getScript(url, success) {
			var script = document.createElement('script');
				script.src = url;
			var head = document.getElementsByTagName('head')[0],
			done = false;
			// Attach handlers for all browsers
			script.onload = script.onreadystatechange = function() {
				if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) {
					done = true;
					// callback function provided as param
					success();
					script.onload = script.onreadystatechange = null;
					head.removeChild(script);
				};
			};
			head.appendChild(script);
		};
		
		getScript('http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', function() {
			if (typeof jQuery=='undefined') {
				alert("Fail load jQuery");
			} else {
				loadAds();
			}
		});
	} else { // jQuery was already loaded
		loadAds();
	};
	function loadAds() {
		jQuery(document).ready(function(){
			var zona78070005 = '<div id="zona-78070005" style="width:728px; height:90px;"><script type="text/javascript">googletag.cmd.push(function() { googletag.display("zona-78070005"); });</scr'+'ipt></div>';
if (jQuery("#sidebar_dfp").length > 0) { jQuery("#sidebar_dfp").empty().html(zona78070005); }var zona78070125 = '<div id="zona-78070125" style="width:300px; height:250px;"><script type="text/javascript">googletag.cmd.push(function() { googletag.display("zona-78070125"); });</scr'+'ipt></div>';
if (jQuery("#footer_dfp").length > 0) { jQuery("#footer_dfp").empty().html(zona78070125); }
		});
	}
	</script>
<?php
}