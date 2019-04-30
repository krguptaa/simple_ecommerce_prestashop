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
class MM_Column extends MM_Obj
{
    public $id_column;
    public $id_menu;    
    public $id_tab;
    public $column_size;    
    public $sort_order;
    public $is_breaker;    
    public static $definition = array(
		'table' => 'ets_mm_column',
		'primary' => 'id_column',
		'multilang' => false,
		'fields' => array(
			'id_menu' => array('type' => self::TYPE_INT),
            'id_tab' => array('type' => self::TYPE_INT),  
            'column_size' => array('type' => self::TYPE_STRING),   
            'sort_order' => array('type' => self::TYPE_INT), 
            'is_breaker' => array('type' => self::TYPE_INT),             
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
        $this->setFields(Ets_megamenu::$columns);
	}
}
