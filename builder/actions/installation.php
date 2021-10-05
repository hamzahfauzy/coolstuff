<?php

$builder = new Builder;
$fields  = $builder->get_installation_field();

if(request() == 'POST')
{
    $upload = upload($_FILES['logo'],'installation');
    if($upload['status'] == "success")
    {
        $installation_data = $_POST;
        $installation_data['logo'] = $upload['filename'];
        $installation_data = json_encode($installation_data);
        if($builder->set_content('installation',$installation_data))
        {
            header('location:index.php');
            return;
        }
    }
}