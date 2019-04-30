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
class MM_Block extends MM_Obj
{
    public $id_block;
    public $title;    
    public $title_link;
    public $content;
    public $enabled;
    public $sort_order;
    public $id_categories;
    public $order_by_category;
    public $id_manufacturers;
    public $order_by_manufacturers;
    public $display_mnu_img;
    public $display_mnu_name;
    public $display_mnu_inline;
    public $id_suppliers;
    public $order_by_suppliers;
    public $display_suppliers_img;
    public $display_suppliers_name;
    public $display_suppliers_inline;
    public $id_cmss;
    public $block_type;
    public $image;
    public $custom_class;
    public $display_title;
    public $id_column;
    public $image_link;
	public $product_type;
    public $id_products;
    public $product_count;
    public $combination_enabled;
    public $show_description;
    public $show_clock;
    public static $definition = array(
		'table' => 'ets_mm_block',
		'primary' => 'id_block',
		'multilang' => true,
		'fields' => array(
			'sort_order' => array('type' => self::TYPE_INT),
            'id_column' => array('type' => self::TYPE_INT), 
            'id_categories' => array('type' => self::TYPE_STRING),  
            'order_by_category' => array('type' => self::TYPE_STRING), 
            'id_manufacturers' => array('type' => self::TYPE_STRING),
            'order_by_manufacturers' => array('type' => self::TYPE_STRING), 
            'display_mnu_img' => array('type' => self::TYPE_INT),
            'display_mnu_name' => array('type' => self::TYPE_INT),
            'display_mnu_inline' => array('type' => self::TYPE_STRING),
            'id_suppliers' => array('type' => self::TYPE_STRING),
            'order_by_suppliers' => array('type' => self::TYPE_STRING), 
            'display_suppliers_img' => array('type' => self::TYPE_INT),
            'display_suppliers_name' => array('type' => self::TYPE_INT),
            'display_suppliers_inline' => array('type' => self::TYPE_STRING),
            'id_cmss' => array('type' => self::TYPE_STRING),
			'product_type' => array('type' => self::TYPE_STRING),
            'id_products' => array('type' => self::TYPE_STRING),
			'product_count' => array('type' => self::TYPE_INT),
            'enabled' => array('type' => self::TYPE_INT),
            'image' => array('type' => self::TYPE_STRING,'lang' => false),
            'block_type' => array('type' => self::TYPE_STRING),
            'display_title' => array('type' => self::TYPE_INT),
            'show_description' => array('type' => self::TYPE_INT),
            'show_clock' => array('type' => self::TYPE_INT),
            // Lang fields
            'title' => array('type' => self::TYPE_STRING, 'lang' => true),			
            'title_link' => array('type' => self::TYPE_STRING, 'lang' => true), 
            'image_link' => array('type' => self::TYPE_STRING, 'lang' => true),   
            'content' => array('type' => self::TYPE_HTML, 'lang' => true),                
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
        $this->setFields(Ets_megamenu::$blocks);
	}
}
