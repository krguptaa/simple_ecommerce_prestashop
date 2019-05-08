<?php
/**
 * 2007-2014 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * No redistribute in other sites, or copy.
 *
 * @author    RSI
 * @copyright 2007-2014 RSI
 * @license   http://localhost
 */

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
/* Check to security tocken */
if (Tools::substr(
    Tools::encrypt('prestaspeed/img'),
    0,
    10
) != Tools::getValue('token') || !Module::isInstalled('prestaspeed')
) {
    die('Bad token');
}
include(dirname(__FILE__).'/prestaspeed.php');
$prestaspeed = new PrestaSpeed();
/* Check if the module is enabled */
if ($prestaspeed->active) {
    /* Check if the requested shop exists */
    if (_PS_VERSION_ > '1.5.0.0') {
        $shops = Db::getInstance()
                   ->ExecuteS('SELECT id_shop FROM `'._DB_PREFIX_.'shop`');
        $list_id_shop = array();
        foreach ($shops as $shop) {
            $list_id_shop[] = (int)$shop['id_shop'];
        }
        $id_shop = (Tools::getIsset(Tools::getValue('id_shop')) && in_array(
            Tools::getValue('id_shop'),
            $list_id_shop
        )) ? (int)Tools::getValue('id_shop') : (int)Configuration::get('PS_SHOP_DEFAULT');
        $prestaspeed->img = true;
        /* for the main run initiat the sitemap's files name stored in the database */
        if (!Tools::getIsset(Tools::getValue('continue'))) {
            $prestaspeed->img((int)$id_shop);
        }
    }
    if (!Tools::getIsset(Tools::getValue('continue'))) {
        $prestaspeed->img();
    }
}
