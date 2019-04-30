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
{if isset($block) && $block && $block.enabled}    
    <div class="ets_mm_block mm_block_type_{strtolower($block.block_type)|escape:'html':'UTF-8'} {if !$block.display_title}mm_hide_title{/if}">
        <h4 {if Configuration::get('ETS_MM_TEXTTITLE_FONT_SIZE')} style="font-size:{Configuration::get('ETS_MM_TEXTTITLE_FONT_SIZE')|intval}px"{/if}>{if $block.title_link}<a href="{$block.title_link|escape:'html':'UTF-8'}" {if Configuration::get('ETS_MM_TEXTTITLE_FONT_SIZE')} style="font-size:{Configuration::get('ETS_MM_TEXTTITLE_FONT_SIZE')|intval}px"{/if}>{/if}{$block.title|escape:'html':'UTF-8'}{if $block.title_link}</a>{/if}</h4>
        <div class="ets_mm_block_content">        
            {if $block.block_type=='CATEGORY'}
                {if isset($block.categoriesHtml)}{$block.categoriesHtml nofilter}{/if}
            {elseif $block.block_type=='MNFT'}
                {if isset($block.manufacturers) && $block.manufacturers}
                    <ul {if isset($block.display_mnu_img) && $block.display_mnu_img}class="mm_mnu_display_img"{/if}>
                        {foreach from=$block.manufacturers item='manufacturer'}
                            <li class="{if isset($block.display_mnu_img) && $block.display_mnu_img}item_has_img {if isset($block.display_mnu_inline) && $block.display_mnu_inline}item_inline_{$block.display_mnu_inline|escape:'html':'UTF-8'}{/if}{/if}">
                                <a href="{$manufacturer.link|escape:'html':'UTF-8'}">
                                    {if isset($block.display_mnu_img) && $block.display_mnu_img}
                                        <span class="ets_item_img">
                                            <img src="{$manufacturer.image|escape:'html':'UTF-8'}" alt="" title="{$manufacturer.label|escape:'html':'UTF-8'}"/>
                                        </span>
                                        {if isset($block.display_mnu_name) && $block.display_mnu_name}
                                            <span class="ets_item_name">{$manufacturer.label|escape:'html':'UTF-8'}</span>
                                        {/if}
                                    {else}
                                        {$manufacturer.label|escape:'html':'UTF-8'}
                                    {/if}
                                </a>
                            </li>
                        {/foreach}
                    </ul>
                {/if}
            {elseif $block.block_type=='MNSP'}
                {if isset($block.suppliers) && $block.suppliers}
                    <ul {if isset($block.display_suppliers_img) && $block.display_suppliers_img}class="mm_mnu_display_img"{/if}>
                        {foreach from=$block.suppliers item='supplier'}
                            <li class="{if isset($block.display_suppliers_img) && $block.display_suppliers_img}{if isset($block.display_suppliers_inline) && $block.display_suppliers_inline}item_inline_{$block.display_suppliers_inline|escape:'html':'UTF-8'}{/if} item_has_img{/if}">
                                <a href="{$supplier.link|escape:'html':'UTF-8'}">
                                    {if isset($block.display_suppliers_img) && $block.display_suppliers_img}
                                        <span class="ets_item_img">
                                            <img src="{$supplier.image|escape:'html':'UTF-8'}" alt="" title="{$supplier.label|escape:'html':'UTF-8'}" />
                                        </span>
                                        {if isset($block.display_suppliers_name) && $block.display_suppliers_name}
                                            <span class="ets_item_name">{$supplier.label|escape:'html':'UTF-8'}</span>
                                        {/if}
                                    {else}
                                        {$supplier.label|escape:'html':'UTF-8'}
                                    {/if}
                                </a>
                            </li>
                        {/foreach}
                    </ul>
                {/if}
            {elseif $block.block_type=='CMS'}
                {if isset($block.cmss) && $block.cmss}
                    <ul>
                        {foreach from=$block.cmss item='cms'}
                            <li><a href="{$cms.link|escape:'html':'UTF-8'}">{$cms.label|escape:'html':'UTF-8'}</a></li>
                        {/foreach}
                    </ul>
                {/if}
            {elseif $block.block_type=='IMAGE'}
                {if isset($block.image) && $block.image}{if $block.image_link}<a href="{$block.image_link|escape:'html':'UTF-8'}">{/if}
                    <span class="mm_img_content">
                        <img src="{$block.image|escape:'html':'UTF-8'}" alt="{$block.title|escape:'html':'UTF-8'}" />
                    </span>
                {if $block.image_link}</a>{/if}{/if}
            {elseif $block.block_type=='PRODUCT'}
                {if isset($block.productsHtml)}{$block.productsHtml nofilter}{/if}
            {else}
                {$block.content nofilter}
            {/if}
        </div>
    </div>
    <div class="clearfix"></div>
{/if}