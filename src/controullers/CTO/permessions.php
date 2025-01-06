<?php 
if(isset($_POST["btn_permession"])){
    $create = isset($_POST["role1_create"])  ? "on" : "off";
    $delete = isset($_POST["role1_delete"]) ? "on" : "off";
    $update = isset($_POST["role1_update"])  ? "on" : "off";
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

?>