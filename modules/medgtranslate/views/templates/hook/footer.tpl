{*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade this module to newer
* versions in the future. If you wish to customize this module for your
* needs please refer to http://doc.prestashop.com/display/PS15/Overriding+default+behaviors
* #Overridingdefaultbehaviors-Overridingamodule%27sbehavior for more information.
*
* @author Mediacom87 <support@mediacom87.net>
* @copyright  Mediacom87
* @license    commercial license see tab in the module
*}

<div class="clearBoth col-xs-12 col-sm-2">
    <div id="google_translate_element"></div>
</div>
<script type="text/javascript">
function googleTranslateElementInit() {ldelim}
  new google.translate.TranslateElement({ldelim}pageLanguage: '{if isset($lang_iso)}{$lang_iso}{else}{$language.iso_code}{/if}', layout: google.translate.TranslateElement.InlineLayout.SIMPLE{rdelim}, 'google_translate_element');
{rdelim}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
