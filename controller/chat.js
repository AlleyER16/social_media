
function display_feedback(message){

    $("#show_operation_message").find("#message").html(message);

    $("#show_loading").slideUp("fast");

    interval = setInterval(function(){

        $("#show_operation_message").slideDown("fast").delay(1000);
        $("#show_operation_message").toggle("fast");

        clearInterval(interval);

    }, 500);

}

function edit_chat(chat_id, message){

    $("#update_chat_form").find("input[name='chat_id']").val(chat_id);
    $("#update_chat_form").find("textarea[name='message']").val(message);

    $("#updateChatModal").modal("show");

}

function delete_chat(chat_id){

    $("#show_loading").slideDown("fast").delay(100);

    var form_data = $(this).serialize();

    $.ajax({

        url: "models/delete_message.php",
        type: "post",
        data: {chat_id},
        success: function(data){

            var data = jQuery.trim(data);

            if(data == "Unauthorized"){

                window.location = "login.php";
                return;

            }

            if(data == "Message deleted successfully"){

                $(`#cht__${chat_id}`).remove();

            }

            display_feedback(data);

        },
        error: function(){

            display_feedback("Error deleting message. Retry");

        }

    });

}

function append_message(message, chat_id){

    var message_html = `
        <div class="row w3-margin-bottom" id="cht__${chat_id}">
            <div class="col-md-2 col-sm-2 col-xs-2"></div>
            <div class="col-md-10 col-sm-10 col-xs-10 w3-right-align">
                <span style="cursor: pointer; text-decoration: underline" class="text-danger" onclick="delete_chat(${chat_id})">Delete</span>
                <span style="cursor: pointer;  text-decoration: underline" class="text-primary" onclick="edit_chat(${chat_id}, \`${message}\`)">Edit</span>
                <button class="btn btn-primary" id="msg__${chat_id}">${message}</button>
            </div>
        </div>
    `;

    $("#actual_chat").append(message_html);

}

$(document).ready(function() {

    $("#send_message").submit(function(event) {

        event.preventDefault();

        $("#show_loading").slideDown("fast").delay(100);

        var form_data = $(this).serialize();

        const message = $(this).find("input[name='message']").val();

        $.ajax({

            url: "models/add_message.php",
            type: "post",
            data: form_data,
            success: function(data){

                data = $.trim(data);

                data = data.split(",");

                if(data[0] == "Unauthorized"){
                    window.location = "login.php";return;
                }

                if(data[0] === "Message added successfully"){

                    append_message(message, data[1]);

                    $("#show_loading").slideUp("fast");

                    $("#send_message").trigger("reset");

                }else{

                    display_feedback(data);

                }

            },
            error: function(){

                display_feedback("Error Sending Message. Retry");

            }

        });

    });

    $("#update_chat_form").submit(function(event) {

        event.preventDefault();

        const submit_button = $(this).find("button[type='submit']");

        submit_button.html("Updating...").attr("disabled", "disabled");

        const server_response = $(this).find("span[class='server_response']");

        var form_data = $(this).serialize();

        const chat_id = $(this).find("input[name='chat_id']").val();
        const message = $(this).find("textarea[name='message']").val();

        $.ajax({

            url: "models/update_message.php",
            type: "post",
            data: form_data,
            success: function(data){

                data = $.trim(data);

                if(data == "Unauthorized"){
                    window.location = "login.php";return;
                }

                if(data === "Message updated successfully"){

                    $(`#msg__${chat_id}`).html(message);

                    $("#updateChatModal").find("button[data-dismiss='modal']").trigger("click");
                    $("#update_chat_form").trigger("reset");

                    server_response.html("");
                    submit_button.removeAttr("disabled").html("Update");

                }else{

                    server_response.html(data);
                    submit_button.removeAttr("disabled").html("Update");

                }

            },
            error: function(){

                display_feedback("Error Sending Message. Retry");

            }

        });

    });

});
