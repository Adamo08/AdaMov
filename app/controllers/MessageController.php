<?php

/**
 * MessageController class to handle message-related actions such as fetching unread messages,
 * marking messages as read, and managing message interactions between admins.
 */
class MessageController extends Controller
{
    private $messageModel;

    /**
     * Constructor to initialize the Message model.
     * The model will be used to interact with the database for message operations.
     */
    public function __construct()
    {
        // Load the Message model
        $this->messageModel = new Message();
    }

    /**
     * Fetch unread message count for the currently logged-in admin.
     * This count will be displayed in the navbar's message counter.
     *
     * @return void
     */
    public function getUnreadCount()
    {
        // Get the current admin's ID (can be from session or other method)
        $adminId = $_SESSION['admin_id'];

        // Fetch the unread message count from the model
        $messageCount = $this->messageModel->getUnreadMessageCount($adminId);

        // Return the message count as JSON
        echo json_encode(['count' => $messageCount]);
    }

    /**
     * Mark a message as read.
     * This function will update the 'is_read' status of the message in the database.
     *
     * @param int $messageId - The ID of the message to be marked as read.
     * @return void
     */
    public function markAsRead($messageId)
    {
        // Mark the message as read by passing the message ID
        $this->messageModel->markAsRead($messageId);
        
        // Return a success message or status
        echo json_encode(['success' => true]);
    }

    /**
     * Fetch and display all messages for the current admin.
     * This could be for the admin to view their messages.
     *
     * @return void
     */
    public function fetchMessages()
    {
        $adminId = $_SESSION['admin_id'];
        $messages = $this->messageModel->getMessagesByAdmin($adminId);

        // Render the view to display the messages (e.g., a message list view)
        $this->view('messages', ['messages' => $messages]);
    }

    /**
     * Fetch limited messages (e.g., 5) for the dropdown in the header.
     * This is for showing a preview of the most recent messages.
     *
     * @return void
     */
    public function fetchMessagesForDropdown()
    {
        // Get the current admin's ID
        $adminId = $_SESSION['admin_id'];

        // Fetch the first 5 messages from the model
        $messages = $this->messageModel->getMessagesForDropdown($adminId);

        // Return the messages as JSON to be used in the dropdown
        echo json_encode(['messages' => $messages]);
    }

}
