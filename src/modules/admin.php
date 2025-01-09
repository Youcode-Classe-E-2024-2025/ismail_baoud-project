<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'user.php';

class admin extends User
{

    public function __construct($fullname, $email, $password)
    {
        parent::__construct($fullname, $email, $password);
    }

    public function add_to_db($db)
    {
        try {
            $query = "INSERT INTO admin (fullname, email, password) VALUES (?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->execute([$this->fullname, $this->email, password_hash($this->password, PASSWORD_DEFAULT)]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    static function get_admins($db)
    {
        try {
            $query = "SELECT id,fullname, email FROM admin";
            $stmt = $db->prepare($query);
            
            
            
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            return false;
        }
    }

    static function check_email($db, $email)
    {
        $check_query = "SELECT email FROM admin WHERE email = ?";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->execute([$email]);
        return $check_stmt;
    }
   
}
?>