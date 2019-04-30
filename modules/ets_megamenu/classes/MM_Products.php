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

class MM_Products
{
    private static $is17 = false;
    private $nProducts = 1;
    private $id_category = 2;
    private $Page = 1;
    private $orderBy = null;
    private $orderWay = null;
    private $randSeed = 1;
    private $context;

    public function __construct(Context $context)
    {
    	if ($context)
    	    $this->context = $context;
    	else
    		$this->context = Context::getContext();
        self::$is17 = version_compare(_PS_VERSION_, '1.7', '>=');
    }

    public function setRandSeed($randSeed)
    {
        $this->randSeed = $randSeed;
        return $this;
    }

    public function setIdCategory($id_category)
    {
        $this->id_category = $id_category;
        return $this;
    }

    public function setPage($Page)
    {
        $this->Page = $Page;
        return $this;
    }

    public function setPerPage($nProducts)
    {
        $this->nProducts = $nProducts;
        return $this;
    }

    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function setOrderWay($orderWay)
    {
        $this->orderWay = $orderWay;
        return $this;
    }

    public function getPages($methods)
    {
        if (!$methods)
            return 1;
        $nbTotal = (int)$this->{$methods}(true);
        return ceil($nbTotal/$this->nProducts);
    }

    public function getBestSellers($count = false)
    {
        if ($count)
            return ProductSale::getNbSales();
        if (($bestSales = ProductSale::getBestSales((int)$this->context->language->id, $this->Page, $this->nProducts, $this->orderBy, $this->orderWay)))
        {
            if (!self::$is17) {
                $currency = new Currency((int)$this->context->currency->id);
                $use_tax = (Product::getTaxCalculationMethod((isset($this->context->customer->id) && $this->context->customer->id? (int)$this->context->customer->id : null)) != PS_TAX_EXC);
                foreach ($bestSales as &$product){
                    $product['price'] = Tools::displayPrice(Product::getPriceStatic((int)$product['id_product'], $use_tax), $currency);
                }
            }
        }
        return $bestSales;
    }

    public function getHomeFeatured($count = false)
    {
        if (!$this->id_category)
            return array();
        $category = new Category((int)$this->id_category, (int)$this->context->language->id);
        if (!$category->active)
            return false;
        if ($count)
            return $category->getProducts((int)$this->context->language->id, 0, 0, null, null, false, 1, ($this->context->controller->controller_type != 'admin'? true : false), $this->context);
        $products = $category->getProducts(
        	(int)$this->context->language->id, $this->Page, $this->nProducts, $this->orderBy, $this->orderWay, false, true,
	        ($this->orderBy != 'rand'? false : true), ($this->orderBy != 'rand'? 1 : $this->nProducts),
	        ($this->context->controller->controller_type != 'admin'? true : false), $this->context
        );
        return $products;
    }

    public function getNewProducts($count = false)
    {
        if ($count)
            return Product::getNewProducts((int)$this->context->language->id, 0, 0, true);
        $newProducts = false;
        if (Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) {
            $newProducts = Product::getNewProducts((int)$this->context->language->id, $this->Page, $this->nProducts, false, $this->orderBy, $this->orderWay, $this->context);
        }
        return $newProducts;
    }

    public function getSpecialProducts($count = false)
    {
        if ($count)
            return self::getPricesDrop((int)$this->context->language->id, 0, 0, true);
        $pricesDrops = self::getPricesDrop((int)$this->context->language->id, $this->Page, $this->nProducts, false, $this->orderBy, $this->orderWay, false, false, $this->context);
        return $pricesDrops;
    }

	public static function getPricesDrop(
		$id_lang,
		$page_number = 0,
		$nb_products = 10,
		$count = false,
		$order_by = null,
		$order_way = null,
		$beginning = false,
		$ending = false,
		Context $context = null ) {
		if (!Validate::isBool($count)) {
			die(Tools::displayError());
		}

		if (!$context) {
			$context = Context::getContext();
		}
		if ($page_number < 1) {
			$page_number = 1;
		}
		if ($nb_products < 1) {
			$nb_products = 10;
		}
		if (empty($order_by) || $order_by == 'position') {
			$order_by = 'price';
		}
		if (empty($order_way)) {
			$order_way = 'DESC';
		}
		if ($order_by == 'id_product' || $order_by == 'price' || $order_by == 'date_add' || $order_by == 'date_upd') {
			$order_by_prefix = 'product_shop';
		} elseif ($order_by == 'name') {
			$order_by_prefix = 'pl';
		}
		if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) {
			die(Tools::displayError());
		}
		$current_date = date('Y-m-d H:i:00');
		$ids_product = self::_getProductIdByDate((!$beginning ? $current_date : $beginning), (!$ending ? $current_date : $ending), $context);
		$tab_id_product = array();
		foreach ($ids_product as $product) {
			if (is_array($product)) {
				$tab_id_product[] = (int)$product['id_product'];
			} else {
				$tab_id_product[] = (int)$product;
			}
		}
		$front = false;
		if ($context->controller->controller_type != 'admin') {
			$front = true;
		}
		$sql_groups = '';
		if (Group::isFeatureActive()) {
			$groups = FrontController::getCurrentCustomerGroups();
			$sql_groups = ' AND EXISTS(SELECT 1 FROM `'._DB_PREFIX_.'category_product` cp JOIN `'._DB_PREFIX_.'category_group` cg ON (cp.id_category = cg.id_category AND cg.`id_group` '.(count($groups) ? 'IN ('.implode(',', $groups).')' : '= 1').') WHERE cp.`id_product` = p.`id_product`)';
		}

		if ($count) {
			return Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue('
			SELECT COUNT(DISTINCT p.`id_product`)
			FROM `'._DB_PREFIX_.'product` p
			'.Shop::addSqlAssociation('product', 'p').'
			WHERE product_shop.`active` = 1
			AND product_shop.`show_price` = 1
			'.($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '').'
			'.((!$beginning && !$ending) ? 'AND p.`id_product` IN('.((is_array($tab_id_product) && count($tab_id_product)) ? implode(', ', $tab_id_product) : 0).')' : '').'
			'.$sql_groups);
		}

		if (strpos($order_by, '.') > 0) {
			$order_by = explode('.', $order_by);
			$order_by = pSQL($order_by[0]).'.`'.pSQL($order_by[1]).'`';
		}
        $prev_version = version_compare(_PS_VERSION_, '1.6.1.0', '<');
        $sql = '
		SELECT
			p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, pl.`description`, pl.`description_short`, pl.`available_now`, pl.`available_later`,
			'.($prev_version? ' MAX(product_attribute_shop.id_product_attribute)' : ' IFNULL(product_attribute_shop.id_product_attribute, 0)').' `id_product_attribute`,
			pl.`link_rewrite`, pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`,
			pl.`name`, '.($prev_version? 'MAX(image_shop.`id_image`)' : 'image_shop.`id_image`').' `id_image`, il.`legend`, m.`name` AS manufacturer_name,
			DATEDIFF(
				p.`date_add`,
				DATE_SUB(
					"'.date('Y-m-d').' 00:00:00",
					INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY
				)
			) > 0 AS new
		FROM `'._DB_PREFIX_.'product` p' .Shop::addSqlAssociation('product', 'p')
            .($prev_version? 'LEFT JOIN '._DB_PREFIX_.'product_attribute pa ON (pa.id_product = p.id_product)'.Shop::addSqlAssociation('product_attribute', 'pa', false, 'product_attribute_shop.default_on=1').'':'LEFT JOIN `'._DB_PREFIX_.'product_attribute_shop` product_attribute_shop ON (p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop='.(int)$context->shop->id.')')
            .Product::sqlStock('p', 0, false, $context->shop).'
		LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product`AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').')'
            .($prev_version? 'LEFT JOIN `'._DB_PREFIX_.'image` i ON (i.`id_product` = p.`id_product`)'. Shop::addSqlAssociation('image', 'i', false, 'image_shop.cover=1') : 'LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop ON (image_shop.`id_product` = p.`id_product` AND image_shop.id_shop=' . (int)$context->shop->id . ')').'
		LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON ('.($prev_version? 'i' : 'image_shop').'.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')
		LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
		WHERE product_shop.`active` = 1
		AND product_shop.`show_price` = 1
		'.($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '').'
		'.((!$beginning && !$ending) ? ' AND p.`id_product` IN ('.((is_array($tab_id_product) && count($tab_id_product)) ? implode(', ', $tab_id_product) : 0).')' : '').'
		'.pSQL($sql_groups).'
		GROUP BY product_shop.id_product
		ORDER BY '.(isset($order_by_prefix) ? pSQL($order_by_prefix).'.' : '').pSQL($order_by).' '.pSQL($order_way).'
		LIMIT '.(int)(($page_number-1) * $nb_products).', '.(int)$nb_products;

		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

		if (!$result) {
			return false;
		}

		if ($order_by == 'price') {
			Tools::orderbyPrice($result, $order_way);
		}

		return Product::getProductsProperties($id_lang, $result);
	}

	protected static function _getProductIdByDate($beginning, $ending, Context $context = null, $with_combination = false)
	{
		if (!$context) {
			$context = Context::getContext();
		}
		$id_country = (int)Configuration::get('PS_COUNTRY_DEFAULT');
		if ($context->controller->controller_type != 'admin')
		{
			$id_address = $context->cart->{Configuration::get('PS_TAX_ADDRESS_TYPE')};
			$ids = Address::getCountryAndState($id_address);
			if (!empty($ids['id_country']))
				$id_country = $ids['id_country'];
		}
		return SpecificPrice::getProductIdByDate(
			$context->shop->id,
			$context->currency->id,
			$id_country,
			(int)Configuration::get('PS_CUSTOMER_GROUP'),
			$beginning,
			$ending,
			0,
			$with_combination
		);
	}
}