<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

class __delete {

    private $db;

    public function __construct() {
        $datab = new ConnectionDB();
        $this->db = $datab->getConnection();
    }

    public function delete_member( $id ) {
        $query = "UPDATE member SET cto_id = null where member_id = $id";
        $stmt = $this->db->prepare( $query );
        $stmt->execute();
        return $stmt->fetch();

    }

    public function delete_projet( $id ) {
        $query = "UPDATE projet SET status = 'DEACTIVE' where id = $id";
        $stmt = $this->db->prepare( $query );
        $stmt->execute();
        return $stmt->fetch();

    }

    public function delete_tache( $id ) {
        $query = "UPDATE tache SET deleted = 'deactive' where id = $id";
        $stmt = $this->db->prepare( $query );
        $stmt->execute();
        return $stmt->fetch();

    }
}
if ( isset( $_POST[ 'deactive_member' ] ) ) {
    $id = $_POST[ 'member_id' ];
    $res = new __delete();
    $res->delete_member( $id );
    header( 'location: /CTO_dashboard' );
}

if ( isset( $_POST[ 'deactive_tache' ] ) ) {
    $id = $_POST[ 'tache_id' ];
    $res = new __delete();
    $res->delete_tache( $id );
    header( 'location: /CTO_dashboard' );
}

if ( isset( $_POST[ 'deactive_projet' ] ) ) {
    $id = $_POST[ 'projet_id' ];
    $res = new __delete();
    $res->delete_projet( $id );
    header( 'location: /CTO_dashboard' );
}

?>