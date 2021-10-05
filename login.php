<?php

if(isset($_POST['login']))
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => API_URL.'site/login',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array('username' => $_POST['username'],'password' => $_POST['password']),
    CURLOPT_HTTPHEADER => array(
        'Cookie: PHPSESSID=91e11000f3e92cca1032aa639e7d4929; _csrf-endpointapi=8ea8830a85483860774b028521c7fd3e1e92380a0e1e2ab2142f128ce8581885a%3A2%3A%7Bi%3A0%3Bs%3A17%3A%22_csrf-endpointapi%22%3Bi%3A1%3Bs%3A32%3A%22LbJL7XKXAhWi_BlsI1uQNhhwcz8l8Ffz%22%3B%7D; _identity=f618d2e8fff4a7302f7879e75aa47a2e595096d3228433dfa48f49c8019e6829a%3A2%3A%7Bi%3A0%3Bs%3A9%3A%22_identity%22%3Bi%3A1%3Bs%3A47%3A%22%5B17%2C%22TEg5dwq4kIjVtyF9oVAqT_ScsG6tYdo2%22%2C2592000%5D%22%3B%7D'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $response = json_decode($response);
    if($response->message == 'Login gagal')
        echo "Login gagal";
    else
    {
        $_SESSION['auth'] = [
            'token'    => $response->token,
            'username' => $response->username,
        ];
        header('location:index.php');
        die();
    }
}