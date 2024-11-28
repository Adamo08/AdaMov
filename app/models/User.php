<?php


class User extends Model {
    protected $table = 'users';
    protected $links_table = 'user_social_links';

    /**
     * Get a user by their email.
     * @param string $email
     * @return array|false
    */ 
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get a user by their email.
     * @param string $id
     * @return array|false
    */ 
    public function getUserByID($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Returns the full name of a user
     * @param int $id user ID
     * @return string full name
    */
    public function getfullName($id){
        // Base Query
        $sql = "SELECT CONCAT(lname,' ', fname) FROM {$this->table} WHERE id = :id";
        // Prepare AND Execute
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id,PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    /**
     * Returns the avatar for the specified user
     * @param int $id user's ID
     * @return string 
    */
    public function getAvatar($id){
        // Base Query
        $sql = "SELECT avatar FROM {$this->table} WHERE id = :id";
        // Prepare AND Execute
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Get all users.
     * @return array
    */ 
    public function getAllUsers() {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetches user social links
     * @param int $user_id
     * @return array
    */
    public function getUserSocialLinks($user_id) {
        // Base query
        $sql = "SELECT * FROM {$this->links_table}  WHERE user_id = :id LIMIT 1";
        // Prepare, Bind AND Execute
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    /**
     * Function to insert a new user.
     * @param string $fname
     * @param string $lname
     * @param string $email
     * @param string $password
     * @param string $token
     * @return bool
    */
    public function createUser($fname, $lname, $email, $password, $token) {
        // Check if email already exists
        if ($this->getUserByEmail($email)) {
            return false;
        }

        $passwordHash = hash('sha256', $password);

        // Insert a new user
        $query = 'INSERT INTO ' . $this->table . ' (fname, lname, email, password, verification_token) VALUES (:fname, :lname, :email, :password, :token)';
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':token', $token);

        return $stmt->execute();
    }


    /**
     * Updates the user's profile information.
     *
     * @param int $user_id The ID of the user to update.
     * @param array $data The data to update (keys: fname, lname, email, address).
     * @return bool True if the update was successful, false otherwise.
    */
    public function updateUserProfile($user_id, $data) {
        try {
            $sql = "UPDATE {$this->table} 
                    SET fname = :fname, 
                        lname = :lname, 
                        email = :email, 
                        address = :address 
                    WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':fname', $data['fname'], PDO::PARAM_STR);
            $stmt->bindParam(':lname', $data['lname'], PDO::PARAM_STR);
            $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindParam(':address', $data['address'], PDO::PARAM_STR);
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Update User Profile Error: ' . $e->getMessage());
            return false;
        }
    }


    /**
     * Updates the social links for a user.
     *
     * This method updates the user's social media links (facebook, instagram, twitter, github) in the database.
     * Only the provided links will be updated, and others will remain unchanged.
     *
     * @param int $user_id The ID of the user whose social links will be updated.
     * @param array $socialLinks An associative array of social links, where the key is the 
     * platform name (e.g., 'facebook', 'github') and the value is the corresponding URL.
     *  Example: [
     *            'facebook' => 'https://facebook.com/user', 
     *            'twitter' => 'https://twitter.com/user'
     * ].
     *
     * @return bool True if the update was successful, false otherwise.
    */
    public function updateUserSocialLinks($user_id, $socialLinks) {
        try {
            // Prepare the update query
            $sql = "UPDATE {$this->links_table} 
                    SET facebook = :facebook, 
                        instagram = :instagram, 
                        twitter = :twitter, 
                        github = :github,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':facebook', $socialLinks['facebook'], PDO::PARAM_STR);
            $stmt->bindParam(':instagram', $socialLinks['instagram'], PDO::PARAM_STR);
            $stmt->bindParam(':twitter', $socialLinks['twitter'], PDO::PARAM_STR);
            $stmt->bindParam(':github', $socialLinks['github'], PDO::PARAM_STR);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

            // Execute the query
            return $stmt->execute();

        } catch (PDOException $e) {
            error_log('Update Social Links Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Updates the user's avatar in the database
     * @param int $user_id
     * @param string $avatar_filename
     * @return bool
     */
    public function updateAvatar($user_id, $avatar_filename) {
        // Update the avatar filename in the database for the given user
        $query = "UPDATE {$this->table} SET avatar = :avatar WHERE id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':avatar', $avatar_filename);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }





    /**
     * Verify user by token.
     * @param string $token
     * @return bool
    */
    public function verifyUser($token) {
        $query = 'UPDATE ' . $this->table . ' SET status = 1, verification_token = NULL WHERE verification_token = :token AND status = 0';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':token', $token);

        return $stmt->execute() && $stmt->rowCount() > 0;
    }
}
