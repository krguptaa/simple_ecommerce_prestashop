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
	
	<link rel="stylesheet" href="">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
	<body>
		<style type="text/css" media="screen">
			{foreach from=$showsc item=item}
				.fadeOut_{$item.id|escape:'htmlall':'UTF-8'} > .owl-nav > .owl-prev, 
				.fadeOut_{$item.id|escape:'htmlall':'UTF-8'} > .owl-nav > .owl-next {
					background: #{$item.background_arrow|escape:'htmlall':'UTF-8'} !important;
					color: #{$item.text_color_arrow|escape:'htmlall':'UTF-8'} !important;
					font-size: 18px;
					margin-top: -30px;
					position: absolute;
					top: 42%;
					text-align: center;
					line-height: 39px;
					border:1px solid #fff;
					width: 40px;
					height: 40px;
				}
				.template_slide .fadeOut_{$item.id|escape:'htmlall':'UTF-8'}_title .page-title-categoryslider{
					color: #{$item.text_button_color|escape:'htmlall':'UTF-8'};
				}
				.template_slide .fadeOut_{$item.id|escape:'htmlall':'UTF-8'}_title .page-title-categoryslider:after{
					background-color: #{$item.text_button_color|escape:'htmlall':'UTF-8'};
				}
				.fadeOut_{$item.id|escape:'htmlall':'UTF-8'} .owl-nav .owl-prev:hover, 
				.fadeOut_{$item.id|escape:'htmlall':'UTF-8'} .owl-nav .owl-next:hover {
					background: #{$item.background_arrow_hover|escape:'htmlall':'UTF-8'} !important;
				}
				.fadeOut_{$item.id|escape:'htmlall':'UTF-8'} .whislist_casour{
					background: #{$item.background_button|escape:'htmlall':'UTF-8'};
					color:#{$item.text_button_color|escape:'htmlall':'UTF-8'};
					border: 1px solid #{$item.text_button_color|escape:'htmlall':'UTF-8'};
				}
				.fadeOut_{$item.id|escape:'htmlall':'UTF-8'} .ad_info_pro h4 a:hover{
					color: #{$item.text_button_color|escape:'htmlall':'UTF-8'};
				}
				.fadeOut_{$item.id|escape:'htmlall':'UTF-8'} .whislist_casour>a{
					background: transparent !important;
					color:#{$item.text_button_color|escape:'htmlall':'UTF-8'};
				}
				.fadeOut_{$item.id|escape:'htmlall':'UTF-8'} .whislist_casour:hover,.compare_check,.compare_check a{
					background: #{$item.background_button_hover|escape:'htmlall':'UTF-8'} !important;
					color: #{$item.text_button_color_hover|escape:'htmlall':'UTF-8'} !important;
					transition: all 0.4s ease-in-out 0s;
				}
				.fadeOut_{$item.id|escape:'htmlall':'UTF-8'} .whislist_casour:hover a{
					color: #{$item.text_button_color_hover|escape:'htmlall':'UTF-8'} !important;
				}
				.fadeOut_{$item.id|escape:'htmlall':'UTF-8'} .ad_info_pro h4 a{
					font-size: 13px;
					color: #{$item.text_color|escape:'htmlall':'UTF-8'};
				}
				.fadeOut_{$item.id|escape:'htmlall':'UTF-8'} .add_to_carsou .ajax_add_to_cart_button:hover{
					color: #{$item.background_button|escape:'htmlall':'UTF-8'} !important;
				}
				.fadeOut_{$item.id|escape:'htmlall':'UTF-8'} .add_to_carsou .ajax_add_to_cart_button{
					background:#{$item.text_button_color|escape:'htmlall':'UTF-8'} !important;
					color: #{$item.background_button|escape:'htmlall':'UTF-8'};
				}
			{/foreach}
		</style>

	</body>
</html>