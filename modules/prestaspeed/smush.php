<?php
/**
 * 2007-2014 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * No redistribute in other sites, or copy.
 *
 * @author    RSI
 * @copyright 2007-2016 RSI
 * @license   http://localhost
 */

include('smushit.inc.php');
include('../../config/defines.inc.php');
include('../../config/config.inc.php');
include('prestaspeed.php');
$cusi2 = Configuration::get('PRESTASPEED_CUSI2');
// Path desde dónde empieza a buscar las imagenes
define('BASEPATH', _PS_ROOT_DIR_.'/'.$cusi2); // TODO: CAMBIAR ESTO POR TU PATH ORIGINAL
define('WEBSERVICE', 'http://www.resmush.it/ws.php?img=');
define('BASEURL', 'http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.$cusi2); // TODO: Y ESTO POR TU URL
define('MIN_TIME', 100); // uTime, modificado hace mínimo una fase lunar (aprox. 29 dias)
define('ORIGINAL_POSTFIX', '_orig');
$start_time = 0;
$max_execution_time = 3337200;
$smush = new SmushIt();
$msg = '';
$myFile = "images.txt";
$fh = fopen(
    $myFile,
    'a'
);

// find para encontrar TODAS las imagenes
//exec('find ' . BASEPATH . ' -type f -not -name "*' . ORIGINAL_POSTFIX . '*" -exec file --mime-type {} \; | grep -e "image/png" -e  "image/gif" -e "image/jpeg"', $findRes);

$pattern = '{*.jpg,*.png,*.gif}';
$path = BASEPATH;
$flags = GLOB_BRACE;


$paths = glob(
    $path.'*',
    GLOB_MARK | GLOB_ONLYDIR | GLOB_NOSORT
);

$files = glob(
    $path.$pattern,
    $flags
);

$newv = array();
foreach ($files as $file) {
    $newv[] = pathinfo($file);
}
foreach ($newv as $k => $v) {
    //var_dump($newv)	;

    $newv[$k]['path'] = $newv[$k]['dirname'].'/';
    $newv[$k]['filename'] = $newv[$k]['filename'];
    $newv[$k]['extension'] = Tools::substr(
        $newv[$k]['path'],
        strrpos(
            $newv[$k]['path'],
            '.'
        )
    );
    $newv[$k]['pathsmush'] = Tools::substr($newv[$k]['path'], 0, strrpos($newv[$k]['path'], '.')).ORIGINAL_POSTFIX.$newv[$k]['extension'];
    $newv[$k]['url'] = BASEURL.str_replace(BASEPATH, '', $newv[$k]['path']).$newv[$k]['basename'];
    //  $newv[$k]['mimetype'] = $v['extension'];
}
//return $files;

// convertimos la salida del comando en un array trabajable.


// init variables stats
$totalCompress = 0;
$sumCompress = 0;
$bytesAhorro = 0;

$i = 0;

foreach ($newv as $file) {
    $compressRes = $smush->compress($file['url']);
    $s = $file['url'];
    $o = Tools::jsonDecode(Tools::file_get_contents(WEBSERVICE.$s));
    print_r($s);
    print_r($o);
    /*
    if(isset($o->error)){
        die('Error');
    }
    */
    fwrite(
        $fh,
        '-'.date('l jS \of F Y h:i:s A').'<br/>'
    );
    fwrite(
        $fh,
        $o->src_size.'<br/>'
    );
    fwrite(
        $fh,
        $o->dest_size.'<br/>'
    );
    fwrite(
        $fh,
        $file['pathsmush'].'<br/>'
    );
    // sólo si no es gif pues smushit los pasa a png
    // y de momento no nos interesa por los cambios de
    // código que implica.
    if ($file['extension'] != '.gif') {
        try {
            // comprovar que no existe ya optimizado de hace poco...

            // sólo si el fichero es menor que el original (cosa que debe ser siempre, pues sinó salta una exception)
            if ($o->src_size > $o->dest_size) {
                fwrite(
                    $fh,
                    $o->src_size.'-'.$o->dest_size
                );
                // Realizamos copia del original
                // pero solo si no existe el original ya.
                if (!file_exists($file['pathsmush'])) {
                    $msg .= 'Copy the original '.PHP_EOL.'cp '.$file['path'].' '.$file['pathsmush'].PHP_EOL.'<br/>';
                    fwrite(
                        $fh,
                        $msg
                    );
//              exec('cp ' . $file['path'] . ' ' . $file['pathsmush']);

                    copy(
                        $file['path'],
                        $file['pathsmush']
                    );
                } else {
                    $msg .= 'Dont copy the original. '.$file['pathsmush'].PHP_EOL.'<br/>';
                    fwrite(
                        $fh,
                        $msg
                    );
                }

                // Bajamos el fichero "bien" comprimido
                $msg .= 'downloading: '.$file['path'].PHP_EOL.'from: '.$o->dest.' ('.$o->percent.'%)'.PHP_EOL.PHP_EOL.'<br/>';
                fwrite(
                    $fh,
                    $msg
                );
                copy(
                    $o->dest,
                    $file['path']
                );
                // exec('wget --output-document=' . $file['path'] . ' ' . $o->dest);
                // calulamos estadístcas.
                $bytesAhorro += $o->src_size - $o->dest_size;
                $sumCompress += $o->percent;
                $totalCompress++;
            } else {
                $msg .= ' Cant optimize this file for better compression.'.PHP_EOL.'<br/>';
            }
        } catch (Exception $e) {
            $msg .= 'Exception smushit. '.$e->getMessage().' on file: '.$file['url'].PHP_EOL.PHP_EOL.'<br/>';
        }
    }
    // TODO
    // habilitar esto si queremos un test limitado por numero de files.
    /*
    if ($totalCompress == 2) {
      echo PHP_EOL . PHP_EOL . 'Smush finalizado:' . PHP_EOL;
      echo                     '-----------------' . PHP_EOL;
      echo PHP_EOL . 'Ficheros totales comprimidos = ' . $totalCompress;
      echo PHP_EOL . 'Compresión media = ' . ($sumCompress/$totalCompress);
      echo PHP_EOL . 'Bytes total ahorrados = ' . ($bytesAhorro) . PHP_EOL;

      die('we stop at 2 ... ' . PHP_EOL);
    }
    */
}

// Mostramos resumen.
$msg .= PHP_EOL.PHP_EOL.'Smush finished:'.PHP_EOL.'<br/>';
$msg .= '-----------------'.PHP_EOL.'<br/>';
$msg .= PHP_EOL.'Total compressed files = '.$totalCompress.'<br/>';
if ($totalCompress == 0) {
    $totalCompress = 1;
} // Evita un divided by 0.
$msg .= PHP_EOL.'Medium compresion = '.($sumCompress / $totalCompress).' %<br/>';
$msg .= PHP_EOL.'Saved Bytes = '.($bytesAhorro).PHP_EOL.'<br/>';
$fh = fopen(
    $myFile,
    'a'
);

fwrite(
    $fh,
    $msg
);
fclose($fh);
