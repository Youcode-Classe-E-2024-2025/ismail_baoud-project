<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

class equipe {
    private $cto_id;
    private $member_id;

    public function __construct( $member_id, $cto_id ) {
        $this->member_id = $member_id;
        $this->cto_id = $cto_id;
    }

    public function add_member( $conn ) {
        try {
            $query = 'UPDATE member SET CTO_id = ? WHERE member_id = ? ';
            $stmt = $conn->prepare( $query );
            $stmt->execute( [ $this->cto_id, $this->member_id ] );
            return true;
        } catch ( PDOException $e ) {
            return false;
        }
    }
    static function get_equipe( $db, $id ) {
        try {
            $query = "SELECT member_id,fullname, email FROM member where CTO_id = $id and status = 'active'";
            $stmt = $db->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            return false;
        }
    }
    static function get_all_equipe( $db ) {
        try {
            $query = "SELECT member_id,fullname, email FROM member where CTO_id is null and status = 'active'";
            $stmt = $db->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            return false;
        }
    }
}