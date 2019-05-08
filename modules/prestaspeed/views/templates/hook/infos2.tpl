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
{literal}
	<script>
		var bar = $('span');
var p = $('p');

var width = bar.attr('style');
//width = width.replace("width:", "");
//width = width.substr(0, width.length-1);


var interval;
var start = 0; 
var end = parseInt(width);
var current = start;

var countUp = function() {
  current++;
  p.html(current + "%");
  
  if (current === end) {
    clearInterval(interval);
  }
};

interval = setInterval(countUp, (1000 / (end + 1)));
	</script>
	
	<style type="text/css">
div.meter {
  position: relative;
  width: 510px;
  height: 25px;
  border: 1px solid #b0b0b0;
 
  /* viewing purposes */
  -webkit-box-shadow: inset 0 3px 5px 0 #d3d0d0;
  -moz-box-shadow: inset 0 3px 5px 0 #d3d0d0;
  box-shadow: inset 0 3px 5px 0 #d3d0d0;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  -ms-border-radius: 3px;
  -o-border-radius: 3px;
  border-radius: 3px;
}
div.meter span {
  display: block;
  height: 100%;
  animation: grower 1s linear;
  -moz-animation: grower 1s linear;
  -webkit-animation: grower 1s linear;
  -o-animation: grower 1s linear;
  position: relative;
  top: -1px;
  left: -1px;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  -ms-border-radius: 3px;
  -o-border-radius: 3px;
  border-radius: 3px;
  -webkit-box-shadow: inset 0px 3px 5px 0px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: inset 0px 3px 5px 0px rgba(0, 0, 0, 0.2);
  box-shadow: inset 0px 3px 5px 0px rgba(0, 0, 0, 0.2);
  border: 1px solid #3c84ad;
  background: #6eb2d1;
  background-image: -webkit-gradient(linear, 0 0, 100% 100%, color-stop(0.25, rgba(255, 255, 255, 0.2)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.2)), color-stop(0.75, rgba(255, 255, 255, 0.2)), color-stop(0.75, transparent), to(transparent));
  background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent);
  background-image: -moz-linear-gradient(45deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent);
  background-image: -ms-linear-gradient(45deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent);
  background-image: -o-linear-gradient(45deg, rgba(255, 255, 255, 0.2) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0.2) 75%, transparent 75%, transparent);
  -webkit-background-size: 45px 45px;
  -moz-background-size: 45px 45px;
  -o-background-size: 45px 45px;
  background-size: 45px 45px;
}
div.meter span:before {
  content: '';
  display: block;
  width: 100%;
  height: 50%;
  position: relative;
  top: 50%;
  background: rgba(0, 0, 0, 0.03);
}
div.meter p {
  position: absolute;
  top: 0;
  margin: 0 10px;
  line-height: 25px;
  font-family: 'Helvetica';
  font-weight: bold;
  -webkit-font-smoothing: antialised;
  font-size: 15px;
  color: #333;
  text-shadow: 0 1px rgba(255, 255, 255, 0.6);
}

@keyframes grower {
  0% {
    width: 0%;
  }
}

@-moz-keyframes grower {
  0% {
    width: 0%;
  }
}

@-webkit-keyframes grower {
  0% {
    width: 0%;
  }
}

@-o-keyframes grower {
  0% {
    width: 0%;
  }
}
	</style>

    {/literal}
<div class="alert alert-message"> 


<table width="450" border="0">
  <tr>
    <td colspan="2" align="left"><div class="meter">
  <span style="width:{$percent|escape:'htmlall':'UTF-8'}%"></span>
 <p>{l s='Site general performance:' mod='prestaspeed'} {$loadtime|escape:'htmlall':'UTF-8'}{l s=' %' mod='prestaspeed'}</p>
</div></td>
    </tr>
  <tr>
    <td width="65" align="left"><img src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/performance.png" style="  width: 64px;margin: 5px;" /></td>
    <td align="left"><strong>{$response}</strong> {l s='is the response time from your server. Reducing the server response time can increase the performance in a' mod='prestaspeed'} <strong>{$responseimpact}%</strong>.{l s='You can disable server stats, change to PHP 7, use FAST CGI to increase the server response time in your server panel.' mod='prestaspeed'} </td>
  </tr>
  <tr>
    <td width="65" align="left"><img src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/resources.png" style="  width: 64px;margin: 5px;" /></td>
    <td align="left"><strong>{$resources}</strong> {l s='is the total resources including images, javascript/css files, etc (the ideal is 80/90 per page). You can reduce the resources changing to less products in homepage, or disabling modules that you don`t use.' mod='prestaspeed'}</td>
  </tr>
</table>

<br/>
<p><strong>1-</strong>{l s='If you use Youtube videos on CMS or homepage, PrestaSpeed can save almost 1mb of file loading from Youtube scripts and make videos responsive. You only need to replace the classic iframe of youtube:' mod='prestaspeed'} <input value='<iframe width="560" height="315" src="https://www.youtube.com/embed/mCJCbvoPaaA?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>' disabled size="180"> {l s='to' mod='prestaspeed'} <input value='<div class="youtube-player" data-id="mCJCbvoPaaA"></div>' disabled size="70"> {l s='Where mCJCbvoPaaA is the video code' mod='prestaspeed'} </p>
<p><strong>2-</strong>{l s='Image optimization can take much time if you have a lot of images. You can get error 500. We recommend use the cron option to optimize images.' mod='prestaspeed'}</p>
<p><span style="color:#093; font-weight:bolder">Tip: </span>{l s='If you get 0kb optimized in images, run the module without ssl and disable media servers. If still gets 0kb, use the cron option to optimize the images' mod='prestaspeed'}</p>
<p><span style="color:#093; font-weight:bolder">Tip: </span>{l s='If the optimization process of the images don`t finish, and you see a white screen or an internal server error, just press F5 until you back to the module configuration.Remember, image optimization uses smushit service, if the service is down, Prestaspeed can`t optimize the images.' mod='prestaspeed'}</p>
<p><strong>3-</strong>{l s='Back office optimization cache the media files (images, css, javascript).' mod='prestaspeed'}
<p><span style="color:#093; font-weight:bolder">Tip: </span>{l s='If enable back office optimization, sometimes you dont see the changes in cms. Simply, disable BO optimization.' mod='prestaspeed'}</p>

<br/>
<center><img src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/readme.png" style="  width: 31px;margin: 5px;" /><a href="{$module_dir|escape:'htmlall':'UTF-8'}moduleinstall.pdf" target="_blank">README</a> / 
		<img src="{$module_dir|escape:'htmlall':'UTF-8'}views/img/terms.png" style="  width: 31px;margin: 5px;" /><a href="{$module_dir|escape:'htmlall':'UTF-8'}termsandconditions.pdf" target="_blank">TERMS</a></center><br/>

</div>
