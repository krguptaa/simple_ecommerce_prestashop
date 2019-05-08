{*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* No redistribute in other sites, or copy.
*
*  @author RSI <rsi>
*  @copyright  2007-2017 RSI
*}      
        <section id="prestaspeed" class="panel widget{if $allow_push} allow_push{/if}">
	<div class="panel-heading">
		<i class="icon-time"></i> {l s='Data to optimize - Prestaspeed' mod='prestaspeed'}
		<span class="panel-heading-action">
			<a class="list-toolbar-btn" href="{$linkpmo|escape:'htmlall':'UTF-8'}" title="{l s='Configure' mod='prestaspeed'}">
				<i class="process-icon-configure"></i>
			</a>
			
		</span>
	</div>
	
	<section id="dash_live" class="loading">
		<ul class="data_list_large">
			<li>
				<span class="data_label ">
				<a  href="{$linkpmo|escape:'htmlall':'UTF-8'}">	{l s='Discounts:' mod='prestaspeed'}</a>
					<small class="text-muted"><br/>
						{l s='From expired promotions/vouchers' mod='prestaspeed'}
					</small>
				</span>
				<span class="data_value2 size_xxl">
					{$disc|escape:'htmlall':'UTF-8'}
				</span>
			</li>
			<li>
				<span class="data_label ">
				<a  href="{$linkpmo|escape:'htmlall':'UTF-8'}">	{l s='Pages not found:' mod='prestaspeed'}</a>
					<small class="text-muted"><br/>
						{l s='From 404 pages not found error' mod='prestaspeed'}
					</small>
				</span>
				<span class="data_value2 size_xxl">
					{$pnf|escape:'htmlall':'UTF-8'}
				</span>
			</li>
			<li>
				<span class="data_label ">
					<a  href="{$linkpmo|escape:'htmlall':'UTF-8'}">	{l s='Guest data:' mod='prestaspeed'}</a>
					<small class="text-muted"><br/>
						{l s='From all users' mod='prestaspeed'}
					</small>
				</span>
				<span class="data_value2 size_xxl">
				{$guest|escape:'htmlall':'UTF-8'}
				</span>
			</li>
            	<li>
				<span class="data_label ">
					<a  href="{$linkpmo|escape:'htmlall':'UTF-8'}">	{l s='Viewed pages:' mod='prestaspeed'}</a>
					<small class="text-muted"><br/>
						{l s='From all users'  mod='prestaspeed'}
					</small>
				</span>
				<span class="data_value2 size_xxl">
					{$pages|escape:'htmlall':'UTF-8'}
				</span>
			</li>
            	<li>
				<span class="data_label ">
					<a  href="{$linkpmo|escape:'htmlall':'UTF-8'}">	{l s='Abandoned carts:' mod='prestaspeed'}</a>
					<small class="text-muted"><br/>
						{l s='From non register users' mod='prestaspeed'}
					</small>
				</span>
				<span class="data_value2 size_xxl">
				{$cartsa|escape:'htmlall':'UTF-8'}
				</span>
			</li>
            <li>
				<span class="data_label ">
					<a  href="{$linkpmo|escape:'htmlall':'UTF-8'}">	{l s='Connection data:' mod='prestaspeed'}</a>
					<small class="text-muted"><br/>
						{l s='From all users'  mod='prestaspeed'}
					</small>
				</span>
				<span class="data_value2 size_xxl">
				{$conn|escape:'htmlall':'UTF-8'}
				</span>
			</li>
            <hr />
                <li>
				<span class="data_label ">
					<a  href="{$linkpmo|escape:'htmlall':'UTF-8'}">	{l s='Database size' mod='prestaspeed'}</a>
					<small class="text-muted"><br/>
						{l s='Total size of the database'  mod='prestaspeed'}
					</small>
				</span>
				<span class="data_value2 size_xxl">
				{$data|escape:'htmlall':'UTF-8'}
				</span>
			</li>
            <hr/>
            <li>
				<span class="data_label ">
					<a  href="{$linkpmo|escape:'htmlall':'UTF-8'}">	{l s='Total KB saved' mod='prestaspeed'}</a>
					<small class="text-muted"><br/>
						{l s='On image compression' mod='prestaspeed'}
					</small>
				</span>
				<span class="data_value2 size_xxl">
				{$totsav|escape:'htmlall':'UTF-8'}
				</span>
			</li>
		</ul>
	</section>
	
</section>