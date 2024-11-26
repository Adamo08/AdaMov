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
