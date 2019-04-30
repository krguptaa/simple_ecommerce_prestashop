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
    <li data-id-block="{$block.id_block|intval}" class="mm_blocks_li {if !$block.enabled}mm_disabled{/if} item{$block.id_block|intval}" data-obj="block">
{/if}
<div class="mm_buttons">
    <span class="mm_block_delete" title="{l s='Delete block' mod='ets_megamenu'}">{l s='Delete' mod='ets_megamenu'}</span>
    <span class="mm_duplicate" title="{l s='Duplicate block' mod='ets_megamenu'}">{l s='Duplicate' mod='ets_megamenu'}</span>
    <span class="mm_block_edit" title="{l s='Edit block' mod='ets_megamenu'}">{l s='Edit' mod='ets_megamenu'}</span>
</div>
<div class="mm_block_wrapper">
    {hook h='displayBlock' block=$block}
</div>
{if $have_li}
    </li>
{/if}