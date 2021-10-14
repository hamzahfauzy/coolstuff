<?php
$role = NULL;
$message = [];
$auth_data = [];
// from connection

// from builder
$builder = new Builder;
$installation = $builder->get_installation();

if(!empty($installation) && ($_POST['username']==$installation->username&&$_POST['password']==$installation->password))
{
    $role = "builder";
    $auth_data = [
        // 'token'    => $data['token'],
        'username' => $installation->username,
        'id' => 1,
        'role' => $role
    ];

    $message = [
        'status' => 'success',
        'message' => 'Login Sukses'
    ];
}
else
{
    $message = [
        'status' => 'fail',
        'message' => 'Login Gagal'
    ];
}

if($auth_data)
    $_SESSION['auth'] = $auth_data;
echo json_encode($message);