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

class MM_Cache { 
	private $expire = 1; 
    public function __construct()
    {
        $this->expire = (int)Configuration::get('ETS_MM_CACHE_LIFE_TIME') >=1 ? (int)Configuration::get('ETS_MM_CACHE_LIFE_TIME') : 1;
    }
	public function get($key) {
		$files = glob(dirname(__FILE__).'/../cache/' . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');        
		if ($files) {
			$cache = Tools::file_get_contents($files[0]);
            foreach ($files as $file) {
				$time = (int)Tools::substr(strrchr($file, '.'), 1);
      			if ($time*3600 < time()) {
					if (file_exists($file)) {
						@unlink($file);
					}
      			}
    		}			
			return $cache;			
		}
        return false;
	}
  	public function set($key, $value) {
    	$this->delete($key);		
		$file = dirname(__FILE__).'/../cache/'  . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.' . (time() + (int)$this->expire*3600);    	
		$handle = fopen($file, 'w');
    	fwrite($handle, $value ? $value : '');		
    	fclose($handle);
  	}	
  	public function delete($key = false) {
		$files = glob(dirname(__FILE__).'/../cache/'  . ($key ? 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) : '') . '.*');		
		if ($files) {
    		foreach ($files as $file) {
      			if (file_exists($file) && strpos($file,'index.php')===false) {
					unlink($file);
				}
    		}
		}
  	}
}