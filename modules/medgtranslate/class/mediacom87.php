<?php
/**
 * 2008-today Mediacom87
 *
 * NOTICE OF LICENSE
 *
 * Read in the module
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    Mediacom87 <support@mediacom87.net>
 * @copyright 2008-today Mediacom87
 * @license   define in the module
 * @version 1.0.0
 */

class MedGtranslateClass
{
    /**
     * __construct function.
     *
     * @access public
     * @param mixed $module
     * @return void
     */
    public function __construct($module)
    {
        $this->module = $module;
    }
    /**
     * isoCode function.
     *
     * @access public
     * @param bool $domain (default: false)
     * @return void
     */
    public function isoCode($domain = false)
    {
        $iso = $this->module->context->language->iso_code;

        if ($iso == 'fr') {
            return 'fr';
        } elseif ($domain) {
            return 'com';
        } else {
            return 'en';
        }
    }

    /**
     * medJsonModuleFile function.
     *
     * @access public
     * @return void
     */
    public function medJsonModuleFile()
    {
        $conf = Configuration::getMultiple(array('MED_JSON_TIME', 'MED_JSON_FILE'));

        if (!isset($conf['MED_JSON_TIME']) || $conf['MED_JSON_TIME'] < (time() - 604800)) {
            Configuration::updateValue('MED_JSON_TIME', time());
            $url_api = 'https://api-addons.prestashop.com/'._PS_VERSION_.'/contributor/all_products/'.$this->module->module_key.'/'.$this->module->context->language->iso_code.'/'.$this->module->context->country->iso_code;
            $conf['MED_JSON_FILE'] = Tools::file_get_contents($url_api);
            Configuration::updateValue('MED_JSON_FILE', $conf['MED_JSON_FILE']);
        }

        $modules = Tools::jsonDecode($conf['MED_JSON_FILE'], true);

        if (!is_array($modules) || isset($modules['errors'])) {
            Configuration::updateValue('MED_JSON_TIME', 0);
            return null;
        } else {
            return $modules;
        }
    }

    /**
     * medJsonModuleRate function.
     *
     * @access public
     * @param bool $id (default: false)
     * @param bool $hash (default: false)
     * @return void
     */
    public function medJsonModuleRate($id = false, $hash = false)
    {
        if (!$id || !$hash) {
            return null;
        }

        $conf = Tools::jsonDecode(Configuration::get('MED_A_'.$id), true);

        if (!isset($conf['time']) || $conf['time'] < (time() - 604800)) {
            $conf['time'] = time();
            $iso = $this->module->context->language->iso_code;
            $country = $this->module->context->country->iso_code;
            $url_api = 'https://api-addons.prestashop.com/'._PS_VERSION_.'/contributor/product/'.$hash.'/'.$iso.'/'.$country;
            $result = Tools::file_get_contents($url_api);
            $module = Tools::jsonDecode($result, true);
            if (isset($module['products'][0]['nbRates'])) {
                $conf['nbRates'] = $module['products'][0]['nbRates'];
                $conf['avgRate'] = $module['products'][0]['avgRate']*2*10;
                $datas = Tools::jsonEncode($conf);
                Configuration::updateValue('MED_A_'.$id, $datas);
            } else {
                $conf = null;
            }
        }

        if (!is_array($conf)) {
            Configuration::deleteByName('MED_A_'.$id);
            return null;
        } else {
            return $conf;
        }
    }
}
