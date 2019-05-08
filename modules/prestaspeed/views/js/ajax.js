/*
 * jQuery UI Slider Access
 * By: Trent Richardson [http://trentrichardson.com]
 * Version 0.3
 * Last Modified: 10/20/2012
 * 
 * Copyright 2011 Trent Richardson
 * Dual licensed under the MIT and GPL licenses.
 * http://trentrichardson.com/Impromptu/GPL-LICENSE.txt
 * http://trentrichardson.com/Impromptu/MIT-LICENSE.txt
 * 
 *//* InstantClick 3.1.0 | (C) 2014 Alexandre Dieulot | http://instantclick.io/license */

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
	
	