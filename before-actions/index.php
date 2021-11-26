<?php

$except = ['auth/login'];
if(isset($_GET['page']) && isset($_SESSION['auth']) && !in_array($_GET['page'],$except) ){
    $user = $_SESSION['auth'];

    $builder = new Builder;
    $json_modules = $builder->get_content('modules');

    $data_key = null;

    $module = [];

    foreach ($json_modules as $key => $value) {

        $value = (array) $value;

        if($value['code'] == $user['role']){
            $data_key = $key;
            $module = $value;
            break;
        }
    }

    unset($module['code']);

    $active_modules = array_keys($module);
    $allowed = false;
    foreach($active_modules as $active_module)
    {
        // echo $_GET['page'] .' '.$active_module;
        if(startWith($_GET['page'],$active_module))
        {
            $allowed = true;
            break;
        }
    }

    if(!$allowed)
    {
        echo "Error 403. Forbidden. <a href='$_SERVER[HTTP_REFERER]'>Kembali</a>";
        exit;
    }


}
