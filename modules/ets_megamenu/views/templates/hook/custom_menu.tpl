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
{if $ETS_MM_DISPLAY_SHOPPING_CART || $ETS_MM_DISPLAY_SEARCH || $ETS_MM_DISPLAY_CUSTOMER_INFO || $ETS_MM_CUSTOM_HTML_TEXT}
    <div class="mm_extra_item{if $ETS_MM_SEARCH_DISPLAY_DEFAULT} mm_display_search_default{/if}">
        {if $ETS_MM_CUSTOM_HTML_TEXT}
            <div class="mm_custom_text">
                {$ETS_MM_CUSTOM_HTML_TEXT nofilter}
            </div>
        {/if}
        {if $ETS_MM_DISPLAY_SEARCH}
            {hook h='displaySearch'}
        {/if}
        {if $ETS_MM_DISPLAY_CUSTOMER_INFO}
            {hook h='displayCustomerInforTop'}
        {/if}
        {if $ETS_MM_DISPLAY_SHOPPING_CART }
            {hook h='displayCartTop'}
        {/if}
    </div>
{/if}