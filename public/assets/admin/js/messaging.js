$(document).ready(function () {

    // alert("messaging.js");
    // console.log("messaging.js");
    
    function fetchMessages() {
        $.ajax({
            url: "/AdaMov/public/Message/fetchMessagesForDropdown",
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (typeof response === "string") {
                    response = JSON.parse(response);
                }
            
                console.log("Final response:", response);
            
                let dropdownMenu = $("#messagesDropdown").siblings(".dropdown-menu");
                dropdownMenu.find(".dropdown-item").remove();
            
                if (Array.isArray(response.messages) && response.messages.length > 0) {
                    $(".badge-counter").text(response.messages.length);
            
                    response.messages.forEach((message) => {
                        let messageItem = `
                            <a class="dropdown-item d-flex align-items-center" href="#">
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

    // Initial fetch on page load
    fetchMessages();
});
