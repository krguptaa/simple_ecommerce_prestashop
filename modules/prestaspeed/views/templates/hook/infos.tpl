{*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* No redistribute in other sites, or copy.
*
*  @author RSI <rsi_2004>
*  @copyright  2007-2017 RSI
*} 
<div class="bootstrap panel">
	<div class="panel-heading">
		<i class="icon-trash-o"></i> {l s='Automatic clean:' mod='prestaspeed'}
	</div>
     {l s='Ask your hosting provider to setup a "Cron task" to load the following URL at the time you would like:' mod='prestaspeed'}
	<a href="{$prestaspeed_cron|escape:'htmlall':'UTF-8'}" target="_blank">{$prestaspeed_cron|escape:'htmlall':'UTF-8'}</a><br /><br />
    {l s='You can use the free Prestashop module Cron tasks manager.Just enable it and configure the url and time' mod='prestaspeed'}
    </div>
    
    <div class="panel">
<div class="panel-heading">
		<i class="icon-info"></i> {l s='Video' mod='prestaspeed'} 
     
	</div>
<iframe width="640" height="360" src="https://www.youtube.com/embed/XBpPmdjg2O0?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe></div>