<?php 
class role_permession {
    private $db;
}
if(isset($_POST["btn_permession"])){
    $role = $_POST["role"];
    $create = isset($_POST["role1_create"])  ? "on" : "off";
    $delete = isset($_POST["role1_delete"]) ? "on" : "off";
    $update = isset($_POST["role1_update"])  ? "on" : "off";
    echo $role;
    if($create == "on"){

        echo $create;
    }
    if($delete == "on"){

        
        echo $delete;
    }
    if($update == "on"){

        echo $update;
    }
    
}
if(isset($_POST["btn_role"])){
    $role= $_POST["role_create"];
    
}


?>