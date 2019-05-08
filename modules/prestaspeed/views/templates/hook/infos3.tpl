{*
* 2007-2014 PrestaShop
*
* NOTICE OF LICENSE
*
* No redistribute in other sites, or copy.
*
*  @author RSI <rsi_2004>
*  @copyright  2007-2017 RSI
*} 
<script type="text/javascript">
$(document).ready(function(e) {
	
	
	
	
	
		    var type=$("#type").val();
			var output=$("#output").val();
			var cusi=$("#cusi").val();
		if (cusi != '') {
$("#toprocess").append(cusi);   
		} else {
$("#toprocess").append(type);   

			}
});

</script>
{if $psversion < "1.6.0.0"}

{literal}
<script>
$(document).ready(function(){

			var type=$("#type").val();
			var output=$("#output").val();
			var cusi=$("#cusi").val();
			
			//	var but = '<button id="mybut" type="button">Optimize now</button>'
			//  var ifra = '<iframe id="ifra" ></iframe>'
			
			//$("#module_form_submit_btn_2").before(but)
			// $("#cleani_on").after(ifra)
			
			/*form*/
			$("#mybut").click(function(){
			if (cusi != '') {
			$("#ifra").attr("src", '../modules/prestaspeed/ajax2.php?type='+$("#cusi").val()+'&output=&cusi='+cusi);
			} else {
			$("#ifra").attr("src", '../modules/prestaspeed/ajax2.php?type='+$("#type").val()+'&output=&cusi='+cusi);
			
			}
			alert("Process started. This can take many minutes depending on the number of images. Do not exit this window until the process is finished");
			});
});
</script>
{/literal}
{/if}
{if $psversion > "1.6.0.0"}
<div class="bootstrap panel">
	<div class="panel-heading">
		<i class="icon-image"></i> {l s='Run the image optimization:' mod='prestaspeed'}
        </div>
        {else}
         <fieldset>
      <legend><img src="{$module_dir}views/img/pictures.gif" alt="" title="" />{l s='Run the image optimization:' mod='prestaspeed'}</legend>
        {/if}
      
     <p> {l s='This process optimize the file/folder:' mod='prestaspeed'}<strong> <span id="toprocess"></span></strong></p>   
          
   <iframe id="ifra" width="100%">

   </iframe>     <br/><br/>
     <button type="button" id="mybut" class="btn btn-default pull-right"><i class="icon-image"></i>{l s='Optimize' mod='prestaspeed'}</button><br/><br/>
  {if $psversion > "1.6.0.0"}
  </div>
  {else}
  </fieldset>
  {/if}

   
