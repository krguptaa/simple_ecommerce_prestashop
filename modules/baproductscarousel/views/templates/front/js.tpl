{*
* 2007-2019 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@buy-addons.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
* @author    Buy-addons    <contact@buy-addons.com>
* @copyright 2007-2019 Buy-addons
* @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<!DOCTYPE html>
<html>
<head>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="{$base|escape:'htmlall':'UTF-8'}modules/baproductscarousel/views/js/assets/owl.carousel.js"></script>
</head>
<body>
	<script>
		$(document).ready(function($) {
			{foreach from=$slidejs item=item}
			if (auto_play == 'true') {
				setInterval(checktime_{$item.id|escape:'htmlall':'UTF-8'},1500);
				function checktime_{$item.id|escape:'htmlall':'UTF-8'}() {
					if (!$('.template_slide').is(':hover')) {
						if(!$('body').hasClass('modal-open')) {
							$('.fadeOut_{$item.id|escape:'htmlall':'UTF-8'}').trigger('play.owl.autoplay');
						}
						else {
							$('.fadeOut_{$item.id|escape:'htmlall':'UTF-8'}').trigger('stop.owl.autoplay');
						}
					}
				}
			}
			$('.fadeOut_{$item.id|escape:'htmlall':'UTF-8'}').owlCarousel({
				animateOut: 'slideOutDown',
				animateIn: 'flipInX',
				autoplayHoverPause:true,
				loop: {$item.loops|escape:'htmlall':'UTF-8'},
				autoplay:{$item.auto_play|escape:'htmlall':'UTF-8'},
				margin: 10,
				nav :{$item.nav|escape:'htmlall':'UTF-8'},
				dots :{$item.dots|escape:'htmlall':'UTF-8'},
				navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
				responsive:{
			        0:{
			            items:{$item.item_mobile|escape:'htmlall':'UTF-8'},
						nav :{$item.nav|escape:'htmlall':'UTF-8'},
						dots :{$item.dots|escape:'htmlall':'UTF-8'},
			        },
			        600:{
			            items:{$item.item_tablet|escape:'htmlall':'UTF-8'},
						nav :{$item.nav|escape:'htmlall':'UTF-8'},
						dots :{$item.dots|escape:'htmlall':'UTF-8'},
			        },
			        1000:{
			            items:{$item.item_desktop|escape:'htmlall':'UTF-8'},
						nav :{$item.nav|escape:'htmlall':'UTF-8'},
						dots :{$item.dots|escape:'htmlall':'UTF-8'},
			        }
			    }
			});
			{/foreach}
		});
	</script>
</body>
</html>