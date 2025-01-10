<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );
require_once 'user.php';

class CTO extends User {

    public function __construct( $fullname, $email, $password ) {
        parent::__construct( $fullname, $email, $password );
    }

    public function add_to_db( $db ) {
        try {
            $query = 'INSERT INTO CTO (fullname, email, password) VALUES (?, ?, ?)';
            $stmt = $db->prepare( $query );
            $stmt->execute( [ $this->fullname, $this->email, password_hash( $this->password, PASSWORD_DEFAULT ) ] );
            return true;
        } catch ( PDOException $e ) {
            return false;
        }
    }

    static function get_CTO( $db ) {
        try {
            $query = "SELECT cto_id, fullname, email FROM CTO where status = 'active'";
            $stmt = $db->prepare( $query );
            $stmt->execute();
            $stmt->fetchAll( PDO::FETCH_ASSOC );
            return $stmt;
        } catch ( PDOException $e ) {
            return false;
        }
    }

    static function check_email( $db, $email ) {
        $check_query = "SELECT email FROM CTO WHERE email = ? and status = 'active'";
        $check_stmt = $db->prepare( $check_query );
        $check_stmt->execute( [ $email ] );
        return $check_stmt;
    }

}
?>