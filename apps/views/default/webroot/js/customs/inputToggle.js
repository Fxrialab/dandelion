/**
 * @Author 	: Duc Hong Quach
 * @Website : http://hongducdesign.com
 * @Date 	: Friday, Feb. 17th 2012
 * @Desc 	: A tiny plugin replaces the default 'placeholder' attribute on input element. In which we can change the text color using the default CSS.
 * @Example : 
 * 	For sample usage, just insert this line into your doucument ready script:
 * 		$('input[type=text],textarea').inputToggle();
 *  You can change the text color for two states, inactive and active color. Like this:		
	 * 	$('input[type=text],textarea').inputToggle({
			'inactive':'red',
			'active':'blue'		
		});
 */
//You need an anonymous function to wrap around your function to avoid conflict
(function($){
 
    //Attach this new method to jQuery
    $.fn.extend({
         
        //This is where you write your plugin's name
        inputToggle: function(options) {
 
        	//Set the default values, use comma to separate the settings,
        	// inactiveColor : when the input is not being focused
        	// active 		 : when the input is focused
        	
            var defaults = {                
                inactive : '#000000',
                active : '#000000'
            }
            
            //auto bind the new option value into the default
            var options =  $.extend(defaults, options);
 
            return this.each(function() {
            	// this = each input
                var $this = $(this),
                	defaultValue = $this.val(),	
                	opt = options;
                
                // In case we used the "placeholder" attritube, we replace it with the default text
                if($this.attr('placeholder')){
                	defaultValue = $this.attr('placeholder');
                	$this.val(defaultValue);
                	$this.removeAttr('placeholder');
                }
                   
                // Set the inactive text color
                $this.css({'color':opt.inactive});
                
                // focus event on the input element, clear the default text
                $this.focus(function(){                	
                	if($(this).val() == defaultValue){
                		$(this).val('');
                		$(this).css({'color':opt.active});
                	}
                });
                
                // blur event on the input element, reset back to default value when leaving blank
                $this.blur(function(){
                	if($.trim($(this).val()) == ''){
                		$(this).val(defaultValue);
                		$(this).css({'color':opt.inactive});
                	}
                })                               
            });        	        
        }
    });
     
//pass jQuery to the function,
//So that we will able to use any valid Javascript variable name
//to replace "$" SIGN. But, we'll stick to $ (I like dollar sign: ) )      
})(jQuery);