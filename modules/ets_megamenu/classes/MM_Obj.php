<?php
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

if (!defined('_PS_VERSION_'))
	exit;
class MM_Obj extends ObjectModel 
{ 
    public $fields; 
    
    public function setFields($fields)
    {
        $this->fields = $fields;
    } 
    public function renderForm()
    {
        $helper = new HelperForm();
        $helper->module = new Ets_megamenu();
        $configs = $this->fields['configs'];
        $fields_form = array();
        $fields_form['form'] = $this->fields['form'];               
        if($configs)
        {
            foreach($configs as $key => $config)
            {                
                if(isset($config['type']) && in_array($config['type'],array('sort_order')))
                    continue;
                $confFields = array(
                    'name' => $key,
                    'type' => $config['type'],
                    'class'=>isset($config['class'])?$config['class']:'',
                    'label' => $config['label'],
                    'desc' => isset($config['desc']) ? $config['desc'] : false,
                    'required' => isset($config['required']) && $config['required'] ? true : false,
                    'autoload_rte' => isset($config['autoload_rte']) && $config['autoload_rte'] ? true : false,
                    'options' => isset($config['options']) && $config['options'] ? $config['options'] : array(),
                    'suffix' => isset($config['suffix']) && $config['suffix'] ? $config['suffix']  : false,
                    'values' => isset($config['values']) ? $config['values'] : false,
                    'lang' => isset($config['lang']) ? $config['lang'] : false,
                    'showRequired' => isset($config['showRequired']) && $config['showRequired'],
                    'hide_delete' => isset($config['hide_delete']) ? $config['hide_delete'] : false,
                    'placeholder' => isset($config['placeholder']) ? $config['placeholder'] : false,
                    'display_img' => $this->id && isset($config['type']) && $config['type']=='file' && $this->$key!='' && @file_exists(dirname(__FILE__).'/../views/img/upload/'.$this->$key) ? $helper->module->modulePath().'views/img/upload/'.$this->$key : false,
                    'img_del_link' => $this->id && isset($config['type']) && $config['type']=='file' && $this->$key!='' && @file_exists(dirname(__FILE__).'/../views/img/upload/'.$this->$key) ? $helper->module->baseAdminUrl().'&deleteimage='.$key.'&itemId='.(isset($this->id)?$this->id:'0').'&mm_object=MM_'.Tools::ucfirst($fields_form['form']['name']) : false, 
                );
                if(isset($config['tree']) && $config['tree'])
                {
                    $confFields['tree'] = $config['tree'];
                    if(isset($config['tree']['use_checkbox']) && $config['tree']['use_checkbox'])
                        $confFields['tree']['selected_categories'] = explode(',',$this->$key);
                    else
                        $confFields['tree']['selected_categories'] = array($this->$key);
                }                    
                if(!$confFields['suffix'])
                    unset($confFields['suffix']);                
                $fields_form['form']['input'][] = $confFields;
            }
        }        
        
		$helper->show_toolbar = false;
		$helper->table = $this->table;
		$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
		$helper->default_form_language = $lang->id;
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
		$this->fields_form = array();		
		$helper->identifier = $this->identifier;
		$helper->submit_action = 'save_'.$this->fields['form']['name'];
        $link = new Link();
		$helper->currentIndex = $link->getAdminLink('AdminModules', true).'&configure=ets_megamenu';
		$language = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $fields = array();        
        $languages = Language::getLanguages(false);
        $helper->override_folder = '/';        
        if($configs)
        {
                foreach($configs as $key => $config)
                {
                    
                    if($config['type']=='checkbox')
                        $fields[$key] = $this->id ? explode(',',$this->$key) : (isset($config['default']) && $config['default'] ? $config['default'] : array());
                    elseif(isset($config['lang']) && $config['lang'])
                    {                    
                        foreach($languages as $l)
                        {
                            $temp = $this->$key;
                            $fields[$key][$l['id_lang']] = $this->id ? $temp[$l['id_lang']] : (isset($config['default']) && $config['default'] ? $config['default'] : null);
                        }
                    }
                    elseif(!isset($config['tree']))
                        $fields[$key] = $this->id ? $this->$key : (isset($config['default']) && $config['default'] ? $config['default'] : null);                            
                }
        }
           
        $helper->tpl_vars = array(
			'base_url' => Context::getContext()->shop->getBaseURL(),
			'language' => array(
				'id_lang' => $language->id,
				'iso_code' => $language->iso_code
			),
			'fields_value' => $fields,
			'languages' => Context::getContext()->controller->getLanguages(),
			'id_language' => Context::getContext()->language->id, 
            'key_name' => 'id_'.$fields_form['form']['name'],
            'item_id' => $this->id,  
            'mm_object' => 'MM_'.Tools::ucfirst($fields_form['form']['name']),
            'list_item' => true,
            'image_baseurl' => $helper->module->modulePath().'views/img/',                 
        );        
        return str_replace(array('id="ets_mm_menu_form"','id="fieldset_0"'),'',$helper->generateForm(array($fields_form)));	
    }
    public function getFieldVals()
    {
        if(!$this->id)
            return array();
        $vals = array();
        foreach($this->fields['configs'] as $key => $config)
        {
            if(property_exists($this,$key))
            {
                if(isset($config['lang'])&&$config['lang'])
                {
                    $val_lang= $this->$key;
                    $vals[$key]=$val_lang[Context::getContext()->language->id];

                }
                else
                    $vals[$key] = $this->$key;
                    
            }
                
        }
        $vals['id_'.$this->fields['form']['name']] = (int)$this->id;
        unset($config);
        return $vals;
    }
    public function clearImage($image)
    {
        $configs = $this->fields['configs'];  
        $errors = array();
        $success = array();
        if(!$this->id)
            $errors[] = Ets_megamenu::$trans['object_empty'];
        elseif(!isset($configs[$image]['type']) || isset($configs[$image]['type']) && $configs[$image]['type']!='file')
            $errors[] = Ets_megamenu::$trans['field_not_valid'];
        elseif(isset($configs[$image]) && !isset($configs[$image]['required']) || (isset($configs[$image]['required']) && !$configs[$image]['required']))
        {
            $imageName = $this->$image;
            $imagePath = dirname(__FILE__).'/../views/img/upload/'.$imageName;
            if($imageName && file_exists($imagePath) && !Ets_megamenu::imageExits($imageName,$this->id))
            {
                @unlink($imagePath);
                $this->$image = '';
                if($this->update())
                {
                    $success[] = Ets_megamenu::$trans['image_deleted'];
                    if(Configuration::get('ETS_MM_CACHE_ENABLED'))
                        Ets_megamenu::clearAllCache();
                }                    
                else
                    $errors[] = Ets_megamenu::$trans['unkown_error'];
            }
        }
        else
            $errors[] = $configs[$image]['label']. Ets_megamenu::$trans['required_text'];
        return array('errors' => $errors,'success' => $success);
    }
    public function deleteObj()
    {        
        $errors = array();
        $success = array();
        $configs = $this->fields['configs'];
        $parent=isset($this->fields['form']['parent'])?$this->fields['form']['parent']:'1';
        $images = array();
        foreach($configs as $key => $config)
        {
            if($config['type']=='file' && $this->$key && @file_exists(dirname(__FILE__).'/../views/img/upload/'.$this->$key) && !Ets_megamenu::imageExits($this->$key,$this->id))
                $images[] = dirname(__FILE__).'/../views/img/upload/'.$this->$key;
        }        
        if(!$this->delete())
            $errors[] = Ets_megamenu::$trans['cannot_delete'];
        else
        {
            foreach($images as $image)
                @unlink($image);
            $success[] = Ets_megamenu::$trans['item_deleted'];
            if(Configuration::get('ETS_MM_CACHE_ENABLED'))
                Ets_megamenu::clearAllCache();
            if(isset($configs['sort_order']) && $configs['sort_order'])
            {
                Db::getInstance()->execute("
                    UPDATE "._DB_PREFIX_."ets_mm_".pSQL($this->fields['form']['name'])."
                    SET sort_order=sort_order-1 
                    WHERE sort_order>".(int)$this->sort_order." ".(isset($configs['sort_order']['order_group'][$parent]) && ($orderGroup = $configs['sort_order']['order_group'][$parent]) ? " AND ".pSQL($orderGroup)."=".(int)$this->$orderGroup : "")."
                ");
            }
            if($this->id && isset($this->fields['form']['connect_to2']) && $this->fields['form']['connect_to2'] 
                && ($subs = Db::getInstance()->executeS("SELECT id_".pSQL($this->fields['form']['connect_to2'])." FROM "._DB_PREFIX_."ets_mm_".pSQL($this->fields['form']['connect_to2']). " WHERE id_".pSQL($this->fields['form']['name'])."=".(int)$this->id)))
            {
                foreach($subs as $sub)
                {
                    $className = 'MM_'.Tools::ucfirst(Tools::strtolower($this->fields['form']['connect_to2']));
                    if(class_exists($className))
                    {
                        $obj = new $className((int)$sub['id_'.$this->fields['form']['connect_to2']]);
                        $obj->deleteObj();
                    }                    
                }
            }
            if($this->id && isset($this->fields['form']['connect_to']) && $this->fields['form']['connect_to'] 
                && ($subs = Db::getInstance()->executeS("SELECT id_".pSQL($this->fields['form']['connect_to'])." FROM "._DB_PREFIX_."ets_mm_".pSQL($this->fields['form']['connect_to']). " WHERE id_".pSQL($this->fields['form']['name'])."=".(int)$this->id)))
            {
                foreach($subs as $sub)
                {
                    $className = 'MM_'.Tools::ucfirst(Tools::strtolower($this->fields['form']['connect_to']));
                    if(class_exists($className))
                    {
                        $obj = new $className((int)$sub['id_'.$this->fields['form']['connect_to']]);
                        $obj->deleteObj();
                    }                    
                }
            }

        }            
        return array('errors' => $errors,'success' => $success);
    }
    public function maxVal($key,$group = false, $groupval=0)
    {  
       return ($max = Db::getInstance()->getValue("SELECT max(".pSQL($key).") FROM "._DB_PREFIX_."ets_mm_".pSQL($this->fields['form']['name']).($group && ($groupval > 0) ? " WHERE ".pSQL($group)."=".(int)$groupval : ''))) ? (int)$max : 0;
    }   
    public function updateOrder($previousId = 0, $groupdId = 0,$parentObj='')
    {        
        $group = isset($this->fields['configs']['sort_order']['order_group'][$parentObj]) && $this->fields['configs']['sort_order']['order_group'][$parentObj] ? $this->fields['configs']['sort_order']['order_group'][$parentObj] : false;
        if(!$groupdId && $group)
            $groupdId = $this->$group;
        $oldOrder = $this->sort_order;
        if($group && $groupdId && property_exists($this,$group) && $this->$group != $groupdId)
        {            
            Db::getInstance()->execute("
                    UPDATE "._DB_PREFIX_."ets_mm_".pSQL($this->fields['form']['name'])."
                    SET sort_order=sort_order-1 
                    WHERE sort_order>".(int)$this->sort_order." AND id_".pSQL($this->fields['form']['name'])."!=".(int)$this->id."
                          ".($group && $groupdId ? " AND ".pSQL($group)."=".(int)$this->$group : ""));
            $this->$group = $groupdId;
            if($parentObj=='tab')
            {
                $tab= new MM_Tab($groupdId);
                $this->id_menu = $tab->id_menu;
            }
            if($parentObj=='menu')
            {
                $this->id_tab=0;
            }
            $changeGroup = true;
        }
        else
            $changeGroup = false;                    
        if($previousId > 0)
        {
            $objName = 'MM_'.Tools::ucfirst($this->fields['form']['name']);
            $obj = new $objName($previousId);
            if($obj->sort_order > 0)
                $this->sort_order = $obj->sort_order+1;
            else
                $this->sort_order = 1;
        }
        else
            $this->sort_order = 1;
        if($this->update())
        {    
            
            Db::getInstance()->execute("
                    UPDATE "._DB_PREFIX_."ets_mm_".pSQL($this->fields['form']['name'])."
                    SET sort_order=sort_order+1 
                    WHERE sort_order>=".(int)$this->sort_order." AND id_".pSQL($this->fields['form']['name'])."!=".(int)$this->id."
                          ".($group && $groupdId ? " AND ".pSQL($group)."=".(int)$this->$group : ""));
            
            if(!$changeGroup && $this->sort_order!=$oldOrder)
            {                
                
                $rs = Db::getInstance()->execute("
                        UPDATE "._DB_PREFIX_."ets_mm_".pSQL($this->fields['form']['name'])."
                        SET sort_order=sort_order-1
                        WHERE sort_order>".($this->sort_order > $oldOrder ? (int)($oldOrder) : (int)($oldOrder+1)).($group && $groupdId ? " AND ".pSQL($group)."=".(int)$this->$group : ""));
                if(Configuration::get('ETS_MM_CACHE_ENABLED'))
                    Ets_megamenu::clearAllCache(); 
                return $rs;
            }
            if(Configuration::get('ETS_MM_CACHE_ENABLED'))
                Ets_megamenu::clearAllCache();  
            return true;
        }               
        return false;       
    }
    public function saveData()
    {
        $errors = array();
        $success = array();
        $languages = Language::getLanguages(false);
        $id_lang_default = (int)Configuration::get('PS_LANG_DEFAULT');
        $parent=isset($this->fields['form']['parent'])?$this->fields['form']['parent']:'1';
        $configs = $this->fields['configs'];       
        if($configs)
        {
            foreach($configs as $key => $config)
            {
                if($config['type']=='sort_order')
                    continue;
                if(isset($config['lang']) && $config['lang'])
                {
                    if(isset($config['required']) && $config['required'] && $config['type']!='switch' && trim(Tools::getValue($key.'_'.$id_lang_default) == ''))
                    {
                        $errors[] = $config['label'].' '.Ets_megamenu::$trans['required_text'];
                    }                        
                }
                else
                {
                    if(isset($config['required']) && $config['required'] && isset($config['type']) && $config['type']=='file')
                    {
                        if($this->$key=='' && !isset($_FILES[$key]['size']))
                            $errors[] = $config['label'].' '.Ets_megamenu::$trans['required_text'];
                        elseif(isset($_FILES[$key]['size']))
                        {
                            $fileSize = round((int)$_FILES[$key]['size'] / (1024 * 1024));
                			if($fileSize > 100)
                                $errors[] = $config['label'].' '.Ets_megamenu::$trans['file_too_large'];
                        }   
                    }
                    else
                    {
                        if(isset($config['required']) && $config['required'] && $config['type']!='switch' && trim(Tools::getValue($key) == ''))
                        {
                            $errors[] = $config['label'].' '.Ets_megamenu::$trans['required_text'];
                        }
                        elseif(!is_array(Tools::getValue($key)) && isset($config['validate']) && method_exists('Validate',$config['validate']))
                        {
                            $validate = $config['validate'];
                            if(!Validate::$validate(trim(Tools::getValue($key))))
                                $errors[] = $config['label'].' '.Ets_megamenu::$trans['invalid_text'];
                            unset($validate);
                        }
                        elseif(!Validate::isCleanHtml(trim(Tools::getValue($key))))
                        {
                            $errors[] = $config['label'].' '.Ets_megamenu::$trans['required_text'];
                        } 
                    }                          
                }                    
            }
        }            
        
        //Custom validation
        if($this->fields['form']['name']=='menu')
        {
            switch(Tools::getValue('link_type'))
            {
                case 'CUSTOM':
                    if(trim(Tools::getValue('link_'.$id_lang_default))=='')
                        $errors[] = Ets_megamenu::$trans['custom_link_required_text'];
                    break;
                case 'CMS':
                    if(!(int)Tools::getValue('id_cms'))
                        $errors[] = Ets_megamenu::$trans['cms_required_text'];
                    break;
                case 'CATEGORY':
                    if(!(int)Tools::getValue('id_category'))
                        $errors[] = Ets_megamenu::$trans['category_required_text'];
                    break;
                case 'MNFT':
                    if(!(int)Tools::getValue('id_manufacturer'))
                        $errors[] = Ets_megamenu::$trans['manufacturer_required_text'];
                    break;
                case 'MNSP':
                    if(!(int)Tools::getValue('id_supplier'))
                        $errors[] = Ets_megamenu::$trans['supplier_required_text'];
                    break;
                case 'CONTACT':
                    break;
                case 'HOME':
                    break;
                default:
                    $errors[] = Ets_megamenu::$trans['link_type_not_valid_text'];
                    break;
            }
            if(Tools::strlen(Tools::getValue('sub_menu_max_width'))<1 || Tools::strlen(Tools::getValue('sub_menu_max_width')) > 50)
                $errors[] = Ets_megamenu::$trans['sub_menu_width_invalid'].'2';
            foreach($languages as $lang)
            {
                if($bubble_text = Tools::getValue('bubble_text_'.$lang['id_lang']))
                {
                    if(Tools::strlen($bubble_text) > 50)
                    {
                        $errors[] = Ets_megamenu::$trans['bubble_text_is_too_long'];
                    } 
                    $bubble_text_entered = true;
                }
                                       
            }  
            if(isset($bubble_text_entered) && $bubble_text_entered)
            {
                if(!Tools::getValue('bubble_text_color'))
                    $errors[] = Ets_megamenu::$trans['bubble_text_color_is_required'];
                if(!Tools::getValue('bubble_background_color'))
                    $errors[] = Ets_megamenu::$trans['bubble_background_color_is_required'];
            }
            
        }
        if($this->fields['form']['name']=='block')
        {
            switch(Tools::getValue('block_type'))
            {
                case 'HTML':
                    if(trim(Tools::getValue('content_'.$id_lang_default))=='')
                        $errors[] = Ets_megamenu::$trans['content_required_text'];
                    break;
                case 'CMS':
                    if(!Tools::getValue('id_cmss'))
                        $errors[] = Ets_megamenu::$trans['cmss_required_text'];
                    break;
                case 'CATEGORY':
                    if(!Tools::getValue('id_categories'))
                        $errors[] = Ets_megamenu::$trans['categories_required_text'];
                    break;
                case 'MNFT':
                    if(!Tools::getValue('id_manufacturers'))
                        $errors[] = Ets_megamenu::$trans['manufacturers_required_text'];
                    break;  
                case 'MNSP':
                    if(!Tools::getValue('id_suppliers'))
                        $errors[] = Ets_megamenu::$trans['suppliers_required_text'];
                    break; 
                case 'PRODUCT':
                	if (Tools::getValue('product_type', false) == 'specific')
	                {
		                if(!Tools::getValue('id_products', false))
			                $errors[] = Ets_megamenu::$trans['products_required_text'];
	                }
	                else
	                {
		                if(!Tools::getValue('product_count', false))
			                $errors[] = Ets_megamenu::$trans['product_count_required_text'];
		                elseif(!Validate::isUnsignedId(Tools::getValue('product_count')))
			                $errors[] = Ets_megamenu::$trans['product_count_not_valid_text'];
	                }
                    break;                
                case 'IMAGE':
                    if($this->image=='' && (!isset($_FILES['image']['size']) || isset($_FILES['image']['size']) && !$_FILES['image']['size']))
                        $errors[] = Ets_megamenu::$trans['image_required_text'];
                    break;
                default:
                    $errors[] = Ets_megamenu::$trans['block_type_not_valid_text'];
                    break;
            }
        }
        
        if(!$errors)
        {            
            if($configs)
            {
                foreach($configs as $key => $config)
                {
                    if(isset($config['type']) && $config['type']=='sort_order')
                    {
                        if(!$this->id)
                        {
                            if(!isset($config['order_group'][$parent]) || isset($config['order_group'][$parent]) && !$config['order_group'][$parent])
                                $this->$key = $this->maxVal($key)+1;
                            else
                            {
                                $orderGroup = $config['order_group'][$parent];
                                $this->$key = $this->maxVal($key,$orderGroup,(int)$this->$orderGroup)+1;
                            }                                                         
                        }
                    }
                    elseif(isset($config['lang']) && $config['lang'])
                    {
                        $valules = array();
                        foreach($languages as $lang)
                        {
                            if($config['type']=='switch')                                                           
                                $valules[$lang['id_lang']] = (int)trim(Tools::getValue($key.'_'.$lang['id_lang'])) ? 1 : 0;                                
                            else
                                $valules[$lang['id_lang']] = trim(Tools::getValue($key.'_'.$lang['id_lang'])) ? trim(Tools::getValue($key.'_'.$lang['id_lang'])) : trim(Tools::getValue($key.'_'.$id_lang_default));
                        }
                        $this->$key = $valules;
                    }
                    elseif($config['type']=='switch')
                    {                           
                        $this->$key = (int)Tools::getValue($key) ? 1 : 0;                                                      
                    }
                    elseif($config['type']=='file')
                    {
                        //Upload file
                        if(isset($_FILES[$key]['tmp_name']) && isset($_FILES[$key]['name']) && $_FILES[$key]['name'])
                        {
                            $salt = Tools::substr(sha1(microtime()),0,10);
                            $type = Tools::strtolower(Tools::substr(strrchr($_FILES[$key]['name'], '.'), 1));
                            $imageName = @file_exists(dirname(__FILE__).'/../views/img/upload/'.Tools::strtolower($_FILES[$key]['name']))|| Tools::strtolower($_FILES[$key]['name'])==$this->$key ? $salt.'-'.Tools::strtolower($_FILES[$key]['name']) : Tools::strtolower($_FILES[$key]['name']);
                            $fileName = dirname(__FILE__).'/../views/img/upload/'.$imageName;                
                            if(file_exists($fileName))
                            {
                                $errors[] = $config['label'].' '.Ets_megamenu::$trans['file_existed'];
                            }
                            else
                            {                                    
                    			$imagesize = @getimagesize($_FILES[$key]['tmp_name']);                                    
                                if (!$errors && isset($_FILES[$key]) &&				
                    				!empty($_FILES[$key]['tmp_name']) &&
                    				!empty($imagesize) &&
                    				in_array($type, array('jpg', 'gif', 'jpeg', 'png'))
                    			)
                    			{
                    				$temp_name = tempnam(_PS_TMP_IMG_DIR_, 'PS');    				
                    				if ($error = ImageManager::validateUpload($_FILES[$key]))
                    					$errors[] = $error;
                    				elseif (!$temp_name || !move_uploaded_file($_FILES[$key]['tmp_name'], $temp_name))
                    					$errors[] = Ets_megamenu::$trans['can_not_upload'];
                    				elseif (!ImageManager::resize($temp_name, $fileName, null, null, $type))
                    					$errors[] = Ets_megamenu::$trans['upload_error_occurred'];
                    				if (isset($temp_name))
                    					@unlink($temp_name);
                                    if(!$errors)
                                    {
                                        if($this->$key!='')
                                        {
                                            $oldImage = dirname(__FILE__).'/../views/img/upload/'.$this->$key;
                                            if(file_exists($oldImage) && !Ets_megamenu::imageExits($this->$key,$this->id))
                                                @unlink($oldImage);
                                        }  
                                        $this->$key = $imageName;
                                    }
                                }
                            }
                        }
                        //End upload file                       
                    }
                    elseif($config['type']=='categories' && isset($config['tree']['use_checkbox']) && $config['tree']['use_checkbox'] || $config['type']=='checkbox')
                        $this->$key = implode(',',Tools::getValue($key));                                                   
                    else
                        $this->$key = trim(Tools::getValue($key));   
                    }
                }
        }        
        if (!count($errors))
        {               
           if($this->id && $this->update() || !$this->id && $this->add())
           {
                if(Configuration::get('ETS_MM_CACHE_ENABLED'))
                    Ets_megamenu::clearAllCache();
                $success[] = Ets_megamenu::$trans['data_saved'];
           }                
           else
                $errors[] = Ets_megamenu::$trans['unkown_error'];
        }
        return array('errors' => $errors, 'success' => $success);        
    }  
    public function duplicateItem($id_parent = false,$id_parent2=false)
    {
        $oldId = $this->id;
        $this->id = null;  
        if($id_parent && isset($this->fields['form']['parent']) && ($parent = 'id_'.$this->fields['form']['parent']) && property_exists($this,$parent))
            $this->$parent = $id_parent;
        if($id_parent2 && isset($this->fields['form']['parent2']) && ($parent2 = 'id_'.$this->fields['form']['parent2']) && property_exists($this,$parent2))
            $this->$parent2 = $id_parent2;
        if(property_exists($this,'sort_order'))
        {
            if(!isset($this->fields['form']['parent'])|| !isset($this->fields['configs']['sort_order']['order_group'][$this->fields['form']['parent']]) || isset($this->fields['configs']['sort_order']['order_group'][$this->fields['form']['parent']]) && !$this->fields['configs']['sort_order']['order_group'][$this->fields['form']['parent']])
                $this->sort_order = $this->maxVal('sort_order')+1;
            else
            {
                $tempName = $this->fields['configs']['sort_order']['order_group'][$this->fields['form']['parent']];
                $this->sort_order = $this->maxVal('sort_order',$tempName,(int)$this->$tempName)+1;
                $groupId = $this->$tempName;
            }  
            $oldOrder = $this->sort_order;              
        }
        if(property_exists($this,'image') && $this->image && file_exists(dirname(__FILE__).'/../views/img/upload/'.$this->image))
        {
            $salt = $this->maxVal('id_'.$this->fields['form']['name'])+1;
            $oldImage = dirname(__FILE__).'/../views/img/upload/'.$this->image;
            $this->image = $salt.'_'.$this->image;            
        }
        if(property_exists($this,'menu_img_link') && $this->menu_img_link && file_exists(dirname(__FILE__).'/../views/img/upload/'.$this->menu_img_link))
        {
            $salt = $this->maxVal('id_'.$this->fields['form']['name'])+1;
            $oldmenu_img_link = dirname(__FILE__).'/../views/img/upload/'.$this->menu_img_link;
            $this->menu_img_link = $salt.'_'.$this->menu_img_link;            
        }
        if(property_exists($this,'background_image') && $this->background_image && file_exists(dirname(__FILE__).'/../views/img/upload/'.$this->background_image))
        {
            $salt = $this->maxVal('id_'.$this->fields['form']['name'])+1;
            $oldbackground_image = dirname(__FILE__).'/../views/img/upload/'.$this->background_image;
            $this->background_image = $salt.'_'.$this->background_image;            
        }
        if(property_exists($this,'tab_img_link') && $this->tab_img_link && file_exists(dirname(__FILE__).'/../views/img/upload/'.$this->tab_img_link))
        {
            $salt = $this->maxVal('id_'.$this->fields['form']['name'])+1;
            $oldtab_img_link = dirname(__FILE__).'/../views/img/upload/'.$this->tab_img_link;
            $this->image = $salt.'_'.$this->tab_img_link;            
        }
        if($this->add())
        {
            if(isset($oldImage) && $oldImage)
            {
                @copy($oldImage,dirname(__FILE__).'/../views/img/upload/'.$this->image);
            }
            if(isset($oldmenu_img_link) && $oldmenu_img_link)
            {
                @copy($oldmenu_img_link,dirname(__FILE__).'/../views/img/upload/'.$this->menu_img_link);
            }
            if(isset($oldbackground_image) && $oldbackground_image)
            {
                @copy($oldbackground_image,dirname(__FILE__).'/../views/img/upload/'.$this->background_image);
            }
            if(isset($oldtab_img_link) && $oldtab_img_link)
            {
                @copy($oldtab_img_link,dirname(__FILE__).'/../views/img/upload/'.$this->tab_img_link);
            }
            if(isset($oldOrder) && $oldOrder)
                $this->updateOrder($oldId,isset($groupId) ? (int)$groupId : 0); 
            if(get_class($this)=='MM_Menu' && $this->enabled_vertical)
            {
                if(isset($this->fields['form']['connect_to2']) && $this->fields['form']['connect_to2']
                    && ($subs = Db::getInstance()->executeS("SELECT id_".pSQL($this->fields['form']['connect_to2'])." FROM "._DB_PREFIX_."ets_mm_".pSQL($this->fields['form']['connect_to2']). " WHERE id_".pSQL($this->fields['form']['name'])."=".(int)$oldId)))
                {
                    foreach($subs as $sub)
                    {
                        $className = 'MM_'.Tools::ucfirst(Tools::strtolower($this->fields['form']['connect_to2']));
                        if(class_exists($className))
                        {
                            $obj = new $className((int)$sub['id_'.$this->fields['form']['connect_to2']]);
                            if(get_class($this)=='MM_Tab')
                                $obj->duplicateItem($id_parent, $this->id);
                            else
                                $obj->duplicateItem($this->id);
                        }                    
                    }
                }
            }
            else
            {
                if(isset($this->fields['form']['connect_to']) && $this->fields['form']['connect_to']
                    && ($subs = Db::getInstance()->executeS("SELECT id_".pSQL($this->fields['form']['connect_to'])." FROM "._DB_PREFIX_."ets_mm_".pSQL($this->fields['form']['connect_to']). " WHERE id_".pSQL($this->fields['form']['name'])."=".(int)$oldId)))
                {
                    foreach($subs as $sub)
                    {
                        $className = 'MM_'.Tools::ucfirst(Tools::strtolower($this->fields['form']['connect_to']));
                        if(class_exists($className))
                        {
                            $obj = new $className((int)$sub['id_'.$this->fields['form']['connect_to']]);
                            if(get_class($this)=='MM_Tab')
                                $obj->duplicateItem($id_parent, $this->id);
                            else
                                $obj->duplicateItem($this->id);
                        }                    
                    }
                }
            }     
            
            return $this;
        }
        return false;
    }
    public function update($null_value=false)
    {
        $ok = parent::update($null_value);
        if(get_class($this)=='MM_Menu' && $this->enabled_vertical)
        {
            $columns= Db::getInstance()->executeS('SELECT id_column FROM '._DB_PREFIX_.'ets_mm_column WHERE id_menu='.(int)$this->id.' AND id_tab not in (SELECT id_tab FROM '._DB_PREFIX_.'ets_mm_tab where id_menu ='.(int)$this->id.')');
            if($columns)
            {
                $id_tab= Db::getInstance()->getValue('SELECT id_tab FROM '._DB_PREFIX_.'ets_mm_tab where id_menu='.(int)$this->id);
                if(!$id_tab)
                {
                    $tab=new MM_Tab();
                    $tab->id_menu=$this->id;
                    $tab->enabled=1;
                    $languages= Language::getLanguages(false);
                    foreach($languages as $language)
                    {
                        $tab->title[$language['id_lang']] ='Undefined title';
                    }
                    $tab->add();
                    $id_tab=$tab->id;
                }
                foreach($columns as $column)
                {
                    Db::getInstance()->execute('UPDATE '._DB_PREFIX_.'ets_mm_column SET id_tab="'.(int)$id_tab.'" WHERE id_column='.(int)$column['id_column']);
                }
            }
        }
        return $ok;
    }   
}