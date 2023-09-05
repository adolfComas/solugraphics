/* ---------------------------------------------
 Contact form
 --------------------------------------------- */
$(document).ready(function(){
    $("#submit_btn").click(function(){
        
        //get input field values
        var user_name = $('input[name=name]').val();
        var user_email = $('input[name=email]').val();
        var user_phone = $('input[name=phone]').val();
        var user_message = $('textarea[name=message]').val();
        
        //simple validation at client's end
        //we simply change border color to red if empty field using .css()
        var proceed = true;
        if (user_name == "") {
            $('input[name=name]').css('border-color', '#e41919');
            proceed = false;
        }
        if (user_email == "") {
            $('input[name=email]').css('border-color', '#e41919');
            proceed = false;
        }
        if (user_phone == "") {
            $('input[name=phone]').css('border-color', '#e41919');
            proceed = false;
        }
        if (user_message == "") {
            $('textarea[name=message]').css('border-color', '#e41919');
            proceed = false;
        }
        
        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {
                'userName': user_name,
                'userEmail': user_email,
                'userMessage': user_message,
                'userPhone': user_phone
            };
            
            //Ajax post data to server
            $.post('contact_me.php', post_data, function(response){
            
                //load json data from server and output message     
                if (response.type == 'error') {
                    output = '<div class="alert alert-danger">' + response.text + '</div>';
                }
                else {
                
                    output = '<div class="alert-success">' + response.text + '</div>';
                    
                    //reset values in all input fields
                    $('#contactform input').val('');
                    $('#contactform textarea').val('');
                }
                
                $("#result").hide().html(output).slideDown();
            }, 'json');
            
        }
        
        return false;
    });
    
    //reset previously set border colors and hide all message on .keyup()
    $("#contact_form input, #contactform textarea").keyup(function(){
        $("#contactform input, #contactform textarea").css('border-color', '');
        $("#result").slideUp();
    });
    
});