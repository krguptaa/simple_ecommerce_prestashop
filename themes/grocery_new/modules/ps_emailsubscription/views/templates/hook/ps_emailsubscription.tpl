{**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2018 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *}

{*

<section class="container py-5 my-md-4 text-center">
      <div class="row">
          <div class="col-xl-8 offset-xl-2">
              <h2 class="trajan-font text-dark text-center">Sign up to take $20 off your first order </h2>
                <div class="subscribe-from">
                         <form action="{$urls.pages.index}#footer" method="post">
        <div class="row">
          <div class="col-xs-12">
            <input
              class=" float-xs-right hidden-xs-down"
              name="submitNewsletter"
              type="submit"
              value="{l s='Subscribe' d='Shop.Theme.Actions'}"
            >
            <input
              class="btn btn-primar float-xs-right hidden-sm-up"
              name="submitNewsletter"
              type="submit"
              value="{l s='OK' d='Shop.Theme.Actions'}"
            >
            <div class="input-wrapper">
              <input
                name="email"
                type="email"
                value="{$value}"
                placeholder="{l s='Your email address' d='Shop.Forms.Labels'}"
                aria-labelledby="block-newsletter-label"
              >
            </div>
            <input type="hidden" name="action" value="0">
            <div class="clearfix"></div>
          </div>
          <div class="col-xs-12">
              {if $conditions}
                <p>{$conditions}</p>
              {/if}
              {if $msg}
                <p class="alert {if $nw_error}alert-danger{else}alert-success{/if}">
                  {$msg}
                </p>
              {/if}
             
          </div>
        </div>
      </form>
                    <p>Yes, I want to be on Dmv Grocery's exclusive email list! Terms of Service and Privacy Policy apply.</p>
                </div>
          </div>
        </div>
    </section>
    *}
       <section class="container py-5 my-md-4 text-center">
      <div class="row">
          <div class="col-xl-8 offset-xl-2">
              <h2 class="trajan-font text-dark text-center">Sign up to take $20 off your first order </h2>
                <div class="subscribe-from">
                  <form action="{$urls.pages.index}#footer" method="post">
                      <input name="email" type="email" value="{$value}" placeholder="Your email here" aria-labelledby="block-newsletter-label">
                        <input value="Subscribe"  name="submitNewsletter" type="submit">

                        <input type="hidden" name="action" value="0">
                       
                    </form>
                    <p>Yes, I want to be on Dmv Grocery's exclusive email list! Terms of Service and Privacy Policy apply.</p>
                </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
              {if $msg}
                <p class="alert {if $nw_error}alert-danger{else}alert-success{/if}">
                  {$msg}
                </p>
              {/if}
             
          </div>
        </div>
    </section>