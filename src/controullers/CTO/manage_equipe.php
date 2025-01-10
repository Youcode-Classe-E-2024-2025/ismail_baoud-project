<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

class equipe_handling {
    private $db;

    public function __construct() {
        $datab = new ConnectionDB();
        $this->db = $datab->getConnection();
    }

    public function add_member( $m_id, $c_id ) {
        $res = new equipe( $m_id, $c_id );
        $res->add_member( $this->db );
    }

    public function _display( $id ) {

        try {
            return equipe::get_equipe( $this->db, $id );
        } catch ( PDOException $e ) {
            error_log( 'Error in category display: ' . $e->getMessage() );
            return [];
        }
    }

    public function display() {

        try {
            return equipe::get_all_equipe( $this->db );
        } catch ( PDOException $e ) {
            error_log( 'Error in category display: ' . $e->getMessage() );
            return [];
        }
    }
}

if ( isset( $_POST[ 'btn_category' ] ) ) {
    $name = $_POST[ 'name' ];
    $category = new category_handling();
    $category->getdata( $name );
    header( 'location: /CTO_dashboard' );
}

if ( isset( $_POST[ 'btn_equipe' ] ) ) {
    $id = $_POST[ 'role' ];
    $res = new equipe_handling();
    $res->add_member( $id, $_SESSION[ 'cto_id' ] );
    header( 'location: /CTO_dashboard' );
}
?>