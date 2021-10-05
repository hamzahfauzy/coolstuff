<?php
$builder = new Builder;
$roles       = $builder->get_content('roles');
$roles       = (array) $roles;
unset($roles[$_GET['key']]);

$role_data = json_encode($roles);
if($builder->set_content('roles',$role_data))
{
    set_flash_msg(['success'=>'Data berhasil di hapus']);
    header('location:index.php?page=builder/roles/index');
    return;
}