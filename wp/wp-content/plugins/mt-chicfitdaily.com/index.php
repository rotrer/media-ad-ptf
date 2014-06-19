<?php
/**
 * Plugin Name: DFP Mediatrends - chicfitdaily.com
 * Plugin URI: http://mediatrends.cl
 * Description: Personalización de ads
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
	googletag.defineSlot('/20099485/Chic_INX_header', [728, 90], 'zona1-ad').addService(googletag.pubads());
	googletag.defineSlot('/20099485/Chic_INX_sidebar', [300, 250], 'zona2-ad').addService(googletag.pubads());
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
				// jQuery loaded! Make sure to use .noConflict just in case
				// fancyCode();
				// if (thisPageUsingOtherJSLibrary) {
				// 	// Run your jQuery Code
				// } else {
				// 	// Use .noConflict(), then run your jQuery Code
				// }
			}
		});
	} else { // jQuery was already loaded
		loadAds();
	};
	function loadAds() {
		var zona1 = '<!-- Chic_INX_header --><div id="zona1-ad" style="width:728px; height:90px;"><script type="text/javascript">googletag.cmd.push(function() { googletag.display("zona1-ad"); });</scr'+'ipt></div>';
		var zona2 = '<!-- Chic_INX_sidebar --><div id="zona2-ad" style="width:300px; height:250px;"><script type="text/javascript">googletag.cmd.push(function() { googletag.display("zona2-ad"); });</scr'+'ipt></div>';
		jQuery(document).ready(function(){
			if (jQuery("#zona1").length > 0) { jQuery("#zona1").empty().html(zona1); }
			if (jQuery("#zona2").length > 0) { jQuery("#zona2").empty().html(zona2); }
		});
	}
	</script>
<?php
}