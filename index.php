<?php
session_start();
require_once "config/connectiondb.class.php";
include_once "helpers/debug.php";
include_once "src/modules/admin.php";
include_once "src/modules/category.php";
include_once "src/modules/CTO.class.php";
include_once "src/modules/equipe.php";
include_once "src/modules/role.php";
include_once "src/modules/member.classe.php";
include_once "src/modules/projet.classe.php";
require_once "src/modules/tache.class.php";
require_once "src/controullers/member/tache.php";
require_once "src/controullers/member/getinformations.php";
require_once "src/controullers/member/statistics.php";
require_once "src/controullers/CTO/projet.php";
require_once "src/controullers/CTO/category_add.php";
require_once "src/controullers/CTO/tache.php";
require_once "src/controullers/CTO/CSRF.php";
require_once "src/controullers/CTO/permessions.php";
require_once "src/controullers/CTO/manage_equipe.php";
require_once "src/controullers/admin/member.php";
require_once "src/controullers/admin/projet.php";
require_once "src/controullers/admin/statistics.php";




$uri = parse_url($_SERVER["REQUEST_URI"])["path"];
$routes = [
    "/"=>"public/index.php",
    "/index.php"=>"public/index.php",
    "/login"=>"src/controullers/login.php",
    "/signup"=>"src/controullers/signup.php",
    "/logOut"=>"src/controullers/logOut.php",
    "/admin_dashboard"=>"src/views/admin/dashboard_admin.php",
    "/CTO_dashboard"=>"src/views/CTO/dashboard_CTO.php",
    "/member_dashboard"=>"src/views/member/dashboard_member.php",
    "/add_CTO"=>"src/controullers/admin/CTO_handl.php",
    "/delete_by_admin"=>"src/controullers/admin/delete.php",
    "/delete_by_CTO"=>"src/controullers/CTO/delete.php",
    "/projet_create"=>"src/controullers/CTO/projet.php",
    "/manage_equipe"=>"src/controullers/CTO/manage_equipe.php",
    "/tache"=>"src/controullers/CTO/tache.php",
    "/category"=>"src/controullers/CTO/category_add.php"

];

if(array_key_exists($uri,$routes)){
    require $routes[$uri];
}else{
    require "error/404.php";
}

?>