<?php

class projet {
    private $name;
    private $description;
    private $CTO_id;
    private $visibility;

    public function __construct( $name, $description, $visibility, $id ) {
        $this->name = $name;
        $this->description = $description;
        $this->visibility = $visibility;
        $this->CTO_id = $id;
    }

    public function add_to_db( $conn ) {
        try {
            $query = 'INSERT INTO projet (title,description, cto_id,visibility) VALUES (?, ?, ?, ?)';
            $stmt = $conn->prepare( $query );
            $stmt->execute( [ $this->name, $this->description, $this->CTO_id, $this->visibility ] );
            return true;
        } catch ( PDOException $e ) {
            return false;
        }
    }

    static function get_all_projects( $conn ) {
        try {
            $query = "SELECT p.title,p.id, p.description,p.status ,p.visibility , c.fullname FROM projet p inner join CTO c ON p.cto_id = c.cto_id where p.status = 'ACTIVE' ORDER BY title ASC ";
            $stmt = $conn->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            error_log( message: 'Error displaying categories: ' . $e->getMessage() );

        }
    }
    static function get_projects( $conn, $id ) {
        try {
            $query = "SELECT id,title, description,status,visibility FROM projet where cto_id = $id and status = 'ACTIVE' ORDER BY title ASC ";
            $stmt = $conn->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            error_log( 'Error displaying categories: ' . $e->getMessage() );

        }

    }

    static function get_public_projects( $conn ) {
        try {
            $query = "SELECT id,title, description,status FROM projet where visibility = 'public' and status = 'ACTIVE' ORDER BY title ASC ";
            $stmt = $conn->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            error_log( 'Error displaying categories: ' . $e->getMessage() );

        }
    }

    static function project_complet( $conn ) {
        try {
            $query = "SELECT * FROM projet where status = 'TERMINER'";

            $stmt = $conn->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            error_log( 'Error displaying categories: ' . $e->getMessage() );

        }

    }
    static function project_active( $conn ) {
        try {
            $query = "SELECT * FROM projet where status = 'ACTIVE'";

            $stmt = $conn->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            error_log( 'Error displaying categories: ' . $e->getMessage() );

        }

    }

}
?>