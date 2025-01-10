<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

class info_member {

    private $db;

    public function __construct() {
        $datab = new ConnectionDB();
        $this->db = $datab->getConnection();
    }

    public function get_memberinfo( $id ) {
        $members = member::get_memberinfo( $this->db, $id );

        return $members;
    }
}
?>