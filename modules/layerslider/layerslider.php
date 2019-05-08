<?php
/**
* Creative Slider v6.6.5 - Responsive Slideshow Module https://creativeslider.webshopworks.com
*
*  @author    WebshopWorks <info@webshopworks.com>
*  @copyright 2018 WebshopWorks
*  @license   One Domain Licence
*/

defined('_PS_VERSION_') or exit;

class LayerSlider extends Module
{
    public static $instance;

    protected $init = false;
    protected $tabs = array(
        'Creative Slider' => array('class' => 'AdminParentLayerSlider', 'active' => 1, 'icon' => 'collections'),
        'Sliders' => array('class' => 'AdminLayerSlider', 'active' => 1),
        'Media Manager' => array('class' => 'AdminLayerSliderMedia', 'active' => 0),
        'Revisions' => array('class' => 'AdminLayerSliderRevisions', 'active' => 1),
        'Transition Builder' => array('class' => 'AdminLayerSliderTransition', 'active' => 1),
        'Skin Editor' => array('class' => 'AdminLayerSliderSkin', 'active' => 1),
        'CSS Editor' => array('class' => 'AdminLayerSliderStyle', 'active' => 1),
    );
    protected $lang = array(
        'fr' => array(
            'Creative Slider' => 'Creative Slider',
            'Sliders' => 'Diaporamas',
            'Media Manager' => 'Directeur des médias',
            'Revisions' => 'Révisions',
            'Transition Builder' => 'Effets de Transition',
            'Skin Editor' => 'Éditeur de skin',
            'CSS Editor' => 'Éditeur de CSS',
        )
    );

    public function __construct()
    {
        $this->name = 'layerslider';
        $this->tab = 'slideshows';
        $this->version = '6.6.5';
        $this->author = 'WebshopWorks';
        $this->module_key = 'b92dd49b8609431aeb010cb8db905a3f';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.7');
        $this->bootstrap = false;
        $this->displayName = 'Creative Slider';
        $this->description = 'Responsive Slideshow Module';
        $this->confirmUninstall = 'Are you sure you want to uninstall?';
        self::$instance = $this;
        parent::__construct();
        $this->controllerClass = str_replace('controller', '', Tools::strtolower(get_class($this->context->controller)));
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }
        $db = Db::getInstance();
        $res = $db->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'layerslider_module` (
                `id_slider` int(11) NOT NULL,
                `id_shop` int(11) NOT NULL DEFAULT 0,
                `id_lang` int(11) NOT NULL DEFAULT 0,
                `hook` varchar(64) NOT NULL DEFAULT \'\',
                `position` tinyint(2) NOT NULL DEFAULT 0,
                `pages` text NULL
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
        ');
        if (!$res) {
            $this->_errors[] = $db->getMsgError();
            return false;
        }
        return parent::install();
    }

    protected function addTabs()
    {
        $parent = version_compare(_PS_VERSION_, '1.7.0', '<') ? 0 : (int)Tab::getIdFromClassName('CONFIGURE');
        foreach ($this->tabs as $name => $t) {
            $tab = new Tab();
            $tab->active = $t['active'];
            $tab->class_name = $t['class'];
            $tab->name = array();
            foreach (Language::getLanguages(true) as $lang) {
                $tab->name[$lang['id_lang']] = isset($this->lang[$lang['iso_code']]) ? $this->lang[$lang['iso_code']][$name] : $name;
            }
            if (isset($t['icon'])) {
                $tab->icon = $t['icon'];
            }
            $tab->module = $this->name;
            $tab->id_parent = $parent;
            $tab->add();

            if ($t['class'] == 'AdminParentLayerSlider') {
                $parent = (int)Tab::getIdFromClassName($t['class']);
            }
        }
    }

    protected function deleteTabs()
    {
        foreach ($this->tabs as $t) {
            $id_tab = (int)Tab::getIdFromClassName($t['class']);
            if ($id_tab) {
                $tab = new Tab($id_tab);
                $tab->delete();
            }
        }
    }

    public function enable($force_all = false)
    {
        if ($res = parent::enable($force_all)) {
            $this->addTabs();
            $this->registerHook('filterCmsContent');
            $this->registerHook('filterProductContent');
            $this->registerHook('filterCategoryContent');
            $this->registerHook('displayHeader');
            if (version_compare(_PS_VERSION_, '1.7.1', '<')) {
                $this->registerHook('displayBackOfficeHeader');
            }
            $modules = Db::getInstance()->executeS('SELECT DISTINCT hook FROM '._DB_PREFIX_.'layerslider_module WHERE hook != "" AND id_shop > -1');
            foreach ($modules as $mod) {
                $this->registerHook($mod['hook']);
            }
        }
        return $res;
    }

    public function disable($force_all = false)
    {
        $this->deleteTabs();
        $db = Db::getInstance();
        $db->execute('DELETE FROM '._DB_PREFIX_.'tab WHERE module = "layerslider"');
        $this->unregisterHook('filterCmsContent');
        $this->unregisterHook('filterProductContent');
        $this->unregisterHook('filterCategoryContent');
        $this->unregisterHook('displayHeader');
        $this->unregisterHook('displayBackOfficeHeader');
        $modules = $db->executeS('SELECT DISTINCT hook FROM '._DB_PREFIX_.'layerslider_module WHERE hook != "" AND id_shop > -1');
        foreach ($modules as $mod) {
            $this->unregisterHook($mod['hook']);
        }
        return parent::disable($force_all);
    }

    public function getContent()
    {
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminLayerSlider'));
    }

    public function generateSlider($id)
    {
        if (is_array($id)) {
            $id = empty($id[2]) ? $id[1] : $id[2];
        }
        require_once _PS_MODULE_DIR_.'layerslider/helper.php';
        require_once _PS_MODULE_DIR_.'layerslider/base/layerslider.php';
        return LsShortcode::handleShortcode(array('id' => $id, 'filters' => ''));
    }

    protected function isOnPage(&$mod)
    {
        if (($mod['id_shop'] == 0 || $mod['id_shop'] == $this->context->shop->id) && ($mod['id_lang'] == 0 || $mod['id_lang'] == $this->context->language->id)) {
            if (!isset($mod['pages']) || !$mod['pages']) {
                $mod['pages'] = '{"cat":"all","prod":"all","cms":"all","page":"all"}';
            }
            if ($mod['pages'] == '{"cat":"all","prod":"all","cms":"all","page":"all"}') {
                return true;
            }
            $pages = Tools::jsonDecode($mod['pages'], true);
            switch ($this->controllerClass) {
                case 'index':
                    if ($pages['cat'] === 'all') {
                        return true;
                    }
                    return isset($pages['index']);
                case 'category':
                    if ($pages['cat'] === 'all') {
                        return true;
                    }
                    $id = Tools::getValue('id_category');
                    return in_array("$id", $pages['cat']);
                case 'product':
                    if ($pages['prod'] === 'all') {
                        return true;
                    }
                    $id = Tools::getValue('id_product');
                    return in_array("$id", $pages['prod']);
                case 'cms':
                    if ($pages['cms'] === 'all') {
                        return true;
                    }
                    if (isset($this->context->controller->cms->id)) {
                        return in_array("{$this->context->controller->cms->id}", $pages['page']);
                    }
                    if (isset($this->context->controller->cms_category->id)) {
                        return in_array("{$this->context->controller->cms_category->id}", $pages['cms']);
                    }
                    return false;
                case 'manufacturer':
                    if ($pages['cms'] === 'all') {
                        return true;
                    }
                    if (isset($pages['manufacturer'])) {
                        $id = (int) Tools::getValue('id_manufacturer', 0);
                        return in_array($id, $pages['manufacturer']);
                    }
                    return false;
                case 'psblogpostsmodulefront':
                    return isset($pages[$this->controllerClass]) && !$this->context->controller->id_post;
                case 'prestablogblogmodulefront':
                    if ($pages['cms'] === 'all') {
                        return true;
                    }
                    if ($id = Tools::getValue('id', 0)) {
                        return isset($pages['bn']) && in_array("$id", $pages['bn']);
                    }
                    $c = Tools::getValue('c', 0);
                    return isset($pages['bc']) && in_array("$c", $pages['bc']);
                default:
                    if ($pages['cms'] === 'all') {
                        return true;
                    }
                    return isset($pages[$this->controllerClass]);
            }
        }
        return false;
    }

    protected function displaySliders($hook)
    {
        $content = '';
        $modules = Db::getInstance()->executeS('SELECT * FROM '._DB_PREFIX_.'layerslider_module WHERE hook = "'.pSQL($hook).'" ORDER BY position');
        foreach ($modules as &$mod) {
            if ($this->isOnPage($mod)) {
                $content .= $this->generateSlider($mod['id_slider']);
            }
        }
        return $content;
    }

    public function __call($method, $args)
    {
        if (stripos($method, 'hookdisplay') === 0) {
            $hook = 'display'.Tools::substr($method, 11);
            return $this->displaySliders($hook);
        }
    }

    public function hookFilterCmsContent(&$cnt)
    {
        $cnt['object']['content'] = $this->filterShortcode($cnt['object']['content']);
        return $cnt;
    }

    public function hookFilterProductContent(&$cnt)
    {
        $cnt['object']['description'] = $this->filterShortcode($cnt['object']['description']);
        return $cnt;
    }

    public function hookFilterCategoryContent(&$cnt)
    {
        $cnt['object']['description'] = $this->filterShortcode($cnt['object']['description']);
        return $cnt;
    }

    public function filterShortcode(&$content)
    {
        require_once _PS_MODULE_DIR_.'layerslider/helper.php';
        require_once _PS_MODULE_DIR_.'layerslider/base/layerslider.php';
        $regexLs = '~<p>\s*\[(?:creative|layer)slider\s+id=["\']?(\w+)["\']?\s*\]\s*</p>|\[(?:creative|layer)slider\s+id=["\']?(\w+)["\']?\s*\]~i';
        $regexNav = '~\[[cl]s-navigate\s+id=["\']?(\w+)["\']?\s+action=["\']?(\w+)["\']?\s*\](.*?)\[/[cl]s-navigate\s*\]~i';
        $lsNav = '<a class="ls-navigate" href="javascript:;" onclick="jQuery(\'#layerslider_$1\').layerSlider(\'$2\')">$3</a>';
        $content = preg_replace_callback($regexLs, array($this, 'generateSlider'), $content);
        $content = preg_replace($regexNav, $lsNav, $content);
        return $content;
    }

    public function hookDisplayHeader()
    {
        require_once _PS_MODULE_DIR_.'layerslider/helper.php';
        require_once _PS_MODULE_DIR_.'layerslider/base/layerslider.php';
        ls_do_action('ls_enqueue_scripts');

        if (version_compare(_PS_VERSION_, '1.7.1', '<')) {
            // parse shortcodes
            $ctrl = $this->context->controller;
            if (in_array($ctrl->php_self, array('category', 'product', 'manufacturer')) && method_exists($ctrl, 'get'.$ctrl->php_self)) {
                $res = $ctrl->{'get'.$ctrl->php_self}();
                foreach (array('description', 'short_description', 'description_short') as $desc) {
                    if (!empty($res->{$desc})) {
                        $res->{$desc} = $this->filterShortcode($res->{$desc});
                    }
                }
            } elseif ($ctrl->php_self == 'cms' && !empty($ctrl->cms->content)) {
                $ctrl->cms->content = $this->filterShortcode($ctrl->cms->content);
            }
        } else {
            $vars = &$this->context->smarty->tpl_vars;
            if (!empty($vars['manufacturer']->value['description'])) {
                $desc = &$vars['manufacturer']->value['description'];
                $desc = $this->filterShortcode($desc);
            }
            if (!empty($vars['manufacturer']->value['short_description'])) {
                $short = &$vars['manufacturer']->value['short_description'];
                $short = preg_replace('/\[(creative|layer)slider.*?\]/i', '', $short);
            }
        }
        return ls_meta_generator();
    }

    public function hookDisplayBackOfficeHeader()
    {
        return $this->display(__FILE__, 'views/templates/admin/header.tpl');
    }
}

function creativeSlider($id)
{
    return LayerSlider::$instance->generateSlider($id);
}
