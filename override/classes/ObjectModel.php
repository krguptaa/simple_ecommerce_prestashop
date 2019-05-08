<?php
/**
* Creative Slider v6.6.5 - Responsive Slideshow Module https://creativeslider.webshopworks.com
*
*  @author    WebshopWorks <info@webshopworks.com>
*  @copyright 2018 WebshopWorks
*  @license   One Domain Licence
*/
defined('_PS_VERSION_') or exit;
abstract class ObjectModel extends ObjectModelCore
{
    /*
    * module: layerslider
    * date: 2019-05-06 22:45:26
    * version: 6.6.5
    */
    public function __construct($id = null, $id_lang = null, $id_shop = null)
    {
        parent::__construct($id, $id_lang, $id_shop);
        if (!defined('_PS_ADMIN_DIR_')) {
            $class = get_class($this);
            if ($class == 'CategoriesClass') {
                $obj = array('description' => $this->description);
                $res = Hook::exec('filterCategoryContent', array('object' => $obj), null, true);
                if (isset($res['layerslider']) && isset($res['layerslider']['object']) && !empty($res['layerslider']['object']['description'])) {
                    $this->description = $res['layerslider']['object']['description'];
                }
            } elseif ($class == 'NewsClass') {
                $obj = array('content' => $this->content);
                $res = Hook::exec('filterCmsContent', array('object' => $obj), null, true);
                if (isset($res['layerslider']) && isset($res['layerslider']['object']) && !empty($res['layerslider']['object']['content'])) {
                    $this->content = $res['layerslider']['object']['content'];
                }
            }
        }
    }
}
