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
    <li class="mm_menus_li item{$menu.id_menu|intval} {if !$menu.enabled}mm_disabled{/if}" data-id-menu="{$menu.id_menu|intval}" data-obj="menu">
{/if}                        
    {if $menu.enabled_vertical}
        <div class="mm_menus_li_content" style="width: {if $menu.menu_item_width}{$menu.menu_item_width|escape:'html':'UTF-8'}{else}230px{/if}">
            <span class="mm_menu_name mm_menu_toggle">
                <span class="mm_menu_content_title">
                    {if $menu.menu_img_link}
                        <img src="{$menu.menu_img_link|escape:'html':'UTF-8'}" title="" alt="" width="20" />
                    {else if $menu.menu_icon}
                        <i class="fa {$menu.menu_icon|escape:'html':'UTF-8'}"></i>
                    {/if}
                    {$menu.title|escape:'html':'UTF-8'}
                    {if $menu.bubble_text}<span class="mm_bubble_text" style="background: {if $menu.bubble_background_color}{$menu.bubble_background_color|escape:'html':'UTF-8'}{else}#FC4444{/if}; color: {if $menu.bubble_text_color|escape:'html':'UTF-8'}{$menu.bubble_text_color}{else}#ffffff{/if};">{$menu.bubble_text}</span>{/if}
                </span>
            </span>
            <div class="mm_buttons button_add_tab">
                <span class="mm_menu_delete" title="{l s='Delete menu' mod='ets_megamenu'}">{l s='Delete' mod='ets_megamenu'}</span>  
                <span class="mm_duplicate" title="{l s='Duplicate menu' mod='ets_megamenu'}">{l s='Duplicate' mod='ets_megamenu'}</span>                      
                <span class="mm_menu_edit" title="{l s='Edit menu' mod='ets_megamenu'}">{l s='Edit menu' mod='ets_megamenu'}</span>                
                <span class="mm_menu_toggle mm_menu_toggle_arrow">{l s='Close' mod='ets_megamenu'}</span> 
                <div class="mm_add_tab btn btn-default" data-id-menu="{$menu.id_menu|intval}" title="{l s='Add tab' mod='ets_megamenu'}">{l s='Add tab' mod='ets_megamenu'}</div> 
            </div> 
        </div>
        
        <div class="mm_tabs_ul">
            <ul class="mm_tabs_ul_content">
                {if $menu.tabs}                            
                    {foreach from=$menu.tabs item='tab'}
                        <li data-id-tab="{$tab.id_tab|intval}" class="mm_tabs_li item{$tab.id_tab|intval} {if !$tab.enabled}mm_disabled{/if}" data-obj="tab">
                            {hook h='displayMMItemTab' tab=$tab}
                        </li>
                    {/foreach}                            
                {/if}
            </ul>
        </div>
    {else}
        <div class="mm_menus_li_content">
            <span class="mm_menu_name mm_menu_toggle">
                <span class="mm_menu_content_title">
                    {if $menu.menu_img_link}
                        <img src="{$menu.menu_img_link|escape:'html':'UTF-8'}" title="" alt="" width="20" />
                    {else if $menu.menu_icon}
                        <i class="fa {$menu.menu_icon|escape:'html':'UTF-8'}"></i>
                    {/if}
                    {$menu.title|escape:'html':'UTF-8'}
                    {if $menu.bubble_text}<span class="mm_bubble_text" style="background: {if $menu.bubble_background_color}{$menu.bubble_background_color|escape:'html':'UTF-8'}{else}#FC4444{/if}; color: {if $menu.bubble_text_color|escape:'html':'UTF-8'}{$menu.bubble_text_color}{else}#ffffff{/if};">{$menu.bubble_text}</span>{/if}
                </span>
            </span>
            <div class="mm_buttons">
                <span class="mm_menu_delete" title="{l s='Delete menu' mod='ets_megamenu'}">{l s='Delete' mod='ets_megamenu'}</span>  
                <span class="mm_duplicate" title="{l s='Duplicate menu' mod='ets_megamenu'}">{l s='Duplicate' mod='ets_megamenu'}</span>                      
                <span class="mm_menu_edit" title="{l s='Edit menu' mod='ets_megamenu'}">{l s='Edit' mod='ets_megamenu'}</span>                
                <span class="mm_menu_toggle mm_menu_toggle_arrow">{l s='Close' mod='ets_megamenu'}</span> 
                <div class="mm_add_column btn btn-default" data-id-menu="{$menu.id_menu|intval}" title="{l s='Add column' mod='ets_megamenu'}">{l s='Add column' mod='ets_megamenu'}</div> 
            </div> 
        </div>
        <ul class="mm_columns_ul">
            {if $menu.columns}                            
                {foreach from=$menu.columns item='column'}
                    <li data-id-column="{$column.id_column|intval}" class="mm_columns_li item{$column.id_column|intval} column_size_{$column.column_size|intval} {if $column.is_breaker}mm_breaker{/if}" data-obj="column">
                        {hook h='displayMMItemColumn' column=$column}
                    </li>
                {/foreach}                            
            {/if}  
        </ul> 
    {/if} 
{if $have_li}
</li>
{/if}