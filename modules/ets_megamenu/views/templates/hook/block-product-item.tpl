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
    {foreach from=$products item='product'}
        <li class="mm_product_item " data-id="{$product.id_product|intval}-{$product.id_product_attribute|intval}">
            <a class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}" itemprop="url">
                <img class="mm_product_image" src="{$product.image|escape:'quotes':'UTF-8'}" alt="{$product.name|truncate:20:'...':true|escape:'html':'UTF-8'}"/>
                <div class="mm_product_info">
                    <span class="product_name">{$product.name|truncate:80:'...':true|escape:'html':'UTF-8'}</span>
                    {if isset($product.attributes) && $product.attributes}
                        {assign var='ik2' value=0}
                        <span class="product_combination"> {foreach from=$product.attributes item='attribute'}{assign var='ik2' value=$ik2+1}{$attribute.group_name|truncate:80:'...':true|escape:'html':'UTF-8'}-{$attribute.attribute_name|truncate:80:'...':true|escape:'html':'UTF-8'}{if $ik2 < count($product.attributes)}, {/if}{/foreach}</span>
                    {/if}
                </div>
            </a>
            <div class="content_price" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
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
            </div>
            <div class="mm_block_item_close" title="{l s='Delete' mod='ets_megamenu'}">
                <i class="icon-trash"></i>
            </div>
        </li>
    {/foreach}
{/if}