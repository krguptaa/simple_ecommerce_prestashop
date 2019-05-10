/**
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
*/
var baslierfront = function(){
	$('.quiss').css('display','none');
	$('.template_slide').on('mouseenter','.slier_item>div',function(){
		$(this).find('.quiss').fadeIn(300);
	});
	$('.template_slide').on('mouseleave','.slier_item>div',function(){
		$(this).find('.quiss').fadeOut(300);
	});
	$.fn.slidercompare = function () {
		$(this).on('click','.add_to_compare',function(){
			var productId = $(this).attr('data-id-product');
			reloadProductComparison();
			compareButtonsStatusRefresh();
			totalCompareButtons();
			if($.inArray(parseInt(productId),comparedProductsIds) === -1) {
				if (comparedProductsIds.length < comparator_max_item) {
					$(this).parent('.whislist_casour').addClass('compare_check');
					$('.ba_slider_popup_background').css('display','block');
					$('.ba_popup_compare').css('display','block');
				}
			}
			else{
				$(this).parent('.whislist_casour').removeClass('compare_check');
				if (!!$.prototype.fancybox){
					$.fancybox({
						type: 'inline',
	                    autoScale: true,
	                    minHeight: 20,
	                    padding: 0,
	                    content: '<p class="ba-fancy">Removed in the comparison</p>'
					});
				}
			}
		});
	}
	$.fn.bahometabsli = function(){
	
	}
	$.fn.sliderwishlist = function () {
		$(this).on('click',function(){
			var id = $(this).attr('id_s');
			if (id_customer !== '') {
				if (!$(this).hasClass('compare_check')) {
					shs(id,'add');
					$(this).addClass('compare_check');
				}
				else{
					shs(id,'delete');
					$(this).removeClass('compare_check');
					if (!!$.prototype.fancybox){
						$.fancybox({
							type: 'inline',
				            autoScale: true,
				            minHeight: 20,
				            padding: 0,
				            content: '<p class="ba-fancy">Removed in your wishlist</p>'
						});
					}
				}
			} else {
				shs(id,'add');
			}
		})
	}
	$.fn.sliderquickview = function () {
		$(this).on('click','.quiss', function(e){
			if($(this).css('display') !== 'none') {
				e.preventDefault();
				var url = $(this).attr('rel');
				if (url.indexOf('?') != -1)
					url += '&';
				else
					url += '?';
				if (!!$.prototype.fancybox)
					$.fancybox({
						'padding':  0,
						'width':    1087,
						'height':   610,
						'type':     'iframe',
						'href':     url + 'content_only=1'
					});
			}
		});
	}
}
$.fn.fixloop = function () {
	var owl = $(this);
	$(this).on('click','.owl-nav>.owl-prev',function(){
		if($(this).hasClass('disabled')){
			$(this).parent().next('.owl-dots').find('.owl-dot:last').click();
		}
	});
	$(this).on('click','.owl-nav>.owl-next',function(){
		if($(this).parents(owl).find('.owl-item:not(.cloned):last').hasClass('active')){
			$(this).parents(owl).find('.owl-stage').css('transform','translate3d(0px, 0px, 0px)');
			$(this).removeClass('disabled');
			$('.fadeOut_1').trigger('next.owl.carousel');
		}
	});
}
function baslierremovecom(abc){
	var id = $(abc).attr('data-id-product');
	$.ajax({
		url:"index.php?controller=products-comparison&ajax=1&action=remove&id_product="+id,
		dataType: 'json ',
		data: '',
		method:'POST',
		success:function(data){
			$(abc).parent('.whislist_casour').removeClass('compare_check');
			$(abc).addClass('add_to_compare');
			$(abc).attr('onclick','');
			if (!!$.prototype.fancybox){
				$.fancybox({
					type: 'inline',
                    autoScale: true,
                    minHeight: 20,
                    padding: 0,
                    content: '<p class="ba-fancy">Removed in the comparison</p>'
				});
			}
			comparedProductsIds
		    position = comparedProductsIds.indexOf(id);
			if ( ~position ) { comparedProductsIds.splice(position, 1);}
		}
	});
}
function shs(ids,action){
	if (typeof WishlistCart === 'function') {
		WishlistCart('wishlist_block_list',action,ids,false,1);
		return false;
	}
}
$(document).ready(function($) {
	baslierfront();
	$('.wis').sliderwishlist();
	$('.bahometabsli').bahometabsli();
	$('.template_slide').slidercompare();
	$('.template_slide').sliderquickview();
	$('.ba_close_popup,.ba_slider_popup_background').on('click',function(){
		$('.ba_slider_popup_background').css('display','none');
		$('.ba_popup_compare').css('display','none');
	});
})