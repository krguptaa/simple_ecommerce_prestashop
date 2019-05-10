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
{* <div class="row">
	<div class="col-lg-12">
		<ul class="nav nav-tabs dropss">
		    <li class="active"><a href="{$url_base|escape:'htmlall':'UTF-8'}&bl=helper" class="list-group-item group_block" id="slider_pro_setting" style="text-align: left;" title="">{l s='Slider Setting' mod='baproductscarousel'}</a></li>
	  	</ul>
    </div>
</div> *}
{if $demoMode=="1"}
	<div class="bootstrap ba_error">
		<div class="module_error alert alert-danger">
			{l s='You are use ' mod='baproductscarousel'}
			<strong>{l s='Demo Mode ' mod='baproductscarousel'}</strong>
			{l s=', so some buttons, functions will be disabled because of security. ' mod='baproductscarousel'}
			{l s='You can use them in Live mode after you puchase our module. ' mod='baproductscarousel'}
			{l s='Thanks !' mod='baproductscarousel'}
		</div>
	</div>
{/if}
<form action="" method="POST" accept-charset="utf-8">
	{foreach from=$showids item=item}
	<input class="hidden" name="id_shop" value="{$id_shop|escape:'htmlall':'UTF-8'}"></input>
	<input class="hidden" name="ids" value="{$id|escape:'htmlall':'UTF-8'}"></input>
	<div class="row">
		<div style="margin-right: 0px;" class="col-lg-2">
			<div class="list-group">
				<a style="text-align: left;" id="general" class="newdrop list-group-item group_block{if $cbt == null} active{/if}">{l s='General Settings' mod='baproductscarousel'}</a>
				<a style="text-align: left;" id="sort" class="newdrop list-group-item group_block{if $cbt == 1} active{/if}">{l s='Filter Products' mod='baproductscarousel'}</a>
				<a style="text-align: left;" id="layout" class="newdrop list-group-item group_block{if $cbt == 2} active{/if}">{l s='Layout Setting' mod='baproductscarousel'}</a>
	        </div>
		</div>
		<div class="col-lg-10">
			<div {if $cbt != null} style="display: none;" {/if} class="panel general-panel">
				<div class="panel-heading">
					<i class="icon-cogs"></i>
					{l s='GENERAL SETTINGS' mod='baproductscarousel'}
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Title' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-7">
						<input type="text" name="name_item" class="form-control" value="{$item.name|escape:'htmlall':'UTF-8'}"">
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Enable Desktop' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<span class="switch prestashop-switch fixed-width-lg" style="margin-left:2px;">
							<input type="radio" name="active_slider" id="active_slider_on" value="1" {if $item.active == '1'} checked="checked" {/if}/>
							<label for="active_slider_on" class="radioCheck">
							{l s='Yes' mod='baproductscarousel'}
							</label>
							<input type="radio" name="active_slider" id="active_slider_off" value="0" {if $item.active == '0'} checked="checked" {/if}/>
							<label for="active_slider_off" class="radioCheck">
							{l s='No' mod='baproductscarousel'}
							</label>
							<a class="slide-button btn"></a>
						</span>
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Enable on Table' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<span class="switch prestashop-switch fixed-width-lg" style="margin-left:2px;">
							<input type="radio" name="active_slidert" id="active_slidert_on" value="1" {if $item.slitable == '1'}checked="checked"{/if}/>
							<label for="active_slidert_on" class="radioCheck">
							{l s='Yes' mod='baproductscarousel'}
							</label>
							<input type="radio" name="active_slidert" id="active_slidert_off" value="0" {if $item.slitable == '0'}checked="checked"{/if} />
							<label for="active_slidert_off" class="radioCheck">
							{l s='No' mod='baproductscarousel'}
							</label>
							<a class="slide-button btn"></a>
						</span>
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Enable on Mobile' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<span class="switch prestashop-switch fixed-width-lg" style="margin-left:2px;">
							<input type="radio" name="active_sliderm" id="active_sliderm_on" value="1" {if $item.mobile == '1'}checked="checked"{/if}/>
							<label for="active_sliderm_on" class="radioCheck">
							{l s='Yes' mod='baproductscarousel'}
							</label>
							<input type="radio" name="active_sliderm" id="active_sliderm_off" value="0" {if $item.mobile == '0'}checked="checked"{/if}/>
							<label for="active_sliderm_off" class="radioCheck">
							{l s='No' mod='baproductscarousel'}
							</label>
							<a class="slide-button btn"></a>
						</span>
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Staff Only Notes' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-7">
						<textarea name="notes" class="form-control" rows="5">{$item.note|escape:'htmlall':'UTF-8'}</textarea>
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Items In Desktop' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<input type="text" name="item_show" value="{$item.item_desktop|escape:'htmlall':'UTF-8'}" >
					</div>
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Items In Mobile' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<input type="text" name="item_mobile_show" value="{$item.item_mobile|escape:'htmlall':'UTF-8'}" >
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Items In Tablet' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<input type="text" name="item_tablet_show" value="{$item.item_tablet|escape:'htmlall':'UTF-8'}" >
					</div>
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip" data-original-title="Total products display in carousel sliders">{l s='Count' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<input type="text" name="product_show" value="{$item.product_show|escape:'htmlall':'UTF-8'}" >
					</div>
				</div>
				{$sizeslide = $item.sizeslide|json_decode}
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Width Slider' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<input type="text" name="wslider" value="{$sizeslide->sliw|escape:'htmlall':'UTF-8'}" >
					</div>
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Height Slider' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<input type="text" name="hslider" value="{$sizeslide->slih|escape:'htmlall':'UTF-8'}" >
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Image Type' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<select class="form-control" name="wimage">
							{foreach from=$showtimg item=itemimg}	
						    	<option {if $sizeslide->sizeimg == $itemimg.name}selected=""{/if} value="{$itemimg.name|escape:'htmlall':'UTF-8'}">{$itemimg.name|escape:'htmlall':'UTF-8'}</option>
							{/foreach}
						</select>
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Loop Slider' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<span class="switch prestashop-switch fixed-width-lg" style="margin-left:2px;">
							<input type="radio" name="loop_slider" id="loop_slider_on" value="true" {if $item.loops == 'true'} checked="checked" {/if}/>
							<label for="loop_slider_on" class="radioCheck">
							{l s='Yes' mod='baproductscarousel'}
							</label>
							<input type="radio" name="loop_slider" id="loop_slider_off" value="false" {if $item.loops == 'false'} checked="checked" {/if}/>
							<label for="loop_slider_off" class="radioCheck">
							{l s='No' mod='baproductscarousel'}
							</label>
							<a class="slide-button btn"></a>
						</span>
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Auto Play Slider' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<span class="switch prestashop-switch fixed-width-lg" style="margin-left:2px;">
							<input type="radio" name="auto_play" id="auto_play_on" value="true" {if $item.auto_play == 'true'} checked="checked" {/if}/>
							<label for="auto_play_on" class="radioCheck">
							{l s='Yes' mod='baproductscarousel'}
							</label>
							<input type="radio" name="auto_play" id="auto_play_off" value="false" {if $item.auto_play == 'false'} checked="checked" {/if}/>
							<label for="auto_play_off" class="radioCheck">
							{l s='No' mod='baproductscarousel'}
							</label>
							<a class="slide-button btn"></a>
						</span>
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Placements' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<select class="form-control" name="block">
					    	<option {if $item.block == 'none'} selected="" {/if} class="block_t" img_demo="0" value="none">{l s='- None -' mod='baproductscarousel'}</option>
					    	<option {if $item.block == 'home page tab'} selected="" {/if} class="block_t" img_demo="1" value="home page tab">{l s='Home Page Tab (Only 1.6.x.x)' mod='baproductscarousel'}</option>
					    	<option {if $item.block == 'home page 2'} selected="" {/if} class="block_t" img_demo="img2" value="home page 2">{l s='Home Page 2' mod='baproductscarousel'}</option>
					    	<option {if $item.block == 'product page'} selected="" {/if} class="block_t" img_demo="img3" value="product page">{l s='Product Page' mod='baproductscarousel'}</option>
						</select>
						<img style="width: 100%;margin-top: 10px;" class="demo_img img-responsive" src="" alt="">
					</div>
				</div>
				<div style="" class="row panel-footer">
					<a href="{$url_base|escape:'htmlall':'UTF-8'}&bl=helper" class="btn btn-default"><i class="process-icon-cancel"></i>{l s='Cancel' mod='baproductscarousel'}</a>
					<button style="" type="submit" name="savetung" class="btn btn-default pull-right">
					<i class="process-icon-save"></i>
					{l s='Save' mod='baproductscarousel'}
					</button>
					<button style="" type="submit" name="update_item" class="btn btn-default pull-right">
					<i class="process-icon-save"></i>
					{l s='Save And Stay' mod='baproductscarousel'}
					</button>
				</div>
			</div>
			<div {if $cbt != 1} style="display: none;" {/if} class="panel sort-panel" >
				<div class="panel-heading">
					<i class="icon-cogs"></i>
					{l s='Filter Products' mod='baproductscarousel'}
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Categories' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-8">
						{$tree nofilter} {*Escape is unnecessary*}
					</div>
				</div>
				<div  class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip" data-original-title="Only display products include in this list">{l s='Products' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-8">
						<div class="input-group">
							<input type="text" id="td_id_category" autocomplete="off" name="add_pro" class="form-control">
							<span class="input-group-addon removeval" style="display: none;border-left: none;">
								<i id="icon-removeproduct" class="icon-remove removeproduct"></i>
							</span>
							<span class="input-group-addon searchLoader1" style="display: none;">
								<i id="searchLoader" class="icon-refresh icon-spin" style=""></i>
							</span>
							<span class="input-group-addon">
								<i class="icon-search"></i>
							</span>
						</div>
						<div style="" class="ss">
						</div>
						<div class="add">
							{if $product[0] !== ''}
									{foreach from=$product item=prods}
									<script>
										var url = "{$base|escape:'htmlall':'UTF-8'}{$iso_lang|escape:'htmlall':'UTF-8'}/{$prods->category|escape:'htmlall':'UTF-8'}/{$prods->id|escape:'htmlall':'UTF-8'}-{strtolower(str_replace(' ','-',$prods->name|escape:'htmlall':'UTF-8'))}"+".html";
									</script>
										<div id="div{$prods->id|escape:'htmlall':'UTF-8'}" style="margin-top:10px;float:left;width:100%">
											<button type="button" class="reser delAccessory btn btn-default" ><i class="icon-remove text-danger"></i></button>
											<input type="hidden"  name="active_pro[]" value="{$prods->id|escape:'htmlall':'UTF-8'}">
											<a class="urlss" target="_blank" href="{$base|escape:'htmlall':'UTF-8'}{$iso_lang|escape:'htmlall':'UTF-8'}/{$prods->category|escape:'htmlall':'UTF-8'}/{$prods->id|escape:'htmlall':'UTF-8'}-{$prods->link_rewrite|escape:'htmlall':'UTF-8'}.html" style="float:left;font-size:12px;margin-top: 3px;color:black;">{$prods->name} (id: {$prods->id})</a>
										</div>
									{/foreach}
								{else}
								
								{/if}
						</div>
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Sort By' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-3">
						<select class="form-control" name="order_type">
					    	<option {if $item.ordertype == 'name_asc'} selected {/if} value="name_asc">{l s='Product Name (A->Z)' mod='baproductscarousel'}</option>
					    	<option {if $item.ordertype == 'name_desc'} selected {/if} value="name_desc">{l s='Product Name (Z->A)' mod='baproductscarousel'}</option>
					    	<option {if $item.ordertype == 'price_asc'} selected {/if} value="price_asc">{l s='Price Low To High' mod='baproductscarousel'}</option>
					    	<option {if $item.ordertype == 'price_desc'} selected {/if} value="price_desc">{l s='Price High To Low' mod='baproductscarousel'}</option>
					    	<option {if $item.ordertype == 'discount_asc'} selected {/if} value="discount_asc">{l s='Discount Amount' mod='baproductscarousel'}</option>
					    	<option {if $item.ordertype == 'discount_desc'} selected {/if} value="discount_desc">{l s='Discount Percent' mod='baproductscarousel'}</option>
					    	<option {if $item.ordertype == 'date_asc'} selected {/if} value="date_asc">{l s='Latest Product' mod='baproductscarousel'}</option>
					    	<option {if $item.ordertype == 'date_desc'} selected {/if} value="date_desc">{l s='Oldest Product' mod='baproductscarousel'}</option>
					    	<option {if $item.ordertype == 'bestsell'} selected {/if} value="bestsell">{l s='Best Seller' mod='baproductscarousel'}</option>
					    	<option {if $item.ordertype == 'popular'} selected {/if} value="popular">{l s='Popular' mod='baproductscarousel'}</option>
					    	<option {if $item.ordertype == 'random'} selected {/if} value="random">{l s='Random' mod='baproductscarousel'}</option>
						</select>
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip" data-original-title="This option use to display products in the same category while viewing a product. This setting only work if carousel sliders display on Product Detail">{l s='Products Is The Same Category' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<span class="switch prestashop-switch fixed-width-lg" style="margin-left:2px;">
							<input type="radio" name="productcase" id="prore_on" value="1" {if $item.productcase == '1'} checked="checked" {/if}/>
							<label for="prore_on" class="radioCheck">
							{l s='Yes' mod='baproductscarousel'}
							</label>
							<input type="radio" name="productcase" id="prore_off" value="0" {if $item.productcase == '0'} checked="checked" {/if}/>
							<label for="prore_off" class="radioCheck">
							{l s='No' mod='baproductscarousel'}
							</label>
							<a class="slide-button btn"></a>
						</span>
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Hide Product Out Of Stock' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<span class="switch prestashop-switch fixed-width-lg" style="margin-left:2px;">
							<input type="radio" name="out_stock" id="out_stock_on" value="1" {if $item.cstock == 1}checked="checked" {/if}>
							<label for="out_stock_on" class="radioCheck">
							{l s='Yes' mod='baproductscarousel'}
							</label>
							<input type="radio" name="out_stock" id="out_stock_off" value="0" {if $item.cstock == 0}checked="checked" {/if}>
							<label for="out_stock_off" class="radioCheck">
							{l s='No' mod='baproductscarousel'}
							</label>
							<a class="slide-button btn"></a>
						</span>
					</div>
				</div>
				<div style="" class="row panel-footer">
					<a href="{$url_base|escape:'htmlall':'UTF-8'}&bl=helper" class="btn btn-default"><i class="process-icon-cancel"></i>{l s='Cancel' mod='baproductscarousel'}</a>
					<button style="" type="submit" value='1' name="savetung" class="btn btn-default pull-right">
					<i class="process-icon-save"></i>
					{l s='save' mod='baproductscarousel'}
					</button>
					<button style="" type="submit" value='1' name="update_item" class="btn btn-default pull-right">
					<i class="process-icon-save"></i>
					{l s='Save And Stay' mod='baproductscarousel'}
					</button>
				</div>
			</div>
			<div {if $cbt != 2} style="display: none;" {/if} class="panel layout-panel">
				<div class="panel-heading">
					<i class="icon-cogs"></i>
					{l s='LAYOUT SETTING' mod='baproductscarousel'}
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Show Title' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<span class="switch prestashop-switch fixed-width-lg" style="margin-left:2px;">
							<input type="radio" name="show_title" id="show_title_on" value="1" {if $item.title == 1} checked="checked" {/if} >
							<label for="show_title_on" class="radioCheck">
							{l s='Yes' mod='baproductscarousel'}
							</label>
							<input type="radio" name="show_title" id="show_title_off" value="0" {if $item.title == 0} checked="checked" {/if}>
							<label for="show_title_off" class="radioCheck">
							{l s='No' mod='baproductscarousel'}
							</label>
							<a class="slide-button btn"></a>
						</span>
					</div>
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Show Price' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<span class="switch prestashop-switch fixed-width-lg" style="margin-left:2px;">
							<input type="radio" name="show_price" id="show_price_on" value="1" checked="checked" {if $item.price == 1} checked="checked" {/if}>
							<label for="show_price_on" class="radioCheck">
							{l s='Yes' mod='baproductscarousel'}
							</label>
							<input type="radio" name="show_price" id="show_price_off" value="0" {if $item.price == 0} checked="checked" {/if}>
							<label for="show_price_off" class="radioCheck">
							{l s='No' mod='baproductscarousel'}
							</label>
							<a class="slide-button btn"></a>
						</span>
					</div>
				</div>
				{$addtocart = $item.addtocart|json_decode}
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Show Compare' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<span class="switch prestashop-switch fixed-width-lg" style="margin-left:2px;">
							<input type="radio" name="compare" id="compare_on" value="1" {if $addtocart->compare == 1} checked="checked" {/if} >
							<label for="compare_on" class="radioCheck">
							{l s='Yes' mod='baproductscarousel'}
							</label>
							<input type="radio" name="compare" id="compare_off" value="0" {if $addtocart->compare == 0} checked="checked" {/if}>
							<label for="compare_off" class="radioCheck">
							{l s='No' mod='baproductscarousel'}
							</label>
							<a class="slide-button btn"></a>
						</span>
					</div>
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Show Wish List' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<span class="switch prestashop-switch fixed-width-lg" style="margin-left:2px;">
							<input type="radio" name="wishlist" id="wishlist_on" value="1" {if $addtocart->wishlist == 1} checked="checked" {/if} >
							<label for="wishlist_on" class="radioCheck">
							{l s='Yes' mod='baproductscarousel'}
							</label>
							<input type="radio" name="wishlist" id="wishlist_off" value="0" {if $addtocart->wishlist == 0} checked="checked" {/if}>
							<label for="wishlist_off" class="radioCheck">
							{l s='No' mod='baproductscarousel'}
							</label>
							<a class="slide-button btn"></a>
						</span>
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Show Add To Cart' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<span class="switch prestashop-switch fixed-width-lg" style="margin-left:2px;">
							<input type="radio" name="addtocart" id="addtocart_on" value="1" {if $addtocart->addcart == 1} checked="checked" {/if} >
							<label for="addtocart_on" class="radioCheck">
							{l s='Yes' mod='baproductscarousel'}
							</label>
							<input type="radio" name="addtocart" id="addtocart_off" value="0" {if $addtocart->addcart == 0} checked="checked" {/if}>
							<label for="addtocart_off" class="radioCheck">
							{l s='No' mod='baproductscarousel'}
							</label>
							<a class="slide-button btn"></a>
						</span>
					</div>
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Show Nav' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<span class="switch prestashop-switch fixed-width-lg" style="margin-left:2px;">
							<input type="radio" name="show_nav" id="show_nav_on" value="true" {if $item.nav == 'true'} checked="checked" {/if}/>
							<label for="show_nav_on" class="radioCheck">
							{l s='Yes' mod='baproductscarousel'}
							</label>
							<input type="radio" name="show_nav" id="show_nav_off" value="false" {if $item.nav == 'false'} checked="checked" {/if}/>
							<label for="show_nav_off" class="radioCheck">
							{l s='No' mod='baproductscarousel'}
							</label>
							<a class="slide-button btn"></a>
						</span>
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Show Dots' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<span class="switch prestashop-switch fixed-width-lg" style="margin-left:2px;">
							<input type="radio" name="show_dots" id="show_dots_on" value="true" {if $item.dots == 'true'} checked="checked" {/if}/>
							<label for="show_dots_on" class="radioCheck">
							{l s='Yes' mod='baproductscarousel'}
							</label>
							<input type="radio" name="show_dots" id="show_dots_off" value="false" {if $item.dots == 'false'} checked="checked" {/if}/>
							<label for="show_dots_off" class="radioCheck">
							{l s='No' mod='baproductscarousel'}
							</label>
							<a class="slide-button btn"></a>
						</span>
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Color Themes' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<select class="colortheme" class="form-control" name="colortheme">
					    	<option value="orange">{l s='Orange' mod='baproductscarousel'}</option>
					    	<option value="blue">{l s='Blue' mod='baproductscarousel'}</option>
					    	<option value="red">{l s='Red' mod='baproductscarousel'}</option>
					    	<option value="yellow">{l s='Yellow' mod='baproductscarousel'}</option>
					    	<option value="gray">{l s='Gray' mod='baproductscarousel'}</option>
					    	<option value="green">{l s='Green' mod='baproductscarousel'}</option>
					    	<option value="black">{l s='Black' mod='baproductscarousel'}</option>
					    	<option value="purple">{l s='Purple' mod='baproductscarousel'}</option>
						</select>
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Background Of Arrow' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<input name="background_arrow" class="jscolor checkcolor0 form-control language_en jscolor-active" value="{$item.background_arrow|escape:'htmlall':'UTF-8'}" autocomplete="off" style="display:block; background-image: none;background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
					</div>
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Background Of Arrow On Hover' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<input name="background_arrow_hover" class="jscolor checkcolor1 form-control language_en jscolor-active" value="{$item.background_arrow_hover|escape:'htmlall':'UTF-8'}" autocomplete="off" style="display:block; background-image: none;background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Text Color Arrow' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<input name="text_color_arrow" class="jscolor checkcolor2 form-control language_en jscolor-active" value="{$item.text_color_arrow|escape:'htmlall':'UTF-8'}" autocomplete="off" style="display:block; background-image: none;background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
					</div>
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Text Color' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<input name="text_color" class="jscolor checkcolor3 form-control language_en jscolor-active" value="{$item.text_color|escape:'htmlall':'UTF-8'}" autocomplete="off" style="display:block; background-image: none;background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Background Of Button' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<input name="background_button" class="jscolor checkcolor4 form-control language_en jscolor-active" value="{$item.background_button|escape:'htmlall':'UTF-8'}" autocomplete="off" style="display:block; background-image: none;background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
					</div>
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Background Of Button On Hover' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<input name="background_button_hover" class="jscolor checkcolor5 form-control language_en jscolor-active" value="{$item.background_button_hover|escape:'htmlall':'UTF-8'}" autocomplete="off" style="display:block; background-image: none;background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
					</div>
				</div>
				<div style="margin-top: 15px" class="row">
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Color Of Text Button' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<input name="text_button_color" class="jscolor checkcolor6 form-control language_en jscolor-active" value="{$item.text_button_color|escape:'htmlall':'UTF-8'}" autocomplete="off" style="display:block; background-image: none;background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
					</div>
					<div class="col-lg-3">
						<label class="control-label">
							<span class="label-tooltip">{l s='Color Of Text Button On Hover' mod='baproductscarousel'}</span>
						</label>
					</div>
					<div class="col-lg-2">
						<input name="text_button_color_hover" class="jscolor checkcolor7 form-control language_en jscolor-active" value="{$item.text_button_color_hover|escape:'htmlall':'UTF-8'}" autocomplete="off" style="display:block; background-image: none;background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">
					</div>
				</div>
				<div style="margin-top: 15px;" class="alert alert-info">
					<p>Embed code <b>{l s='{$baproductscarousel_' mod='baproductscarousel'}{$item.id|escape:'htmlall':'UTF-8'} nofilter}</b> {l s='to file tpl of themes to active this silder' mod='baproductscarousel'}</p>
				</div>
				<div style="" class="row panel-footer">
					<a href="{$url_base|escape:'htmlall':'UTF-8'}&bl=helper" class="btn btn-default"><i class="process-icon-cancel"></i>{l s='Cancel' mod='baproductscarousel'}</a>
					<button style="" type="submit" value="2" name="savetung" class="btn btn-default pull-right">
					<i class="process-icon-save"></i>
					{l s='Save' mod='baproductscarousel'}
					</button>
					<button style="" type="submit" value="2" name="update_item" class="btn btn-default pull-right">
					<i class="process-icon-save"></i>
					{l s='Save And Stay' mod='baproductscarousel'}
					</button>
				</div>
			</div>
		</div>
	</div>
	{/foreach}
</form>