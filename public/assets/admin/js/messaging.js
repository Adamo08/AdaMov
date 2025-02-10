$(document).ready(function () {
    function fetchMessages() {
        $.ajax({
            url: "/AdaMov/public/Message/getMessagesForDropdown",
            method: "GET",
            dataType: "json",
            success: function (response) {
                let dropdownMenu = $("#messagesDropdown").siblings(".dropdown-menu");
                dropdownMenu.find(".dropdown-item").remove(); // Clear previous messages

                if (response.length > 0) {
                    $(".badge-counter").text(response.length);

                    response.forEach((message) => {
                        let messageItem = `
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="${message.avatar}" alt="Avatar">
                                    <div class="status-indicator ${message.is_read ? 'bg-success' : 'bg-warning'}"></div>
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
                    $(".badge-counter").text(""); // Remove counter if no messages
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
