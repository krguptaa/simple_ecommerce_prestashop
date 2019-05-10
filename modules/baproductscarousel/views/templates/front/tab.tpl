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
{if $counttest>0}
	{foreach from=$test item=titem}
		{if $titem.active == 1 && $checksdevi == 'desktop'}
			{$kas = 1}
		{elseif $titem.slitable == 1 && $checksdevi == 'table'}
			{$kas = 1}
		{elseif $titem.mobile == 1 && $checksdevi == 'mobile'}
			{$kas = 1}
		{else}
			{$kas = 0}
		{/if}
		{if $kas == 1}
			<li>
				<a data-toggle="tab" href="#baslifadeOut_{$titem.id|escape:'htmlall':'UTF-8'}" class="blockbestsellers bahometabsli">{$titem.name|escape:'htmlall':'UTF-8'}</a>
			</li>
		{/if}
	{/foreach}
{/if}