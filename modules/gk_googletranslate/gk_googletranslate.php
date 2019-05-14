<?php
/**
 * 2008-today Kamlesh Gi[ta]
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
 * @author    Kamlesh Gupta 
 * @license   define in the module
 */

if (!defined('_TB_VERSION_')
    && !defined('_PS_VERSION_')) {
    exit;
}


class Gk_GoogleTranslate extends Module
{
    public $smarty;
    public $context;
    public $controller;
    private $errors = array();
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'gk_googletranslate';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Kamlesh Gupta';
        $this->need_instance = 0;
        $this->module_key = '';
        $this->addons_id = '';
        $this->ps_versions_compliancy = array('min' => '1.5.0.0', 'max' => '1.7.99.99');

        /* boostrap */
        if (version_compare(_PS_VERSION_, '1.6.0.0', '>=')) {
            $this->bootstrap = true;
        } else {
            $this->bootstrap = false;
        }

        parent::__construct();

        $this->displayName = $this->l('Free module to translate your shop');
        $this->description = $this->l('Use Google to translate your store live');

        $this->tpl_path = _PS_ROOT_DIR_.'/modules/'.$this->name;
    }

    /**
     * install function .
     *
     * @access public
     * @return void
     */
    public function install()
    {
        if (!parent::install()
            || !$this->registerHook('Footer')) {
            return false;
        }
        return true;
    }

    /**
     * uninstall function.
     *
     * @access public
     * @return void
     */
    public function uninstall()
    {
        if (!parent::uninstall()) {
            return false;
        }

        return true;
    }

    /**
     * getContent function.
     *
     * @access public
     * @param string $tab (default: 'AdminModules')
     * @return void
     */
    public function getContent($tab = 'AdminModules')
    {

        echo "Admin Section";
    }

    /**
     * hookHeader function.
     *
     * @access public
     * @param mixed $params
     * @return void
     */
    public function hookFooter()
    {
        if ($this->active) {
            return $this->display(__FILE__, 'footer.tpl');
        }
    }

    /**
     * hookDisplayHeader function.
     *
     * @access public
     * @return void
     */
    public function hookDisplayFooter()
    {
        return $this->hookFooter();
    }

    /**
     * hookdisplayLeftColumn function.
     *
     * @access public
     * @return void
     */
    public function hookdisplayLeftColumn()
    {
        return $this->hookFooter();
    }

    /**
     * hookdisplayRightColumn function.
     *
     * @access public
     * @return void
     */
    public function hookdisplayRightColumn()
    {
        return $this->hookFooter();
    }

    /**
     * hookdisplayTop function.
     *
     * @access public
     * @return void
     */
    public function hookdisplayTop()
    {
        return $this->hookFooter();
    }

    /**
     * hookdisplayNav1 function.
     *
     * @access public
     * @return void
     */
    public function hookdisplayNav1()
    {
        return $this->hookFooter();
    }

    /**
     * hookdisplayNav2 function.
     *
     * @access public
     * @return void
     */
    public function hookdisplayNav2()
    {
        return $this->hookFooter();
    }

    /**
     * hookdisplayNavFullWidth function.
     *
     * @access public
     * @return void
     */
    public function hookdisplayNavFullWidth()
    {
        return $this->hookFooter();
    }

    /**
     * hookdisplayTopColumn function.
     *
     * @access public
     * @return void
     */
    public function hookdisplayTopColumn()
    {
        return $this->hookFooter();
    }

	/**
	 * hookDisplayBanner function.
	 *
	 * @access public
	 * @return void
	 */
	public function hookDisplayBanner()
	{
		return $this->hookFooter();
	}

	/**
	 * hookDisplayNav function.
	 *
	 * @access public
	 * @return void
	 */
	public function hookDisplayNav()
	{
		return $this->hookFooter();
	}
}
