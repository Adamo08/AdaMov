<?php 

    class Admin extends Model{
        protected $table = 'admins';


        /**
         * Get an admin by their email.
         * @param string $email
         * @return array|false
        */ 
        public function getAdminByEmail($email) {
            $sql = "SELECT * FROM {$this->table} WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        /**
         * A function that returns the list of all admins
         * @return array
        */
        public function all() {

            $sql = "SELECT * FROM {$this->table}";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        /**
         * Counts the total number of records in the admins table.
         *
         * @return int The total number of records in the admins table.
         */
        public function count(){
            // Base Query
            $sql = "SELECT COUNT(*) FROM {$this->table}";
            // Prepare and Execute
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        }


        /**
         * Updates an admin's profile information.
         *
         * @param int $admin_id The ID of the admin to update.
         * @param array $data The key-value pairs of the fields to update.
         * @return bool Returns true on success, false on failure.
         */
        public function updateAdminProfile($admin_id, array $data) {
            try {
                // Ensure the admin_id is valid
                if (empty($admin_id) || !is_numeric($admin_id)) {
                    return false;
                }

                // Prepare the SQL statement dynamically based on provided fields
                $fields = [];
                $values = [];

                foreach ($data as $column => $value) {
                    $fields[] = "$column = ?";
                    $values[] = $value;
                }

                // Convert array to string for SQL query
                $setClause = implode(', ', $fields);
                $values[] = $admin_id;

                // Prepare and execute the update statement
                $sql = "UPDATE admins SET $setClause WHERE id = ?";
                $stmt = $this->db->prepare($sql);
                return $stmt->execute($values);

            } catch (PDOException $e) {
                error_log("Error updating admin: " . $e->getMessage());
                return false;
            }
        }

        
        /**
         * Removes an admin by their ID.
         *
         * @param int $id The ID of the admin to remove.
         * @return bool Returns true on success, false on failure.
         */
        public function removeAdmin($id) {
            try {
            // Ensure the id is valid
            if (empty($id) || !is_numeric($id)) {
                return false;
            }

            // Prepare and execute the delete statement
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();

            } catch (PDOException $e) {
                error_log("Error removing admin: " . $e->getMessage());
                return false;
            }
        }

        /**
         * Adds a new admin to the database.
         *
         * @param array $data Associative array containing admin details.
         * @return bool Returns true on success, false on failure.
         */
        public function addAdmin($data) {
            try {
                // Ensure required fields are present
                if (empty($data['fname']) || empty($data['lname']) || empty($data['email']) || empty($data['password'])) {
                    return false;
                }

                // Default avatar if not provided
                $avatar = !empty($data['avatar']) ? $data['avatar'] : 'avatars/default.svg';

                // Prepare SQL statement
                $sql = "INSERT INTO {$this->table} (fname, lname, email, password, avatar, added_by) 
                        VALUES (:fname, :lname, :email, :password, :avatar, :added_by)";
                
                $stmt = $this->db->prepare($sql);

                // Binding params
                $stmt->bindParam(':fname', $data['fname'], PDO::PARAM_STR);
                $stmt->bindParam(':lname', $data['lname'], PDO::PARAM_STR);
                $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
                $stmt->bindParam(':password', $data['password'], PDO::PARAM_STR);
                $stmt->bindParam(':avatar', $avatar, PDO::PARAM_STR);
                $stmt->bindParam(':added_by', $data['added_by'], PDO::PARAM_INT);

                return $stmt->execute();
            } catch (PDOException $e) {
                error_log("Error adding admin: " . $e->getMessage());
                return false;
            }
        }



        /**
         * Returns the avatar for the specified Admin
         * @param int $id admin's ID
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


    }