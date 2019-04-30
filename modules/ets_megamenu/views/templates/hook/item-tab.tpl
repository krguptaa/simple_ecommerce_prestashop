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
{if $have_li}
    <li data-id-tab="{$tab.id_tab|intval}" class="mm_tabs_li item{$tab.id_tab|intval} {if !$tab.enabled}mm_disabled{/if}" data-obj="tab">
{/if}
    <div class="mm_tab_li_content" style="width: {if $menu.tab_item_width}{$menu.tab_item_width|escape:'html':'UTF-8'}{else}230px{/if}">
        <span class="mm_tab_name mm_tab_toggle">
            <span class="mm_tab_toggle_title">
                {if $tab.url}
                    <a href="{$tab.url|escape:'html':'UTF-8'}">
                {/if}
                {if $tab.tab_img_link}
                    <img src="{$tab.tab_img_link|escape:'html':'UTF-8'}" title="" alt="" width="20" />
                {else if $tab.tab_icon}
                    <i class="fa {$tab.tab_icon|escape:'html':'UTF-8'}"></i>
                {/if}
                {$tab.title|escape:'html':'UTF-8'}
                {if $tab.bubble_text}<span class="mm_bubble_text" style="background: {if $tab.bubble_background_color}{$tab.bubble_background_color|escape:'html':'UTF-8'}{else}#FC4444{/if}; color: {if $tab.bubble_text_color|escape:'html':'UTF-8'}{$tab.bubble_text_color}{else}#ffffff{/if};">{$tab.bubble_text}</span>{/if}
                {if $tab.url}
                    </a>
                {/if}
            </span>
        </span>
        <div class="mm_buttons" style="left:{if $menu.tab_item_width}{$menu.tab_item_width|escape:'html':'UTF-8'}{else}230px{/if};right:{if $menu.tab_item_width}{$menu.tab_item_width|escape:'html':'UTF-8'}{else}230px{/if};">
            <span class="mm_tab_delete" title="{l s='Delete tab' mod='ets_megamenu'}">{l s='Delete' mod='ets_megamenu'}</span>  
            <span class="mm_duplicate" title="{l s='Duplicate tab' mod='ets_megamenu'}">{l s='Duplicate' mod='ets_megamenu'}</span>                      
            <span class="mm_tab_edit" title="{l s='Edit tab' mod='ets_megamenu'}">{l s='Edit' mod='ets_megamenu'}</span>                
            <span class="mm_menu_toggle mm_menu_toggle_arrow" title="{l s='Close' mod='ets_megamenu'}">{l s='Close' mod='ets_megamenu'}</span> 
            <div class="mm_add_column btn btn-default" title="{l s='Add column' mod='ets_megamenu'}" data-id-menu="{$tab.id_menu|intval}" data-id-tab="{$tab.id_tab|intval}" >{l s='Add column' mod='ets_megamenu'}</div> 
        </div> 
    </div>
    <ul class="mm_columns_ul" style="width:calc(100% - {if $menu.tab_item_width}{$menu.tab_item_width|escape:'html':'UTF-8'}{else}230px{/if}); left: {if $menu.tab_item_width}{$menu.tab_item_width|escape:'html':'UTF-8'}{else}230px{/if};right: {if $menu.tab_item_width}{$menu.tab_item_width|escape:'html':'UTF-8'}{else}230px{/if};">
        {if $tab.columns}                            
            {foreach from=$tab.columns item='column'}
                <li data-id-column="{$column.id_column|intval}" class="mm_columns_li item{$column.id_column|intval} column_size_{$column.column_size|intval} {if $column.is_breaker}mm_breaker{/if}" data-obj="column">
                    {hook h='displayMMItemColumn' column=$column}
                </li>
            {/foreach}                            
        {/if}  
    </ul>
{if $have_li}
</li>
{/if}
