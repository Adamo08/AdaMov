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


        // Here we mark the message as read -- Later

    });

});
