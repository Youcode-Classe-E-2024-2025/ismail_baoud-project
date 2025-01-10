<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

class statistics {

    private $db;

    public function __construct() {
        $datab = new ConnectionDB();
        $this->db = $datab->getConnection();
    }

    public function members() {
        $members = member::get_members( $this->db );

        return $members;
    }

    public function project_complet() {
        $projets = projet::project_complet( $this->db );

        return $projets;
    }

    public function project_active() {
        $projets = projet::project_active( $this->db );

        return $projets;
    }

    public function taches() {
        $taches = tache::get_all_taches( $this->db );

        return $taches;
    }

    public function todo() {
        $taches = tache::get_todo( $this->db );

        return $taches;
    }

    public function doing() {
        $taches = tache::get_doing( $this->db );

        return $taches;
    }

    public function done() {
        $taches = tache::get_done( $this->db );

        return $taches;
    }

}
$total_members = 0;
$complete_projects = 0;
$active_projects = 0;
$total_taches = 0;
$todo = 0;
$doing = 0;
$done = 0;

$stat = new statistics();
$members = $stat->members();

foreach ( $members as $member ) {
    $total_members++;
}
$stat = new statistics();
$projects = $stat->project_complet();
foreach ( $projects as $project ) {
    $complete_projects++;
}
$stat = new statistics();
$projects = $stat->project_active();
foreach ( $projects as $project ) {
    $active_projects++;
}
$stat = new statistics();
$taches = $stat->taches();
foreach ( $taches as $tache ) {
    $total_taches++;
}
$stat = new statistics();
$taches = $stat->todo();
foreach ( $taches as $tache ) {
    $todo++;
}
$stat = new statistics();
$taches = $stat->doing();
foreach ( $taches as $tache ) {
    $doing++;
}
$stat = new statistics();
$taches = $stat->done();
foreach ( $taches as $tache ) {
    $done++;
}

?>

