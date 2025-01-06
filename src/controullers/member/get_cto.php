<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class info_cto
{

    private $db;

    public function __construct()
    {
        $datab = new ConnectionDB();
        $this->db = $datab->getConnection();
    }

    public function get_cto($id)
    {
        $query = "select CTO_id from member where member_id = $id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>