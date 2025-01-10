<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

class _delete {

    private $db;

    public function __construct() {
        $datab = new ConnectionDB();
        $this->db = $datab->getConnection();
    }

    public function delete_member( $id ) {
        $query = "UPDATE member SET status = 'deactivate' where member_id = $id";
        $stmt = $this->db->prepare( $query );
        $stmt->execute();
        return $stmt->fetch();

    }

    public function delete_CTO( $id ) {
        $query = "UPDATE CTO SET status = 'deactivate' where cto_id = $id";
        $stmt = $this->db->prepare( $query );
        $stmt->execute();
        return $stmt->fetch();

    }

    public function delete_projet( $id ) {
        $query = "UPDATE projet SET status = 'DEACTIVE' where id = $id
                    ";
        $stmt = $this->db->prepare( $query );
        $stmt->execute();
        return $stmt->fetch();

    }
}
if ( isset( $_POST[ 'deactive' ] ) ) {
    $id = $_POST[ 'member_id' ];
    $res = new _delete();
    $res->delete_member( $id );
    header( 'location: /admin_dashboard' );
}

if ( isset( $_POST[ 'deactive_CTO' ] ) ) {
    $id = $_POST[ 'cto_id' ];
    $res = new _delete();
    $res->delete_CTO( $id );
    header( 'location: /admin_dashboard' );
}

if ( isset( $_POST[ 'deactive_projet' ] ) ) {
    $id = $_POST[ 'projet_id' ];
    $res = new _delete();
    $res->delete_projet( $id );
    header( 'location: /admin_dashboard' );
}

?>