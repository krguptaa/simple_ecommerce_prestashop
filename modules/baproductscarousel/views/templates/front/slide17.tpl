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
{if $embe == 1}
	{if count($shows) > 0}
		<div class="template_slide">
			{if $title == 1}
				<div class="page-top fadeOut_{$id_sl|escape:'htmlall':'UTF-8'}_title">
					<div class="page-title-categoryslider">
						<span>{$names|escape:'htmlall':'UTF-8'}</span>
					</div> 
				</div>
			{/if}
			<div style="width: {$sizeslide->sliw|escape:'htmlall':'UTF-8'};height: {$sizeslide->slih|escape:'htmlall':'UTF-8'}" class="fadeOut_{$id_sl|escape:'htmlall':'UTF-8'} owl-carousel owl-theme saddd">
				{foreach from=$shows item=item}
					{if Product::getQuantity($item.id_product) <= 0 && $cstock == 1}
						{$checkhihi = 'an'}
					{else}
						{$checkhihi = 'hien'}
					{/if}
					{if $checkhihi == 'hien'}
						{$ks = Category::getCategoryInformations(array($item.id_category_default))}
						{$im = Product::getCover($item.id_product)}
						{foreach from=$ks item=item1}
							{foreach from=$im item=item2}
								<div style="" class="item slier_item">
									<div class="js-product-miniature" data-id-product="{$item.id_product|escape:'htmlall':'UTF-8'}" data-id-product-attribute="{$item.cache_default_attribute|escape:'htmlall':'UTF-8'}">
										<a href="{BaProductsCarousel::getUrlFix($item.id_product|escape:'htmlall':'UTF-8')|escape:'htmlall':'UTF-8'}" title="">
											<img style="margin:auto;" class="img-responsive" src="{BaProductsCarousel::getImgFix($item.id_product,$sizeslide->sizeimg)|escape:'htmlall':'UTF-8'}" alt="">
										</a>
										{$cur = Currency::getCurrency($id_currency)}
										{$lb3 = round({$item.price|escape:'htmlall':'UTF-8'}*$item.rate/100+$item.price,2)*$cur['conversion_rate']}
										{$lb4 = round(Product::getPriceStatic($item.id_product),2)|escape:'htmlall':'UTF-8'}
										{if $lb3 !== $lb4}
											<span style="top: 10px;right: 19px;" class="pro_sale">-{round(($lb3-$lb4)*100/$lb3)|escape:'htmlall':'UTF-8'}%</span>
										{/if}
								    	<a class='quiss quick-view' rel="" title="" data-link-action="quickview"><i class="fa fa-eye"></i></a>
										<div class="ad_info_pro">
											<h4><a href="{BaProductsCarousel::getUrlFix($item.id_product|escape:'htmlall':'UTF-8')}">{$item.name}</a></h4>
											{if $price == 1}
											    <span style="font-size: 1.1rem" class="price_pro">{Tools::displayPrice($lb4|escape:'htmlall':'UTF-8')}</span>
											    {if $lb3 !== $lb4}
											    <span class="price_old">{Tools::displayPrice($lb3|escape:'htmlall':'UTF-8')}</span>
											    {/if}
										    {/if}
										</div>
										<div style="text-align: center;margin-bottom: 7px;">
											{if $checkratingst == 1}
												{$starra = BaProductsCarousel::getAverageGrade($item.id_product)}
												{if $starra['grade'] > 0}
													<span {if $starra['grade'] > 0}style="color: orange;"{/if} class="fa fa-star"></span>
													<span {if $starra['grade'] > 1}style="color: orange;"{/if} class="fa fa-star"></span>
													<span {if $starra['grade'] > 2}style="color: orange;"{/if} class="fa fa-star"></span>
													<span {if $starra['grade'] > 3}style="color: orange;"{/if} class="fa fa-star"></span>
													<span {if $starra['grade'] > 4}style="color: orange;"{/if} class="fa fa-star"></span>
												{/if}
											{/if}
										</div>
										<div style="text-align: center;">
											{* <div class="whislist_casour wis" onclick="WishlistCart('wishlist_block_list', 'add', '{$item.id_product|escape:'htmlall':'UTF-8'}', false, 1); return false;">
												<i class="fa fa-heart"></i>
											</div> *}
											{if $addtocart->addcart == 1}
												<div class="add_to_carsou button-container" >
													<form action="{$urls.pages.cart|escape:'htmlall':'UTF-8'}" method="post" accept-charset="utf-8">
														<input type="hidden" name="id_product" value="{$item.id_product|escape:'htmlall':'UTF-8'}"/>
														<input type="hidden" name="token" value="{$token|escape:'htmlall':'UTF-8'}"/>
														{if Product::getQuantity($item.id_product) <= 0 }
														<a  style="background: #C4C4C4 !important" class="ajax_add_to_cart_button add-to-cart" {if Product::getQuantity($item.id_product) > 0} data-button-action="add-to-cart"  rel="nofollow" title="Add to cart"  data-id-product="{$item.id_product|escape:'htmlall':'UTF-8'}"{/if}>
														<span>{l s='Out of stock' mod='baproductscarousel'}</span>
														</a>
														{else}
														<button class="ajax_add_to_cart_button add-to-cart" {if Product::getQuantity($item.id_product) > 0} data-button-action="add-to-cart"  rel="nofollow" title="Add to cart"  data-id-product="{$item.id_product|escape:'htmlall':'UTF-8'}"{/if}>
														<span>{l s='Add to cart' mod='baproductscarousel'}</span>
														</button>
														{/if}
													</form>
												</div>
											{/if}
											{* <div class="whislist_casour compare">
												<a class="add_to_compare" href="{$base|escape:'htmlall':'UTF-8'}{$iso_lang|escape:'htmlall':'UTF-8'}/{$item1.link_rewrite}/{$item.id_product}-{$item.link_rewrite}.html" data-id-product="{$item.id_product}"><i class="fa fa-retweet"></i></a>
												
											</div> *}
										</div>
									</div>
								</div>
							{/foreach}
						{/foreach}
					{/if}
				{/foreach}
			</div>
		</div>
	{/if}
{/if}