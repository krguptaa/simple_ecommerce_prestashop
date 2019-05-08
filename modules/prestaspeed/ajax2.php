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

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/../../init.php');
include_once('prestaspeed.php');
include_once('smusher.php');
echo '<div id="resultim"></div>';
$cusi2 = Configuration::get('PRESTASPEED_CUSI2');
define('BASEPATH', _PS_ROOT_DIR_.'/'.str_replace('../', '', Tools::getValue('type'))); // TODO: CAMBIAR ESTO POR TU PATH ORIGINAL
//define('BASEURL', 'http://'.$_SERVER['HTTP_HOST'].__PS_BASE_URI__.$cusi); // TODO: Y ESTO POR TU URL
define('MIN_TIME', 1); // uTime, modificado hace mínimo una fase lunar (aprox. 29 dias)
define('ORIGINAL_POSTFIX', '_orig');
$query = 'CREATE TABLE IF NOT EXISTS '._DB_PREFIX_.'smush (`id_smush` int(2) NOT NULL, `url` varchar(255) NOT NULL, `smushed` TINYINT(1) NOT NULL,`saved` varchar(255) NULL, PRIMARY KEY(`url`)) ENGINE=MyISAM default CHARSET=utf8';
Db::getInstance()
  ->Execute($query);
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
(function($) {

// jQuery on an empty object, we are going to use this as our Queue
var ajaxQueue = $({});

$.ajaxQueue = function( ajaxOpts ) {
    var jqXHR,
        dfd = $.Deferred(),
        promise = dfd.promise();

    // queue our ajax request
    ajaxQueue.queue( doRequest );

    // add the abort method
    promise.abort = function( statusText ) {

        // proxy abort to the jqXHR if it is active
        if ( jqXHR ) {
            return jqXHR.abort( statusText );
        }

        var queue = ajaxQueue.queue(),
            index = $.inArray( doRequest, queue );

        if ( index > -1 ) {
            queue.splice( index, 1 );
        }

        // and then reject the deferred
        dfd.rejectWith( ajaxOpts.context || ajaxOpts,
            [ promise, statusText, "" ] );

        return promise;
    };

    // run the actual query
    function doRequest( next ) {
        jqXHR = $.ajax( ajaxOpts )
            .done( dfd.resolve )
            .fail( dfd.reject )
            .then( next, next );
    }

    return promise;
};

})(jQuery);
</script>';
$smusher = new Smush();
$smusher->it(
    BASEPATH,
    Tools::getValue('type')
);
return;
