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
{if $menusHTML}
    <div class="ets_mm_megamenu 
        {if isset($mm_config.ETS_MM_LAYOUT)&&$mm_config.ETS_MM_LAYOUT}layout_{$mm_config.ETS_MM_LAYOUT|escape:'html':'UTF-8'}{/if} 
        {if isset($mm_config.ETS_MM_SHOW_ICON_VERTICAL) && $mm_config.ETS_MM_SHOW_ICON_VERTICAL} show_icon_in_mobile{/if} 
        {if isset($mm_config.ETS_MM_SKIN)&&$mm_config.ETS_MM_SKIN}skin_{$mm_config.ETS_MM_SKIN|escape:'html':'UTF-8'}{/if}  
        {if isset($mm_config.ETS_MM_TRANSITION_EFFECT)&&$mm_config.ETS_MM_TRANSITION_EFFECT}transition_{$mm_config.ETS_MM_TRANSITION_EFFECT|escape:'html':'UTF-8'}{/if}   
        {if isset($mm_config.ETS_MOBILE_MM_TYPE)&&$mm_config.ETS_MOBILE_MM_TYPE}transition_{$mm_config.ETS_MOBILE_MM_TYPE|escape:'html':'UTF-8'}{/if} 
        {if isset($mm_config.ETS_MM_CUSTOM_CLASS)&&$mm_config.ETS_MM_CUSTOM_CLASS}{$mm_config.ETS_MM_CUSTOM_CLASS|escape:'html':'UTF-8'}{/if} 
        {if isset($mm_config.ETS_MM_STICKY_ENABLED)&&$mm_config.ETS_MM_STICKY_ENABLED}sticky_enabled{else}sticky_disabled{/if} 
        {if isset($mm_config.ETS_MM_ACTIVE_ENABLED)&&$mm_config.ETS_MM_ACTIVE_ENABLED}enable_active_menu{/if} 
        {if isset($mm_layout_direction)&&$mm_layout_direction}{$mm_layout_direction|escape:'html':'UTF-8'}{else}ets-dir-ltr{/if}
        {if isset($mm_config.ETS_MM_HOOK_TO)&&$mm_config.ETS_MM_HOOK_TO=='customhook'}hook-custom{else}hook-default{/if}
        {if isset($mm_multiLayout)&&$mm_multiLayout}multi_layout{else}single_layout{/if}
        {if isset($mm_config.ETS_MM_STICKY_DISMOBILE) && $mm_config.ETS_MM_STICKY_DISMOBILE } disable_sticky_mobile {/if}
        ">
        <div class="ets_mm_megamenu_content">
            <div class="container">
                <div class="ets_mm_megamenu_content_content">
                    <div class="ybc-menu-toggle ybc-menu-btn closed">
                        <span class="ybc-menu-button-toggle_icon">
                            <i class="icon-bar"></i>
                            <i class="icon-bar"></i>
                            <i class="icon-bar"></i>
                        </span>
                        {l s='Menu' mod='ets_megamenu'}
                    </div>
                    {$menusHTML nofilter}
                </div>
            </div>
        </div>
    </div>
{/if}