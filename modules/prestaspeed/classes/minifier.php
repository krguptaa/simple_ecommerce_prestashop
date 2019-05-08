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

class Minifier extends PrestaSpeed
{
    public function getMinified($url, $content)
    {
        $postdata = array('http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query(array('input' => $content))));
            return Tools::file_get_contents($url, false, stream_context_create($postdata));
    }
}
