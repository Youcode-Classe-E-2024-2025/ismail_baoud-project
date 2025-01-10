<?php

class tache {
    private $title;
    private $description;
    private $projet_id;
    private $member_id;
    private $priority;
    private $category_id;
    private $date;

    public function __construct( $title, $description, $projet_id, $member_id, $priority, $category_id, $date ) {
        $this->title = $title;
        $this->description = $description;
        $this->projet_id = $projet_id;
        $this->member_id = $member_id;
        $this->priority = $priority;
        $this->category_id = $category_id;
        $this->date = $date;
    }

    public function add_to_db( $db ) {
        try {
            $query = 'INSERT INTO tache (title , description, date, tag, member_id, category_id,projet_id) VALUES (?, ?, ?, ?, ?, ?, ?)';
            $stmt = $db->prepare( $query );

            $stmt->execute( [ $this->title, $this->description, $this->date, $this->priority, $this->member_id, $this->category_id, $this->projet_id ] );
            return true;
        } catch ( PDOException $e ) {
            return false;
        }
    }

    static function get_taches( $conn ) {
        try {
            $query = "SELECT t.id,t.title, t.description, t.status, t.date, t.tag, c.name, 
                     m.fullname, p.title as projet_name
              FROM tache t 
              INNER JOIN projet p ON t.projet_id = p.id 
              INNER JOIN category c ON t.category_id = c.category_id 
              INNER JOIN member m ON t.member_id = m.member_id 
              WHERE t.status = 'A_FAIRE' and p.status = 'ACTIVE' and m.status = 'active' and m.CTO_id is not NULL and t.deleted = 'active'";

            $stmt = $conn->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            error_log( 'Error displaying categories: ' . $e->getMessage() );

        }

    }

    static function get_todo_taches( $conn, $id ) {
        try {
            $query = "SELECT t.id, t.title, t.description, t.status, t.date, t.tag, c.name, 
                     p.title as projet_name
              FROM tache t 
              INNER JOIN projet p ON t.projet_id = p.id 
              INNER JOIN category c ON t.category_id = c.category_id
              INNER JOIN member m ON m.member_id = t.member_id
              WHERE m.member_id = $id and t.status = 'A_FAIRE' and p.status = 'ACTIVE' and m.status = 'active' and m.CTO_id is not NULL and t.deleted = 'active'";

            $stmt = $conn->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            error_log( 'Error displaying categories: ' . $e->getMessage() );

        }
    }
    static function get_doing_taches( $conn, $id ) {
        try {
            $query = "SELECT t.id, t.title, t.description, t.status, t.date, t.tag, c.name, 
                     p.title as projet_name
              FROM tache t 
              INNER JOIN projet p ON t.projet_id = p.id 
              INNER JOIN category c ON t.category_id = c.category_id
              INNER JOIN member m ON m.member_id = t.member_id
              WHERE m.member_id = $id and t.status = 'EN_COURS' and p.status = 'ACTIVE' and m.status = 'active' and m.CTO_id is not NULL and t.deleted = 'active'";
            $stmt = $conn->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            error_log( 'Error displaying categories: ' . $e->getMessage() );

        }
    }
    static function get_done_taches( $conn, $id ) {
        try {
            $query = "SELECT t.id, t.title, t.description, t.status, t.date, t.tag, c.name, 
                     p.title as projet_name
              FROM tache t 
              INNER JOIN projet p ON t.projet_id = p.id 
              INNER JOIN category c ON t.category_id = c.category_id
              INNER JOIN member m ON m.member_id = t.member_id
              WHERE m.member_id = $id and t.status = 'TERMINER' and p.status = 'ACTIVE' and m.status = 'active' and m.CTO_id is not NULL and t.deleted = 'active'";

            $stmt = $conn->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            error_log( 'Error displaying categories: ' . $e->getMessage() );

        }
    }

    static function get_all_taches( $conn ) {
        try {
            $query = 'SELECT * FROM tache';

            $stmt = $conn->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            error_log( 'Error displaying categories: ' . $e->getMessage() );

        }

    }

    static function get_todo( $conn ) {
        try {
            $query = "SELECT * FROM tache where status = 'A_FAIRE'";

            $stmt = $conn->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            error_log( 'Error displaying categories: ' . $e->getMessage() );

        }

    }

    static function get_doing( $conn ) {
        try {
            $query = "SELECT * FROM tache where status = 'EN_COURS'";

            $stmt = $conn->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            error_log( 'Error displaying categories: ' . $e->getMessage() );

        }

    }

    static function get_done( $conn ) {
        try {
            $query = "SELECT * FROM tache where status = 'TERMINER'";

            $stmt = $conn->prepare( $query );
            $stmt->execute();
            return $stmt->fetchAll( PDO::FETCH_ASSOC );
        } catch ( PDOException $e ) {
            error_log( 'Error displaying categories: ' . $e->getMessage() );

        }

    }

}
?>