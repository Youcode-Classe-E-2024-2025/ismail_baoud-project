<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

class member extends User {
    private $image;

    public function __construct( $fullname, $email, $password, $image ) {
        parent::__construct( $fullname, $email, $password );
        $this->image = $image;

    }

    public function add_to_db( $db ) {
        try {
            $query = 'INSERT INTO member (fullname, email, password, image) VALUES (:fullname, :email, :password, :image)';
            $stmt = $db->prepare( $query );
            $hashed_password = password_hash( $this->password, PASSWORD_DEFAULT );
            $stmt->bindparam( ':fullname', $this->fullname );
            $stmt->bindparam( ':email', $this->email );
            $stmt->bindparam( ':password', $hashed_password );
            $stmt->bindParam( ':image', $this->image, PDO::PARAM_LOB );
            $stmt->execute();
            return true;
        } catch ( PDOException $e ) {
            return false;
        }
    }

    static function get_members( $db ) {
        try {
            $query = "SELECT * FROM member where status = 'active'";
            $stmt = $db->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );

        } catch ( PDOException $e ) {
            return false;
        }
    }
    static function get_memberinfo( $db, $id ) {
        try {
            $query = "SELECT * FROM member where status = 'active' and member_id = $id";
            $stmt = $db->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );

        } catch ( PDOException $e ) {
            return false;
        }
    }

    static function check_email( $db, $email ) {
        $check_query = "SELECT email FROM member WHERE email = ? and status = 'active'";
        $check_stmt = $db->prepare( $check_query );
        $check_stmt->execute( [ $email ] );
        return $check_stmt;
    }
}
?>