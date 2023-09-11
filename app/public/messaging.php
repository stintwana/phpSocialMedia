<?php
require_once 'header.php';
echo "<link rel='stylesheet' href='styles/jquery-ui.theme.css'>";
echo  "<script src='js/jquery-ui.js'></script>"; 
if(!$loggedIn)die();
echo" <div class = 'main'>";
echo "<h4>Start A New Chat</h4>";
echo "<hr/>";
?>

    <div class='table-responsive'>
    <h4 align='center'>Online:<?php echo $user ?></h4>
    <div id='user_details'></div>
    <div id = 'user_model_details'></div>
   </div>

</html>



<script>
$(document).ready(function(){
    fetch_user();

    setInterval(function(){
        update_last_activity();
        fetch_user();
        update_chat_history_data();
    },5000);



    function fetch_user(){
        $.ajax({
            url:"fetch_user.php",
            method:"POST",
            success: function(data){
                $('#user_details').html(data);
            }
        })
    }   

    function update_last_activity(){
        $.ajax({
            url: "update_last_activity.php",
            success: function(){

            }
        })
    }

    function make_chat_dialog_box(to_user_token,to_user_name){
        var modal_content = '<div id = "user_dialog_'+to_user_token+'" class="user_dialog" title= "You have a chat with '+to_user_name+'" style="background-color:#f9f9f9">';
        modal_content += '<div style="height: 400px; border: 1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class = "chat_history" data-tousertoken="'+to_user_token+'" id= "chat_history_'+to_user_token+'">';
        modal_content += '</div>';
        modal_content += '<div class = "form-group">';
        modal_content += '<textarea name = "chat_message_'+to_user_token+'" id = "chat_message_'+to_user_token+'" class ="form-control"></textarea>';
        modal_content += '</div> <div class = "form-group" align= "right">';
        modal_content += '<button type = "button" name = "send_chat" id="'+to_user_token+'" class ="btn  btn-info send_chat">Send</button></div></div>';
        $('#user_model_details').html(modal_content);
    }

    $(document).on('click', '.start_chat', function(){
        var to_user_token = $(this).data('tousertoken');
        var to_user_name = $(this).data('tousername');  
        make_chat_dialog_box(to_user_token, to_user_name);
        $("#user_dialog_"+to_user_token).dialog({
            autoOpen:false,
            width: 400
        }) ;
        $('#user_dialog_'+to_user_token).dialog('open');
    });

    $(document).on('click', '.send_chat', function(){
        var to_user_token= $(this).attr('id');
        var chat_message = $('#chat_message_'+to_user_token).val();
        $.ajax({
            url:"insert_chat.php",
            method: "POST",
            data: {to_user_token:to_user_token, chat_message:chat_message},
            success: function(data){
                $('#chat_message_'+to_user_token).val();
                $('#chat_history_'+to_user_token).html(data);
            }
        })
    });

    function fetch_user_chat_history(to_user_token){
        $.ajax({
            url: "fetch_user_chat_history.php",
            method: "POST",
            data: {to_user_token:to_user_token},
            success: function(data){
                $('#chat_history_'+to_user_token).html(data);
            }
        })
    }

    function update_chat_history_data(){
        $('.chat_history').each(function(){
            var to_user_token= $(this).data('tousertoken');
            fetch_user_chat_history(to_user_token);
        });
    }
    $(document).on('click', '.ui-button-icon', function(){
        $('.user_dialog').dialog('destroy').remove();
    });

});
</script>
</div>