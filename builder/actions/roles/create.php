<?php
$builder = new Builder;
$fields  = $builder->get_content('role','sample');

if(request() == 'POST')
{
    $builder = new Builder;
    $roles  = $builder->get_content('roles');
    $roles[] = $_POST;
    $role_data = json_encode($roles);
    if($builder->set_content('roles',$role_data))
    {
        set_flash_msg(['success'=>'Data berhasil di simpan']);
        header('location:index.php?page=builder/roles/index');
        return;
    }
}