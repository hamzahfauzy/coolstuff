<?php
error_reporting(E_ALL);
ini_set('display_errors', false);
ini_set('session.save_path','../session');
session_start();
require '../functions.php';

require '../before-actions/index.php';

if(isset($_GET['action']) && !empty($_GET['action']))
{
    load_action($_GET['action']);
    die();
}

$page_map = require '../config/page_map.php';

$page = 'landing';
$action = 1;
$builder = new Builder;
$installation = $builder->get_installation();
if($installation==false)
{
    $page = 'builder/installation';
    $action = false;
}
else
{     
    if(isset($_GET['page']) && !empty($_GET['page']))
    {
        if(isset($page_map[$_GET['page']]))
            $page = $page_map[$_GET['page']];
        else
            $page = $_GET['page'];
    }

    if(stringContains($page,'builder') && !isset($_SESSION['auth']))
    {
        header('location:index.php?page=auth/login');
        die();
    }

}

load($page,$action);

?>

<style>
    @media print{
            *{
                font-family:Arial;
            }
        }
</style>