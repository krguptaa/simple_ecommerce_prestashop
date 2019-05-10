<?php
/**
* 2007-2016 PrestaShop
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

class BaProductsCarousel extends Module
{
    public $demoMode=false;
    public function __construct()
    {
        $this->name = "baproductscarousel";
        $this->tab = "front_office_features";
        $this->version = "1.0.1";
        $this->author = "buy-addons";
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);
        $this->bootstrap = true;
        $this->module_key = 'f8a7c5bba5ca32324dcb74fc10611e96';
        $this->displayName = $this->l('BA Prestashop Product Slider Carousel');
        $this->description = $this->l('BA Prestashop Product Slider Carousel');
        parent::__construct();
    }
    public function install()
    {
        if (parent::install() == false
            || !$this->registerhook('displayHeader')
            || !$this->registerhook('displayFooterProduct')
            || !$this->registerhook('displayHome')
            || !$this->registerhook('displayHomeTabContent')) {
            return false;
        }
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $addim = 'home'.'_default';
        Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'product_carousel_item`;');
        $query = "CREATE TABLE IF NOT EXISTS  "._DB_PREFIX_.'product_carousel_item';
        $query .="(id int(10) not null AUTO_INCREMENT,active int(10) not null";
        $query .=",name varchar(255) not null,cstock varchar(10) not null,note varchar(255) not null,";
        $query .="slitable varchar(10) not null,nav varchar(10) not null,mobile varchar(10) not null,";
        $query .="dots varchar(10) not null,loops varchar(10) not null,auto_play varchar(10) not null,";
        $query .="block varchar(255) not null,ordertype varchar(255) not null,";
        $query .="price varchar(10) not null,addtocart varchar(255) not null,";
        $query .="title varchar(10) not null,cate varchar(255) not null,sizeslide varchar(255) not null,";
        $query .="active_pro varchar(999) not null,item_desktop varchar(10) not null,";
        $query .="item_tablet varchar(10) not null,item_mobile varchar(10) not null,";
        $query .="productcase varchar(255) not null,product_show varchar(255) not null,";
        $query .="background_arrow varchar(255) not null,text_color_arrow varchar(255) not null,";
        $query .="background_arrow_hover varchar(255) not null,text_color varchar(255) not null,";
        $query .="background_button varchar(255) not null,background_button_hover varchar(255) not null,";
        $query .="text_button_color varchar(255) not null,text_button_color_hover varchar(255) not null,";
        $query .="id_shop int(10) not null,PRIMARY KEY (id))";
        $db->query($query);
        $id_shop = Shop::getCompleteListOfShopsID();
        foreach ($id_shop as $i) {
            $sqladd="INSERT INTO "._DB_PREFIX_.'product_carousel_item'."(name,slitable,mobile,active,cstock,note,";
            $sqladd .="nav,dots,loops,auto_play,block,ordertype,price,addtocart,sizeslide,title,";
            $sqladd .="cate,active_pro,item_desktop,item_tablet,item_mobile,product_show,productcase,";
            $sqladd .="background_arrow,text_color_arrow,background_arrow_hover,text_color,";
            $sqladd .="background_button,background_button_hover,text_button_color,text_button_color_hover,id_shop)";
            $sqladd .="VALUES('layout','0','0','0',";
            $sqladd .="'0','','true','true','false','true','home page tab',";
            $sqladd .="'name_asc','1','{\"addcart\":\"1\",\"wishlist\":\"0\",\"compare\":\"1\"}'";
            $sqladd .=",'{\"slih\":\"100%\",\"sliw\":\"100%\",\"sizeimg\":\"$addim\"}','1',";
            $sqladd .="'[\"".""."\"]','',";
            $sqladd .="'4','2','2','10','0','FFFFFF','000000','FF5E00','000000',";
            $sqladd .="'FFFFFF','FF5E00','FF5E00','FFFFFF','$i')";
            $db->query($sqladd);
        }

        return true;
    }
    public function uninstall()
    {
        if (parent::uninstall() == false) {
            return false;
        }
        Db::getInstance()->Execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'product_carousel_item`;');
        return true;
    }
    public function hookDisplayHomeTab()
    {
        $id_shop = $this->context->shop->id;
        $baiPhone  = stripos($_SERVER['HTTP_USER_AGENT'], "iPhone");
        $baiPad  = stripos($_SERVER['HTTP_USER_AGENT'], "iPad");
        $baAndroid = stripos($_SERVER['HTTP_USER_AGENT'], "Android");
        if ($baiPhone || $baAndroid) {
            $checksdevi = 'mobile';
        } elseif ($baiPad) {
            $checksdevi = 'table';
        } else {
            $checksdevi = 'desktop';
        }
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $showlayout = "SELECT * FROM " . _DB_PREFIX_ ."product_carousel_item";
        $showlayout .=" WHERE id_shop=".(int)$id_shop." AND block = 'home page tab'";
        $test = $db->ExecuteS($showlayout);
        $counttest = count($test);
        $this->context->smarty->assign('checksdevi', $checksdevi);
        $this->context->smarty->assign('counttest', $counttest);
        $this->context->smarty->assign('test', $test);
        $html = $this->display(__FILE__, 'views/templates/front/tab.tpl');
        return $html;
    }
    public function hookDisplayHomeTabContent()
    {
        $html = '';
        $html .= $this->templateslide('home page tab');
        return $html;
    }
    public function hookDisplayHome()
    {
        $html = '';
        $html .= $this->templateslide('home page 2');
        return $html;
    }
    public function hookDisplayFooterProduct()
    {
        $html = '';
        $html .= $this->templateslide('product page');
        return $html;
    }
    public function fixjs()
    {
        $html = '';
        $base =Tools::getShopProtocol() . Tools::getServerName() . __PS_BASE_URI__;
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $showlayout = "SELECT * FROM " . _DB_PREFIX_ ."product_carousel_item";
        $slidejs = $db->ExecuteS($showlayout);
        $this->context->smarty->assign('base', $base);
        $this->context->smarty->assign('slidejs', $slidejs);
        $html .= $this->display(__FILE__, 'views/templates/front/js.tpl');
        return $html;
    }
    public static function getAverageGrade($id_product)
    {
        $validate = (int)Configuration::get('PRODUCT_COMMENTS_MODERATE');

        return Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow('
        SELECT (SUM(pc.`grade`) / COUNT(pc.`grade`)) AS grade
        FROM `'._DB_PREFIX_.'product_comment` pc
        WHERE pc.`id_product` = '.(int)$id_product.'
        AND pc.`deleted` = 0'.
        ($validate == '1' ? ' AND pc.`validate` = 1' : ''));
    }
    public static function getUrlFix($id_product)
    {
        $link = new Link();
        $url = $link->getProductLink($id_product);
        return $url;
    }
    public static function getImgFix($id_product, $imgsize)
    {
        $base =Tools::getShopProtocol() . Tools::getServerName();
        $protocol = Tools::getShopProtocol();
        $image = Image::getCover($id_product);
        $product = new Product($id_product, false, Context::getContext()->language->id);
        $link = new Link;
        if ($image['id_image'] == null) {
            $imagePath = $base._THEME_PROD_DIR_.'en-default-'.$imgsize.".jpg";
        } else {
            $imagePath = $protocol.$link->getImageLink($product->link_rewrite, $image['id_image'], $imgsize);
        }
        return $imagePath;
    }
    public static function selectWishList($id_product, $id_shop, $id_customer)
    {
        if ($id_customer == null) {
            $id_customer = 0;
        }
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $sqlwl = "SELECT * FROM " ._DB_PREFIX_."wishlist_product INNER JOIN " . _DB_PREFIX_ ."wishlist ON";
        $sqlwl .=" " . _DB_PREFIX_ ."wishlist_product.id_wishlist = " . _DB_PREFIX_ ."wishlist.id_wishlist WHERE";
        $sqlwl .=" " . _DB_PREFIX_ ."wishlist.default=1 AND id_customer = ";
        $sqlwl .=(int)$id_customer." AND id_shop = ".(int)$id_shop."";
        $kk = $db->ExecuteS($sqlwl);
        $a = 0;
        foreach ($kk as $key) {
            if ($id_product == $key['id_product']) {
                $a += 1;
            }
        }
        return $a;
    }
    public static function selectCompare($id_product, $id_customer, $count)
    {
        if ($count == null) {
            $count = array();
        }
        if ($id_customer == null) {
            $id_customer = 0;
        }
        if (in_array($id_product, $count)) {
            $searr = 1;
        } else {
            $searr = 0;
        }
        return $searr;
    }
    public function hookDisplayHeader()
    {
        $html = '';
        /*echo '<pre>'; print_r(Product::getUrlRewriteInformations(1));die;*/
        if (Tools::version_compare(_PS_VERSION_, '1.7.0.0', '>')) {
            $html .= $this->fixjs();
        }
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $checkwishlist = Module::isInstalled('blockwishlist');
        $checkratingst = Module::isInstalled('productcomments');
        $this->context->smarty->assign('checkwishlist', $checkwishlist);
        $this->context->smarty->assign('checkratingst', $checkratingst);
        $showlayout = "SELECT * FROM " . _DB_PREFIX_ ."product_carousel_item";
        $showsc = $db->ExecuteS($showlayout);
        foreach ($showsc as $showsck) {
            $varname = $showsck['name'] ."_".$showsck['id'];
            $$varname = $this->templateslide($showsck['block'], $showsck['id']);
            $this->context->smarty->assign('baproductscarousel_'.$showsck['id'], $$varname);
        };
        /*echo '<pre>';print_r(Configuration::get('HOME_FEATURED_NBR'));die;*/
        $id_shop = (int)$this->context->shop->id;
        $id_customer = (int)$this->context->customer->id;
        $id_lang = (int)$this->context->language->id;
        $rtl = new language($id_lang);
        $rtl = $rtl->is_rtl;
        $background_arrow = Configuration::get('background_arrow', '', '', $id_shop);
        $background_arrow_hover = Configuration::get('background_arrow_hover', '', '', $id_shop);
        $text_color = Configuration::get('text_color', '', '', $id_shop);
        $background_button = Configuration::get('background_button', '', '', $id_shop);
        $background_button_hover = Configuration::get('background_button_hover', '', '', $id_shop);
        $text_button_color = Configuration::get('text_button_color', '', '', $id_shop);
        $text_button_color_hover = Configuration::get('text_button_color_hover', '', '', $id_shop);
        $text_color_arrow = Configuration::get('text_color_arrow', '', '', $id_shop);
        $this->context->smarty->assign('showsc', $showsc);
        $this->context->smarty->assign('text_color_arrow', $text_color_arrow);
        $this->context->smarty->assign('background_arrow', $background_arrow);
        $this->context->smarty->assign('background_arrow_hover', $background_arrow_hover);
        $this->context->smarty->assign('text_color', $text_color);
        $this->context->smarty->assign('background_button', $background_button);
        $this->context->smarty->assign('background_button_hover', $background_button_hover);
        $this->context->smarty->assign('text_button_color', $text_button_color);
        $this->context->smarty->assign('text_button_color_hover', $text_button_color_hover);
        $this->context->controller->addJS($this->_path . 'views/js/slidebutton.js');
        $this->context->controller->addJS($this->_path . 'views/js/assets/owl.carousel.js');
        $this->context->controller->addCSS($this->_path . 'views/css/assets/owl.carousel.min.css');
        $this->context->controller->addCSS($this->_path . 'views/css/assets/owl.theme.default.min.css');
        $this->context->controller->addCSS($this->_path . 'views/css/assets/animate.css');
        $this->context->controller->addCSS($this->_path . 'views/css/baslider.css');
        $html .= '<script>
                 var id_customer = \'' .$id_customer. '\';
                 var rtl = \'' .$rtl. '\';
                </script>';
        $html .= $this->display(__FILE__, 'views/templates/front/template.tpl');
        return $html;
    }
    public function templateslide($checktype, $id_sli = null)
    {
        $html = '';
        $id_product_i = (int)Tools::getValue('id_product');
        $baiPhone  = stripos($_SERVER['HTTP_USER_AGENT'], "iPhone");
        $baiPad  = stripos($_SERVER['HTTP_USER_AGENT'], "iPad");
        $baAndroid = stripos($_SERVER['HTTP_USER_AGENT'], "Android");
        $token = Tools::getToken(false);
        /*$id_customer = $this->context->customer->id;*/
        $id_currency = $this->context->currency->id;
        /*$id_group = Customer::getGroupsStatic($id_customer);*/
        $this->context->smarty->assign('token', $token);
        $id_langs = $this->context->language->id;
        $id_shop = $this->context->shop->id;
        $id_customer = $this->context->customer->id;
        $base =Tools::getShopProtocol() . Tools::getServerName() . __PS_BASE_URI__;
        $this->context->smarty->assign('base', $base);
        $iso_lang = $this->context->language->iso_code;
        $this->context->smarty->assign('iso_lang', $iso_lang);
        if (!Tools::version_compare(_PS_VERSION_, '1.7.0.0', '>')) {
            $compared_products = CompareProduct::getCompareProducts($this->context->cookie->id_compare);
            $this->context->smarty->assign('ba_compared_products', $compared_products);
        }
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        /*$page_type = Tools::getValue('controller');*/
        if ($id_sli == null) {
            $showlayout = "SELECT * FROM " . _DB_PREFIX_ ."product_carousel_item";
            $showlayout .=" WHERE id_shop=".(int)$id_shop." AND block = '".pSQL($checktype)."'";
        } else {
            $showlayout = "SELECT * FROM " . _DB_PREFIX_ ."product_carousel_item";
            $showlayout .=" WHERE id_shop=".(int)$id_shop." AND block = '".pSQL($checktype)."'";
            $showlayout .=" AND id=".(int)$id_sli."";
        }
        $test = $db->ExecuteS($showlayout);
        if (isset($test)) {
            foreach ($test as $key) {
                $id_sl = $key['id'];
                $nav = $key['nav'];
                $dots = $key['dots'];
                $loops = $key['loops'];
                $auto_play = $key['auto_play'];
                $price = $key['price'];
                $addtocart = $key['addtocart'];
                $title = $key['title'];
                $names = $key['name'];
                $addtocart = json_decode($key['addtocart']);
                $item_desktop = $key['item_desktop'];
                $item_mobile = $key['item_mobile'];
                $item_tablet = $key['item_tablet'];
                $product_show = $key['product_show'];
                $cstock = $key['cstock'];
                $embe = $key['active'];
                $bablocks = $key['block'];
                if ($key['mobile'] == 0) {
                    if ($baiPhone || $baAndroid) {
                        $embe = 0;
                    }
                }
                if ($key['slitable'] == 0) {
                    if ($baiPad) {
                        $embe = 0;
                    }
                }
                $sizeslide = json_decode($key['sizeslide']);
                $cate = json_decode($key['cate']);
                $pros = json_decode($key['active_pro']);
                $dates = "";
                if (is_array(json_decode($key['cate']))) {
                    /*$ids = join("','",$cate);*/
                }
                /*$zeroo = Tools::displayPrice(0, $id_currency);
                var_dump($zeroo);die;*/
                $ba_product_show = 100;
                $arr = array();
                $arrs = array();
                $arrp = array();
                $v_shows = '';
                $html .= '<script>
                         var auto_play = \'' .$auto_play. '\';
                 </script>';
                if ($key['ordertype'] == 'bestsell') {
                    $shows = "";
                    if (is_array(json_decode($key['cate']))) {
                        foreach ($cate as $cc) {
                            $shows = Product::getProducts($id_langs, 0, $ba_product_show, 'name', 'asc', $cc, true);
                            foreach ($shows as $k_shows => $v_shows) {
                                $queryd = "SELECT `date_upd` FROM "._DB_PREFIX_;
                                $queryd .="product_sale WHERE `id_product` = ".(int)$shows[$k_shows]['id_product'];
                                $date_be = $db->ExecuteS($queryd);
                                foreach ($date_be as $d) {
                                    $dates = $d['date_upd'];
                                }
                                $key_name = ProductSale::getNbrSales($shows[$k_shows]['id_product']);
                                $key_name .=' - '.$dates.' - '. $shows[$k_shows]['id_product'];
                                $arr[$key_name] = $shows[$k_shows];
                            }
                        }
                    }
                    if (is_array($pros)) {
                        foreach ($pros as $pross) {
                            $ss = new Product($pross, true, $id_langs, $id_shop);
                            $queryd = "SELECT `date_upd` FROM "._DB_PREFIX_;
                            $queryd .="product_sale WHERE `id_product` = ".(int)$pross;
                            $date_be = $db->ExecuteS($queryd);
                            foreach ($date_be as $d) {
                                $dates = $d['date_upd'];
                            }
                            $name_p = ProductSale::getNbrSales($pross).' - '.$dates.' - '.$pross;
                            $id_fix = array(
                                'id_product'=>$pross,
                            );
                            if ($ss->active == 1) {
                                $arrs[$name_p] = array(
                                    'name' => $ss->name,
                                    'id_category_default'=>$ss->id_category_default,
                                    'rate'=>Product::getTaxesInformations($id_fix)['rate'],
                                    'id_product'=>$pross,
                                    'price'=>$ss->base_price,
                                    'link_rewrite'=>$ss->link_rewrite,
                                );
                            }
                        }
                        if (count($arr)>0) {
                            $arr = array_intersect_key($arr, $arrs);
                        } else {
                            $arr = $arrs;
                        }
                    }
                    if (Tools::getValue('controller') == 'product') {
                        if ($key['productcase'] == 1) {
                            $involve = new Product($id_product_i);
                            $involve_pro = $involve->getDefaultCategory();
                            $showinvo = Product::getProducts($id_langs, 0, 99, 'name', 'asc', $involve_pro, true);
                            foreach ($showinvo as $k_showinvo => $v_showinvo) {
                                $queryd = "SELECT `date_upd` FROM "._DB_PREFIX_;
                                $queryd .="product_sale WHERE `id_product` = ";
                                $queryd .= pSQL($showinvo[$k_showinvo]['id_product']);
                                $date_be = $db->ExecuteS($queryd);
                                foreach ($date_be as $d) {
                                    $dates = $d['date_upd'];
                                }
                                $key_names = ProductSale::getNbrSales($showinvo[$k_showinvo]['id_product']);
                                $key_names .=' - '.$dates.' - '. $showinvo[$k_showinvo]['id_product'];
                                $arrp[$key_names] = $showinvo[$k_showinvo];
                            }
                            $lads = (int)Tools::getValue('id_product');
                            $itpro = new Product($lads, true, $id_langs, $id_shop);
                            $queryd = "SELECT `date_upd` FROM "._DB_PREFIX_;
                            $queryd .="product_sale WHERE `id_product` = ".(int)$lads;
                            $date_be = $db->ExecuteS($queryd);
                            foreach ($date_be as $d) {
                                $dates = $d['date_upd'];
                            }
                            $reitpro = ProductSale::getNbrSales($id_product_i);
                            $reitpro .=' - '.$dates.' - '.$id_product_i;
                            unset($arrp[$reitpro]);
                            if (count($arr)>0) {
                                $arr = array_intersect_key($arr, $arrp);
                            } else {
                                $arr = $arrp;
                            }
                        }
                    }
                    krsort($arr);
                    /*echo '<pre>';print_r($arr);die;*/
                    $this->context->smarty->assign('shows', array_slice($arr, 0, $product_show));
                }
                if ($key['ordertype'] == 'popular') {
                    $shows = "";
                    if (is_array(json_decode($key['cate']))) {
                        foreach ($cate as $cc) {
                            $shows = Product::getProducts($id_langs, 0, $ba_product_show, 'name', 'asc', $cc, true);
                            foreach ($shows as $k_shows => $v_shows) {
                                $key_name = $shows[$k_shows]['date_upd'];
                                $key_name .=' - '. $shows[$k_shows]['id_product'];
                                $arr[$key_name] = $shows[$k_shows];
                            }
                        }
                    }
                    if (is_array($pros)) {
                        foreach ($pros as $pross) {
                            $ss = new Product($pross, true, $id_langs, $id_shop);
                            $name_p = $ss->date_upd.' - '.$pross;
                            $id_fix = array(
                                'id_product'=>$pross,
                            );
                            if ($ss->active == 1) {
                                $arrs[$name_p] = array(
                                    'name' => $ss->name,
                                    'id_category_default'=>$ss->id_category_default,
                                    'rate'=>Product::getTaxesInformations($id_fix)['rate'],
                                    'id_product'=>$pross,
                                    'price'=>$ss->base_price,
                                    'link_rewrite'=>$ss->link_rewrite,
                                );
                            }
                        }
                        if (count($arr)>0) {
                            $arr = array_intersect_key($arr, $arrs);
                        } else {
                            $arr = $arrs;
                        }
                    }
                    if (Tools::getValue('controller') == 'product') {
                        if ($key['productcase'] == 1) {
                            $involve = new Product($id_product_i);
                            $involve_pro = $involve->getDefaultCategory();
                            $showinvo = Product::getProducts($id_langs, 0, 99, 'name', 'desc', $involve_pro, true);
                            foreach ($showinvo as $k_showinvo => $v_showinvo) {
                                $key_names = $showinvo[$k_showinvo]['date_upd'];
                                $key_names .=' - '. $showinvo[$k_showinvo]['id_product'];
                                $arrp[$key_names] = $showinvo[$k_showinvo];
                            }
                            $itpro = new Product($id_product_i, true, $id_langs, $id_shop);
                            $reitpro = $itpro->date_upd.' - '.Tools::getValue('id_product');
                            unset($arrp[$reitpro]);
                            if (count($arr)>0) {
                                $arr = array_intersect_key($arr, $arrp);
                            } else {
                                $arr = $arrp;
                            }
                        }
                    }
                    ksort($arr);
                    /*echo '<pre>';print_r($arr);die;*/
                    $popu = Product::getProducts($id_langs, 0, $ba_product_show, 'name', 'asc', 2, true);
                    $popular = array();
                    if (count($popu) > 0) {
                        foreach ($popu as $popuk => $popuv) {
                            $popu_name = $popu[$popuk]['date_upd'];
                            $popu_name .=' - '. $popu[$popuk]['id_product'];
                            $popular[$popu_name] = $popu[$popuk];
                        }
                        $pp = array_intersect_key($arr, $popular);
                        ksort($pp);
                        $arr = array_merge($pp, $arr);
                        $this->context->smarty->assign('shows', array_slice($arr, 0, $product_show));
                    } else {
                        $this->context->smarty->assign('shows', array_slice($arr, 0, $product_show));
                    }
                }
                if ($key['ordertype'] == 'name_asc') {
                    $shows = "";
                    if (is_array(json_decode($key['cate']))) {
                        foreach ($cate as $cc) {
                            $shows = Product::getProducts($id_langs, 0, $ba_product_show, 'name', 'asc', $cc, true);
                            foreach ($shows as $k_shows => $v_shows) {
                                $key_name = $shows[$k_shows]['name'] .' - '. $shows[$k_shows]['id_product'];
                                $arr[$key_name] = $shows[$k_shows];
                            }
                        }
                    }
                    if (is_array($pros)) {
                        foreach ($pros as $pross) {
                            $ss = new Product($pross, true, $id_langs, $id_shop);
                            $name_p = $ss->name.' - '.$pross;
                            $id_fix = array(
                                'id_product'=>$pross,
                            );
                            if ($ss->active == 1) {
                                $arrs[$name_p] = array(
                                    'name' => $ss->name,
                                    'id_category_default'=>$ss->id_category_default,
                                    'rate'=>Product::getTaxesInformations($id_fix)['rate'],
                                    'id_product'=>$pross,
                                    'price'=>$ss->base_price,
                                    'link_rewrite'=>$ss->link_rewrite,
                                );
                            }
                        }
                        if (count($arr)>0) {
                            $arr = array_intersect_key($arr, $arrs);
                        } else {
                            $arr = $arrs;
                        }
                    }
                    if (Tools::getValue('controller') == 'product') {
                        if ($key['productcase'] == 1) {
                            $involve = new Product($id_product_i);
                            $involve_pro = $involve->getDefaultCategory();
                            $showinvo = Product::getProducts($id_langs, 0, 99, 'name', 'asc', $involve_pro, true);
                            foreach ($showinvo as $k_showinvo => $v_showinvo) {
                                $key_names = $showinvo[$k_showinvo]['name'];
                                $key_names .=' - '. $showinvo[$k_showinvo]['id_product'];
                                $arrp[$key_names] = $showinvo[$k_showinvo];
                            }
                            $itpro = new Product($id_product_i, true, $id_langs, $id_shop);
                            $reitpro = $itpro->name.' - '.Tools::getValue('id_product');
                            unset($arrp[$reitpro]);
                            if (count($arr)>0) {
                                $arr = array_intersect_key($arr, $arrp);
                            } else {
                                $arr = $arrp;
                            }
                        }
                    }
                    ksort($arr);
                    /*echo '<pre>';print_r($arr);die;*/
                    $this->context->smarty->assign('shows', array_slice($arr, 0, $product_show));
                }
                if ($key['ordertype'] == 'name_desc') {
                    $shows = "";
                    if (is_array(json_decode($key['cate']))) {
                        foreach ($cate as $cc) {
                            $shows = Product::getProducts($id_langs, 0, $ba_product_show, 'name', 'desc', $cc, true);
                            foreach ($shows as $k_shows => $v_shows) {
                                $key_name = $shows[$k_shows]['name'] .' - '. $shows[$k_shows]['id_product'];
                                $arr[$key_name] = $shows[$k_shows];
                            }
                        }
                    }
                    if (is_array($pros)) {
                        foreach ($pros as $pross) {
                            $ss = new Product($pross, true, $id_langs, $id_shop);
                            $name_p = $ss->name.' - '.$pross;
                            $id_fix = array(
                                'id_product'=>$pross,
                            );
                            if ($ss->active == 1) {
                                $arrs[$name_p] = array(
                                    'name' => $ss->name,
                                    'id_category_default'=>$ss->id_category_default,
                                    'rate'=>Product::getTaxesInformations($id_fix)['rate'],
                                    'id_product'=>$pross,
                                    'price'=>$ss->base_price,
                                    'link_rewrite'=>$ss->link_rewrite,
                                );
                            }
                        }
                        if (count($arr)>0) {
                            $arr = array_intersect_key($arr, $arrs);
                        } else {
                            $arr = $arrs;
                        }
                    }
                    if (Tools::getValue('controller') == 'product') {
                        if ($key['productcase'] == 1) {
                            $involve = new Product($id_product_i);
                            $involve_pro = $involve->getDefaultCategory();
                            $showinvo = Product::getProducts($id_langs, 0, 99, 'name', 'desc', $involve_pro, true);
                            foreach ($showinvo as $k_showinvo => $v_showinvo) {
                                $key_names = $showinvo[$k_showinvo]['name'];
                                $key_names .=' - '. $showinvo[$k_showinvo]['id_product'];
                                $arrp[$key_names] = $showinvo[$k_showinvo];
                            }
                            $itpro = new Product($id_product_i, true, $id_langs, $id_shop, true);
                            $reitpro = $itpro->name.' - '.Tools::getValue('id_product');
                            unset($arrp[$reitpro]);
                            if (count($arr)>0) {
                                $arr = array_intersect_key($arr, $arrp);
                            } else {
                                $arr = $arrp;
                            }
                        }
                    }
                    /*echo '<pre>';print_r($arr);die;*/
                    krsort($arr);
                    $this->context->smarty->assign('shows', array_slice($arr, 0, $product_show));
                }
                if ($key['ordertype'] == 'price_asc') {
                    $shows = "";
                    if (is_array(json_decode($key['cate']))) {
                        foreach ($cate as $cc) {
                            $shows = Product::getProducts($id_langs, 0, $ba_product_show, 'price', 'asc', $cc, true);
                            foreach ($shows as $k_shows => $v_shows) {
                                $key_name = Product::getPriceStatic($shows[$k_shows]['id_product']);
                                $key_name .=' - '. $shows[$k_shows]['id_product'];
                                $arr[$key_name] = $shows[$k_shows];
                            }
                        }
                    }
                    if (is_array($pros)) {
                        foreach ($pros as $pross) {
                            $ss = new Product($pross, true, $id_langs, $id_shop);
                            $name_p = Product::getPriceStatic($pross).' - '.$pross;
                            $id_fix = array(
                                'id_product'=>$pross,
                            );
                            if ($ss->active == 1) {
                                $arrs[$name_p] = array(
                                    'name' => $ss->name,
                                    'id_category_default'=>$ss->id_category_default,
                                    'rate'=>Product::getTaxesInformations($id_fix)['rate'],
                                    'id_product'=>$pross,
                                    'price'=>$ss->base_price,
                                    'link_rewrite'=>$ss->link_rewrite,
                                );
                            }
                        }
                        if (count($arr)>0) {
                            $arr = array_intersect_key($arr, $arrs);
                        } else {
                            $arr = $arrs;
                        }
                    }
                    if (Tools::getValue('controller') == 'product') {
                        if ($key['productcase'] == 1) {
                            $involve = new Product($id_product_i);
                            $involve_pro = $involve->getDefaultCategory();
                            $showinvo = Product::getProducts($id_langs, 0, 99, 'price', 'asc', $involve_pro, true);
                            foreach ($showinvo as $k_showinvo => $v_showinvo) {
                                $key_names = Product::getPriceStatic($showinvo[$k_showinvo]['id_product']);
                                $key_names .=' - '. $showinvo[$k_showinvo]['id_product'];
                                $arrp[$key_names] = $showinvo[$k_showinvo];
                            }
                            $itpro = new Product($id_product_i, true, $id_langs, $id_shop);
                            $reitpro = Product::getPriceStatic(Tools::getValue('id_product'));
                            $reitpro .=' - '.Tools::getValue('id_product');
                            unset($arrp[$reitpro]);
                            if (count($arr)>0) {
                                $arr = array_intersect_key($arr, $arrp);
                            } else {
                                $arr = $arrp;
                            }
                        }
                    }
                    /*echo '<pre>'; print_r($arr);die;*/
                    ksort($arr);
                    $this->context->smarty->assign('shows', array_slice($arr, 0, $product_show));
                }
                if ($key['ordertype'] == 'price_desc') {
                    $shows = "";
                    if (is_array(json_decode($key['cate']))) {
                        foreach ($cate as $cc) {
                            $shows = Product::getProducts($id_langs, 0, $ba_product_show, 'price', 'desc', $cc, true);
                            foreach ($shows as $k_shows => $v_shows) {
                                $key_name = Product::getPriceStatic($shows[$k_shows]['id_product']);
                                $key_name .=' - '. $shows[$k_shows]['id_product'];
                                $arr[$key_name] = $shows[$k_shows];
                            }
                        }
                    }
                    if (is_array($pros)) {
                        foreach ($pros as $pross) {
                            $ss = new Product($pross, true, $id_langs, $id_shop);
                            $name_p = Product::getPriceStatic($pross).' - '.$pross;
                            $id_fix = array(
                                'id_product'=>$pross,
                            );
                            if ($ss->active == 1) {
                                $arrs[$name_p] = array(
                                    'name' => $ss->name,
                                    'id_category_default'=>$ss->id_category_default,
                                    'rate'=>Product::getTaxesInformations($id_fix)['rate'],
                                    'id_product'=>$pross,
                                    'price'=>$ss->base_price,
                                    'link_rewrite'=>$ss->link_rewrite,
                                );
                            }
                        }
                        if (count($arr)>0) {
                            $arr = array_intersect_key($arr, $arrs);
                        } else {
                            $arr = $arrs;
                        }
                    }
                    if (Tools::getValue('controller') == 'product') {
                        if ($key['productcase'] == 1) {
                            $involve = new Product($id_product_i);
                            $involve_pro = $involve->getDefaultCategory();
                            $showinvo = Product::getProducts($id_langs, 0, 99, 'price', 'desc', $involve_pro, true);
                            foreach ($showinvo as $k_showinvo => $v_showinvo) {
                                $key_names = Product::getPriceStatic($showinvo[$k_showinvo]['id_product']);
                                $key_names .=' - '. $showinvo[$k_showinvo]['id_product'];
                                $arrp[$key_names] = $showinvo[$k_showinvo];
                            }
                            $itpro = new Product($id_product_i, true, $id_langs, $id_shop);
                            $reitpro = Product::getPriceStatic(Tools::getValue('id_product'));
                            $reitpro .=' - '.Tools::getValue('id_product');
                            unset($arrp[$reitpro]);
                            if (count($arr)>0) {
                                $arr = array_intersect_key($arr, $arrp);
                            } else {
                                $arr = $arrp;
                            }
                        }
                    }
                    /*echo '<pre>'; print_r($arr);die;*/
                    krsort($arr);
                    $this->context->smarty->assign('shows', array_slice($arr, 0, $product_show));
                }
                if ($key['ordertype'] == 'discount_desc') {
                    $shows = "";
                    if (is_array(json_decode($key['cate']))) {
                        foreach ($cate as $cc) {
                            $shows = Product::getProducts($id_langs, 0, $ba_product_show, 'price', 'desc', $cc, true);
                            foreach ($shows as $k_shows => $v_shows) {
                                $discout = (round(round($shows[$k_shows]['price'], 2)
                                +round($shows[$k_shows]['price'], 2) * $shows[$k_shows]['rate']/100, 2)
                                -round(Product::getPriceStatic($shows[$k_shows]['id_product']), 2))
                                /round(round($shows[$k_shows]['price'], 2)+round($shows[$k_shows]['price'], 2)
                                *$shows[$k_shows]['rate']/100, 2);
                                $key_name = $discout;
                                $key_name .=' - '. $shows[$k_shows]['id_product'];
                                $arr[$key_name] = $shows[$k_shows];
                            }
                        }
                    }
                    if (is_array($pros)) {
                        foreach ($pros as $pross) {
                            $ss = new Product($pross, true, $id_langs, $id_shop);
                            $discout = (round(round($ss->base_price, 2)+round($ss->base_price, 2)
                                * $ss->tax_rate/100, 2)-round(Product::getPriceStatic($pross), 2))
                                /(round(round($ss->base_price, 2)+round($ss->base_price, 2) * $ss->tax_rate/100, 2));
                            $name_p = $discout.' - '.$pross;
                            $id_fix = array(
                                'id_product'=>$pross,
                            );
                            if ($ss->active == 1) {
                                $arrs[$name_p] = array(
                                    'name' => $ss->name,
                                    'id_category_default'=>$ss->id_category_default,
                                    'rate'=>Product::getTaxesInformations($id_fix)['rate'],
                                    'id_product'=>$pross,
                                    'price'=>$ss->base_price,
                                    'link_rewrite'=>$ss->link_rewrite,
                                );
                            }
                        }
                        if (count($arr)>0) {
                            $arr = array_intersect_key($arr, $arrs);
                        } else {
                            $arr = $arrs;
                        }
                    }
                    if (Tools::getValue('controller') == 'product') {
                        if ($key['productcase'] == 1) {
                            $involve = new Product($id_product_i);
                            $involve_pro = $involve->getDefaultCategory();
                            $showinvo = Product::getProducts($id_langs, 0, 99, 'price', 'desc', $involve_pro, true);
                            foreach ($showinvo as $k_showinvo => $v_showinvo) {
                                $discout = (round(round($showinvo[$k_showinvo]['price'], 2)
                                +round($showinvo[$k_showinvo]['price'], 2)
                                *$showinvo[$k_showinvo]['rate']/100, 2)
                                -round(Product::getPriceStatic($showinvo[$k_showinvo]['id_product']), 2))
                                /(round(round($showinvo[$k_showinvo]['price'], 2)
                                +round($showinvo[$k_showinvo]['price'], 2)
                                *$showinvo[$k_showinvo]['rate']/100, 2)
                                -round(Product::getPriceStatic($showinvo[$k_showinvo]['id_product']), 2));
                                $key_names = $discout;
                                $key_names .=' - '. $showinvo[$k_showinvo]['id_product'];
                                $arrp[$key_names] = $showinvo[$k_showinvo];
                            }
                            $itpro = new Product($id_product_i, true, $id_langs, $id_shop);
                            $reitpro = Product::getPriceStatic(Tools::getValue('id_product'));
                            $reitpro .=' - '.Tools::getValue('id_product');
                            unset($arrp[$reitpro]);
                            if (count($arr)>0) {
                                $arr = array_intersect_key($arr, $arrp);
                            } else {
                                $arr = $arrp;
                            }
                        }
                    }
                    /*echo '<pre>'; print_r($arr);die;*/
                    krsort($arr);
                    $this->context->smarty->assign('shows', array_slice($arr, 0, $product_show));
                }
                if ($key['ordertype'] == 'discount_asc') {
                    $shows = "";
                    if (is_array(json_decode($key['cate']))) {
                        foreach ($cate as $cc) {
                            $shows = Product::getProducts($id_langs, 0, $ba_product_show, 'price', 'desc', $cc, true);
                            foreach ($shows as $k_shows => $v_shows) {
                                $discout = round(round($shows[$k_shows]['price'], 2)+round($shows[$k_shows]['price'], 2)
                                *$shows[$k_shows]['rate']/100, 2)
                                -round(Product::getPriceStatic($shows[$k_shows]['id_product']), 2);
                                $key_name = $discout;
                                $key_name .=' - '. $shows[$k_shows]['id_product'];
                                $arr[$key_name] = $shows[$k_shows];
                            }
                        }
                    }
                    if (is_array($pros)) {
                        foreach ($pros as $pross) {
                            $ss = new Product($pross, true, $id_langs, $id_shop);
                            $discout = round(round($ss->base_price, 2)+round($ss->base_price, 2)
                                * $ss->tax_rate/100, 2)-round(Product::getPriceStatic($pross), 2);
                            $name_p = $discout.' - '.$pross;
                            $id_fix = array(
                                'id_product'=>$pross,
                            );
                            if ($ss->active == 1) {
                                $arrs[$name_p] = array(
                                    'name' => $ss->name,
                                    'id_category_default'=>$ss->id_category_default,
                                    'rate'=>Product::getTaxesInformations($id_fix)['rate'],
                                    'id_product'=>$pross,
                                    'price'=>$ss->base_price,
                                    'link_rewrite'=>$ss->link_rewrite,
                                );
                            }
                        }
                        if (count($arr)>0) {
                            $arr = array_intersect_key($arr, $arrs);
                        } else {
                            $arr = $arrs;
                        }
                    }
                    if (Tools::getValue('controller') == 'product') {
                        if ($key['productcase'] == 1) {
                            $involve = new Product($id_product_i);
                            $involve_pro = $involve->getDefaultCategory();
                            $showinvo = Product::getProducts($id_langs, 0, 99, 'price', 'desc', $involve_pro, true);
                            foreach ($showinvo as $k_showinvo => $v_showinvo) {
                                $discout = round(round($showinvo[$k_showinvo]['price'], 2)
                                +round($showinvo[$k_showinvo]['price'], 2)
                                *$showinvo[$k_showinvo]['rate']/100, 2)
                                -round(Product::getPriceStatic($showinvo[$k_showinvo]['id_product']), 2);
                                $key_names = $discout;
                                $key_names .=' - '. $showinvo[$k_showinvo]['id_product'];
                                $arrp[$key_names] = $showinvo[$k_showinvo];
                            }
                            $itpro = new Product($id_product_i, true, $id_langs, $id_shop);
                            $reitpro = Product::getPriceStatic(Tools::getValue('id_product'));
                            $reitpro .=' - '.Tools::getValue('id_product');
                            unset($arrp[$reitpro]);
                            if (count($arr)>0) {
                                $arr = array_intersect_key($arr, $arrp);
                            } else {
                                $arr = $arrp;
                            }
                        }
                    }
                    krsort($arr, 1);/*
                    echo '<pre>'; print_r($arr);die;*/
                    $this->context->smarty->assign('shows', array_slice($arr, 0, $product_show));
                }
                if ($key['ordertype'] == 'date_asc') {
                    $shows = "";
                    if (is_array(json_decode($key['cate']))) {
                        foreach ($cate as $cc) {
                            $shows=Product::getProducts($id_langs, 0, $ba_product_show, 'date_add', 'asc', $cc, true);
                            foreach ($shows as $k_shows => $v_shows) {
                                $key_name = $shows[$k_shows]['date_add'] .' - '. $shows[$k_shows]['id_product'];
                                $arr[$key_name] = $shows[$k_shows];
                            }
                        }
                    }
                    if (is_array($pros)) {
                        foreach ($pros as $pross) {
                            $ss = new Product($pross, true, $id_langs, $id_shop);
                            $name_p = $ss->date_add.' - '.$pross;
                            $id_fix = array(
                                'id_product'=>$pross,
                            );
                            if ($ss->active == 1) {
                                $arrs[$name_p] = array(
                                    'name' => $ss->name,
                                    'id_category_default'=>$ss->id_category_default,
                                    'rate'=>Product::getTaxesInformations($id_fix)['rate'],
                                    'id_product'=>$pross,
                                    'price'=>$ss->base_price,
                                    'link_rewrite'=>$ss->link_rewrite,
                                );
                            }
                        }
                        if (count($arr)>0) {
                            $arr = array_intersect_key($arr, $arrs);
                        } else {
                            $arr = $arrs;
                        }
                    }
                    if (Tools::getValue('controller') == 'product') {
                        if ($key['productcase'] == 1) {
                            $involve = new Product($id_product_i);
                            $involve_pro = $involve->getDefaultCategory();
                            $showinvo = Product::getProducts($id_langs, 0, 99, 'date_add', 'asc', $involve_pro, true);
                            foreach ($showinvo as $k_showinvo => $v_showinvo) {
                                $key_names = $showinvo[$k_showinvo]['date_add'];
                                $key_names .=' - '. $showinvo[$k_showinvo]['id_product'];
                                $arrp[$key_names] = $showinvo[$k_showinvo];
                            }
                            $itpro = new Product($id_product_i, true, $id_langs, $id_shop);
                            $reitpro = $itpro->date_add;
                            $reitpro .=' - '.Tools::getValue('id_product');
                            unset($arrp[$reitpro]);
                            if (count($arr)>0) {
                                $arr = array_intersect_key($arr, $arrp);
                            } else {
                                $arr = $arrp;
                            }
                        }
                    }
                    ksort($arr);
                    $this->context->smarty->assign('shows', array_slice($arr, 0, $product_show));
                }
                if ($key['ordertype'] == 'date_desc') {
                    $shows = "";
                    if (is_array(json_decode($key['cate']))) {
                        foreach ($cate as $cc) {
                            $shows=
                            Product::getProducts($id_langs, 0, $ba_product_show, 'date_add', 'desc', $cc, true);
                            foreach ($shows as $k_shows => $v_shows) {
                                $key_name = $shows[$k_shows]['date_add'] .' - '. $shows[$k_shows]['id_product'];
                                $arr[$key_name] = $shows[$k_shows];
                            }
                        }
                    }
                    if (is_array($pros)) {
                        foreach ($pros as $pross) {
                            $ss = new Product($pross, true, $id_langs, $id_shop);
                            $name_p = $ss->date_add.' - '.$pross;
                            $id_fix = array(
                                'id_product'=>$pross,
                            );
                            if ($ss->active == 1) {
                                $arrs[$name_p] = array(
                                    'name' => $ss->name,
                                    'id_category_default'=>$ss->id_category_default,
                                    'rate'=>Product::getTaxesInformations($id_fix)['rate'],
                                    'id_product'=>$pross,
                                    'price'=>$ss->base_price,
                                    'link_rewrite'=>$ss->link_rewrite,
                                );
                            }
                        }
                        if (count($arr)>0) {
                            $arr = array_intersect_key($arr, $arrs);
                        } else {
                            $arr = $arrs;
                        }
                    }
                    if (Tools::getValue('controller') == 'product') {
                        if ($key['productcase'] == 1) {
                            $involve = new Product($id_product_i);
                            $involve_pro = $involve->getDefaultCategory();
                            $showinvo = Product::getProducts($id_langs, 0, 99, 'date_add', 'desc', $involve_pro, true);
                            foreach ($showinvo as $k_showinvo => $v_showinvo) {
                                $key_names = $showinvo[$k_showinvo]['date_add'];
                                $key_names .=' - '. $showinvo[$k_showinvo]['id_product'];
                                $arrp[$key_names] = $showinvo[$k_showinvo];
                            }
                            $itpro = new Product($id_product_i, true, $id_langs, $id_shop);
                            $reitpro = $itpro->date_add;
                            $reitpro .=' - '.Tools::getValue('id_product');
                            unset($arrp[$reitpro]);
                            if (count($arr)>0) {
                                $arr = array_intersect_key($arr, $arrp);
                            } else {
                                $arr = $arrp;
                            }
                        }
                    }
                    krsort($arr);
                    $this->context->smarty->assign('shows', array_slice($arr, 0, $product_show));
                }
                if ($key['ordertype'] == 'random') {
                    $shows = "";
                    if (is_array(json_decode($key['cate']))) {
                        foreach ($cate as $cc) {
                            $shows = Product::getProducts($id_langs, 0, $ba_product_show, 'name', 'asc', $cc, true);
                            foreach ($shows as $k_shows => $v_shows) {
                                $key_name = $shows[$k_shows]['name'] .' - '. $shows[$k_shows]['id_product'];
                                $arr[$key_name] = $shows[$k_shows];
                            }
                        }
                    }
                    if (is_array($pros)) {
                        foreach ($pros as $pross) {
                            $ss = new Product($pross, true, $id_langs, $id_shop);
                            $name_p = $ss->name.' - '.$pross;
                            $id_fix = array(
                                'id_product'=>$pross,
                            );
                            if ($ss->active == 1) {
                                $arrs[$name_p] = array(
                                    'name' => $ss->name,
                                    'id_category_default'=>$ss->id_category_default,
                                    'rate'=>Product::getTaxesInformations($id_fix)['rate'],
                                    'id_product'=>$pross,
                                    'price'=>$ss->base_price,
                                    'link_rewrite'=>$ss->link_rewrite,
                                );
                            }
                        }
                        if (count($arr)>0) {
                            $arr = array_intersect_key($arr, $arrs);
                        } else {
                            $arr = $arrs;
                        }
                    }
                    if (Tools::getValue('controller') == 'product') {
                        if ($key['productcase'] == 1) {
                            $involve = new Product($id_product_i);
                            $involve_pro = $involve->getDefaultCategory();
                            $showinvo = Product::getProducts($id_langs, 0, 99, 'name', 'asc', $involve_pro, true);
                            foreach ($showinvo as $k_showinvo => $v_showinvo) {
                                $key_names = $showinvo[$k_showinvo]['name'];
                                $key_names .=' - '. $showinvo[$k_showinvo]['id_product'];
                                $arrp[$key_names] = $showinvo[$k_showinvo];
                            }
                            $itpro = new Product($id_product_i, true, $id_langs, $id_shop);
                            $reitpro = $itpro->name;
                            $reitpro .=' - '.Tools::getValue('id_product');
                            unset($arrp[$reitpro]);
                            if (count($arr)>0) {
                                $arr = array_intersect_key($arr, $arrp);
                            } else {
                                $arr = $arrp;
                            }
                        }
                    }
                    shuffle($arr);
                    $this->context->smarty->assign('shows', array_slice($arr, 0, $product_show));
                }
                $popuv = "";
                $v_showinvo = "";
                $this->context->smarty->assign('id_shop', $id_shop);
                $this->context->smarty->assign('id_currency', $id_currency);
                $this->context->smarty->assign('id_customer', $id_customer);
                $this->context->smarty->assign('embe', $embe);
                $this->context->smarty->assign('bablocks', $bablocks);
                $this->context->smarty->assign('sizeslide', $sizeslide);
                $this->context->smarty->assign('id_sl', $id_sl);
                $this->context->smarty->assign('nav', $nav);
                $this->context->smarty->assign('dots', $dots);
                $this->context->smarty->assign('auto_play', $auto_play);
                $this->context->smarty->assign('loops', $loops);
                $this->context->smarty->assign('price', $price);
                $this->context->smarty->assign('addtocart', $addtocart);
                $this->context->smarty->assign('title', $title);
                $this->context->smarty->assign('names', $names);
                $this->context->smarty->assign('item_mobile', $item_mobile);
                $this->context->smarty->assign('item_desktop', $item_desktop);
                $this->context->smarty->assign('item_tablet', $item_tablet);
                $this->context->smarty->assign('product_show', $product_show);
                $this->context->smarty->assign('test', $test);
                $this->context->smarty->assign('addtocart', $addtocart);
                $this->context->smarty->assign('popuv', $popuv);
                $this->context->smarty->assign('v_showinvo', $v_showinvo);
                $this->context->smarty->assign('v_shows', $v_shows);
                $this->context->smarty->assign('cstock', $cstock);
                if (Tools::version_compare(_PS_VERSION_, '1.7.0.0', '<')) {
                    $html .= $this->display(__FILE__, 'views/templates/front/slide.tpl');
                } else {
                    $html .= $this->display(__FILE__, 'views/templates/front/slide17.tpl');
                }
            }
        }
        return $html;
    }
    public function addItem()
    {
        $id_shop = $this->context->shop->id;
        $bamodule = AdminController::$currentIndex;
        $token = Tools::getAdminTokenLite('AdminModules');
        if (Tools::isSubmit('add_item')) {
            if ($this->demoMode==true) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&demo=1');
            }
            $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
            $id_shop = Tools::getValue('id_shop');
            $cate=Tools::getValue('categoryBox');
            $cates=json_encode($cate);
            if ($cates == 'false') {
                $cates = '[""]';
            }
            $name_item = Tools::getValue('name_item');
            $out_stock = Tools::getValue('out_stock');
            $notes = Tools::getValue('notes');
            $order_type = Tools::getValue('order_type');
            $show_title = Tools::getValue('show_title');
            $show_price = Tools::getValue('show_price');
            $addtocarts = Tools::getValue('addtocart');
            $wishlist = Tools::getValue('wishlist');
            $compare = Tools::getValue('compare');
            $wslider = Tools::getValue('wslider');
            $hslider = Tools::getValue('hslider');
            $wimage = Tools::getValue('wimage');
            $addtocart = json_encode(array('addcart' => $addtocarts,'wishlist' => $wishlist,'compare' => $compare));
            $sizesl = json_encode(array('sliw' => $wslider,'slih' => $hslider,'sizeimg' => $wimage));
            $show_nav = Tools::getValue('show_nav');
            $show_dots = Tools::getValue('show_dots');
            $active_slider = Tools::getValue('active_slider');
            $table = Tools::getValue('active_slidert');
            $mobile = Tools::getValue('active_sliderm');
            $loop_slider = Tools::getValue('loop_slider');
            $auto_play = Tools::getValue('auto_play');
            $item_show = Tools::getValue('item_show');
            $productcase = Tools::getValue('productcase');
            $item_mobile_show = Tools::getValue('item_mobile_show');
            $item_tablet_show = Tools::getValue('item_tablet_show');
            $product_show = Tools::getValue('product_show');
            $asx = json_encode(Tools::getValue('active_pro'));
            $block = Tools::getValue('block');
            $background_arrow = Tools::getValue('background_arrow');
            $background_arrow_hover = Tools::getValue('background_arrow_hover');
            $text_color = Tools::getValue('text_color');
            $background_button = Tools::getValue('background_button');
            $background_button_hover = Tools::getValue('background_button_hover');
            $text_button_color = Tools::getValue('text_button_color');
            $text_button_color_hover = Tools::getValue('text_button_color_hover');
            $text_color_arrow = Tools::getValue('text_color_arrow');
            if (!ValidateCore::isUnsignedInt($item_show)
                || !ValidateCore::isUnsignedInt($item_mobile_show)
                || !ValidateCore::isUnsignedInt($item_tablet_show)
                || !ValidateCore::isUnsignedInt($product_show)
            ) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&addbaproductscarousel&'
                    .'&configure='.$this->name.'&er=1&add_caitem=1');
            }
            $sqladd="INSERT INTO "._DB_PREFIX_.'product_carousel_item'."(name,slitable,mobile,active,note,cstock,";
            $sqladd .="ordertype,nav,dots,loops,auto_play,block,sizeslide,";
            $sqladd .="price,addtocart,title,cate,active_pro,item_desktop,";
            $sqladd .="item_mobile,item_tablet,product_show,productcase,background_arrow,";
            $sqladd .="background_arrow_hover,text_color,background_button,background_button_hover,";
            $sqladd .="text_button_color,text_button_color_hover,text_color_arrow,id_shop)";
            $sqladd .="VALUES('".pSQL($name_item)."','".pSQL($table)."','".pSQL($mobile)."',";
            $sqladd .="'".pSQL($active_slider)."','";
            $sqladd .=pSQL($notes)."','".pSQL($out_stock)."','".pSQL($order_type)."','".pSQL($show_nav)."',";
            $sqladd .="'".pSQL($show_dots)."','".pSQL($loop_slider)."','".pSQL($auto_play)."',";
            $sqladd .="'".pSQL($block)."','".pSQL($sizesl)."','". (int)$show_price."','";
            $sqladd .= pSQL($addtocart)."','" . (int)$show_title."','";
            $sqladd .= pSQL($cates)."','". pSQL($asx)."','". pSQL($item_show)."','";
            $sqladd .= pSQL($item_mobile_show)."','". pSQL($item_tablet_show)."','";
            $sqladd .= pSQL($product_show)."','".pSQL($productcase)."','". pSQL($background_arrow)."','";
            $sqladd .= pSQL($background_arrow_hover)."','".pSQL($text_color)."','". pSQL($background_button)."','";
            $sqladd .= pSQL($background_button_hover)."','".pSQL($text_button_color)."','";
            $sqladd .= pSQL($text_button_color_hover)."','".pSQL($text_color_arrow)."','". (int)$id_shop."')";
            $db->query($sqladd);
            if ($wishlist == 1) {
                Module::enableByName('blockwishlist');
            }
            Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&ok=1&bl=helper');
        }
    }
    public function updateItem()
    {
        $bamodule = AdminController::$currentIndex;
        $token = Tools::getAdminTokenLite('AdminModules');
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $id_shop = Tools::getValue('id_shop');
        $cbt = Tools::getValue('update_item');
        $ids = Tools::getValue('ids');
        $cate=Tools::getValue('categoryBox');
        $cates=json_encode($cate);
        $name_item = Tools::getValue('name_item');
        $order_type = Tools::getValue('order_type');
        $show_title = Tools::getValue('show_title');
        $show_price = Tools::getValue('show_price');
        $out_stock = Tools::getValue('out_stock');
        $notes = Tools::getValue('notes');
        $wslider = Tools::getValue('wslider');
        $hslider = Tools::getValue('hslider');
        $wimage = Tools::getValue('wimage');
        $addtocarts = Tools::getValue('addtocart');
        $wishlist = Tools::getValue('wishlist');
        $compare = Tools::getValue('compare');
        $addtocart = json_encode(array('addcart' => $addtocarts,'wishlist' => $wishlist,'compare' => $compare));
        $sizesl = json_encode(array('sliw' => $wslider,'slih' => $hslider,'sizeimg' => $wimage));
        $show_nav = Tools::getValue('show_nav');
        $show_dots = Tools::getValue('show_dots');
        $active_slider = Tools::getValue('active_slider');
        $table = Tools::getValue('active_slidert');
        $mobile = Tools::getValue('active_sliderm');
        $loop_slider = Tools::getValue('loop_slider');
        $auto_play = Tools::getValue('auto_play');
        $item_show = Tools::getValue('item_show');
        $productcase = Tools::getValue('productcase');
        $item_mobile_show = Tools::getValue('item_mobile_show');
        $item_tablet_show = Tools::getValue('item_tablet_show');
        $product_show = Tools::getValue('product_show');
        $background_arrow = Tools::getValue('background_arrow');
        $background_arrow_hover = Tools::getValue('background_arrow_hover');
        $text_color = Tools::getValue('text_color');
        $background_button = Tools::getValue('background_button');
        $background_button_hover = Tools::getValue('background_button_hover');
        $text_button_color = Tools::getValue('text_button_color');
        $text_button_color_hover = Tools::getValue('text_button_color_hover');
        $text_color_arrow = Tools::getValue('text_color_arrow');
        $asx = json_encode(Tools::getValue('active_pro'));
        $block = Tools::getValue('block');
        if (Tools::isSubmit('update_item')) {
            if ($cate == false) {
                $cates = '[""]';
            }
            if ($this->demoMode==true) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&demo=1'.'&id='.
                $ids.'&updatebaproductscarousel&'.'&configure='.$this->name.'&cbt='.$cbt);
            }
            if (!ValidateCore::isUnsignedInt($item_show)
                || !ValidateCore::isUnsignedInt($item_mobile_show)
                || !ValidateCore::isUnsignedInt($item_tablet_show)
                || !ValidateCore::isUnsignedInt($product_show)
            ) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&id='.
                    $ids.'&updatebaproductscarousel&'.'&configure='.$this->name.'&er=1');
            }
            $sqladd="UPDATE "._DB_PREFIX_.'product_carousel_item'." SET name = '".pSQL($name_item)."',";
            $sqladd .="ordertype = '".pSQL($order_type)."',active = '".pSQL($active_slider)."',";
            $sqladd .="nav = '".pSQL($show_nav)."',note = '".pSQL($notes)."',slitable = '".pSQL($table)."',";
            $sqladd .="dots='".pSQL($show_dots) ."',cstock = '".pSQL($out_stock)."',mobile = '".pSQL($mobile)."',";
            $sqladd .="loops='".pSQL($loop_slider)."',auto_play='".pSQL($auto_play)."',";
            $sqladd .="block='".pSQL($block)."',";
            $sqladd .="price='".pSQL($show_price)."',addtocart='".pSQL($addtocart)."',";
            $sqladd .="title='".pSQL($show_title)."',cate= '".pSQL($cates) . "',";
            $sqladd .="item_desktop='".pSQL($item_show)."',item_mobile= '".pSQL($item_mobile_show) . "',";
            $sqladd .="item_tablet='".pSQL($item_tablet_show)."',product_show= '".pSQL($product_show) . "',";
            $sqladd .="text_color='".pSQL($text_color)."',background_button= '".pSQL($background_button) . "',";
            $sqladd .="background_button_hover='".pSQL($background_button_hover)."',sizeslide= '".pSQL($sizesl) . "',";
            $sqladd .="text_color_arrow= '".pSQL($text_color_arrow) . "',";
            $sqladd .="background_arrow='".pSQL($background_arrow)."',";
            $sqladd .="text_button_color='".pSQL($text_button_color)."',";
            $sqladd .="text_button_color_hover='".pSQL($text_button_color_hover)."',";
            $sqladd .="background_arrow_hover= '".pSQL($background_arrow_hover) . "',";
            $sqladd .="active_pro='".pSQL($asx)."',productcase= '".pSQL($productcase) . "'";
            $sqladd .=" WHERE id_shop = " . (int) $id_shop . " AND id = '".(int)$ids."'";
            $db->query($sqladd);
            if ($wishlist == 1) {
                Module::enableByName('blockwishlist');
            }
            Tools::redirectAdmin($bamodule.'&token='.$token.'&id='.
            $ids.'&updatebaproductscarousel&'.'&configure='.$this->name.'&ok=1'.'&cbt='.$cbt);
        }
        if (Tools::isSubmit('savetung')) {
            if ($cate == false) {
                $cates = '[""]';
            }
            if ($this->demoMode==true) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&demo=1');
            }
            if (!ValidateCore::isUnsignedInt($item_show)
                || !ValidateCore::isUnsignedInt($item_mobile_show)
                || !ValidateCore::isUnsignedInt($item_tablet_show)
                || !ValidateCore::isUnsignedInt($product_show)
            ) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&id='.
                    $ids.'&updatebaproductscarousel&'.'&configure='.$this->name.'&er=1');
            }
            $sqladd="UPDATE "._DB_PREFIX_.'product_carousel_item'." SET name = '".pSQL($name_item)."',";
            $sqladd .="ordertype = '".pSQL($order_type)."',active = '".pSQL($active_slider)."',";
            $sqladd .="nav = '".pSQL($show_nav)."',note = '".pSQL($notes)."',slitable = '".pSQL($table)."',";
            $sqladd .="dots='".pSQL($show_dots) ."',cstock = '".pSQL($out_stock)."',mobile = '".pSQL($mobile)."',";
            $sqladd .="loops='".pSQL($loop_slider)."',auto_play='".pSQL($auto_play)."',";
            $sqladd .="block='".pSQL($block)."',";
            $sqladd .="price='".pSQL($show_price)."',addtocart='".pSQL($addtocart)."',";
            $sqladd .="title='".pSQL($show_title)."',cate= '".pSQL($cates) . "',";
            $sqladd .="item_desktop='".pSQL($item_show)."',item_mobile= '".pSQL($item_mobile_show) . "',";
            $sqladd .="item_tablet='".pSQL($item_tablet_show)."',product_show= '".pSQL($product_show) . "',";
            $sqladd .="text_color='".pSQL($text_color)."',background_button= '".pSQL($background_button) . "',";
            $sqladd .="background_button_hover='".pSQL($background_button_hover)."',sizeslide= '".pSQL($sizesl) . "',";
            $sqladd .="text_color_arrow= '".pSQL($text_color_arrow) . "',";
            $sqladd .="background_arrow='".pSQL($background_arrow)."',";
            $sqladd .="text_button_color='".pSQL($text_button_color)."',";
            $sqladd .="text_button_color_hover='".pSQL($text_button_color_hover)."',";
            $sqladd .="background_arrow_hover= '".pSQL($background_arrow_hover) . "',";
            $sqladd .="active_pro='".pSQL($asx)."',productcase= '".pSQL($productcase) . "'";
            $sqladd .=" WHERE id_shop = " . (int) $id_shop . " AND id = '".(int)$ids."'";
            $db->query($sqladd);
            if ($wishlist == 1) {
                Module::enableByName('blockwishlist');
            }
            Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&ok=1');
        }
    }
    public function getContent()
    {
        $html = '';
        $this->registerhook('DisplayHomeTab');
        if (Tools::getValue('er') == 1) {
            $alert_error = $this->l('Item Value in Desktop, Mobile, Tablet, Count must be a positive number.');
            $html = $this->displayError($alert_error);
        }
        $this->context->controller->addJS($this->_path . 'views/js/ajax.js');
        $this->context->controller->addCSS($this->_path . 'views/css/style.css');
        $this->context->controller->addJS($this->_path . 'views/js/jscolor.js');
        $this->context->controller->addJS($this->_path . 'views/js/dropdown.js');
        $base =Tools::getShopProtocol() . Tools::getServerName() . __PS_BASE_URI__;
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        $id_shop = $this->context->shop->id;
        $id_langs = $this->context->language->id;
        $iso_lang = $this->context->language->iso_code;
        $checkDemoMode=0;
        if (Tools::getValue('demo')=="1") {
            $checkDemoMode=Tools::getValue('demo');
        }
        $this->smarty->assign('demoMode', $checkDemoMode);
        $this->context->smarty->assign('iso_lang', $iso_lang);
        $this->context->smarty->assign('id_shop', $id_shop);
        $this->context->smarty->assign('base', $base);
        $this->context->smarty->assign('id_langs', $id_langs);
        $this->context->smarty->assign('cbt', Tools::getValue('cbt'));
        $bl = Tools::getValue('bl');
        $bamodule = AdminController::$currentIndex;
        $token = Tools::getAdminTokenLite('AdminModules');
        $url_base = $bamodule.'&token='.$token.'&configure='.$this->name;
        $url_add = $url_base. '&add_caitem=1';
        $html .= '<script>
                         var iso_lang = \'' .$iso_lang. '\';
                         var id_shop = \'' .$id_shop. '\';
                         var id_langs = \'' .$id_langs. '\';
                         var name_m = \'' .$this->name. '\';
                         var base = \'' .$base. '\';
                         var url_base = \'' .$url_base. '\';
                 </script>';
        if (Tools::getValue('ok') == 1) {
            $html .= $this->displayConfirmation($this->l('Successful Update'));
        }
        if (Tools::getValue('ok') == 2) {
            $html .= $this->displayConfirmation($this->l('Deletion successful'));
        }
        $this->context->smarty->assign('url_add', $url_add);
        $this->context->smarty->assign('url_base', $url_base);
        $this->addItem();
        $this->updateItem();
        if (Tools::getValue('updatebaproductscarousel') !== false && Tools::getValue('id')) {
            $id = Tools::getValue('id');
            $this->context->smarty->assign('id', $id);
            $sqlshow = "SELECT * FROM "._DB_PREFIX_."product_carousel_item WHERE id = ".(int)$id."";
            $showids = $db->ExecuteS($sqlshow);
            $sqltimg = "SELECT * FROM "._DB_PREFIX_."image_type";
            $showtimg = $db->ExecuteS($sqltimg);
            foreach ($showids as $key) {
                $json=str_replace("['[',']']", "", json_decode($key['cate']));
                $prods=str_replace("['[',']']", "", json_decode($key['active_pro']));
            }
            if (is_array($json)) {
                $id_category_dbboo = $json;
            } else {
                $id_category_dbboo = array();
            }
            $tree = new HelperTreeCategories('categories-tree');
            $tree->setRootCategory(Category::getRootCategory()
                ->id_category)
                ->setUseCheckBox(true)
                ->setUseSearch(true)
                ->setSelectedCategories($id_category_dbboo);
            $menu = $this->tpl_list_vars['category_tree'] = $tree->render();
            $this->context->smarty->assign("tree", $menu);
            $this->context->smarty->assign('showids', $showids);
            $product=array();
            if (is_array($prods)) {
                foreach ($prods as $prodss) {
                    $product[]=new Product($prodss, true, $id_langs, $id_shop);
                };
            } else {
                $product[]="";
            }
            $this->context->smarty->assign('showtimg', $showtimg);
            $this->context->smarty->assign('product', $product);
            $html .= $this->display(__FILE__, 'views/templates/admin/update_item.tpl');
            return $html;
        }
        if (Tools::getValue('deletebaproductscarousel') !== false && Tools::getValue('id')) {
            if ($this->demoMode==true) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&demo=1');
            }
            $id = Tools::getValue('id');
            $delete = "DELETE FROM "._DB_PREFIX_."product_carousel_item WHERE id = " . (int)$id;
            $db->query($delete);
            Tools::redirectAdmin($bamodule.'&token='.pSQL($token).'&configure='.$this->name.'&ok=2&bl=helper');
        }
        if (Tools::getValue('add_caitem') == 1) {
            $tree = new HelperTreeCategories('categories-tree');
            $tree->setRootCategory(Category::getRootCategory()
                ->id_category)
                ->setUseCheckBox(true)
                ->setUseSearch(true)
                ->setSelectedCategories(array('1'));
            $menu = $this->tpl_list_vars['category_tree'] = $tree->render();
            $sqltimg = "SELECT * FROM "._DB_PREFIX_."image_type";
            $showtimg = $db->ExecuteS($sqltimg);
            $this->context->smarty->assign("showtimg", $showtimg);
            $this->context->smarty->assign("tree", $menu);
            $this->context->controller->addCSS($this->_path . 'views/css/style.css');
            $html .= $this->display(__FILE__, 'views/templates/admin/add_item.tpl');
            return $html;
        }
        if (Tools::isSubmit("duplicatebaproductscarousel")) {
            if ($this->demoMode==true) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&demo=1');
            }
            $id = Tools::getValue('id');
            $sqldup = "SELECT * FROM "._DB_PREFIX_."product_carousel_item ";
            $sqldup .= "WHERE id = ".(int)$id." AND id_shop = ".(int)$id_shop."";
            $showdup = $db->ExecuteS($sqldup);
            foreach ($showdup as $showdup) {
                $sqladd="INSERT INTO "._DB_PREFIX_.'product_carousel_item'."(name,";
                $sqladd .="ordertype,nav,slitable,mobile,dots,loops,auto_play,block,";
                $sqladd .="price,addtocart,title,cate,active_pro,sizeslide,item_desktop,";
                $sqladd .="item_mobile,item_tablet,product_show,productcase,active,background_arrow,";
                $sqladd .="background_arrow_hover,text_color,background_button,background_button_hover,";
                $sqladd .="text_button_color,text_button_color_hover,text_color_arrow,id_shop)";
                $sqladd .="VALUES('".pSQL($showdup['name']).' copy'."','";
                $sqladd .=pSQL($showdup['ordertype'])."','".pSQL($showdup['nav'])."','";
                $sqladd .=pSQL($showdup['slitable'])."','".pSQL($showdup['mobile'])."',";
                $sqladd .="'".pSQL($showdup['dots'])."','".pSQL($showdup['loops'])."','";
                $sqladd .=pSQL($showdup['auto_play'])."',";
                $sqladd .="'".pSQL($showdup['block'])."','". (int)$showdup['price']."','";
                $sqladd .= pSQL($showdup['addtocart'])."','" . (int)$showdup['title']."','";
                $sqladd .= pSQL($showdup['cate'])."','". pSQL($showdup['active_pro'])."','";
                $sqladd .= pSQL($showdup['sizeslide'])."','".pSQL($showdup['item_desktop'])."','";
                $sqladd .= pSQL($showdup['item_mobile'])."','". pSQL($showdup['item_tablet'])."','";
                $sqladd .= pSQL($showdup['product_show'])."','".pSQL($showdup['productcase'])."','";
                $sqladd .= pSQL($showdup['active'])."','".pSQL($showdup['background_arrow'])."','";
                $sqladd .= pSQL($showdup['background_arrow_hover'])."','".pSQL($showdup['text_color'])."','";
                $sqladd .= pSQL($showdup['background_button'])."','";
                $sqladd .= pSQL($showdup['background_button_hover'])."','".pSQL($showdup['text_button_color'])."','";
                $sqladd .= pSQL($showdup['text_button_color_hover'])."','".pSQL($showdup['text_color_arrow'])."','";
                $sqladd .= (int)$showdup['id_shop']."')";
                $db->query($sqladd);
            }
            Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&bl=helper');
        }
        if (Tools::isSubmit("submitFilter")) {
            $id_filter = Tools::getValue('baproductscarouselFilter_id');
            $name_filter = Tools::getValue('baproductscarouselFilter_name');
            $block_filter = Tools::getValue('baproductscarouselFilter_block');
            $id_shop_filter = Tools::getValue('baproductscarouselFilter_id_shop');
            $active_filter = Tools::getValue('baproductscarouselFilter_active');
            $baslitable = Tools::getValue('baproductscarouselFilter_slitable');
            $bamobile = Tools::getValue('baproductscarouselFilter_mobile');
            $this->context->cookie->{'baproductscarouselFilter_id'} = $id_filter;
            $this->context->cookie->{'baproductscarouselFilter_name'} = $name_filter;
            $this->context->cookie->{'baproductscarouselFilter_block'} = $block_filter;
            $this->context->cookie->{'baproductscarouselFilter_id_shop'} = $id_shop_filter;
            $this->context->cookie->{'baproductscarouselFilter_active'} = $active_filter;
            $this->context->cookie->{'baproductscarouselFilter_slitable'} = $baslitable;
            $this->context->cookie->{'baproductscarouselFilter_mobile'} = $bamobile;
            $search_fit = "SELECT * FROM "._DB_PREFIX_."product_carousel_item WHERE id_shop = ".(int)$id_shop."";
            $search_fit .= ' AND block LIKE "%'.pSQL($block_filter).'%" AND name LIKE "%'.pSQL($name_filter).'%" ';
            $search_fit .= 'AND id LIKE "%'.pSQL($id_filter).'%" AND id_shop LIKE "%'.pSQL($id_shop_filter).'%" ';
            $search_fit .= 'AND slitable LIKE "%'.pSQL($baslitable).'%" AND mobile LIKE "%'.pSQL($bamobile).'%" ';
            $search_fit .= 'AND active LIKE "%'.pSQL($active_filter).'%" ';
            $bl = 'helper';
        }
        if (Tools::isSubmit("submitResetbaproductscarousel")) {
            $this->context->cookie->{'baproductscarouselFilter_id'} = null;
            $this->context->cookie->{'baproductscarouselFilter_name'} = null;
            $this->context->cookie->{'baproductscarouselFilter_block'} = null;
            $this->context->cookie->{'baproductscarouselFilter_id_shop'} = null;
            $this->context->cookie->{'baproductscarouselFilter_active'} = null;
            $this->context->cookie->{'baproductscarouselFilter_slitable'} = null;
            $this->context->cookie->{'baproductscarouselFilter_mobile'} = null;
            Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&bl=helper');
        }
        if (Tools::isSubmit('submitBulkdeletebaproductscarousel')) {
            if ($this->demoMode==true) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&demo=1');
            }
            $idbox = Tools::getValue('baproductscarouselBox');
            if (!empty($idbox)) {
                $delete_ids = implode(',', $idbox);
                $deletea = 'DELETE FROM '._DB_PREFIX_.'product_carousel_item WHERE ';
                $deletea .= 'id IN ('. pSQL($delete_ids).')';
                $db->query($deletea);
                Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&bl=helper');
            }
        }
        if (Tools::isSubmit('statusbaproductscarousel')) {
            if ($this->demoMode==true) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&demo=1');
            }
            $id = Tools::getValue('id');
            $sqls = "SELECT * FROM "._DB_PREFIX_."product_carousel_item WHERE id = ".(int)$id."";
            $kq = $db->ExecuteS($sqls);
            foreach ($kq as $kk) {
                $kqa = $kk['active'];
            }
            if ($kqa == 0) {
                $upstatus = "UPDATE "._DB_PREFIX_."product_carousel_item SET active = 1 WHERE id = ".(int)$id."";
            } else {
                $upstatus = "UPDATE "._DB_PREFIX_."product_carousel_item SET active = 0 WHERE id = ".(int)$id."";
            }
            $db->query($upstatus);
            Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&ok=1');
        }
        if (Tools::isSubmit('slitablebaproductscarousel')) {
            if ($this->demoMode==true) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&demo=1');
            }
            $id = Tools::getValue('id');
            $sqls = "SELECT * FROM "._DB_PREFIX_."product_carousel_item WHERE id = ".(int)$id."";
            $kq = $db->ExecuteS($sqls);
            foreach ($kq as $kk) {
                $kqa = $kk['slitable'];
            }
            if ($kqa == 0) {
                $upstatus = "UPDATE "._DB_PREFIX_."product_carousel_item SET slitable = 1 WHERE id = ".(int)$id."";
            } else {
                $upstatus = "UPDATE "._DB_PREFIX_."product_carousel_item SET slitable = 0 WHERE id = ".(int)$id."";
            }
            $db->query($upstatus);
            Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&ok=1');
        }
        if (Tools::isSubmit('mobilebaproductscarousel')) {
            if ($this->demoMode==true) {
                Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&demo=1');
            }
            $id = Tools::getValue('id');
            $sqls = "SELECT * FROM "._DB_PREFIX_."product_carousel_item WHERE id = ".(int)$id."";
            $kq = $db->ExecuteS($sqls);
            foreach ($kq as $kk) {
                $kqa = $kk['mobile'];
            }
            if ($kqa == 0) {
                $upstatus = "UPDATE "._DB_PREFIX_."product_carousel_item SET mobile = 1 WHERE id = ".(int)$id."";
            } else {
                $upstatus = "UPDATE "._DB_PREFIX_."product_carousel_item SET mobile = 0 WHERE id = ".(int)$id."";
            }
            $db->query($upstatus);
            Tools::redirectAdmin($bamodule.'&token='.$token.'&configure='.$this->name.'&ok=1');
        }
        $this->context->smarty->assign('bl', $bl);
        if (isset($search_fit)) {
            $htmls = $this->initList($search_fit);
        } else {
            $htmls = $this->initList('');
        }
        $this->context->smarty->assign('htmls', $htmls);
        $html .= $this->display(__FILE__, 'views/templates/admin/template.tpl');
        return $html;
    }
    public function initList($search_1)
    {
        $helper = new HelperList();
        $helper->shopLinkType = '';
        $helper->simple_header = false;
        $helper->actions = array('edit','delete','duplicate');
        $helper->toolbar_btn['new'] = array(
            'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&add'
            . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'). '&add_caitem=1',
            'desc' => $this->l('Add new')
        );
        $helper->identifier = 'id';
        $helper->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'icon' => 'icon-trash',
                'confirm' => $this->l('Delete selected items?')
            )
        );
        $helper->show_toolbar = true;
        $helper->title = 'Slider Carousel Manager';
        $helper->table = $this->name;
        $helper->list_id = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure='
                . $this->name . '&bl=helper';
        $fields_list = array(
            'id' => array(
                'title' => $this->l('Id'),
                'width' => 35,
                'type' => 'text',
                'class' => 'testid',
            ),
            'name' => array(
                'title' => $this->l('Title'),
                'width' => 35,
                'type' => 'text',
            ),
            'block' => array(
                'title' => $this->l('Placements'),
                'width' => 35,
                'type' => 'text',
                'class' => 'placements',
            ),
            'id_shop' => array(
                'title' => $this->l('Shop Name'),
                'width' => 35,
                'type' => 'text',
                'callback' => 'getNameShop',
                'callback_object' => $this,
            ),
            'ids' => array(
                'title' => $this->l('Shortcode'),
                'width' => 35,
                'class' => 'bashortcode',
                'orderby' => false,
                'search' => false,
                'remove_onclick' => false,
            ),
            'active' => array(
                'title' => $this->l('Enable Desktop'),
                'width' => 100,
                'type' =>'bool',
                'align' => 'right',
                'active' => 'status'
            ),
            'slitable' => array(
                'title' => $this->l('Enable Table'),
                'width' => 100,
                'type' =>'bool',
                'align' => 'right',
                'active' => 'slitable',
            ),
            'mobile' => array(
                'title' => $this->l('Enable Mobile'),
                'width' => 100,
                'type' =>'bool',
                'align' => 'right',
                'active' => 'mobile',
            )
        );
        if ($this->context->cookie->{'baproductscarouselOrderby'} == ""
        && $this->context->cookie->{'baproductscarouselOrderway'} == "") {
            $this->context->cookie->{'baproductscarouselOrderby'} = "id";
            $this->context->cookie->{'baproductscarouselOrderway'} = "ASC";
        } else {
            $valueorderby = Tools::getValue($helper->list_id . "Orderby");
            $valueorderway = Tools::getValue($helper->list_id . "Orderway");
            if ($valueorderby != false && $valueorderway != false) {
                $this->context->cookie->{'baproductscarouselOrderby'} = $valueorderby;
                $this->context->cookie->{'baproductscarouselOrderway'} = Tools::strtoupper($valueorderway);
            }
        }
        $helper->orderBy = $this->context->cookie->{'baproductscarouselOrderby'};
        $helper->orderWay = $this->context->cookie->{'baproductscarouselOrderway'};
        $helper->listTotal = $this->getTotalList($helper, $search_1);
        $htmls = $helper->generateList($this->getListContent($helper, $search_1), $fields_list);
        return $htmls;
    }
    public function getNameShop($v)
    {
        $name = '';
        if ($v != null) {
            $name = Shop::getshop($v)['name'];
        }
        return $name;
    }
    public function getListContent($helper, $search_1)
    {
        $id_shop = $this->context->shop->id;
        $db = Db::getInstance(_PS_USE_SQL_SLAVE_);
        //pagination
        if ($this->context->cookie->{$helper->list_id . '_pagination'} == 10) {
            $this->context->cookie->{$helper->list_id . '_pagination'} = 20;
        }
        $pagi = $this->context->cookie->{$helper->list_id . '_pagination'};
        $selected_pagination = (int) Tools::getValue($helper->list_id . '_pagination', $pagi);
        if ($selected_pagination <= 0) {
            $selected_pagination = 20;
        }
        $this->context->cookie->{$helper->list_id . '_pagination'} = $selected_pagination;
        $page = (int) Tools::getValue('submitFilter' . $helper->list_id);
        if (!$page) {
            $page = 1;
        }
        $start = ($page - 1 ) * $selected_pagination;
        $orderby = $this->context->cookie->{'baproductscarouselOrderby'};
        $orderway = $this->context->cookie->{'baproductscarouselOrderway'};
        if ($search_1 == null) {
            $sql="SELECT * , id as ids FROM " . _DB_PREFIX_ ."product_carousel_item WHERE id_shop = ".(int)$id_shop."";
            $sql .=" ORDER BY ".pSQL($orderby)." ".pSQL($orderway)."";
            $sql .=' LIMIT ' . (int)$start . ',' . (int)$selected_pagination;
            $rows = $db->ExecuteS($sql);
        }
        if ($search_1 != null) {
            $sql = $search_1;
            $sql .=" ORDER BY ".pSQL($orderby)." ".pSQL($orderway)."";
            $sql .=' LIMIT ' . (int)$start . ',' . (int)$selected_pagination;
            $rows = $db->ExecuteS($sql);
        }
        //echo '<pre>'; print($sql);die;
        return $rows;
    }
    private function getTotalList($helper, $search_1)
    {
        $helper;
        // $id_shop = $this->context->shop->id;
        //// Order by
        $id_shop = $this->context->shop->id;
        $orderby = $this->context->cookie->{'baproductscarouselOrderby'};
        $orderway = $this->context->cookie->{'baproductscarouselOrderway'};
        $search_1="SELECT * , id as ids FROM " . _DB_PREFIX_ ."product_carousel_item WHERE id_shop = ".(int)$id_shop."";
        $search_1 .=" ORDER BY ".pSQL($orderby)." ".pSQL($orderway)."";
        $sql = $search_1;
        $this->context->smarty->assign('orderby', $orderby);
        return count(Db::getInstance()->ExecuteS($sql));
    }
}
