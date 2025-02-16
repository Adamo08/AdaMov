$(document).ready(function () {


    function fetchMessages() {
        $.ajax({
            url: "/AdaMov/public/Message/fetchMessagesForDropdown",
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (typeof response === "string") {
                    response = JSON.parse(response);
                }
                
                let dropdownMenu = $("#messagesDropdown").siblings(".dropdown-menu");
                dropdownMenu.find(".dropdown-item").remove();

                if (Array.isArray(response.messages) && response.messages.length > 0) {
                    $(".badge-counter").text(response.messages.length);

                    response.messages.forEach((message) => {
                        let messageItem = `
                            <a class="dropdown-item d-flex align-items-center message-item" 
                                href="#" 
                                data-id="${message.id}"
                                data-is_read="${message.is_read}"
                                data-message="${message.message}"
                                data-sender="${message.sender_name}"
                                data-created_at="${message.created_at}"
                                data-attachment="${message.attachment ?? ''}"
                            >
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="/AdaMov/public/assets/admin/${message.avatar ?? 'avatars/default.svg'}" alt="Avatar">
                                    <div class="status-indicator ${message.is_read ? 'bg-warning' : 'bg-success'}"></div>
                                </div>
                                <div class="${message.is_read ? '' : 'font-weight-bold'}">
                                    <div class="text-truncate">${message.message}</div>
                                    <div class="small text-gray-500">${message.sender_name} · ${message.created_at}</div>
                                </div>
                            </a>`;
                        dropdownMenu.append(messageItem);
                    });
                    
                    dropdownMenu.append(`<div class="dropdown-divider"></div>`);
                    dropdownMenu.append(`<a class="dropdown-item text-center small text-gray-500" href="/AdaMov/public/admin/messages">View All Messages</a>`);
                
                } else {
                    dropdownMenu.append(`<a class="dropdown-item text-center">No new messages</a>`);
                    $(".badge-counter").text("");
                }
            },
            error: function () {
                console.error("Failed to load messages.");
            },
        });
    }

    // Fetch messages every 30 seconds
    setInterval(fetchMessages, 30000);
    fetchMessages();

    // Handle message click event
    $(document).on("click", ".message-item", function () {
        let messageId = $(this).data("id");
        let isMessageRead = $(this).data("is_read");
        let sender = $(this).data("sender");
        let message = $(this).data("message");
        let createdAt = $(this).data("created_at");
        let attachment = $(this).data("attachment");

        $("#messageModal .modal-title").text(`Message from ${sender}`);
        $("#messageModal .modal-body .message-content").text(message);
        $("#messageModal .modal-body .message-time").text(`Sent on: ${createdAt}`);

        if (attachment) {
            $("#messageModal .modal-body .message-attachment").html(
                `<a href="/AdaMov/public/assets/admin/${attachment}" target="_blank">View Attachment</a>`
            );
        } else {
            $("#messageModal .modal-body .message-attachment").html("");
        }

        $("#messageModal").modal("show");


        // Here we mark the message as read -- if not is read yet
        if (isMessageRead != 1){
            markAsRead(messageId);
        }

    });


    $(document).on("click", ".mark-as-read", function () {
        let messageId = $(this).data('id');
        let messageRow = $(this).closest('tr');
    
        markAsRead(messageId);
    
        // Disable the button
        $(this).prop("disabled", true);
    
        // Change row background: remove 'table-warning' and add 'table-light'
        messageRow.removeClass("table-warning").addClass("table-light");
    
        alert("Message marked as read");
    });
    
    


    // A function to mark a message as read
    function markAsRead(messageId){
        $.ajax({
            url: '/AdaMov/public/message/markAsRead',
            method: 'POST',
            data: {
                message_id: messageId
            },
            beforeSend: function () {
                console.log('Sending AJAX request...');
            },
            success: function (response) {
                response = JSON.parse(response);
                if (response.success) {
                    // alert(response.message);
                    console.log(response);
                } else {
                    // alert(response.message);
                    console.log(response);
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX request failed.');
                console.error('XHR:', xhr);
                console.error('Status:', status);
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            },
            complete: function () {
                console.log('AJAX request completed.');
            }
        });
    }





    // Message deletion functionality
    $(document).on('click', '.delete-message', function(){
        if (confirm('Are you sure you want to delete this message?')) {
            let messageId = $(this).data('id');
            let messageRow = $(`tr[data-id="${messageId}"]`);
            
            // Make the POST request to delete the message
            $.ajax({
                url: '/AdaMov/public/message/deleteMessage',
                type: 'POST',
                data: { message_id: messageId },
                success: function(response) {
                    // Handle the response
                    const res = JSON.parse(response);
                    if (res.success) {
                        messageRow.fadeOut(500, function() {
                            ($this).remove();
                        });
                        alert(res.message);
                    } else {
                        alert(res.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle any errors
                    alert('An error occurred while deleting the message.');
                }
            });
        }
    });


    // Message Replay functionality
    $(document).on('click', '.reply-message', function() {
        let messageId = $(this).data('id');
        let senderId = $(this).data('sender-id');

        // Create a hidden form
        var form = $('<form>', {
            method: 'POST',
            action: '/AdaMov/public/admin/contact_admin'
        });

        // Create hidden input fields for message_id and sender_id
        form.append($('<input>', { type: 'hidden', name: 'message_id', value: messageId }));
        form.append($('<input>', { type: 'hidden', name: 'sender_id', value: senderId }));

        // Append the form to the body and submit it
        $('body').append(form);
        form.submit();
    });


});
