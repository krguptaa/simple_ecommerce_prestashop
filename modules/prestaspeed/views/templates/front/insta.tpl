{*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* No redistribute in other sites, or copy.
*
*  @author RSI <rsi_2004@hotmail.com>
*  @copyright  2007-2017 RSI
*}
{if $psversion > '1.6.50.0'}
{literal}
<script>
(function(){"use strict";var c=[],f={},a,e,d,b;if(!window.jQuery){a=function(g){c.push(g)};f.ready=function(g){a(g)};e=window.jQuery=window.$=function(g){if(typeof g=="function"){a(g)}return f};window.checkJQ=function(){if(!d()){b=setTimeout(checkJQ,100)}};b=setTimeout(checkJQ,100);d=function(){if(window.jQuery!==e){clearTimeout(b);var g=c.shift();while(g){jQuery(g);g=c.shift()}b=f=a=e=d=window.checkJQ=null;return true}return false}}})();
</script>
{/literal}
{/if}
{if $infi eq 1}
{if $psversion > "1.6.0.0"}
<script>
  $( document ).ready(function() {
        $('#list').removeClass('selected');
		$('#grid').addClass('selected');
    });
</script>
{/if}
{if $psversion < "1.7.0.0" and $page_name != "index" or $psversion < "1.7.0.0" and $page_name != "index.php"}
 {literal}
<script>
    $(document).ready(function(){
	infinite_scroll = {/literal}{$options|escape:'quotes':'UTF-8'}{literal};
	{/literal}{if isset($pages_nb)}{literal}
	infinite_scroll.maxPage = {/literal}{$pages_nb|escape:'htmlall':'UTF-8'}{literal};
	{/literal}{/if}{literal}
	jQuery( infinite_scroll.contentSelector ).infinitescroll( infinite_scroll, function(newElements, data, url) { eval(infinite_scroll.callback); });
	});
</script>
 {/literal}
{/if}
{if $psversion > "1.7.0.0" and $page_name != "index" or $psversion > "1.7.0.0" and $page_name != "index.php"}

{literal}
<script>
    $(document).ready(function(){
		
	infinite_scroll = {/literal}{$options nofilter}{literal};
	{/literal}{if isset($pages_nb)}{literal}
	infinite_scroll.maxPage = {/literal}{$pages_nb}{literal};
	{/literal}{/if}{literal}
	jQuery( infinite_scroll.contentSelector ).infinitescroll( infinite_scroll, function(newElements, data, url) { eval(infinite_scroll.callback); });
	});
</script>
 {/literal}

{/if}
{/if}


<!--
{if $psversion > "1.6.0.0"}
<script type="text/javascript">
$(document).ajaxComplete(function() {
	  
    
display('list');
			
	
		
    });
</script>
{/if}

-->



