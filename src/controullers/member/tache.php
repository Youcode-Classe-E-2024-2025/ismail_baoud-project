<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

class tache_member {

    private $db;

    public function __construct() {
        $datab = new ConnectionDB();
        $this->db = $datab->getConnection();
    }

    public function display_todo_taches( $id ) {
        $taches = tache::get_todo_taches( $this->db, $id );
        return $taches;
    }

    public function display_doing_taches( $id ) {
        $taches = tache::get_doing_taches( $this->db, $id );
        return $taches;
    }

    public function display_done_taches( $id ) {
        $taches = tache::get_done_taches( $this->db, $id );
        return $taches;
    }
}

?>