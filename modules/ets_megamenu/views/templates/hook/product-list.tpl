{*
* 2007-2018 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2018 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{if isset($products) && $products}	
	<!-- Products list -->
	<ul{if isset($id) && $id} id="{$id|intval}"{/if} class="menu_product_list row{if isset($class) && $class} {$class|escape:'html':'UTF-8'}{/if}">
	{foreach from=$products item=product name=products}		
		<li class="menu_block_product col-xs-12 col-sm-12">
			<div class="product-container" itemscope itemtype="https://schema.org/Product">
				<div class="left-block">
					<div class="product-image-container">
						<a class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
							{assign var='imageLink' value=$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}
                            <img class="replace-2x img-responsive" src="{if (strpos($imageLink,'http://')===false || strpos($imageLink,'https://'))}{$protocol_link nofilter}{/if}{$imageLink|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width|floatval}" height="{$homeSize.height|floatval}"{/if} itemprop="image" />
						</a>
						{if isset($quick_view) && $quick_view}
							<div class="quick-view-wrapper-mobile">
    							<a class="quick-view-mobile" href="{$product.link|escape:'html':'UTF-8'}" rel="{$product.link|escape:'html':'UTF-8'}">
    								<i class="icon-eye-open"></i>
    							</a>
    						</div>
    						<a class="quick-view" href="{$product.link|escape:'html':'UTF-8'}" rel="{$product.link|escape:'html':'UTF-8'}">
    							<span>{l s='Quick view' mod='ets_megamenu'}</span>
    						</a>
						{/if}
                        <div class="button-container">
    						{if isset($PS_CATALOG_MODE) && ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.customizable != 2 && !$PS_CATALOG_MODE}
    							{if (!isset($product.customization_required) || !$product.customization_required) && ($product.allow_oosp || $product.quantity > 0)}
    								{capture}add=1&amp;id_product={$product.id_product|intval}{if isset($product.id_product_attribute) && $product.id_product_attribute}&amp;ipa={$product.id_product_attribute|intval}{/if}{if isset($static_token)}&amp;token={$static_token|escape:'html':'UTF-8'}{/if}{/capture}
    								<a class="button ajax_add_to_cart_button btn btn-default" href="{$link->getPageLink('cart', true, NULL, $smarty.capture.default, false)|escape:'html':'UTF-8'}" rel="nofollow" title="{l s='Add to cart' mod='ets_megamenu'}" data-id-product-attribute="{$product.id_product_attribute|intval}" data-id-product="{$product.id_product|intval}" data-minimal_quantity="{if isset($product.product_attribute_minimal_quantity) && $product.product_attribute_minimal_quantity >= 1}{$product.product_attribute_minimal_quantity|intval}{else}{$product.minimal_quantity|intval}{/if}">
    									<span>{l s='Add to cart' mod='ets_megamenu'}</span>
    								</a>
    							{else}
    								<span class="button ajax_add_to_cart_button btn btn-default disabled">
    									<span>{l s='Add to cart' mod='ets_megamenu'}</span>
    								</span>
    							{/if}
    						{/if}
    					</div>
						{if isset($product.new) && $product.new == 1}
							<a class="new-box" href="{$product.link|escape:'html':'UTF-8'}">
								<span class="new-label">{l s='New' mod='ets_megamenu'}</span>
							</a>
						{/if}
						{if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
							<a class="sale-box" href="{$product.link|escape:'html':'UTF-8'}">
								<span class="sale-label">{l s='Sale!' mod='ets_megamenu'}</span>
							</a>
						{/if}
					</div>
					{if isset($product.is_virtual) && !$product.is_virtual}{hook h="displayProductDeliveryTime" product=$product}{/if}
					{hook h="displayProductPriceBlock" product=$product type="weight"}
				</div>
				<div class="right-block">
					<h5 itemprop="name">
						{if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
						<a class="product-name" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
							{$product.name|truncate:45:'...'|escape:'html':'UTF-8'}
							{if isset($product.attributes) && $product.attributes}
								{assign var='ik2' value=0}
								<span class="product_combination"> {foreach from=$product.attributes item='attribute'}{assign var='ik2' value=$ik2+1}{if isset($attribute.group_name)}{$attribute.group_name|truncate:80:'...':true|escape:'html':'UTF-8'}{else}{$attribute.group|truncate:80:'...':true|escape:'html':'UTF-8'}{/if}-{if isset($attribute.attribute_name)}{$attribute.attribute_name|truncate:80:'...':true|escape:'html':'UTF-8'}{else}{$attribute.name|truncate:80:'...':true|escape:'html':'UTF-8'}{/if}{if $ik2 < count($product.attributes)}, {/if}{/foreach}</span>
							{/if}
						</a>
					</h5>
					{capture name='displayProductListReviews'}{hook h='displayProductListReviews' product=$product}{/capture}
					{if $smarty.capture.displayProductListReviews}
						<div class="hook-reviews">
						{hook h='displayProductListReviews' product=$product}
						</div>
					{/if}
					{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
    					<div class="content_price">
    						{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
    							{hook h="displayProductPriceBlock" product=$product type='before_price'}
    							<span class="price product-price">
    								{if isset($priceDisplay) && !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
    							</span>
    							{if $product.price_without_reduction > 0 && isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
    								{hook h="displayProductPriceBlock" product=$product type="old_price"}
    								<span class="old-price product-price">
    									{displayWtPrice p=$product.price_without_reduction}
    								</span>
    								{hook h="displayProductPriceBlock" id_product=$product.id_product type="old_price"}
    								{if $product.specific_prices.reduction_type == 'percentage'}
    									<span class="price-percent-reduction">-{($product.specific_prices.reduction * 100)|floatval}%</span>
    								{/if}
    							{/if}
    							{hook h="displayProductPriceBlock" product=$product type="price"}
    							{hook h="displayProductPriceBlock" product=$product type="unit_price"}
    							{hook h="displayProductPriceBlock" product=$product type='after_price'}
    						{/if}
    					</div>
					{/if}
                    {if $block.show_clock && isset($product.specific_prices_to)}
                        <div class="panel-discount-countdown" data-countdown="{$product.specific_prices_to|escape:'html':'UTF-8'}"></div>
                    {/if}
                    {if $block.show_description}
                        <p class="product-desc" itemprop="description">
    						{$product.description_short|strip_tags|escape:'html':'UTF-8'|truncate:60:'...'}
    					</p>
                    {/if}
					{if isset($product.color_list)}
						<div class="color-list-container">{$product.color_list nofilter}</div>
					{/if}
					<div class="product-flags">
						{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
							{if isset($product.online_only) && $product.online_only}
								<span class="online_only">{l s='Online only' mod='ets_megamenu'}</span>
							{/if}
						{/if}
						{if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
							{elseif isset($product.reduction) && $product.reduction && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}
								<span class="discount">{l s='Reduced price!' mod='ets_megamenu'}</span>
							{/if}
					</div>
					{if (!$PS_CATALOG_MODE && isset($PS_STOCK_MANAGEMENT) && $PS_STOCK_MANAGEMENT && ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
						{if isset($product.available_for_order) && $product.available_for_order && !isset($restricted_country_mode)}
							<span class="availability">
								{if ($product.allow_oosp || $product.quantity > 0)}
									<span class="{if $product.quantity <= 0 && isset($product.allow_oosp) && !$product.allow_oosp} label-danger{elseif $product.quantity <= 0} label-warning{else} label-success{/if}">
										{if $product.quantity <= 0}{if $product.allow_oosp}{if isset($product.available_later) && $product.available_later}{$product.available_later|escape:'html':'UTF-8'}{else}{l s='In Stock' mod='ets_megamenu'}{/if}{else}{l s='Out of stock' mod='ets_megamenu'}{/if}{else}{if isset($product.available_now) && $product.available_now}{$product.available_now|escape:'html':'UTF-8'}{else}{l s='In Stock' mod='ets_megamenu'}{/if}{/if}
									</span>
								{elseif (isset($product.quantity_all_versions) && $product.quantity_all_versions > 0)}
									<span class="label-warning">
										{l s='Product available with different options' mod='ets_megamenu'}
									</span>
								{else}
									<span class="label-danger">
										{l s='Out of stock' mod='ets_megamenu'}
									</span>
								{/if}
							</span>
						{/if}
					{/if}
				</div>
			</div><!-- .product-container> -->
		</li>
	{/foreach}
</ul>	
{addJsDefL name=min_item}{l s='Please select at least one product' js=1 mod='ets_megamenu'}{/addJsDefL}
{addJsDefL name=max_item}{l s='You cannot add more than %d product(s) to the product comparison' sprintf=$comparator_max_item js=1 mod='ets_megamenu'}{/addJsDefL}
{addJsDef comparator_max_item=$comparator_max_item}
{addJsDef comparedProductsIds=$compared_products}
{else}
	<span class="mm_alert alert-warning">{l s='No product available' mod='ets_megamenu'}</span>
{/if}