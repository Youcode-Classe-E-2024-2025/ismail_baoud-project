<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

class Category {
    private $name;
    private $id;

    public function __construct( $name, $id ) {
        $this->name = $name;
        $this->id = $id;
    }

    public function add_to_db( $conn ) {
        try {
            $query = 'INSERT INTO category (name,cto_id) VALUES (? , ?)';
            $stmt = $conn->prepare( $query );
            $stmt->execute( [ $this->name, $this->id ] );
            return true;
        } catch ( PDOException $e ) {
            error_log( 'Error adding category: ' . $e->getMessage() );
            return false;
        }
    }

    public static function display( $conn, $id ) {
        try {
            $query = "SELECT category_id, name FROM category where cto_id = $id  ORDER BY name ASC";
            $stmt = $conn->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            error_log( 'Error displaying categories: ' . $e->getMessage() );
            return [];
        }
    }
}
?>