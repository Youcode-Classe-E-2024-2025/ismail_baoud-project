<?php 
if (!class_exists('role_permession')) {
    class role_permession {
        private $db;

        public function __construct(){
            $db = new ConnectionDB;
            $conn = $db->getConnection();
            $this->db = $conn;
        }

        public function add_roles($role){
            $res = new role($role);
            $res->add_to_db($this->db);
        }
        public function get_roles(){
            return role::get_role($this->db);
        
        }

        public function add_permessions($roles){
            foreach ($roles as $role_id) {
                $query = "DELETE FROM role_permission WHERE role_id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$role_id]);
        
                for ($permission_id = 1; $permission_id <= 3; $permission_id++) {
                    $permissionKey = "role{$role_id}_permission{$permission_id}";
                    if (isset($_POST[$permissionKey])) {
                        $insertQuery = "INSERT INTO role_permission (role_id, permession_id) VALUES (?, ?)";
                        $stmt = $this->db->prepare($insertQuery);
                        $stmt->execute([$role_id, $permission_id]);
                    }
                }
            }
        }



        public function role($role){
            $query = "SELECT role_id from ROLE where role_name = '$role'";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["btn_permession"])) {
    
    $roles = $_POST['roles'];
    $db = new role_permession();
    $conn = $db->add_permessions($roles);

    

    header("location: /CTO_dashboard");
}

if(isset($_POST["btn_role"])){
    $role= $_POST["role_create"];
    $res = new role_permession();
    $res->add_roles($role);
    
    header("location: /CTO_dashboard");

}


?>