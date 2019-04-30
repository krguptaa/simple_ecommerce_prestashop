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
class MM_Tab extends MM_Obj
{
    public $id_tab;
    public $id_menu;   
    public $tab_img_link;
    public $tab_sub_width;
    public $menu_ver_hidden_border;
    public $tab_sub_content_pos;
    public $tab_icon; 
    public $title;    
    public $enabled;
    public $sort_order;    
    public $bubble_background_color;
    public $bubble_text_color;
    public $bubble_text;
    public $background_image;
    public $position_background;
    public $url;
    public static $definition = array(
		'table' => 'ets_mm_tab',
		'primary' => 'id_tab',
		'multilang' => true,
		'fields' => array(
			'id_menu' => array('type' => self::TYPE_INT), 
            'tab_img_link'=> array('type'=>self::TYPE_STRING),
            'tab_sub_width'=> array('type'=>self::TYPE_STRING),
            'tab_icon'=> array('type'=>self::TYPE_STRING),
            'bubble_text_color'=> array('type'=>self::TYPE_STRING),
            'bubble_background_color'=> array('type'=>self::TYPE_STRING),
            'tab_sub_content_pos'=>array('type'=>self::TYPE_INT),
            'enabled'=>array('type'=>self::TYPE_INT),
            'background_image' => array('type' => self::TYPE_STRING),
            'position_background' => array('type' => self::TYPE_STRING),
            'title' => array('type' => self::TYPE_STRING,'lang' => true),
            'url' => array('type'=>self::TYPE_STRING,'lang'=>true),
            'bubble_text' => array('type' => self::TYPE_STRING,'lang' => true),   
            'sort_order' => array('type' => self::TYPE_INT),             
        )
	);
    public	function __construct($id_item = null, $id_lang = null, $id_shop = null, Context $context = null)
	{
		parent::__construct($id_item, $id_lang, $id_shop);
        $languages = Language::getLanguages(false);         
        foreach($languages as $lang)
        {
            foreach(self::$definition['fields'] as $field => $params)
            {   
                $temp = $this->$field; 
                if(isset($params['lang']) && $params['lang'] && !isset($temp[$lang['id_lang']]))
                {                      
                    $temp[$lang['id_lang']] = '';                        
                }
                $this->$field = $temp;
            }
        }
        unset($context);        
        $this->setFields(Ets_megamenu::$tab_class);
	}
}
