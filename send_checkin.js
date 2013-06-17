 $(document).ready(function(){  

    //get_history();

    function get_history(){
        $.mobile.showPageLoadingMsg("a", "Loading...");
        $.ajax({
            type: 'post',
            url: 'get_hist.php',
            dataType: 'json',
            success: function(data){
                if(data){                    
                    //var processed_data = "["+data+]"]";
                    //var num_items = data.length;

                    //alert(num_items);
                    //$('#tbody_hist').html(data);
                    $.mobile.hidePageLoadingMsg();
                    $('.row_hist').remove();                                   
                    for(var i = 0; i < data.length; i++){
                        $('#tbody_hist').after('<tr class="row_hist"><td class="lat_hist">'+data[i].lat+'</td><td class="long_hist">'+data[i].my_long+'</td><td class="feeling_hist">'+data[i].feeling+'</td><td>'+data[i].note+'</td></tr>');
                    }            
                    //$('#check_in_message').show();
                    //$('#check_in_message').html(data);                        
                    //$('#check_in_message').delay(3000).fadeOut(1500);      
                }else{        
                    alert("oops nothing happened :(");
                }
            }        
        });                                
    }

    $('#update_hist_button').click(function(event){
        event.preventDefault();
        get_history();
    });

    $('#login_form').submit(function(event){
        event.preventDefault();
        $.mobile.showPageLoadingMsg("a", "Loading...");
        var user = $('#txt_login_user').val();
        var pass = $('#txt_login_pass').val();
        var jsonString = {
            "user":user,
            "pass":pass
            }

        $.ajax({
            type: 'post',
            url: 'check_login.php',
            data: jsonString,
            success: function(data){
                $.mobile.hidePageLoadingMsg();
                var log_status = "";
                var log_message = "";
                if(data){
                    log_status = data.substr(0,1);
                    log_message = data.substr(1);
                    if(log_status == 1){
                        //alert('holy cow it worked!');

                        $('.user_name').text("");
                        $('.user_name').append('Welcome ');
                        $('.user_name').append(user);                        
                        $('.user_name').append('!');                        
                        
                        $.mobile.changePage( "#page3", { transition: "slideup" });
                    }else{
                        alert('whoops, it did not work.');
                    }                        
                }else{
                    $('#login_error_message').text("It didn't work.").fadeOut(3000);                                                
                }                    
            }
        });

        return false;
    });    

    $('#checkInForm').submit(function(event){
        event.preventDefault();
        $.mobile.showPageLoadingMsg("a", "Loading...");
        var feeling = $('#feeling_radio_container').children().find('input[name="feeling"]:checked').val();
        //var feeling = $('input[name="feeling"]:checked', '#checkInForm').val()
        var my_lat = $('#my_lat').val();
        var my_long = $('#my_long').val();
        var note = $('#textarea1').val();
        var jsonString = {"feeling":feeling,
                        "my_lat":my_lat,
                        "my_long":my_long,
                        "note":note
                    }
        $.ajax({                                      
            type: 'post',
            url: 'check_in.php',                                   
            data: jsonString,            
            beforeSend: function(){
                if (!$("input[name='feeling']:checked").val()) {
                    $.mobile.hidePageLoadingMsg();
                    alert('Nothing is checked!');                    
                    return false;
                } 
            },                                                                   
            success: function(data){                       
                //$("#loading_mockup_items").hide();  
                //var obj = $.parseJSON(data);
                //alert(data);
                if(data){                    
                    data = $.parseJSON(data);
                    var check_in_status = data.status;
                    //alert(check_in_status);
                    $('#check_in_message').show();
                    
                    if(check_in_status == 0){
                        $('#check_in_message').text(data.message);                        
                    }else if(check_in_status == 1){                        
                        $('#check_in_message').html("Latitude: " + data.my_lat + "<br/>Longitude: " + data.my_long + "<br/>Feeling: " + data.feeling);                        
                    }
                    
                    $('#check_in_message').delay(5000).fadeOut(1500);  
                    $('#checkInForm')[0].reset();  
                    //$('#feeling').find('input[name="feeling"]:checked').attr('checked', false);  
                }else{        
                    alert("oops nothing happened :(");
                } 
                $.mobile.hidePageLoadingMsg();       
            } 
        }); 
        return false;
    }); 

    $('#register_form').submit(function(){
        event.preventDefault();
        $.mobile.showPageLoadingMsg("a", "Loading...");
        var user = $('#txt_register_user').val();
        var pass = $('#txt_register_pass').val();
        //alert(user);
        //alert(pass);
        var jsonString = {
            "user":user,
            "pass":pass
            }

        $.ajax({
            type: 'post',
            url: 'register.php',
            data: jsonString,
            success: function(data){
                $.mobile.hidePageLoadingMsg();   
                //alert(data);
                console.log(data);
                if(data){                                                        
                    data = $.parseJSON(data);
                    if(data.status == 1){
                        //alert('holy cow it worked!');
                        $('login_box_div span.user_name').text("");
                        $('#login_box_div span.user_name').append('Welcome ');
                        $('#login_box_div span.user_name').append(user);                        
                        $('#login_box_div span.user_name').append('!');
                        $.mobile.changePage( "#page1", { transition: "slideup" });
                    }else{
                        $('#register_error_message').text(data.message).delay(5000).fadeOut(2000);                            
                    }
                    $('#txt_register_user').val("");
                    $('#txt_register_pass').val("");
                }else{
                    $('#register_error_message').text("It didn't work.  Maybe a smart person can figure out why.").delay(5000).fadeOut(2000);                                                
                }                    
            }
        });

        return false;
    }); 

    $('#get_map_link').click(function(event){
        event.preventDefault();
        $.mobile.showPageLoadingMsg("a", "Loading...");
        $('#history_map').show();
        map_with_markers();
        $.mobile.hidePageLoadingMsg();
    });
});
