<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

class category_handling {
    private $db;

    public function __construct() {
        $datab = new ConnectionDB();
        $this->db = $datab->getConnection();
    }

    public function getdata( $name, $id ) {
        $category = new category( $name, $id );
        $category->add_to_db( $this->db );
    }

    static function display( $id ) {
        $datab = new ConnectionDB();
        $db = $datab->getConnection();

        try {
            $query = "SELECT category_id, name FROM category where cto_id = $id ORDER BY name ASC";
            $stmt = $db->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            error_log( 'Error in category display: ' . $e->getMessage() );
            return [];
        }
    }
}

if ( isset( $_POST[ 'btn_category' ] ) ) {

    $names = $_POST[ 'dynamic_fields' ];
    $id = $_SESSION[ 'cto_id' ];
    foreach ( $names as $name ) {

        $category = new category_handling();
        $category->getdata( $name, $id );
    }
    header( 'location: /CTO_dashboard' );
}
?>