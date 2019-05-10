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


<ps-alert-hint class="medAddonsMarket">

    <p>{l s='Do you like this module?' mod='medgtranslate'}</p>
    <p>{l s='Get other ones directly on' mod='medgtranslate'}</p>
    <p><a href="https://www.prestatoolbox.{$iso_domain|escape:'htmlall':'UTF-8'}/1_mediacom87?utm_source=module&utm_medium=cpc&utm_campaign={$name|escape:'htmlall':'UTF-8'}" target="_blank" title="PrestaToolBox Market Place"><img src="{$img_path}prestatoolbox.png" alt="PrestaToolBox Market Place" class="img-responsive" /></a></p>
    <p>{l s='Or on' mod='medgtranslate'}</p>
    <p><a href="https://addons.prestashop.com/{$iso_code|escape:'htmlall':'UTF-8'}/2_community-developer?contributor=322" target="_blank" title="Prestashop Addons Market Place"><img src="{$img_path}prestashop-addons-logo.png" alt="Prestashop Addons Market Place" class="img-responsive" /></a></p>

</ps-alert-hint>