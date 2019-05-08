<?php
/**
 * 2007-2014 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * No redistribute in other sites, or copy.
 *
 * @author    RSI
 * @copyright 2007-2017 RSI
 * @license   http://localhost!
 */

class Smush extends PrestaSpeed
{
    // original, redirects to somewhere else..
    // const url = 'http://smush.it/ws.php';
    // official but does not work
    // const url = 'http://developer.yahoo.com/yslow/smushit/ws.php';
    // used at the new page but does not hande uploads
    // const url = 'http://smushit.com/ysmush.it/ws.php';
    // used at the new page but does not hande uploads
    // const url = 'http://smushit.eperf.vip.ac4.yahoo.com/ysmush.it/ws.php';
    // working
    const URL = 'http://api.resmush.it/ws.php?img=';
    // regexp for check extension
    private static $regexp;

    /*
    */
    public static function it(
        $path,
        $type
    ) {
        $regexp = '/\.(jpg|jpeg|png)$/i';
        $quiet = false;
        $pretend = false;
        $recursive = true;
        $type = $type;
        // create the curl object
        $curl = curl_init(self::URL);
        // set default options
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true
            )
        );
        // is the path is a folder, we get all images on these folder
        $fn = is_dir($path) ? 'folder' : 'file';
        // call the method
        call_user_func(
            'smush::'.$fn,
            $curl,
            $path,
            $regexp,
            $quiet,
            $pretend,
            $recursive,
            $type
        );
        // close curl to free memory
        curl_close($curl);
    }

    /*
    */

    private static function folder(
        $curl,
        $path,
        $regexp,
        $quiet,
        $pretend,
        $recursive,
        $type
    ) {
        // loop through all files on the folder to get images
        $it = new DirectoryIterator($path);
        $thetotal = iterator_count($it);
        $current = '';
        $thetot = 0;
        foreach ($it as $file) {
            $thetot++;
            //$current = $path;
            //self::outputProgress($current, count($it));

            if (!$file->isDot()) {
                $path = $file->getPathname();
                if (preg_match(
                    $regexp,
                    $path
                )) {
                    self::file(
                        $curl,
                        $path,
                        $regexp,
                        $quiet,
                        $pretend,
                        $type,
                        $thetotal,
                        $thetot
                    );
                }
                // if it's a folder, scan it too
                if ($file->isDir()) {
                    self::folder(
                        $curl,
                        $path,
                        $regexp,
                        $quiet,
                        $pretend,
                        $recursive,
                        $type
                    );
                    //sleep(15);
                }
            }
        }
    }

    /*
    */
    private static function file(
        $curl,
        $path,
        $regexp,
        $quiet,
        $pretend,
        $type,
        $thetotal,
        $thetot = 0
    ) {
        if (!isset($thetot)) {
            $thetot = 1;
        }
        if (!isset($thetotal)) {
            $thetotal = 1;
        }
        ob_start();
        echo '
	<script type="text/javascript">
	    $(document).ready(function(){
			//var globalvar = 0;
			//if (globalvar == 0) {
             $.ajaxQueue({
                        url: "../prestaspeed/ajax.php",
                        dataType: "json",
						processData :false,
						type: "POST",
						data: "path=\''.$path.'\'",
                        async: true,
                        success: function(response) {
							$("#resultim").append(response);						
							if('.($thetotal - 5).' <= '.$thetot.'){
							
							var alerted = localStorage.getItem("alerted") || "";
							if (alerted != "yes") {
							alert("Process finished");
							localStorage.setItem("alerted","yes");
							}
							}
							window.scrollBy(0,10);
							$("html, body").animate({ scrollTop: $(document).height() }, 10);
                }
            }); 
			//}
			//var globalvar = 1;
			
			});
			//$(document).ajaxComplete(function() {
			//var globalvar = 0;	
			//});
				
			</script>';
        //sleep(15);
        ob_end_flush();
        /*
    // check that the file exists
    if (!file_exists($path)) {
        throw new Exception('Invalid file path: '.$path);
    } elseif (preg_match($regexp, $path)) {
        curl_setopt(
            $curl,
            CURLOPT_POSTFIELDS,
            array(
                'files' => class_exists('CurlFile', false) ? new CURLFile($path) : "@{$path}"
            )
        );
        if (!$quiet && Tools::getValue('type') == null) {
            echo "  smushing ".$path." :";
        }
        $response = curl_exec($curl);
        if ($response === false) {
            if (!$quiet && Tools::getValue('type') == null) {
                echo "  error: the server has gone\n".PHP_EOL;
            }
        } else {
            $data = Tools::jsonDecode($response);
            $query = 'INSERT IGNORE INTO '._DB_PREFIX_.'smush (`id_smush`, `url`, `smushed`, `saved`) VALUES (\'\', \''.pSQL((string)$path).'\', \'0\', \'0\')';
            if (!Db::getInstance()
                   ->Execute($query)
            ) {
                ;
            }
            if (!empty($data->error)) {
                $s = str_replace(_PS_ROOT_DIR_, 'http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__, $path);
                $o = Tools::jsonDecode(file_get_contents(URL . $s));
                if (isset($o->error)) {
                    if (!$quiet && Tools::getValue('type') == null) {
                        echo "  error: ".Tools::strtolower($data->error)."\n";
                    }
                } else {
                    if (Tools::getValue('type') == null) {
                        echo str_pad("  ".$o->src_size." -> ".$o->dest_size, 26, " ")." = ".round($o->dest_size * 100 / $o->src_size)."%\n<br/>";
                    }
                    $total = $o->src_size - $o->dest_size;

                    $upd = 'UPDATE '._DB_PREFIX_.'smush SET `smushed` = \'1\', `saved` = \''.pSQL((float)$total).'\' WHERE  '._DB_PREFIX_.'smush.url =  \''.pSQL((string)$path).'\'';
                    Db::getInstance()
                      ->Execute($upd);
                }
                if ($pretend) {
                    return true;
                }
                $ds = $o->dest;
                $content =  Tools::file_get_contents($ds);
                file_put_contents($path.'-tmp', $content);
                if (filesize($path.'-tmp') > 0) {
                    if (!file_exists($path.'-old')) {
                        rename($path, $path.'-old');
                    }
                    return rename($path.'-tmp', $path);
                } else {
                    return;
                }
            } elseif ($data->src_size < $data->dest_size) {
                if (!$quiet && Tools::getValue('type') != null) {
                    echo "  error: got larger\n<br/>".PHP_EOL;
                }
            } elseif ($data->dest_size < 20) {
                if (!$quiet) {
                    if (Tools::getValue('type') == null) {
                        echo "  error: empty file downloaded\n<br/>".PHP_EOL;
                    }
                    $upd = 'UPDATE '._DB_PREFIX_.'smush SET `smushed` = \'1\', `saved` = \'-2\' WHERE  '._DB_PREFIX_.'smush.url =  \''.pSQL((string)$path).'\'';
                    Db::getInstance()
                      ->Execute($upd);
                }
            } elseif ($data->src_size == $data->dest_size) {
                if (!$quiet) {
                    if (Tools::getValue('type') == null) {
                        echo "  cannot be optimized further\n<br/>".PHP_EOL;
                    }
                    $upd = 'UPDATE '._DB_PREFIX_.'smush SET `smushed` = \'1\', `saved` = \'-1\' WHERE  '._DB_PREFIX_.'smush.url =  \''.pSQL((string)$path).'\'';
                    Db::getInstance()
                      ->Execute($upd);
                }
            } else {
                if (!$quiet) {
                    if (Tools::getValue('type') == null) {
                        echo str_pad("  ".$data->src_size." -> ".$data->dest_size, 26, " ")." = ".round($data->dest_size * 100 / $data->src_size)."%\n<br/>";
                    }
                    $total = $data->src_size - $data->dest_size;

                    $upd = 'UPDATE '._DB_PREFIX_.'smush SET `smushed` = \'1\', `saved` = \''.pSQL((float)$total).'\' WHERE  '._DB_PREFIX_.'smush.url =  \''.pSQL((string)$path).'\'';
                    Db::getInstance()
                      ->Execute($upd);
                }
                // if it's a gif image it is converted to a png file

                if ($pretend) {
                    return true;
                }
                $ds = $data->dest;
                $content =  Tools::file_get_contents($ds);
                file_put_contents($path.'-tmp', $content);
                if (filesize($path.'-tmp') > 0) {
                    if (!file_exists($path.'-old')) {
                        rename($path, $path.'-old');
                    }
                    return rename($path.'-tmp', $path);
                } else {
                   // unlink($path.'-tmp');
                    return;
                }
            }
        }
    } elseif (!$quiet && Tools::getValue('type') == null) {
        echo "  error: invalid file ".$path."\n".PHP_EOL;
    }*/
    }
}
