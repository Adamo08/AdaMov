<?php

/**
 * Message model for interacting with the database's admin_messages table.
 * This model includes methods to fetch unread message count, mark messages as read,
 * and retrieve messages for the currently logged-in admin.
 */
class Message extends Model
{
    protected $table = 'admin_messages';

    /**
     * Fetch the count of unread messages for a specific admin.
     * 
     * @param int $adminId - The ID of the admin whose unread messages to count.
     * @return int - The number of unread messages for the given admin.
     */
    public function getUnreadMessageCount($adminId)
    {
        // SQL query to count unread messages (is_read = 0) for the given admin
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE receiver_id = :receiver_id AND is_read = 0";
        
        // Prepare and execute the query
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':receiver_id', $adminId, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the result and return the count
        return $stmt->fetchColumn();
    }

    /**
     * Mark a specific message as read.
     * 
     * @param int $messageId - The ID of the message to mark as read.
     * @return bool - True if the update was successful, false otherwise.
     */
    public function markAsRead($messageId)
    {
        // SQL query to update the message's 'is_read' status
        $sql = "UPDATE {$this->table} SET is_read = 1 WHERE id = :message_id";
        
        // Prepare and execute the query
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':message_id', $messageId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Fetch all messages for a specific admin.
     * 
     * @param int $adminId - The ID of the admin whose messages to fetch.
     * @return array - An array of messages for the given admin.
     */
    public function getMessagesByAdmin($adminId)
    {
        // SQL query to fetch all messages for the given admin
        $sql = "SELECT * FROM {$this->table} WHERE receiver_id = :receiver_id ORDER BY created_at DESC";
        
        // Prepare and execute the query
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':receiver_id', $adminId, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch all messages and return them as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch a limited number of messages (e.g., 5) for a specific admin for the dropdown.
     * This method is used for showing the most recent messages in the header dropdown.
     * 
     * @param int $adminId - The ID of the admin whose messages to fetch.
     * @param int $limit - The number of messages to fetch (default is 5).
     * @return array - An array of messages for the given admin, limited by the number specified.
     */
    public function getMessagesForDropdown($adminId, $limit = 5)
    {
        $sql = "SELECT am.id, am.message, am.created_at, am.attachment,
                    a.avatar, 
                    CONCAT(a.fname, ' ', a.lname) AS sender_name,
                    am.is_read
                FROM admin_messages am
                JOIN admins a ON am.sender_id = a.id
                WHERE am.receiver_id = :receiver_id 
                AND am.is_deleted_receiver = 0
                ORDER BY am.created_at DESC
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':receiver_id', $adminId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    


}