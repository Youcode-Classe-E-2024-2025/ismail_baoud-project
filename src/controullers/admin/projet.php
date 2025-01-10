<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

class all_projets {

    private $db;

    public function __construct() {
        $datab = new ConnectionDB();
        $this->db = $datab->getConnection();
    }

    public function display() {
        $projets = projet::get_all_projects( $this->db );

        return $projets;
    }
}
?>