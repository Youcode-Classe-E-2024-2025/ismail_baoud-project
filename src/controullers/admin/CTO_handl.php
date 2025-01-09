<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// echo "<pre>";
// var_dump(get_declared_classes());
// echo "<pre>";


class add_CTO
{

    private $db;

    public function __construct()
    {
        $datab = new ConnectionDB();
        $this->db = $datab->getConnection();
    }

    public function add_CTO($fullname, $email, $password)
    {
        $res = new CTO($fullname, $email, $password);
        $res->add_to_db($this->db);
    }

    public function display_member($id)
    {
        $query = "select * from member where member_id = $id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch();

    }
    public function delet($id)
    {
        $query = "DELETE FROM tache WHERE member_id = $id;
                  delete from member where member_id = $id
";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch();

    }


    public function display_members()
    {
        $query = "select * from member";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function display_CTO()
    {
        $query = "select * from CTO where status = 'active'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function display()
    {
        $CTOs = CTO::get_all_CTOs($this->db);
        return $CTOs;
    }
}

if (isset($_POST["CTO_create"])) {
    $id = $_POST["CTO_id"];
    $res = new add_CTO();
    $result = $res->display_member($id);
    $fullname = $result["fullname"];
    $email = $result["email"];
    $password = "CTOpass2025";

    $res = new add_CTO();
    $res->add_CTO($fullname, $email, $password);

    $res = new add_CTO();
    $res->delet($id);
    header("location:/admin_dashboard");
}




?>