<?php
$msg = get_flash_msg('success');

$builder = new Builder;
$all_fields  = $builder->get_content('role','sample');
$all_fields  = (array) $all_fields;

$roles       = $builder->get_content('roles');
$values      = (array) $roles[$_GET['key']];
$keys        = array_keys($values);
$fields      = [];

foreach($keys as $key)
{
    $fields[$key] = [
        'type' => $all_fields[$key],
        'value' => $values[$key]
    ];
}

if(request() == 'POST')
{
    $role_data = $_POST;
    $roles = (array) $roles;
    $roles[$_GET['key']] = $role_data;
    $role_data = json_encode($roles);
    if($builder->set_content('roles',$role_data))
    {
        set_flash_msg(['success'=>'Data berhasil di update']);
        header('location:index.php?page=builder/roles/index');
        return;
    }
    // $installation_data = $_POST;
    // if(isset($_FILES['logo']) && !empty($_FILES['logo']['name']))
    // {
    //     $upload = upload($_FILES['logo'],'installation');
    //     $installation_data['logo'] = $upload['filename'];
    // }
    // else
    //     $installation_data['logo'] = $fields['logo']['value'];
    // $installation_data = json_encode($installation_data);
    // if($builder->set_content('installation',$installation_data))
    // {
    //     set_flash_msg(['success'=>'Data berhasil di update']);
    //     header('location:index.php?page=builder/setting/index');
    //     return;
    // }
}