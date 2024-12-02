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


        

    }