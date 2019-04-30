{*
* 2007-2018 ETS-Soft
*
* NOTICE OF LICENSE
*
* This file is not open source! Each license that you purchased is only available for 1 wesite only.
* If you want to use this file on more websites (or projects), you need to purchase additional licenses. 
* You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
* 
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs, please contact us for extra customization service at an affordable price
*
*  @author ETS-Soft <etssoft.jsc@gmail.com>
*  @copyright  2007-2018 ETS-Soft
*  @license    Valid for 1 website (or project) for each purchase of license
*  International Registered Trademark & Property of ETS-Soft
*}
{if isset($products) && $products}
	<!-- Products list -->
	<ul{if isset($id) && $id} id="{$id|intval}"{/if} class="product_list grid row{if isset($class) && $class} {$class|escape:'html':'UTF-8'}{/if}">
	{foreach from=$products item=product name=products}		
		<li class="ajax_block_product col-xs-12 col-sm-12">
			<div class="product-container" itemscope itemtype="https://schema.org/Product">
				<div class="left-block">
					<div class="product-image-container">
						<a class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
							{if isset($product.image_id)}{assign var='imageLink' value=$link->getImageLink($product.link_rewrite, $product.image_id, $imageType)}{else}{assign var='imageLink' value=$link->getImageLink($product.link_rewrite, $product.id_image, $imageType)}{/if}
                            <img class="replace-2x img-responsive" src="{if (strpos($imageLink,'http://')===false || strpos($imageLink,'https://'))}{$protocol_link|escape:'html':'UTF-8'}{/if}{$imageLink|escape:'html':'UTF-8'}" alt="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" title="{if !empty($product.legend)}{$product.legend|escape:'html':'UTF-8'}{else}{$product.name|escape:'html':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width|floatval}" height="{$homeSize.height|floatval}"{/if} itemprop="image" />
						</a>
                    </div>
				</div>
				<div class="right-block">
					<h5 itemprop="name">
						{if isset($product.pack_quantity) && $product.pack_quantity}{$product.pack_quantity|intval|cat:' x '}{/if}
						<a class="product-name" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url" >
							<span class="product_name">{$product.name|truncate:45:'...'|escape:'html':'UTF-8'}</span>
						</a>
                        {if isset($product.attributes) && $product.attributes}
							{assign var='ik2' value=0}
							<span class="product_combination"> {foreach from=$product.attributes item='attribute'}{assign var='ik2' value=$ik2+1}{if isset($attribute.group_name)}{$attribute.group_name|truncate:80:'...':true|escape:'html':'UTF-8'}{else}{$attribute.group|truncate:80:'...':true|escape:'html':'UTF-8'}{/if}-{if isset($attribute.attribute_name)}{$attribute.attribute_name|truncate:80:'...':true|escape:'html':'UTF-8'}{else}{$attribute.name|truncate:80:'...':true|escape:'html':'UTF-8'}{/if}{if $ik2 < count($product.attributes)}, {/if}{/foreach}</span>
						{/if}
					</h5>   
                    {if $block.show_description}
                        <p class="product-desc" itemprop="description">
    						{if isset($product.description_short) && $product.description_short}{$product.description_short|strip_tags|escape:'html':'UTF-8'|truncate:60:'...'}{/if}
    					</p> 
                    {/if}    
                    {if (!$PS_CATALOG_MODE && ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
						<div class="content_price" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
							{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}
								<span itemprop="price" class="price product-price">
									{hook h="displayProductPriceBlock" product=$product type="before_price"}
									{if isset($priceDisplay) && !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}
								</span>									
								{if isset($product.price_without_reduction) && $product.price_without_reduction > 0 && isset($product.specific_prices) && $product.specific_prices && isset($product.specific_prices.reduction) && $product.specific_prices.reduction > 0}
									{hook h="displayProductPriceBlock" product=$product type="old_price"}
									<span class="old-price product-price">
										{displayWtPrice p=$product.price_without_reduction}
									</span>
									{if $product.specific_prices.reduction_type == 'percentage'}
										<span class="price-percent-reduction">-{($product.specific_prices.reduction * 100)|floatval}%</span>
									{/if}
								{/if}								
							{/if}
						</div>
					{/if} 
                    {if $block.show_clock && isset($product.specific_prices_to)}
                        <div class="panel-discount-countdown" data-countdown="{$product.specific_prices_to|escape:'html':'UTF-8'}"></div>
                    {/if}           
				</div>				
			</div><!-- .product-container> -->
		</li>
	{/foreach}
    </ul>
{else}
	<span class="mm_alert alert-warning">{l s='No product available' mod='ets_megamenu'}</span>
{/if}