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
var _0xaae8="";
! function(e) {
    "use strict";
    var t = e("body"),
        s = e("#owl-large"),
        l = e("#owl-thumbnail"),
        f = function() {
        var t = e("[data-countdown]"),
        n = '<div class="countdown-item"><div class="countdown-inner"><div class="countdown-cover"><div class="countdown-table"><div class="countdown-cell"><div class="countdown-time">%-D</div><div class="countdown-text">Day%!D</div></div></div></div></div></div><div class="countdown-item"><div class="countdown-inner"><div class="countdown-cover"><div class="countdown-table"><div class="countdown-cell"><span class="countdown-time">%H</span><div class="countdown-text">Hr%!H</div></div></div></div></div></div><div class="countdown-item"><div class="countdown-inner"><div class="countdown-cover"><div class="countdown-table"><div class="countdown-cell"><span class="countdown-time">%M</span><div class="countdown-text">Min%!M</div></div></div></div></div></div><div class="countdown-item"><div class="countdown-inner"><div class="countdown-cover"><div class="countdown-table"><div class="countdown-cell"><span class="countdown-time">%S</span><div class="countdown-text">Sec%!S</div></div></div></div></div></div>';
        t.length > 0 && t.each(function() {
                var t = e(this).data("countdown");
                e(this).countdown(t).on("update.countdown", function(t) {
                    e(this).html(t.strftime(n))
                })
            })
        };
    e(document).ready(function() {
       f();
    })
}(jQuery);