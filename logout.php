<?php 
require_once './classes/function.php';
$obj= new web();

if($obj->DoLogout())
{
    header("Refresh:0.5; url=login.php");   
}
?>