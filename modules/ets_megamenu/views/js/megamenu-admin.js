/**
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
 * needs please contact us for extra customization service at an affordable price
 *
 *  @author ETS-Soft <etssoft.jsc@gmail.com>
 *  @copyright  2007-2018 ETS-Soft
 *  @license    Valid for 1 website (or project) for each purchase of license
 *  International Registered Trademark & Property of ETS-Soft
 */
var mm_func = {
    search : function() {
        if ($('.mm_form .mm_product_ids').length > 0 && $('.mm_form .mm_search_product').length > 0 && typeof mmBaseAdminUrl !== "undefined")
        {
            var mm_autocomplete = $('.mm_form .mm_search_product');
            //var mm_product_ids = $('.mm_form .mm_product_ids').val();
            mm_autocomplete.autocomplete(mmBaseAdminUrl, {
                resultsClass: "mm_results",
                minChars: 1,
                delay: 300,
                appendTo: '.mm_form .mm_search_product_form',
                autoFill: false,
                max: 20,
                matchContains: false,
                mustMatch: false,
                scroll: true,
                cacheLength: 100,
                scrollHeight: 180,
                extraParams: {
                    excludeIds: $('.mm_form .mm_product_ids').val(),
                },
                formatItem: function (item) {
                    return '<span data-item-id="'+item[0]+'-'+item[1]+'" class="mm_item_title">' + (item[5] ? '<img src="'+item[5]+'" alt=""/> ' : '') + item[2] + (item[3]? item[3] : '') + (item[4] ? ' (Ref:' + item[4] + ')' : '') + '</span>';
                },
            }).result(function (event, data, formatted) {
                if (data)
                {
                    mm_func.addProduct(data, $('.mm_form .mm_product_ids'));
                }
                mm_autocomplete.val('');
                mm_func.closeSearch();
            });
        }
        $(document).on('click', '.mm_block_item_close', function () {
            if ($(this).parent('li').data('id') != '')
                mm_func.removeProduct($(this).parents('li').data('id'));
        });
        if ($('.mm_form .mm_products').length > 0) {
            mm_func.sortProductList();
        }
    },
    addProduct: function (data, mm_product_ids) {
        if ($('.mm_form .mm_products').length > 0)
        {
            if ($('.mm_form .mm_products .mm_product_loading.active').length <=0)
            {
                $('.mm_form .mm_products .mm_product_loading').addClass('active');
                $.ajax({
                    url: mmBaseAdminUrl,
                    data: {
                        ids : data[0] + '-' + data[1],
                        product_type : 'specific'
                    },
                    type: 'post',
                    dataType: 'json',
                    success: function(json)
                    {
                        if (json) 
                        {
                            $('.mm_form .mm_products .mm_product_loading.active').before(json.html);
                            if (!mm_product_ids.val()) 
                            {
                                mm_product_ids.val(data[0] + '-' + data[1]);
                            } 
                            else 
                            {
                                if (mm_product_ids.val().split(',').indexOf(data[0] + '-' + data[1]) == -1) 
                                {
                                    mm_product_ids.val(mm_product_ids.val() + ',' + data[0] + '-' + data[1]);

                                } 
                                else 
                                {
                                    showErrorMessage(data[2].toString() + ' has been tagged.');
                                }
                            }
                            //reset search
                            $('.mm_form .mm_search_product').unautocomplete();
                            mm_func.search();
                        }
                        $('.mm_form .mm_products .mm_product_loading.active').removeClass('active');

                    },
                    error: function(xhr, status, error)
                    {
                        $('.mm_form .mm_products .mm_product_loading.active').removeClass('active');
                    }
                });
            }
        }
    },
    removeIds: function (parent, element) {
        var ax = -1;
        if ((ax = parent.indexOf(element)) !== -1)
            parent.splice(ax, 1);
        return parent;
    },
    removeProduct : function(ID) {
        if ($('.mm_form .mm_products').length > 0 && $('.mm_form .mm_products .mm_product_item').length > 0 && $('.mm_form li.mm_product_item[data-id="'+ID+'"]').length >0 && $('.mm_form .mm_product_ids').length > 0)
        {
            $('.mm_form li.mm_product_item[data-id="'+ID+'"]').remove();
            if (!$('.mm_form li.mm_product_item[data-id="'+ID+'"]').length)
            {
                var IDs = $('.mm_form .mm_product_ids').val().split(',');
                $('.mm_form .mm_product_ids').val(mm_func.removeIds(IDs, ID));
            }
        }
    },
    closeSearch: function () {
        $('.mm_form .mm_search_product').val('');
        if ($('.ybc_ins_results').length > 0)
            $('.ybc_ins_results').hide();
    },
    sortProductList: function () {
        $('.mm_form .mm_products').sortable({
            update: function (e, ui) {
                if (this === ui.item.parent()[0])
                {
                    var $sort = '';
                    $('.mm_form .mm_products .mm_product_item').each(function () {
                        $sort += $(this).data('id') + ',';
                    });
                    if ($sort && $('.mm_form .mm_product_ids').length > 0)
                        $('.mm_form .mm_product_ids').val($sort);
                }
            }
        }).disableSelection();
    },
}
$(document).ready(function(){
    if($('.mm_menus_li.open .mm_tabs_ul .mm_tabs_li.open .mm_columns_ul').length)
    {
       $('.mm_menus_li.open .mm_tabs_ul').css('height',($('.mm_menus_li.open .mm_tabs_ul .mm_tabs_li.open .mm_columns_ul').height()+300)+'px') 
    }
    $(window).load(function(){
        displayHeightTab();
        displayCountDownClock();
    });
    if($('input[name="ETS_MM_DISPLAY_SEARCH"]:checked').val()==1)
    {
        $('.form-group.mm_form_display_search').show();
    }
    else
        $('.form-group.mm_form_display_search').hide();
    $(document).on('click','input[name="ETS_MM_DISPLAY_SEARCH"]',function(){
        if($('input[name="ETS_MM_DISPLAY_SEARCH"]:checked').val()==1)
        {
            $('.form-group.mm_form_display_search').show();
        }
        else
            $('.form-group.mm_form_display_search').hide();
    });
    $(document).on('click', '#awesome-icon .mm_icon', function () {
        if ($('.dummyfile > input.mm_browse_icon').length > 0)
        {
            $('.dummyfile > input.mm_browse_icon').val($(this).data('icon'));
            $('.mm_pop_up .mm_close').click();
            $('.dummyfile > input.mm_browse_icon').focus();
        }
    });
    $(document).on('click', '.mm_browse_icon button[type="button"]', function () {
        if ($('.mm_menu_form.mm_pop_up').length > 0 && !$('.mm_menu_form.mm_pop_up').hasClass('hidden') && $('.mm_icon_form_new').length > 0)
        {
            $('.mm_menu_form.mm_pop_up').addClass('hidden').removeClass('mm_pop_up');
            $('.mm_icon_form_new').removeClass('hidden').addClass('mm_pop_up');
        }
    });
   $(document).on('click','.mm_add_menu',function(){
        $('.mm_pop_up').addClass('hidden');
        $('.mm_menu_form').removeClass('hidden');   
        $('.mm_forms').removeClass('hidden').parents('.mm_popup_overlay').removeClass('hidden'); 
        if($('.mm_menu_form .mm_form form input[name="itemId"]').length <= 0 || $('.mm_menu_form .mm_form form input[name="mm_object"]')!='MM_Menu'  || $('.mm_menu_form .mm_form form input[name="itemId"]').length > 0 && parseInt($('.mm_menu_form .mm_form form input[name="itemId"]').val())!=0)
            $('.mm_menu_form .mm_form').html($('.mm_menu_form_new').html());
        checkFormFields();
        $('.mm-alert').remove();
        return false;     
   }); 
   $(document).on('click','.checkbox_all input',function(){
        if($(this).is(':checked'))
        {
            $(this).closest('.form-group').find('input').attr('checked','checked');
        }
        else
        {
            $(this).closest('.form-group').find('input').removeAttr('checked');
        }
   });
   $(document).on('click','.checkbox input',function(){
        if($(this).is(':checked'))
        {
            if($(this).closest('.form-group').find('input:checked').length==$(this).closest('.form-group').find('input').length-1)
                 $(this).closest('.form-group').find('.checkbox_all input').attr('checked','checked');
        }
        else
        {
            $(this).closest('.form-group').find('.checkbox_all input').removeAttr('checked');
        } 
   });
   $(document).on('click','input[name="ETS_MM_VERTICAL_ENABLED"],input[name="ETS_MM_STICKY_ENABLED"],input[name="display_mnu_img"],input[name="display_suppliers_img"]',function(){
        checkFormFields();
   });
   $(document).on('change','select[name="enabled_vertical"],select[name="sub_menu_type"]',function(){
        checkFormFields();
   });
   $(document).on('click','.mm_import_button',function(){
        $(this).parents('.mm_pop_up').addClass('hidden');
        $(this).parents('.mm_forms').addClass('hidden');
        $('.mm_export_form').removeClass('hidden');
        $('.mm_export.mm_pop_up').removeClass('hidden');
   });
   $(document).on('click','.mm_menu_toggle',function(){
        if(!$(this).parents('.mm_menus_li').eq(0).hasClass('open'))
        {
            $('.mm_menus_li').removeClass('open');
            $(this).parents('.mm_menus_li').eq(0).addClass('open');
            if($('.mm_menus_li.open .mm_tabs_li').length>0)
            {
                $('.mm_menus_li.open .mm_tabs_li').removeClass('open');
                $('.mm_menus_li.open .mm_tabs_li:first-child').addClass('open');
            } 
            displayHeightTab();  
        }
   });
   $(document).on('click','.mm_tab_toggle',function(){
        if(!$(this).parents('.mm_tabs_li').eq(0).hasClass('open'))
        {
            $('.mm_tabs_li').removeClass('open');
            $(this).parents('.mm_tabs_li').eq(0).addClass('open');  
            displayHeightTab(); 
        }
   });
   $(document).on('click','.mm_save',function(){
        tinyMCE.triggerSave();
        if(!$(this).parents('form').eq(0).hasClass('active') && $('.defaultForm.active').length <= 0)
        {
            $(this).parents('form').eq(0).addClass('active');
            $(this).parents('.mm_save_wrapper').eq(0).addClass('loading');
            $('.mm-alert').remove();
            var formData = new FormData($(this).parents('form').get(0));
            if($('.defaultForm.active input[type="file"]').length > 0)
            {
                $('.defaultForm.active input[type="file"]').each(function(){
                    if (document.getElementById($(this).attr('id')).files.length == 0 ) {
                          formData.delete($(this).attr('id'));
                    }
                });
            }       
            $.ajax({
                url: $(this).parents('form').eq(0).attr('action'),
                data: formData,
                type: 'post',
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(json){
                    showSaveMessage(json.alert);
                    $('.mm_save_wrapper').removeClass('loading');                    
                    if(json.images && json.success)
                    {
                       $.each(json.images,function(i,item){
                            if($('.defaultForm.active input[name="'+item.name+'"]').length > 0)
                            {
                                updatePreviewImage(item.name,item.url,item.delete_url);
                            }
                       });
                    }
                    if(json.itemId && json.itemKey && json.success)
                    {
                        $('.defaultForm.active input[name="'+json.itemKey+'"]').val(json.itemId);
                        $('.defaultForm.active input[name="itemId"]').val(json.itemId);
                    }
                    if(json.mm_object=='MM_Menu' && json.success && json.title)
                    {                        
                        if($('.mm_menus ul').length <= 0)
                        {
                            $('.mm_menus').append('<ul class="mm_menus_ul"></ul>');
                            //Sortable  
                            mmSort('.mm_menus_ul'); 
                        }                            
                        if($('.mm_menus > ul.mm_menus_ul > li.item'+json.itemId).length <=0 )
                        {
                            $('.mm_menus_li').removeClass('open');
                            $('.mm_menus > ul.mm_menus_ul').append('<li class="mm_menus_li '+(!json.vals.enabled ? ' mm_disabled ' : '')+' item'+json.itemId+' open" data-id-menu="'+json.itemId+'" data-obj="menu">'+json.vals.html_content+'</li>');   
                            $('.mm_form form .panel-heading').html(mmEditMenuTxt);
                            mmSort('.mm_tabs_ul_content');
                            mmSort('.mm_columns_ul'); 
                            mmSort('.mm_blocks_ul');                           
                        }                            
                        else
                        {
                            $('.mm_menus > ul.mm_menus_ul > li.item'+json.itemId).html(json.vals.html_content);
                            mmSort('.mm_tabs_ul_content');
                            mmSort('.mm_columns_ul');
                            mmSort('.mm_blocks_ul');  
                        }
                        if($('.mm_menus_li.open .mm_tabs_li').length>0)
                        {
                            $('.mm_menus_li.open .mm_tabs_li:first-child').addClass('open');
                        }                                                    
                    } 
                    if(json.mm_object=='MM_Tab' && json.success)
                    {
                        if($('.mm_menus_li.item'+json.vals.id_menu+' > div.mm_tabs_ul > ul.mm_tabs_ul_content').length <= 0)
                        {
                            $('.mm_menus_li.item'+json.vals.id_menu).append('<div class="mm_tabs_ul"><ul class="mm_tabs_ul_content"></ul></div>');
                            //Sortable                            
                            mmSort('.mm_tabs_ul_content'); 
                        }                            
                        if($('.mm_menus_li.item'+json.vals.id_menu+' > div.mm_tabs_ul > ul.mm_tabs_ul_content > li.item'+json.itemId).length <=0 )
                        {
                            $('.mm_tabs_li').removeClass('open');
                            $('.mm_menus_li.item'+json.vals.id_menu+' > div.mm_tabs_ul > ul.mm_tabs_ul_content').append('<li class="mm_tabs_li item'+json.itemId+(!json.vals.enabled ? ' mm_disabled ' : '')+' open" data-id-tab="'+json.itemId+'" data-obj="tab">'+json.vals.html_content+'</li>');
                            $('.mm_form form .panel-heading').html(mmEditColumnTxt);
                            mmSort('.mm_tabs_ul_content');
                            mmSort('.mm_columns_ul'); 
                        }                            
                        else
                        {
                            $('ul.mm_tabs_ul_content > li.item'+json.itemId).html(json.vals.html_content);
                            mmSort('.mm_tabs_ul_content');
                            mmSort('.mm_columns_ul');
                            mmSort('.mm_blocks_ul'); 
                            
                        }    
                    }                    
                    if(json.mm_object=='MM_Column' && json.success)
                    {
                        if($('.mm_menus_li.item'+json.vals.id_menu+' > div.mm_tabs_ul > ul.mm_tabs_ul_content').length<=0)
                        {
                            if($('.mm_menus_li.item'+json.vals.id_menu+' > ul.mm_columns_ul').length <= 0)
                            {
                                $('.mm_menus_li.item'+json.vals.id_menu).append('<ul class="mm_columns_ul"></ul>');
                                //Sortable    
                                mmSort('.mm_tabs_ul_content');                        
                                mmSort('.mm_columns_ul'); 
                            }                            
                            if($('.mm_menus_li.item'+json.vals.id_menu+' > ul.mm_columns_ul > li.item'+json.itemId).length <=0 )
                            {
                                $('.mm_menus_li.item'+json.vals.id_menu+' > ul.mm_columns_ul').append('<li class="mm_columns_li item'+json.itemId+' column_size_'+json.vals.column_size+' '+(json.vals.is_breaker ? 'mm_breaker' : '')+'" data-id-column="'+json.itemId+'" data-obj="column">'+json.vals.html_content+'</li>');
                                $('.mm_form form .panel-heading').html(mmEditColumnTxt);
                                mmSort('.mm_blocks_ul'); 
                            }                            
                            else
                                $('.mm_menus_li.item'+json.vals.id_menu+' > ul.mm_columns_ul > li.item'+json.itemId).attr('class','mm_columns_li item'+json.itemId+' column_size_'+json.vals.column_size+' '+(json.vals.is_breaker ? 'mm_breaker' : ''));                           
                        }
                        else
                        {
                            if($('.mm_tabs_li.item'+json.vals.id_tab+' > ul.mm_columns_ul').length <= 0)
                            {
                                $('.mm_tabs_li.item'+json.vals.id_tab).append('<ul class="mm_columns_ul"></ul>');
                                //Sortable    
                                mmSort('.mm_tabs_ul_content');                        
                                mmSort('.mm_columns_ul'); 
                            }                            
                            if($('.mm_tabs_li.item'+json.vals.id_tab+' > ul.mm_columns_ul > li.item'+json.itemId).length <=0 )
                            {
                                $('.mm_tabs_li.item'+json.vals.id_tab+' > ul.mm_columns_ul').append('<li class="mm_columns_li item'+json.itemId+' column_size_'+json.vals.column_size+' '+(json.vals.is_breaker ? 'mm_breaker' : '')+'" data-id-column="'+json.itemId+'" data-obj="column">'+json.vals.html_content+'</li>');
                                $('.mm_form form .panel-heading').html(mmEditColumnTxt);
                                mmSort('.mm_blocks_ul'); 
                            }                            
                            else
                                $('.mm_tabs_li.item'+json.vals.id_tab+' > ul.mm_columns_ul > li.item'+json.itemId).attr('class','mm_columns_li item'+json.itemId+' column_size_'+json.vals.column_size+' '+(json.vals.is_breaker ? 'mm_breaker' : ''));
                        }
                    } 
                    if(json.mm_object=='MM_Block' && json.success && json.vals.blockHtml)
                    {
                        if($('.mm_columns_li.item'+json.vals.id_column+' > ul.mm_blocks_ul').length <= 0)
                        {
                            $('.mm_columns_li.item'+json.vals.id_column).append('<ul class="mm_blocks_ul"></ul>');
                            //Sortable                            
                            mmSort('.mm_blocks_ul'); 
                        }                            
                        if($('.mm_columns_li.item'+json.vals.id_column+' > ul.mm_blocks_ul > li.item'+json.itemId).length <=0 )
                        {
                            $('.mm_columns_li.item'+json.vals.id_column+' > ul.mm_blocks_ul').append('<li class="mm_blocks_li '+(!json.vals.enabled ? ' mm_disabled ' : '')+' item'+json.itemId+'" data-id-block="'+json.itemId+'" data-obj="block">'+'<div class="mm_buttons"><span class="mm_block_delete" title="'+mmDeleteBlockTxt+'">'+mmDeleteTxt+'</span><span class="mm_duplicate" title="'+mmDuplicateBlockTxt+'">'+mmDuplicateTxt+'</span><span class="mm_block_edit" title="'+mmEditBlockTxt+'">'+mmEditTxt+'</span></div><div class="mm_block_wrapper">'+json.vals.blockHtml+'</div></li>');
                            $('.mm_form form .panel-heading').html(mmEditBlockTxt);
                        }                            
                        else
                        {
                            $('.mm_columns_li.item'+json.vals.id_column+' > ul.mm_blocks_ul > li.item'+json.itemId + ' .mm_block_wrapper').html(json.vals.blockHtml);
                            if(json.vals.enabled)
                                $('.mm_columns_li.item'+json.vals.id_column+' > ul.mm_blocks_ul > li.item'+json.itemId).removeClass('mm_disabled');
                            else
                                $('.mm_columns_li.item'+json.vals.id_column+' > ul.mm_blocks_ul > li.item'+json.itemId).addClass('mm_disabled');
                        }                            
                    }                    
                    $('.defaultForm.active').removeClass('active');
                    if(json.success)
                    {
                        mmAlertSucccess($('.mm_menu_form .alert-success').html());
                        $('.mm_pop_up').addClass('hidden').parents('.mm_forms').addClass('hidden').parents('.mm_popup_overlay').addClass('hidden');
                    } 
                    displayHeightTab();   
                    var $images = $('.ets_megamenu img');
                    $images.load(function(){
                        displayHeightTab();
                    });
                    displayCountDownClock();                
                },
                error: function(xhr, status, error)
                {
                    $('.defaultForm.active').removeClass('active');
                    $('.mm_save_wrapper').removeClass('loading'); 
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);                    
                }
            });   
        } 
        return false;       
   });
   $(document).on('click','.mm_close',function(){
       if ($('.mm_icon_form_new').hasClass('mm_pop_up'))
       {
           $('.mm_icon_form_new').removeClass('mm_pop_up').addClass('hidden');
           $('.mm_menu_form').removeClass('hidden').addClass('mm_pop_up');
       }
       else
       {
           $(this).parents('.mm_pop_up').addClass('hidden').parents('.mm_popup_overlay').addClass('hidden');
           $(this).parents('.mm_forms').addClass('hidden');
       }
       $('.mm_export_form').addClass('hidden');
   });
   $(document).on('change','input[type="file"]',function(){
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp','zip'];
        
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $(this).val('');
            if($(this).next('.dummyfile').length > 0)
            {
                $(this).next('.dummyfile').eq(0).find('input[type="text"]').val('');
            }
            if($(this).parents('.col-lg-9').eq(0).find('.preview_img').length > 0)
                $(this).parents('.col-lg-9').eq(0).find('.preview_img').eq(0).remove(); 
            if($(this).parents('.col-lg-9').eq(0).next('.uploaded_image_label').length > 0)
            {
                $(this).parents('.col-lg-9').eq(0).next('.uploaded_image_label').removeClass('hidden');
                $(this).parents('.col-lg-9').eq(0).next('.uploaded_image_label').next('.uploaded_img_wrapper').removeClass('hidden');
            }            
            alert(ets_mm_invalid_file);
        }
        else
        {
            readURL(this);            
        }       
    });
    $(document).on('click','.del_preview',function(){
        var $this=$(this);
        var field_name=''
        var object_name='';
        var idItem=0;
        $(this).parents('form').eq(0).addClass('active');
        if($(this).parents('.col-lg-9').eq(0).find('input[type="file"]').length > 0)
        {
            var field_name=$(this).parents('.col-lg-9').eq(0).find('input[type="file"]').eq(0).attr('name');
        }
        if($(this).parents('form').eq(0).find('input[name="mm_object"]').length > 0)
        {
            var object_name=$(this).parents('form').eq(0).find('input[name="mm_object"]').eq(0).val();
        }
        if($(this).parents('form').eq(0).find('input[name="itemId"]').length > 0)
        {
            var idItem=$(this).parents('form').eq(0).find('input[name="itemId"]').eq(0).val();
        }
        if(field_name && object_name)
        {
            $.ajax({
                url: '',
                data: 'deleteimage='+field_name+'&itemId='+idItem+'&mm_object='+object_name,
                type: 'post',
                dataType: 'json',                
                success: function(json){
                    showSaveMessage(json.alert);   
                    if($this.parents('.col-lg-9').eq(0).next('.uploaded_image_label').length > 0)
                    {
                        $this.parents('.col-lg-9').eq(0).next('.uploaded_image_label').removeClass('hidden');
                        $this.parents('.col-lg-9').eq(0).next('.uploaded_image_label').next('.uploaded_img_wrapper').removeClass('hidden');
                    }
                    $this.parents('.col-lg-9').eq(0).find('.dummyfile input[type="text"]').val('');
                    if($this.parents('.col-lg-9').eq(0).find('input[type="file"]').length > 0)
                    {
                        $this.parents('.col-lg-9').eq(0).find('input[type="file"]').eq(0).val('');
                    }  
                    $this.parents('.preview_img').remove();                 
                    $('.defaultForm.active').removeClass('active');
                },
                error: function(xhr, status, error)
                {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                    $('.defaultForm.active').removeClass('active');
                }
            });
        }
    });
    $(document).on('click','.delete_url',function(){
        var delLink = $(this);
        if(!$(this).parents('form').eq(0).hasClass('active') && $('.defaultForm.active').length <= 0)
        {
            $(this).parents('form').eq(0).addClass('active');
            $.ajax({
                url: $(this).attr('href'),
                data: {},
                type: 'post',
                dataType: 'json',                
                success: function(json){
                    showSaveMessage(json.alert);   
                    if(json.success)
                    {
                        delLink.parents('.uploaded_img_wrapper').eq(0).prev('.uploaded_image_label').eq(0).remove();
                        delLink.parents('.uploaded_img_wrapper').eq(0).remove();
                    }                 
                    $('.defaultForm.active').removeClass('active');
                },
                error: function(xhr, status, error)
                {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                    $('.defaultForm.active').removeClass('active');
                }
            });
        }
        return false;
    });
    $(document).on('click','.mm_menu_edit',function(){
        if(!$(this).hasClass('active'))
        {
            $(this).addClass('active');
            $('.ets_megamenu').addClass('loading-form');            
            $('.mm-alert').remove();
            $.ajax({
                url: mmBaseAdminUrl,
                dataType: 'json',
                type: 'post',
                data: {
                    itemId: $(this).parents('li').eq(0).data('id-menu'),
                    request_form: 1,
                    mm_object: 'MM_Menu',                
                },
                success: function(json){
                    showSaveMessage(json.alert);  
                    $('.mm_pop_up').addClass('hidden'); 
                    $('.mm_forms').removeClass('hidden');
                    $('.mm_menu_form').removeClass('hidden');
                    $('.mm_menu_form .mm_form').html(json.form);
                    checkFormFields();
                    $('.mm_menu_form .mm_form .mColorPickerInput').mColorPicker();
                    $('.mm_menus_li.item'+json.itemId+' .mm_menu_edit').removeClass('active');
                    $('.mm_menus_li').removeClass('open');
                    $('.mm_menus_li.item'+json.itemId).addClass('open');
                    $('.ets_megamenu').removeClass('loading-form');
                },
                error: function(xhr, status, error)
                {
                    $('.mm_menu_edit').removeClass('active');
                    $('.ets_megamenu').removeClass('loading-form');
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            }); 
        }               
    });
    $(document).on('click','.mm_menu_delete',function(){
            if(!$(this).hasClass('active'))
            {
                $(this).addClass('active');
                $.ajax({
                    url: mmBaseAdminUrl,
                    dataType: 'json',
                    type: 'post',
                    data: {
                        itemId: $(this).parents('li').eq(0).data('id-menu'),
                        deleteobject: 1,
                        mm_object: 'MM_Menu',                
                    },
                    success: function(json){
                        if(json.success)
                        {
                            if($('.mm_menus_li.item'+json.itemId).hasClass('open'))
                            {
                                if($('.mm_menus_li.item'+json.itemId).prev('li').length > 0)
                                    $('.mm_menus_li.item'+json.itemId).prev('li').addClass('open');
                                else 
                                if($('.mm_menus_li.item'+json.itemId).next('li').length > 0)
                                    $('.mm_menus_li.item'+json.itemId).next('li').addClass('open');
                            }                            
                            $('.mm_menus_li.item'+json.itemId).remove();
                            mmAlertSucccess(json.successMsg); 
                        }                            
                        else
                            $('.mm_menus_li.item'+json.itemId+' .mm_menu_delete').removeClass('active');
                        displayHeightTab();
                    },
                    error: function(xhr, status, error)
                    {
                        $('.mm_menu_delete').removeClass('active');
                        var err = eval("(" + xhr.responseText + ")");
                        alert(err.Message);
                    }
                });
            }            
        return false;
    });
    
    //Column
    
    $(document).on('click','.mm_add_column',function(){  
        $('.mm_pop_up').addClass('hidden');
        $('.mm_forms').removeClass('hidden');
        $('.mm_menu_form').removeClass('hidden');   
        if($('.mm_menu_form .mm_form form input[name="itemId"]').length <= 0 || $('.mm_menu_form .mm_form form input[name="mm_object"]')!='MM_Column'  || $('.mm_menu_form .mm_form form input[name="itemId"]').length > 0 && (parseInt($('.mm_menu_form .mm_form form input[name="itemId"]').val())!=0 || parseInt($('.mm_menu_form .mm_form form input[name="itemId"]').val())==0 && parseInt($('.mm_menu_form .mm_form form input[name="id_menu"]').val()))!=parseInt($(this).attr('data-id-menu')))
        {
            $('.mm_menu_form .mm_form').html($('.mm_column_form_new').html()); 
            $('.mm_menu_form .mm_form form input[name="id_menu"]').val($(this).attr('data-id-menu')); 
            $('.mm_menu_form .mm_form form input[name="id_tab"]').val(parseInt($(this).attr('data-id-tab')));             
        }
        $('.mm-alert').remove();
        return false;     
    }); 
    $(document).on('click','.mm_add_tab',function(){  
        $('.mm_pop_up').addClass('hidden');
        $('.mm_forms').removeClass('hidden');
        $('.mm_menu_form').removeClass('hidden');   
        if($('.mm_menu_form .mm_form form input[name="itemId"]').length <= 0 || $('.mm_menu_form .mm_form form input[name="mm_object"]')!='MM_Tab'  || $('.mm_menu_form .mm_form form input[name="itemId"]').length > 0 && (parseInt($('.mm_menu_form .mm_form form input[name="itemId"]').val())!=0 || parseInt($('.mm_menu_form .mm_form form input[name="itemId"]').val())==0 && parseInt($('.mm_menu_form .mm_form form input[name="id_menu"]').val()))!=parseInt($(this).attr('data-id-menu')))
        {
            $('.mm_menu_form .mm_form').html($('.mm_tab_form_new').html()); 
            $('.mm_menu_form .mm_form form input[name="id_menu"]').val($(this).attr('data-id-menu'));              
        }
        $('.mm-alert').remove();
        return false;     
    });
    $(document).on('click','.mm_tab_delete',function(){
            if(!$(this).hasClass('active'))
            {
                $(this).addClass('active');
                $.ajax({
                    url: mmBaseAdminUrl,
                    dataType: 'json',
                    type: 'post',
                    data: {
                        itemId: $(this).parents('li').eq(0).data('id-tab'),
                        deleteobject: 1,
                        mm_object: 'MM_Tab',                
                    },
                    success: function(json){
                        if(json.success)
                        {
                            if($('.mm_tabs_li.item'+json.itemId).hasClass('open'))
                            {
                                if($('.mm_tabs_li.item'+json.itemId).prev('li').length > 0)
                                    $('.mm_tabs_li.item'+json.itemId).prev('li').addClass('open');
                                else 
                                if($('.mm_tabs_li.item'+json.itemId).next('li').length > 0)
                                    $('.mm_tabs_li.item'+json.itemId).next('li').addClass('open');
                            }                            
                            $('.mm_tabs_li.item'+json.itemId).remove();
                            mmAlertSucccess(json.successMsg); 
                        }                            
                        else
                            $('.mm_tabs_li.item'+json.itemId+' .mm_tab_delete').removeClass('active');
                        displayHeightTab();
                    },
                    error: function(xhr, status, error)
                    {
                        $('.mm_menu_delete').removeClass('active');
                        var err = eval("(" + xhr.responseText + ")");
                        alert(err.Message);
                    }
                });
            }            
        return false;
    });    
    $(document).on('click','.mm_column_delete',function(){
            if(!$(this).hasClass('active'))
            {
                $(this).addClass('active');
                $.ajax({
                    url: mmBaseAdminUrl,
                    dataType: 'json',
                    type: 'post',
                    data: {
                        itemId: $(this).parents('li').eq(0).data('id-column'),
                        deleteobject: 1,
                        mm_object: 'MM_Column',                
                    },
                    success: function(json){
                        if(json.success)
                        {
                            $('.mm_columns_li.item'+json.itemId).remove();
                            mmAlertSucccess(json.successMsg);
                        }                            
                        else
                            $('.mm_columns_li.item'+json.itemId+' .mm_column_delete').removeClass('active');
                        displayHeightTab();
                    },
                    error: function(xhr, status, error)
                    {
                        $('.mm_column_delete').removeClass('active');
                        var err = eval("(" + xhr.responseText + ")");
                        alert(err.Message);
                    }
                });
            }            
        return false;
    });
    $(document).on('click','.mm_column_edit',function(){
        if(!$(this).hasClass('active'))
        {
            $('.ets_megamenu').addClass('loading-form');
            $(this).addClass('active');
            $('.mm-alert').remove();
            $.ajax({
                url: mmBaseAdminUrl,
                dataType: 'json',
                type: 'post',
                data: {
                    itemId: $(this).parents('li').eq(0).data('id-column'),
                    request_form: 1,
                    mm_object: 'MM_Column',                
                },
                success: function(json){       
                    $('.mm_pop_up').addClass('hidden');
                    $('.mm_forms').removeClass('hidden');
                    $('.mm_menu_form').removeClass('hidden');
                    $('.mm_menu_form .mm_form').html(json.form);
                    checkFormFields();
                    $('.mm_menu_form .mm_form .mColorPickerInput').mColorPicker();
                    $('.mm_columns_li.item'+json.itemId+' .mm_column_edit').removeClass('active');
                    $('.ets_megamenu').removeClass('loading-form');
                },
                error: function(xhr, status, error)
                {
                    $('.mm_column_edit').removeClass('active');
                    $('.ets_megamenu').removeClass('loading-form');
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            }); 
        }               
    });
    $(document).on('click','.mm_tab_edit',function(){
        if(!$(this).hasClass('active'))
        {
            $('.ets_megamenu').addClass('loading-form');
            $(this).addClass('active');
            $('.mm-alert').remove();
            $.ajax({
                url: mmBaseAdminUrl,
                dataType: 'json',
                type: 'post',
                data: {
                    itemId: $(this).parents('li').eq(0).data('id-tab'),
                    request_form: 1,
                    mm_object: 'MM_Tab',                
                },
                success: function(json){       
                    $('.mm_pop_up').addClass('hidden');
                    $('.mm_forms').removeClass('hidden');
                    $('.mm_menu_form').removeClass('hidden');
                    $('.mm_menu_form .mm_form').html(json.form);
                    checkFormFields();
                    $('.mm_menu_form .mm_form .mColorPickerInput').mColorPicker();
                    $('.mm_tabs_li.item'+json.itemId+' .mm_tab_edit').removeClass('active');
                    $('.ets_megamenu').removeClass('loading-form');
                },
                error: function(xhr, status, error)
                {
                    $('.mm_tab_edit').removeClass('active');
                    $('.ets_megamenu').removeClass('loading-form');
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            }); 
        }               
    });
    //Block
    $(document).on('click','.mm_add_block',function(){ 
        $('.mm_pop_up').addClass('hidden');
        $('.mm_menu_form').removeClass('hidden');
        $('.mm_forms').removeClass('hidden');   
        if($('.mm_menu_form .mm_form form input[name="itemId"]').length <= 0 || $('.mm_menu_form .mm_form form input[name="mm_object"]')!='MM_Block'  || $('.mm_menu_form .mm_form form input[name="itemId"]').length > 0 && (parseInt($('.mm_menu_form .mm_form form input[name="itemId"]').val())!=0 || parseInt($('.mm_menu_form .mm_form form input[name="itemId"]').val())==0 && parseInt($('.mm_menu_form .mm_form form input[name="id_column"]').val()))!=parseInt($(this).attr('data-id-column')))
        {
            $('.mm_menu_form .mm_form').html($('.mm_block_form_new').html()); 
            $('.mm_menu_form .mm_form form input[name="id_column"]').val($(this).attr('data-id-column')); 
            checkFormFields();
        }
        $('.mm-alert').remove();
        return false;     
    }); 
    $(document).on('click','.mm_block_edit',function(){
        if(!$(this).hasClass('active'))
        {
            $(this).addClass('active');
            $('.ets_megamenu').addClass('loading-form');
            $('.mm-alert').remove();
            $.ajax({
                url: mmBaseAdminUrl,
                dataType: 'json',
                type: 'post',
                data: {
                    itemId: $(this).parents('li').eq(0).data('id-block'),
                    request_form: 1,
                    mm_object: 'MM_Block',                
                },
                success: function(json){        
                    $('.mm_pop_up').addClass('hidden');
                    $('.mm_forms').removeClass('hidden');  
                    $('.mm_menu_form').removeClass('hidden');
                    $('.mm_menu_form .mm_form').html(json.form);
                    checkFormFields();
                    if ($('#block_type').length > 0 && $('#block_type').val() == 'PRODUCT')
                    {
                        mm_func.search();
                    }
                    $('.mm_menu_form .mm_form .mColorPickerInput').mColorPicker();
                    $('.mm_blocks_li.item'+json.itemId+' .mm_block_edit').removeClass('active');
                    $('.ets_megamenu').removeClass('loading-form');
                },
                error: function(xhr, status, error)
                {
                    $('.mm_block_edit').removeClass('active');
                    $('.ets_megamenu').removeClass('loading-form');
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            }); 
        }               
    });
    $(document).on('click','.mm_block_delete',function(){
            if(!$(this).hasClass('active'))
            {
                $(this).addClass('active');
                $.ajax({
                    url: mmBaseAdminUrl,
                    dataType: 'json',
                    type: 'post',
                    data: {
                        itemId: $(this).parents('li').eq(0).data('id-block'),
                        deleteobject: 1,
                        mm_object: 'MM_Block',                
                    },
                    success: function(json){
                        if(json.success)
                        {
                            $('.mm_blocks_li.item'+json.itemId).remove();
                            mmAlertSucccess(json.successMsg);
                        }                            
                        else
                            $('.mm_blocks_li.item'+json.itemId+' .mm_block_delete').removeClass('active');
                        displayHeightTab();
                    },
                    error: function(xhr, status, error)
                    {
                        $('.mm_block_delete').removeClass('active');
                        var err = eval("(" + xhr.responseText + ")");
                        alert(err.Message);
                    }
                });
            }            
        return false;
    });
    
    //Duplicate
    $(document).on('click','.mm_duplicate',function(){
            if(!$(this).hasClass('active'))
            {
                $(this).addClass('active');
                var mm_object = $(this).parents('li').eq(0).data('obj');
                var itemId = 0;
                if(mm_object=='menu')
                    itemId = $(this).parents('li').eq(0).data('id-menu');
                else if(mm_object=='column') 
                    itemId = $(this).parents('li').eq(0).data('id-column');
                else if(mm_object=='tab')
                    itemId = $(this).parents('li').eq(0).data('id-tab');
                else
                    itemId = $(this).parents('li').eq(0).data('id-block');
                $.ajax({
                    url: mmBaseAdminUrl,
                    dataType: 'json',
                    type: 'post',
                    data: {
                        itemId: itemId,
                        duplicateItem: 1,
                        mm_object: mm_object,                
                    }, 
                    success: function(json){
                        if(json.mm_object!='menu')
                        {
                            if($('li[data-id-'+json.mm_object+'="'+json.itemId+'"] > .mm_buttons .mm_duplicate').length > 0)
                                $('li[data-id-'+json.mm_object+'="'+json.itemId+'"] > .mm_buttons .mm_duplicate').removeClass('active');
                        }
                        else
                        {
                            if($('li[data-id-'+json.mm_object+'="'+json.itemId+'"] > .mm_menus_li_content .mm_buttons > .mm_duplicate').length > 0)
                                $('li[data-id-'+json.mm_object+'="'+json.itemId+'"] > .mm_menus_li_content .mm_buttons > .mm_duplicate').removeClass('active');
                        }
                        if(json.html)
                        {
                            if($('li[data-id-'+json.mm_object+'="'+json.itemId+'"]').length > 0)
                                $('li[data-id-'+json.mm_object+'="'+json.itemId+'"]').after(json.html);
                            else
                                if($('ul.mm_'+json.mm_object+'s_ul').length > 0)
                                    $('ul.mm_'+json.mm_object+'s_ul').append(json.html);
                        }
                        if(json.mm_object=='menu')
                        {
                            $('.mm_menus_li').removeClass('open');
                            $('li[data-id-'+json.mm_object+'="'+json.newItemId+'"]').addClass('open');
                            if($('.mm_menus_li.open .mm_tabs_li').length>0)
                            {
                                $('.mm_menus_li.open .mm_tabs_li:first-child').addClass('open');
                            } 
                        }
                        if(json.mm_object=='tab')
                        {
                            $('.mm_tabs_li').removeClass('open');
                            $('li[data-id-'+json.mm_object+'="'+json.newItemId+'"]').addClass('open');
                        }
                        mmSort('.mm_blocks_ul'); 
                        mmSort('.mm_tabs_ul_content');
                        mmSort('.mm_columns_ul');
                        mmSort('.mm_menus_ul');   
                        if(json.alerts.success)
                            mmAlertSucccess(json.alerts.success);
                        else
                            alert(json.alerts.errors);
                        displayHeightTab();   
                        var $images = $('.ets_megamenu img');
                        $images.load(function(){
                            displayHeightTab();
                        });
                    },
                    error: function(xhr, status, error)
                    {
                        $('.mm_duplicate').removeClass('active');
                        var err = eval("(" + xhr.responseText + ")");
                        alert(err.Message);
                    }
                });
            }            
        return false;
    });
    
    $(document).on('change','.mm_form select[name="link_type"],.mm_form select[name="block_type"]',function(){
        checkFormFields();
        if ($('#block_type').length > 0)
        {
            if ($('#block_type').val() != 'PRODUCT')
            {
                $('.row_id_products, .row_product_count, .row_product_type').hide();
            }
            else
            {
                changeProductType();
                mm_func.search();
            }
        }
    });
    
    //Config
    $(document).on('click','.mm_config_save',function(){
        if(!$('.mm_config_form_content').hasClass('active'))
        {
            $('.mm_config_form_content').addClass('active');
            $(this).parents('.mm_save_wrapper').eq(0).addClass('loading');
            $('.mm-alert').remove();
            var formData = new FormData($(this).parents('form').get(0));
            $.ajax({
                url: $(this).parents('form').eq(0).attr('action'),
                data: formData,
                type: 'post',
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(json){
                    $('.mm-alert').remove();
                    //$('.ets_megamenu').attr('class','ets_megamenu '+json.layout_direction);
                    $('.mm_config_form_content').removeClass('active');
                    $('.mm_config_form_content').append(json.alert);
                    if(json.success)
                    {
                        mmAlertSucccess($('.mm_config_form_content .alert-success').html());
                        $('.mm_pop_up').addClass('hidden').parents('.mm_popup_overlay').addClass('hidden');
                    } 
                    $('.mm_save_wrapper').removeClass('loading');
                    
                },
                error: function(xhr, status, error)
                {
                    $('.mm-alert').remove();
                    $('.mm_save_wrapper').removeClass('loading');
                    $('.mm_config_form_content').removeClass('active');
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            });
        }
        return false;
    });
    $(document).on('click','.mm_config_button',function(){
        $('.mm_pop_up').addClass('hidden');
        $('.mm_config_form').removeClass('hidden').parents('.mm_popup_overlay').removeClass('hidden');
        $('.mm-alert.alert-success').remove();
        checkFormFields();
    });
    $(document).on('click','.mm_import_menu',function(){
        if(!$('.mm_import_option_form').hasClass('active'))
        {
            $('.mm_import_option_form').addClass('active');
            var formData = new FormData($(this).parents('form').get(0));
            $('.mm_import_option_form .alert').remove();
            $.ajax({
                url: $('.mm_import_option_form').attr('action'),
                data: formData,
                type: 'post',
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(json){
                    $('.mm_import_option_form').removeClass('active');
                    if(json.success)
                    {
                        $('.mm_pop_up').addClass('hidden');
                        $('.mm_forms').addClass('hidden');
                        $('.mm_export_form').addClass('hidden');
                        $('.mm_export.mm_pop_up').addClass('hidden');
                        mmAlertSucccess(json.success);
                        setTimeout(function(){
                            location.reload();
                        },3000);                        
                    }
                    else
                    {
                        $('.mm_import_option_form').append('<div class="alert alert-danger">'+json.error+'</div>');
                    }                                        
                },
                error: function(xhr, status, error)
                {
                    $('.mm_import_option_form').removeClass('active');
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);                    
                }                
            }); 
        }
        return false;
    }); 
    //Reset
    $(document).on('click','.mm_reset_default',function(){
            if(!$(this).hasClass('active'))
            {
                $(this).addClass('active');
                $.ajax({
                    url: mmBaseAdminUrl,
                    dataType: 'json',
                    type: 'post',
                    data: {
                        reset_config: 1,                
                    },
                    success: function(json){
                        $('.mm_reset_default').removeClass('active'); 
                        if(json.success)
                        {
                            mmAlertSucccess(json.success);
                            setTimeout(function(){
                                location.reload();
                            },3000); 
                        }                            
                    },
                    error: function(xhr, status, error)
                    {
                        $('.mm_reset_default').removeClass('active');
                        var err = eval("(" + xhr.responseText + ")");
                        alert(err.Message);
                    }
                });
            }            
        return false;
    });
    //Sortable
    mmSort('.mm_blocks_ul');
    mmSort('.mm_tabs_ul_content'); 
    mmSort('.mm_columns_ul');
    mmSort('.mm_menus_ul');   
    
    //Color   
    $('.custom_color').hide();
    $('.custom_color.'+$('#ETS_MM_LAYOUT').val()).show();
    $(document).on('change','#ETS_MM_LAYOUT',function(){
        $('.custom_color').hide();
        $('.custom_color.'+$('#ETS_MM_LAYOUT').val()).show();
    });   
    
    //Cache    
    if(parseInt($('input[name="ETS_MM_CACHE_ENABLED"]:checked').val())==1)
        $('.row_ets_mm_cache_life_time').show();
    else
        $('.row_ets_mm_cache_life_time').hide();
    $(document).on('change','input[name="ETS_MM_CACHE_ENABLED"]',function(){
        if(parseInt($('input[name="ETS_MM_CACHE_ENABLED"]:checked').val())==1)
            $('.row_ets_mm_cache_life_time').show();
        else
            $('.row_ets_mm_cache_life_time').hide();
    });
    $(document).on('click','.mm_clear_cache',function(){
        if(!$(this).hasClass('active'))
        {
            $(this).addClass('active');
            $.ajax({
                url: $(this).attr('href'),
                data: {
                    clearMenuCache: 1,
                },
                type: 'post',
                dataType: 'json',
                success: function(json){
                    $('.mm_clear_cache').removeClass('active');                    
                    if(json.success)
                        mmAlertSucccess(json.success);
                },
                error: function(xhr, status, error)
                {
                    $('.mm_clear_cache').removeClass('active');   
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            });
        }
        return false;
    });
    //Initial events
    $('.ets_mm_fancy').fancybox();
    if($('.mm_menus_ul > li').length > 0)
        $('.mm_menus_ul > li:first-child').addClass('open');
    if($('.mm_menus_li.open .mm_tabs_li').length>0)
    {
        $('.mm_menus_li.open .mm_tabs_li:first-child').addClass('open');
    }
    displayHeightTab();    
    $(document).mouseup(function (e)
    {
        if ($('.mm_results').length > 0 && $('.mm_results').is(':visible'))
            return false;
        var container = $(".mm_pop_up");
        var colorpanel = $('#mColorPicker');
        var mce_container =$('.mce-container');
        if (!mce_container.is(e.target) && mce_container.has(e.target).length === 0 && !container.is(e.target) 
            && container.has(e.target).length === 0 && !colorpanel.is(e.target) && colorpanel.has(e.target).length === 0
            && ($('#mColorPicker').length <=0 || ($('#mColorPicker').length > 0 && $('#mColorPicker').css('display')=='none'))
            && $('.mm_export.mm_pop_up').hasClass('hidden'))
        {
            if ($('.mm_icon_form_new').hasClass('mm_pop_up'))
            {
                $('.mm_icon_form_new').removeClass('mm_pop_up').addClass('hidden');
                $('.mm_menu_form').removeClass('hidden').addClass('mm_pop_up');
            }
            else
            {
                $('.mm_pop_up').addClass('hidden').parents('.mm_popup_overlay').addClass('hidden');
                $('.mm_forms').addClass('hidden');
            }
            $('.mm_export_form').addClass('hidden');
        }
    });
    $(document).keyup(function(e) {      
      if (e.keyCode === 27)
      {
          if ($('.mm_icon_form_new').hasClass('mm_pop_up'))
          {
              $('.mm_icon_form_new').removeClass('mm_pop_up').addClass('hidden');
              $('.mm_menu_form').removeClass('hidden').addClass('mm_pop_up');
          }
          else
          {
              $('.mm_pop_up').addClass('hidden').parents('.mm_popup_overlay').addClass('hidden');
              $('.mm_forms').addClass('hidden');
          }
        $('.mm_export_form').addClass('hidden');
      }
    });
    $(document).on('click','.mm_change_mode',function(){
        $('.mm_change_mode').removeClass('active');
        $(this).addClass('active');
        if($(this).hasClass('mm_layout_rlt'))
            $('.ets_megamenu').removeClass('ets-dir-ltr').addClass('ets-dir-rtl');
        else
            $('.ets_megamenu').removeClass('ets-dir-rtl').addClass('ets-dir-ltr');
    });
    
    $(document).on('click','.mm_view_mode',function(){
        if(!$(this).hasClass('active'))
        {
            $('.mm_view_mode').removeClass('active');
            $(this).addClass('active');
            if($(this).hasClass('mm_view_mode_tab_select'))
            {
                $('.ets_megamenu').removeClass('mm_view_mode_list').addClass('mm_view_mode_tab');
                displayHeightTab();
            }
            else
            {
                $('.ets_megamenu').removeClass('mm_view_mode_tab').addClass('mm_view_mode_list');
                if($('.mm_tabs_ul_content').length)
                    $('.mm_tabs_ul_content').removeAttr('style');
            }
                
        }        
    });
    if($('select[name="ETS_MM_HOOK_TO"]').val()=='customhook' && $('select[name="ETS_MM_HOOK_TO"]').next('.help-block').length > 0)
        $('select[name="ETS_MM_HOOK_TO"]').next('.help-block').addClass('active');
    $(document).on('change','select[name="ETS_MM_HOOK_TO"]',function(){
        if($(this).val()=='customhook' && $(this).next('.help-block').length > 0)
            $(this).next('.help-block').addClass('active');
        else
            $(this).next('.help-block').removeClass('active');
    });
    $(document).on('click','.mm_config_form_tab > li',function(){
        $('.mm_config_form_tab > li,.mm_config_forms > div').removeClass('active');
        $(this).addClass('active');
        $('.mm_config_forms div.mm_config_'+$(this).attr('data-tab')).addClass('active');
    });
    if($('.mm_block_wrapper a').length > 0)
      $('.mm_block_wrapper a').attr('target','_blank');  
    if ($('#product_type_specific').length > 0)
        changeProductType();
    $(document).on('change','input[type=radio][name=product_type]', function () {
        changeProductType();
    });
});

function changeProductType()
{
    $('.row_product_type').show();
    if ($('#product_type_specific').is(':checked'))
    {
        $('.row_id_products').show();
        $('.row_product_count').hide();
    }
    else
    {
        $('.row_id_products').hide();
        $('.row_product_count').show();
    }
}


function mmSort(selector)
{
    $(selector).sortable({
      connectWith: selector,
      update: function(e,ui)
      {
         if (this === ui.item.parent()[0]) {
            var obj = ui.item.attr('data-obj');
            var itemId = ui.item.attr('data-id-'+obj);
            var parentObj = ui.item.parents('li').length > 0 ? ui.item.parents('li').eq(0).attr('data-obj') : false;
            var parentId = parentObj && ui.item.parents('li').length > 0 ? ui.item.parents('li').eq(0).attr('data-id-'+parentObj) : 0;
            var previousId = ui.item.prev('li').length > 0 ? ui.item.prev('li').attr('data-id-'+obj) : 0;
            $.ajax({
                url: mmBaseAdminUrl,
                type: 'post',
                dataType: 'json',
                data: {
                    itemId: itemId,
                    obj: obj,
                    parentId: parentId,
                    parentObj: parentObj ? parentObj : '',
                    previousId: previousId,
                    updateOrder: 1,
                },
                success: function(json)
                {
                    if(!json.success)
                        $(selector).sortable('cancel');
                    displayHeightTab();
                },
                error: function()
                {
                    $(selector).sortable('cancel');
                }
            });
         }        
      }
    }).disableSelection();
}
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            if($(input).parents('.col-lg-9').eq(0).find('.preview_img').length <= 0)
            {
                $(input).parents('.col-lg-9').eq(0).append('<div class="preview_img"><img src="'+e.target.result+'"/> <i style="font-size: 20px;" class="process-icon-delete del_preview"></i></div>');
            }
            else
            {
                $(input).parents('.col-lg-9').eq(0).find('.preview_img img').eq(0).attr('src',e.target.result);
            }
            if($(input).parents('.col-lg-9').eq(0).next('.uploaded_image_label').length > 0)
            {
                $(input).parents('.col-lg-9').eq(0).next('.uploaded_image_label').addClass('hidden'); 
                $(input).parents('.col-lg-9').eq(0).next('.uploaded_image_label').next('.uploaded_img_wrapper').addClass('hidden');
            }                                      
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function updatePreviewImage(name,url,delete_url)
{
    if($('.defaultForm.active input[name="'+name+'"]').length > 0 && $('.defaultForm.active input[name="'+name+'"]').parents('.col-lg-9').length > 0)
    {
        if($('.defaultForm.active input[name="'+name+'"]').parents('.col-lg-9').eq(0).find('.preview_img').length > 0)
           $('.defaultForm.active input[name="'+name+'"]').parents('.col-lg-9').eq(0).find('.preview_img').eq(0).remove(); 
        if($('.defaultForm.active input[name="'+name+'"]').parents('.col-lg-9').eq(0).next('.uploaded_image_label').length<=0)
        {
            $('.defaultForm.active input[name="'+name+'"]').parents('.col-lg-9').eq(0).after('<label class="control-label col-lg-3 uploaded_image_label" style="font-style: italic;">Uploaded image: </label><div class="col-lg-9 uploaded_img_wrapper"><a class="ybc_fancy" href="'+url+'"><img title="Click to see full size image" style="display: inline-block; max-width: 200px;" src="'+url+'"></a>'+(delete_url ? '<a class="delete_url" style="display: inline-block; text-decoration: none!important;" href="'+delete_url+'"><span style="color: #666"><i style="font-size: 20px;" class="process-icon-delete"></i></span></a>' : '')+'</div>');
        }
        else
        {
            var imageWrapper = $('.defaultForm.active input[name="'+name+'"]').parents('.col-lg-9').eq(0).next('.uploaded_image_label').next('.col-lg-9');
            imageWrapper.find('a.ets_mm_fancy').eq(0).attr('href',url);
            imageWrapper.find('a.ets_mm_fancy img').eq(0).attr('src',url);
            if(imageWrapper.find('a.delete_url').length > 0)
                imageWrapper.find('a.delete_url').eq(0).attr('href',delete_url);
            $('.defaultForm.active input[name="'+name+'"]').parents('.col-lg-9').eq(0).next('.uploaded_image_label').removeClass('hidden');
            $('.defaultForm.active input[name="'+name+'"]').parents('.col-lg-9').eq(0).next('.uploaded_image_label').next('.uploaded_img_wrapper').removeClass('hidden');            
        }
        $('.defaultForm.active input[name="'+name+'"]').val('');        
    }
}
function showSaveMessage(alertmsg)
{    
    if(alertmsg)
    {
        if($('.defaultForm.active').parents('.mm_pop_up').eq(0).find('.alert').length > 0)
            $('.defaultForm.active').parents('.mm_pop_up').eq(0).find('.alert').remove();
        $('.defaultForm.active').parents('.mm_pop_up').eq(0).append(alertmsg);
    }    
}
function checkFormFields()
{
    if($('.mm_form select[name="link_type"]').length > 0)
    {
        $('.mm_form .row_link, .mm_form .row_id_manufacturer, .mm_form .row_menu_ver_alway_show, .mm_form .row_id_category, .mm_form .row_id_cms, .mm_form .row_menu_ver_hidden_border, .mm_form .row_id_supplier,.mm_form .row_menu_ver_text_color, .mm_form .row_menu_ver_background_color, .mm_form .row_menu_item_width,.mm_form .row_tab_item_width,.mm_form .row_background_image,.mm_form .row_position_background,.mm_form .row_display_tabs_in_full_width').hide();
        if($('.mm_form select[name="link_type"]').val()=='CUSTOM')
            $('.mm_form .row_link').show();
        else if($('.mm_form select[name="link_type"]').val()=='CMS')
            $('.mm_form .row_id_cms').show();
        else if($('.mm_form select[name="link_type"]').val()=='CATEGORY')
            $('.mm_form .row_id_category').show();
        else if($('.mm_form select[name="link_type"]').val()=='MNFT')
            $('.mm_form .row_id_manufacturer').show();
        else if($('.mm_form select[name="link_type"]').val()=='MNSP')
            $('.mm_form .row_id_supplier').show();
        if($('select[name="enabled_vertical"]').val()==1)
        {
            $('.mm_form .row_menu_ver_text_color, .mm_form .row_menu_ver_alway_show, .mm_form .row_menu_ver_hidden_border, .mm_form .row_menu_ver_background_color,.mm_form .row_menu_item_width,.mm_form .row_tab_item_width').show();
            if($('#sub_menu_type').val()=='FULL')
                $('.mm_form .row_display_tabs_in_full_width').show();
        }  
        else
            $('.mm_form .row_background_image,.mm_form .row_position_background').show();
         
    }
    if($('.mm_form select[name="block_type"]').length > 0)
    {
        $('.mm_form .row_product_type,.mm_form .row_product_count,.mm_form .row_image, .mm_form .row_id_manufacturers, .mm_form .row_id_categories, .mm_form .row_id_cmss,.mm_form .row_image_link,.mm_form .row_content,.mm_form .row_id_products, .mm_form .row_id_suppliers,.mm_form .row_order_by_category,.mm_form .row_order_by_suppliers,.mm_form .row_order_by_manufacturers,.mm_form .row_display_mnu_name, .mm_form .row_display_mnu_inline,.mm_form .row_display_suppliers_name,.mm_form .row_display_suppliers_inline,.mm_form .row_display_suppliers_img,.mm_form .row_display_mnu_img,.mm_form .row_show_description, .mm_form .row_show_clock').hide();
        if($('.mm_form select[name="block_type"]').val()=='HTML')
            $('.mm_form .row_content').show();
        else if($('.mm_form select[name="block_type"]').val()=='CMS')
            $('.mm_form .row_id_cmss').show();
        else if($('.mm_form select[name="block_type"]').val()=='CATEGORY')
            $('.mm_form .row_id_categories,.mm_form .row_order_by_category').show();
        else if($('.mm_form select[name="block_type"]').val()=='MNFT')
        {
            $('.mm_form .row_id_manufacturers,.mm_form .row_order_by_manufacturers, .mm_form .row_display_mnu_img').show();
            if($('input[name="display_mnu_img"]:checked').val()==1)
            {
                $('.mm_form .row_display_mnu_name, .mm_form .row_display_mnu_inline').show();
            }
        }
        else if($('.mm_form select[name="block_type"]').val()=='MNSP')
        {
            $('.mm_form .row_id_suppliers,.mm_form .row_order_by_suppliers,.mm_form .row_display_suppliers_img').show();
            if($('input[name="display_suppliers_img"]:checked').val()==1)
            {
                $('.mm_form .row_display_suppliers_name, .mm_form .row_display_suppliers_inline').show();
            }
        }
            
        else if($('.mm_form select[name="block_type"]').val()=='PRODUCT')
        {
            $('.mm_form .row_show_description, .mm_form .row_show_clock').show();
            $('.mm_form .row_id_products').show();
            changeProductType();
        }
            
        else if($('.mm_form select[name="block_type"]').val()=='IMAGE')
        {
            $('.mm_form .row_image').show();
            $('.mm_form .row_image_link').show();    
        }
    }
    if($('input[name="ETS_MM_VERTICAL_ENABLED"]').length>0)
    {
        if($('input[name="ETS_MM_VERTICAL_ENABLED"]:checked').val()==1)
        {
            $('.vertical_group').show();
        }
        else
            $('.vertical_group').hide();
    }
    if($('input[name="ETS_MM_STICKY_ENABLED"]').length>0)
    {
        if($('input[name="ETS_MM_STICKY_ENABLED"]:checked').val()==1)
        {
            $('.row_ets_mm_sticky_dismobile').show();
        }
        else
            $('.row_ets_mm_sticky_dismobile').hide();
    }
    $('.mm_config_extra_features .form-group-wrapper .help-block').addClass('alert-warning').addClass('alert');
}
function mmAlertSucccess(successMsg)
{    
    if($('#content .ets_mm_success_alert').length <= 0)
    {
        $('#content').append('<div class="alert alert-success ets_mm_success_alert" style="display: none;"></div>');        
    }
    $('#content .ets_mm_success_alert').html(successMsg);
    $('#content .ets_mm_success_alert').fadeIn().delay(5000).fadeOut();
}
function displayHeightTab()
{
    if($('.mm_menus_li.open .mm_tabs_ul .mm_tabs_li.open .mm_columns_ul').length)
    {
       var height_menu = $('.mm_menus_li.open .mm_tabs_ul .mm_tabs_li.open .mm_columns_ul').height()+300;
       $('.mm_menus_li.open .mm_tabs_ul').css('height',($('.mm_menus_li.open .mm_tabs_ul .mm_tabs_li.open .mm_columns_ul').height()+300)+'px');
      
       $('.ets_megamenu').css('height',(height_menu+100)+'px');
    }
    else if($('.mm_menus_li.open .mm_columns_ul').length)
    {
        $('.ets_megamenu').css('height',($('.mm_menus_li.open .mm_columns_ul').height()+200)+'px');
    }
}
function displayCountDownClock()
{
    var t = $("[data-countdown]"),
    n = '<div class="countdown-item"><div class="countdown-inner"><div class="countdown-cover"><div class="countdown-table"><div class="countdown-cell"><div class="countdown-time">%-D</div><div class="countdown-text">Day%!D</div></div></div></div></div></div><div class="countdown-item"><div class="countdown-inner"><div class="countdown-cover"><div class="countdown-table"><div class="countdown-cell"><span class="countdown-time">%H</span><div class="countdown-text">Hr%!H</div></div></div></div></div></div><div class="countdown-item"><div class="countdown-inner"><div class="countdown-cover"><div class="countdown-table"><div class="countdown-cell"><span class="countdown-time">%M</span><div class="countdown-text">Min%!M</div></div></div></div></div></div><div class="countdown-item"><div class="countdown-inner"><div class="countdown-cover"><div class="countdown-table"><div class="countdown-cell"><span class="countdown-time">%S</span><div class="countdown-text">Sec%!S</div></div></div></div></div></div>';
    if(t.length>0)
    {
        t.each(function() {
            var t = $(this).data("countdown");
            $(this).countdown(t).on("update.countdown", function(t) {
                $(this).html(t.strftime(n));
            })
        });
    }
      
}