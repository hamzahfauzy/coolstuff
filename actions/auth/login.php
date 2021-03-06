<?php

$builder = new Builder;
$installation = $builder->get_installation();
$msg = get_flash_msg('fail');

if(isset($_SESSION['auth']))
{
    header('location:index.php?page=builder/home/dashboard');
    return;
}

if(request() == 'POST')
{
    require '../helpers/QueryBuilder.php';
    $qb = new QueryBuilder();
    $user = $qb->select("USERS")
                ->where('username',$_POST['username'])
                ->where('password',$_POST['password'])
                ->first();

    if($user)
    {
        $auth_data = [
            // 'token'    => $data['token'],
            'username' => $_POST['username'],
            'role' => $user['WEWENANG']
        ];

        $_SESSION['auth'] = $auth_data;
        header('location:index.php?page=builder/home/dashboard');
        return;
    }

    set_flash_msg(['fail'=>'Login Gagal']);
    header('location:index.php?page=auth/login');
    return;

}