<?php
ini_set('session.save_path','../session');
session_start();
require '../functions.php';

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
    if(isset($_SESSION['auth']))
        $page = 'builder/home/dashboard';
    
    if(isset($_GET['page']) && !empty($_GET['page']))
    {
        if(isset($page_map[$_GET['page']]))
            $page = $page_map[$_GET['page']];
        else
            $page = $_GET['page'];
    }
    else
    {    
        $page = 'landing';
        // $page = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : $page;
    }
    // if(!isset($_SESSION['auth']))

}

load($page,$action);