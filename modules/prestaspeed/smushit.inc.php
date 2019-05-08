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
 * @license   http://localhost!
 */

class Smush22 extends PrestaSpeed
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
        $options = array()
    ) {
        $regexp = in_array(
            'gifs',
            $options
        ) ? '/\.(jpg|jpeg|png)$/i' : '/\.(jpg|jpeg|png)$/i';
        $quiet = in_array(
            'quiet',
            $options
        );
        $pretend = in_array(
            'pretend',
            $options
        );
        $recursive = in_array(
            'recursive',
            $options
        );
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
            $recursive
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
        $recursive
    ) {
        // loop through all files on the folder to get images
        $it = new DirectoryIterator($path);
        foreach ($it as $file) {
            if (!$file->isDot()) {
                $path = $file->getPathname();
                // if it's a folder, scan it too
                if ($file->isDir()) {
                    self::folder(
                        $curl,
                        $path,
                        $regexp,
                        $quiet,
                        $pretend,
                        $recursive
                    );
                } elseif (preg_match($regexp, $path)) {
                    self::file(
                        $curl,
                        $path,
                        $regexp,
                        $quiet,
                        $pretend
                    );
                    if (!$quiet) {
                        //echo "\n";
                    }
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
        $pretend
    ) {
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
                //echo "  smushing ".$path." :";
            }
            // call the server app
            $response = curl_exec($curl);
            // if no response from the server
            if ($response === false) {
                if (!$quiet && Tools::getValue('type') == null) {
                   // echo "  error: the server has gone\n".PHP_EOL;
                }
            } else {
                // decode the json response
                $data = Tools::jsonDecode($response);
                $query = 'INSERT IGNORE INTO '._DB_PREFIX_.'smush (`id_smush`, `url`, `smushed`, `saved`) VALUES (\'\', \''.pSQL((string)$path).'\', \'0\', \'0\')';
                if (!Db::getInstance()
                       ->Execute($query)
                ) {
                    ;
                }

 //URL of the optimized picture
                // if there is some error
                if (!empty($data->error)) {
                    $s = str_replace(_PS_ROOT_DIR_, 'http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__, $path);
                    $o = Tools::jsonDecode(file_get_contents(URL . $s));
                    if (isset($o->error)) {
                        if (!$quiet && Tools::getValue('type') == null) {
                           // echo "  error: ".Tools::strtolower($data->error)."\n";
                        }
                    } else {
                        if (Tools::getValue('type') == null) {
                           // echo str_pad("  ".$o->src_size." -> ".$o->dest_size, 26, " ")." = ".round($o->dest_size * 100 / $o->src_size)."%\n<br/>";
                        }
                        $total = $o->src_size - $o->dest_size;

                        $upd = 'UPDATE '._DB_PREFIX_.'smush SET `smushed` = \'1\', `saved` = \''.pSQL((float)$total).'\' WHERE  '._DB_PREFIX_.'smush.url =  \''.pSQL((string)$path).'\'';
                        Db::getInstance()
                          ->Execute($upd);
                    }
                    // if it's a gif image it is converted to a png file
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
                       // unlink($path.'-tmp');
                        return;
                    }
                } elseif ($data->src_size < $data->dest_size) {
                    if (!$quiet && Tools::getValue('type') != null) {
                       // echo "  error: got larger\n<br/>".PHP_EOL;
                    }
                } elseif ($data->dest_size < 20) {
                    if (!$quiet) {
                        if (Tools::getValue('type') == null) {
                           // echo "  error: empty file downloaded\n<br/>".PHP_EOL;
                        }
                        $upd = 'UPDATE '._DB_PREFIX_.'smush SET `smushed` = \'1\', `saved` = \'-2\' WHERE  '._DB_PREFIX_.'smush.url =  \''.pSQL((string)$path).'\'';
                        Db::getInstance()
                          ->Execute($upd);
                    }
                } elseif ($data->src_size == $data->dest_size) {
                    if (!$quiet) {
                        if (Tools::getValue('type') == null) {
                            //echo "  cannot be optimized further\n<br/>".PHP_EOL;
                        }
                        $upd = 'UPDATE '._DB_PREFIX_.'smush SET `smushed` = \'1\', `saved` = \'-1\' WHERE  '._DB_PREFIX_.'smush.url =  \''.pSQL((string)$path).'\'';
                        Db::getInstance()
                          ->Execute($upd);
                    }
                } else {
                    if (!$quiet) {
                        if (Tools::getValue('type') == null) {
                           // echo str_pad("  ".$data->src_size." -> ".$data->dest_size, 26, " ")." = ".round($data->dest_size * 100 / $data->src_size)."%\n<br/>";
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
            //echo "  error: invalid file ".$path."\n".PHP_EOL;
        }
    }
}
