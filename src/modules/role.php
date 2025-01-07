<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Category
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function add_to_db($conn)
    {
        try {
            $query = "INSERT INTO ROLE (role_name) VALUES (?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([$this->name]);
            return true;
        } catch (PDOException $e) {
            error_log("Error adding category: " . $e->getMessage());
            return false;
        }
    }
}
?>