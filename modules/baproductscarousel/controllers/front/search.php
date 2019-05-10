<?php
/**
* 2007-2018PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
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
*  @author    Buy-Addons <contact@buy-addons.com>
*  @copyright 2007-2018 PrestaShop SA
*  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
* @since 1.6
*/

class BaproductscarouselSearchModuleFrontController extends ModuleFrontController
{

    /**
     * @see FrontController::postProcess()
     */
    public function run()
    {
            $asasas = array();
            $id_lang = Tools::getValue('id_langs');
            $id_shop = Tools::getValue('id_shop');
            $name_product = Tools::getValue('name_product');
            $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
            $search = "Select *," . _DB_PREFIX_ . "product_lang.id_product,";
            $search .= _DB_PREFIX_ . "product_lang.name as pr_name ,";
            $search .= _DB_PREFIX_ . "product_lang.link_rewrite as pr_link ,";
            $search .= _DB_PREFIX_ . "category_lang.link_rewrite as ca_link ,";
            $search .= _DB_PREFIX_ . "category_lang.name as ca_name from ";
            $search .= _DB_PREFIX_ . "product INNER JOIN " . _DB_PREFIX_ . "product_lang ON " ;
            $search .= _DB_PREFIX_ . "product_lang.id_product=";
            $search .= _DB_PREFIX_ . "product.id_product INNER JOIN " . _DB_PREFIX_ . "category_lang ON ";
            $search .=_DB_PREFIX_ . "category_lang.id_category = " ._DB_PREFIX_. "product.id_category_default WHERE ";
            $search .= _DB_PREFIX_ . "product_lang.name like '%".pSQL($name_product)."%'";
            $search .=" AND " . _DB_PREFIX_ . "product.active = 1 AND " ;
            $search .=_DB_PREFIX_ . "product_lang.id_lang='".(int)$id_lang."' AND " ;
            $search .= _DB_PREFIX_ . "category_lang.id_lang";
            $search .= " = '".(int)$id_lang."' AND " . _DB_PREFIX_ . "product_lang.id_shop = '".(int)$id_shop."' AND ";
            $search .=_DB_PREFIX_ . "category_lang.id_shop = '".(int)$id_shop."'";
            $shows = $db->ExecuteS($search);
           /* foreach ($shows as $key) {
                
                echo "<tr>";
                echo "<th><input type='checkbox' value='$id_lang'></th>";
                echo '<th>'.$key["id_product"].'</th>';
                echo '<th>'.$key["name"].'</th>';
                echo "</tr>";
            }*/
            $count=count($shows);
            $asasas['count']=$count;
            $asasas['shows']=$shows;
            echo Tools::jsonEncode($asasas);
    }
}
