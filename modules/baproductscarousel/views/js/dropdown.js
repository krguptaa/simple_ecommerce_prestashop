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
var baslideradmin = function(){
	if ($('option.block_t:selected').attr('img_demo') != 0) {
		var opt_ch = base+'modules/'+name_m+"/views/img/"+$('option.block_t:selected').attr('img_demo')+'.png';
	    $('.demo_img').attr('src',opt_ch);
	} else {
		$('.demo_img').attr('src','');
	}
    var a ='';
	change = function(oj,backg,color,backg1,color1){
		$('.checkcolor4,.checkcolor7').val(backg.replace("#", ""));
		$('.checkcolor4,.checkcolor7').css('background-color', backg);
		$('.checkcolor4,.checkcolor7').css('color', color);
		$('.checkcolor6,.checkcolor5,.checkcolor1').val(backg1.replace("#", ""));
		$('.checkcolor6,.checkcolor5,.checkcolor1').css('background-color', backg1);
		$('.checkcolor6,.checkcolor5,.checkcolor1').css('color', color1);
	}
    $.fn.makecode = function(){
    	$(this).each(function( index ) {
			$(this).nextAll('td.bashortcode').text('{$baproductscarousel_'+$(this).text().trim()+' nofilter}');
		});
    }
    $.fn.makedup = function () {
	    $(this).find('.dropdown-menu').find('li:last').find('a').attr('onclick','demo(this)');
	    $(this).find('.dropdown-menu').find('li:last').find('a').attr('href','javascript:void(0)');
		// a = $(this).find('.noborder').val();
		// $(this).find('.dropdown-menu').find('li:not(":first")').find('a').attr('href',url_base+'&id='+a+'&duplicatebaproductscarousel');
	 	//$('.noborder').each(function( index ) {
	 	// $('.baproductscarousel tbody tr').attr('class',$(this).val());
		// 	// ls.find('li:not(":first")').find('a').attr('href',url_base+'&id='+$(this).val()+'&duplicatebaproductscarousel');
		// });
	}
	$.fn.slidermakeimg = function () {
		$(this).on('click',function(){
			if ($('option.block_t:selected').attr('img_demo') != 0) {
				var opt_ch = base+'modules/'+name_m+"/views/img/"+$('option.block_t:selected').attr('img_demo')+'.png';
				$('.demo_img').attr('src',opt_ch);
			} else {
				$('.demo_img').attr('src','');
			}
		});
	}
	$.fn.sliderdropdown = function () {
		$(this).on('click',function(){
			var id_list = $(this).attr('id');
			var class_list = $("#"+id_list+'s');
			$('.re_slide').addClass('hidden');
			$('.dropss .group_block').parent().removeClass('active');
			$(this).parent().addClass('active');
			class_list.removeClass('hidden');
		});
	}
	$.fn.dropitem = function () {/*
		$('.newdrop:first').addClass('active');
		$('.col-lg-10>.panel').not(':first').css('display','none');*/
		$(this).on('click',function(){
			var id = $(this).attr('id');
			if (!$(this).hasClass('active')) {
				$('.newdrop').removeClass('active');
				$(this).addClass('active');
				$('.col-lg-10>.panel').css('display','none');
				$('.'+id+'-panel').css('display','block');
			}
			else{
				if ($('.newdrop.active').length>1) {
					$(this).removeClass('active');
					$('.'+id+'-panel').css('display','none');
				}
			}
		});
	}
	$.fn.colortheme = function () {
		var array_color = [
			['orange','#FFFFFF','#000000','#FF5E00','#ffffff'],
			['black','#FFFFFF','#000000','#000000','#ffffff'],
			['red','#FFFFFF','#000000','#E53935','#ffffff'],
			['yellow','#FFFFFF','#000000','#FFC100','#ffffff'],
			['blue','#FFFFFF','#000000','#1DA1F3','#ffffff'],
			['green','#FFFFFF','#000000','#75B239','#ffffff'],
			['purple','#FFFFFF','#000000','#7151ED','#ffffff'],
			['gray','#FFFFFF','#000000','#5A5A5A','#ffffff'],
		];
		var i = 0;
		$(this).on('click',function(){
			var thisselect = $(this);
			if (i > 0) {
				$.each(array_color,function(key,value) {
					if(thisselect.children(':selected').val() == value[0]){
						change(key,value[1],value[2],value[3],value[4]);
					}
				});
			}
			i++
		})
	}
}
function demo(aa){
	var bb = $(aa).parents('tr').find('.testid').text();
	$(aa).attr('href', url_base+'&id='+bb+'&duplicatebaproductscarousel');
}
function add(oj){
	var text='';
	var id=$(oj).attr("id");
	var checks='div'+id;
	var url = $(oj).attr('rel');
	if(!document.getElementById(checks)){
		text += '<div id="div'+id+'" style="margin-top:10px;float:left;width:100%">';
		text += '<button type="button" class="delAccessory btn btn-default reser"><i class="icon-remove text-danger"></i></button>'
		text += '<input type="hidden" name="active_pro[]" value="'+id+'">'
		text += '<a target="_blank" href="'+url+'" style="float:left;font-size:12px;margin-top: 3px;color:black;">'+$(oj).text()+'</a>';
		text += '</div>'
    	$(".add").append(text);
	}
	/*$(".ss").css("display", "none");
	$('input[name=add_pro]').removeAttr('value');*/
}
$(document).ready(function(){
	baslideradmin();
	$('.removeval').on('click',function(){
		$(this).prev().val("");
		$(this).css('display','none')
		$('.ss').css('display','none')
	})
	$('.newdrop').dropitem();
	$('.baproductscarousel tbody tr').makedup();
	$('td.testid').makecode();
	$('.colortheme').colortheme();
	$('.block_t').parent().slidermakeimg();
	$('.dropss .group_block').sliderdropdown();
	$('body').on('click','.reser',function(){
		$(this).parent().remove();
	});
});