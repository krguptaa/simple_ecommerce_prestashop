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
{assign var="checkhihi" value="hien"}
<div class="ba_slider_popup_background" style="display: none;"></div>
<div class="ba_popup_compare">
	<p style="margin: 0px;">Added to your compare, View comparison list <a style="color: #00aff0" href="{$base|escape:'htmlall':'UTF-8'}{$iso_lang|escape:'htmlall':'UTF-8'}/products-comparison" class="clish2" target="_blank">click here</a></p>
	<span class="ba_close_popup"><a title="Close" class="fancybox-close exit_popup" href="javascript:;"></a></span>
</div>
<div {if $bablocks == 'home page tab'} id="baslifadeOut_{$id_sl|escape:'htmlall':'UTF-8'}" {/if} class="template_slide {if $bablocks == 'home page tab'}badnone{/if}">
	<script>
		if (rtl==1) {
			testrtl = true;
		}
		else{
			testrtl = false;
		}
		function checktime_{$id_sl|escape:'htmlall':'UTF-8'}() {
			if ($('.template_slide:hover').length === 0) {
				if(!$('html').hasClass('fancybox-margin')) {
					$('.fadeOut_{$id_sl|escape:'htmlall':'UTF-8'}').trigger('play.owl.autoplay');
				}
				else {
					$('.fadeOut_{$id_sl|escape:'htmlall':'UTF-8'}').trigger('stop.owl.autoplay');
				}
			}
		}
		$(document).ready(function(){
			$('.fadeOut_{$id_sl|escape:'htmlall':'UTF-8'}').owlCarousel({
				autoplayHoverPause:true,
				loop: {$loops|escape:'htmlall':'UTF-8'},
				autoplay:{$auto_play|escape:'htmlall':'UTF-8'},
				margin: 10,
				rtl:testrtl,
				nav :{$nav|escape:'htmlall':'UTF-8'},
				dots :{$dots|escape:'htmlall':'UTF-8'},
				navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
				responsive:{
			        0:{
			            items:{$item_mobile|escape:'htmlall':'UTF-8'},
						nav :{$nav|escape:'htmlall':'UTF-8'},
						dots :{$dots|escape:'htmlall':'UTF-8'},
			        },
			        600:{
			            items:{$item_tablet|escape:'htmlall':'UTF-8'},
						nav :{$nav|escape:'htmlall':'UTF-8'},
						dots :{$dots|escape:'htmlall':'UTF-8'},
			        },
			        1000:{
			            items:{$item_desktop|escape:'htmlall':'UTF-8'},
						nav :{$nav|escape:'htmlall':'UTF-8'},
						dots :{$dots|escape:'htmlall':'UTF-8'},
			        }
			    },
			});
			if (auto_play == 'true') {
				setInterval(checktime_{$id_sl|escape:'htmlall':'UTF-8'},1500);
			}
		});
	</script>
	{if $embe == 1}
		{if count($shows) > 0}
			{if $title == 1}
				<div class="page-top fadeOut_{$id_sl|escape:'htmlall':'UTF-8'}_title">
					<div class="page-title-categoryslider">
						<span>{$names|escape:'htmlall':'UTF-8'}</span>
					</div> 
				</div>
			{/if}
			<div style="width: {$sizeslide->sliw|escape:'htmlall':'UTF-8'};height: {$sizeslide->slih|escape:'htmlall':'UTF-8'}" class="fadeOut_{$id_sl|escape:'htmlall':'UTF-8'} owl-carousel owl-theme saddd {if $bablocks == 'home page tab'}owl-hidden{/if}">
				{foreach from=$shows item=item}
					{if Product::getQuantity($item.id_product) <= 0 && $cstock == 1}
						{$checkhihi = 'an'}
					{else}
						{$checkhihi = 'hien'}
					{/if}
					{if $checkhihi == 'hien'}
						{$ks = Category::getCategoryInformations(array($item.id_category_default))}
						{$im = Product::getCover($item.id_product)}
						<div style="" class="item slier_item">
							<div>
								<div>
									<a href="{BaProductsCarousel::getUrlFix($item.id_product|escape:'htmlall':'UTF-8')}" title="">
										<img class="img-responsive" style="margin: auto" src="{BaProductsCarousel::getImgFix($item.id_product,$sizeslide->sizeimg)|escape:'htmlall':'UTF-8'}" alt="">
									</a>
								</div>
								{$lb = {convertPrice price={$item.price|escape:'htmlall':'UTF-8'}*$item.rate/100+$item.price|escape:'htmlall':'UTF-8'}}
								{$lb2 = {convertPrice price={Product::getPriceStatic($item.id_product|escape:'htmlall':'UTF-8')}}}
								{if $lb2 !== $lb}
									{$lb3 = round({$item.price|escape:'htmlall':'UTF-8'}*$item.rate/100+$item.price,2)}
									{$lb4 = round(Product::getPriceStatic($item.id_product),2)|escape:'htmlall':'UTF-8'}
									<span class="pro_sale">-{round(($lb3-$lb4)*100/$lb3)|escape:'htmlall':'UTF-8'}%</span>
								{/if}
						    		<a class='quiss' rel="{BaProductsCarousel::getUrlFix($item.id_product|escape:'htmlall':'UTF-8')}" title=""><i class="fa fa-eye"></i></a>
								<div class="ad_info_pro">
									<h4><a href="{BaProductsCarousel::getUrlFix($item.id_product|escape:'htmlall':'UTF-8')}">{$item.name}</a></h4>
									{if $price == 1}
									    <span class="price_pro">{convertPrice price={Product::getPriceStatic($item.id_product|escape:'htmlall':'UTF-8')}}</span>
									    {if $lb2 !== $lb}
									    <span class="price_old">{$lb|escape:'htmlall':'UTF-8'}</span>
									    {/if}
								    {/if}
								</div>
								<div style="text-align: center;margin-bottom: 7px;">
									{if $checkratingst == 1}
										{$starra = BaProductsCarousel::getAverageGrade($item.id_product)}
										{if $starra['grade'] > 0}
											<span {if $starra['grade'] > 0}style="color: #fec42d;"{/if} class="fa fa-star"></span>
											<span {if $starra['grade'] > 1}style="color: #fec42d;"{/if} class="fa fa-star"></span>
											<span {if $starra['grade'] > 2}style="color: #fec42d;"{/if} class="fa fa-star"></span>
											<span {if $starra['grade'] > 3}style="color: #fec42d;"{/if} class="fa fa-star"></span>
											<span {if $starra['grade'] > 4}style="color: #fec42d;"{/if} class="fa fa-star"></span>
										{else}
											{* <span class="fa fa-star-o"></span>
											<span class="fa fa-star-o"></span>
											<span class="fa fa-star-o"></span>
											<span class="fa fa-star-o"></span>
											<span class="fa fa-star-o"></span> *}
										{/if}
									{/if}
								</div>
								<div style="text-align: center;">
									{if $checkwishlist == true && $addtocart->wishlist == 1}
										<div class="whislist_casour wis {if BaProductsCarousel::selectWishList($item.id_product, $id_shop, $id_customer) == 1}compare_check{/if}" id_s="{$item.id_product|escape:'htmlall':'UTF-8'}">
											<i class=""></i>
										</div>
									{/if}
									{if $addtocart->addcart == 1}
										<div class="add_to_carsou button-container" >
											<a {if Product::getQuantity($item.id_product) <= 0 } style="background: #C4C4C4 !important" {/if} class="ajax_add_to_cart_button" href="{$base|escape:'htmlall':'UTF-8'}{$iso_lang|escape:'htmlall':'UTF-8'}/cart?add=1&id_product={$item.id_product|escape:'htmlall':'UTF-8'}&token={$token|escape:'htmlall':'UTF-8'}" rel="nofollow" title="Add to cart" data-id-product="{$item.id_product|escape:'htmlall':'UTF-8'}">
											<span>{if Product::getQuantity($item.id_product) <= 0 }{l s='Out of stock' mod='baproductscarousel'}{else}{l s='Add to cart' mod='baproductscarousel'}{/if}</span>
											</a>
										</div>
									{/if}
									{if $addtocart->compare == 1}
										<div class="whislist_casour compare {if BaProductsCarousel::selectCompare($item.id_product, $id_customer,$ba_compared_products) == 1}compare_check{/if}">
											<a {if BaProductsCarousel::selectCompare($item.id_product, $id_customer,$ba_compared_products) == 1 } onclick="baslierremovecom(this)" {else} class="add_to_compare"{/if} data-id-product="{$item.id_product|escape:'htmlall':'UTF-8'}"><i class=""></i></a>
										</div>
									{/if}
								</div>
							</div>
						</div>
					{/if}
				{/foreach}
				{addJsDefL name=max_item}{l s='You cannot add more than %d product(s) to the product comparisons, view comparison list ' sprintf=$comparator_max_item  mod='baproductscarousel'}<a style="color: blue" href="{$base|escape:'htmlall':'UTF-8'}{$iso_lang|escape:'htmlall':'UTF-8'}/products-comparison" target="_blank">click here</a>{/addJsDefL}
				{addJsDefL name=added_to_wishlist}{l s='Added to your wishlist, view your wishlist ' mod='baproductscarousel'}<a class="clish2" style="color: #00aff0" href="{$base|escape:'htmlall':'UTF-8'}{$iso_lang|escape:'htmlall':'UTF-8'}/module/blockwishlist/mywishlist" target="_blank">click here</a>{/addJsDefL}
				{addJsDef comparedProductsIds=$compared_products}
				{addJsDef comparator_max_item=$comparator_max_item}
			</div>
		{/if}
	{/if}
</div>