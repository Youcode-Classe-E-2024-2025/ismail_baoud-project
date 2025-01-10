<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

class _tache {

    private $db;

    public function __construct() {
        $datab = new ConnectionDB();
        $this->db = $datab->getConnection();
    }

    public function add_tache( $title, $description, $projet_id, $member_id, $priority, $category_id, $date ) {
        $project = new tache( $title, $description, $projet_id, $member_id, $priority, $category_id, $date );
        $project->add_to_db( $this->db );
    }

    public function display_taches() {
        $taches = tache::get_taches( $this->db );

        return $taches;
    }
}
if ( isset( $_POST[ 'btn_tache' ] ) ) {
    $title = $_POST[ 'title' ];
    $description = $_POST[ 'description' ];
    $projet_id = $_POST[ 'projet_id' ];
    $member_id = $_POST[ 'member_id' ];
    $priority = $_POST[ 'priority' ];
    $category_id = $_POST[ 'category_id' ];
    $date = $_POST[ 'date' ];

    $res = new _tache();
    $res->add_tache( $title, $description, $projet_id, $member_id, $priority, $category_id, $date );
    header( 'location: /CTO_dashboard' );
}
?>