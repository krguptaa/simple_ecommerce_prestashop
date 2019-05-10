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
$(document).ready(function(){
	$('#td_id_category').keyup(function(){
		$('.searchLoader1').css('display','');
		$('.removeval').css('display','');
		var name_product = jQuery('#td_id_category').val();
		if (name_product.length==0) {
			$('.searchLoader1').css('display','none');
			$(".ss").css("display", "none");
			$(".removeval").css("display", "none");
		} else{
			$.ajax({
				url:base+"index.php?controller=search&fc=module&module=baproductscarousel",
				dataType: 'json ',
				data: 'name_product=' + name_product + '&id_shop='+id_shop +'&id_langs='+id_langs,
				method:'POST',
				success:function(data){
				$('.searchLoader1').css('display','none');
				/*$(".ss").html(data);*/
				product_show(data);
				}
			});
		}
	});
});
function product_show(data){
	if (data.count == 0) {
		$(".ss").css("display", "none");
	} else {
		$(".ss").css("display", "block");
	}
	var html='';
	html+="";
	for(var i = 0;i<data.count;i++){
		html+='<li rel="'+base+iso_lang+'/'+data.shows[i]['ca_link']+'/'+data.shows[i]['id_product']+'-'+data.shows[i]['pr_link']+'.html" onclick="add(this)" id="'+data.shows[i]['id_product']+'" class="ui-widget-content ui-corner-tr rga">';
		html+='<p style="padding:5px;margin:0px;font-size:11px;"  >'+data.shows[i]['pr_name']+" "+"(ref: "+data.shows[i]['reference']+")"+'</p>';
		html+='</li>';
	} 
	$(".ss").html(html);
};