<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $installation->app_name ?></title>
    <link rel="shortcut icon" href="<?=get_file_storage('installation/'.$installation->logo)?>" type="image/x-icon">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
    <div class="login flex h-screen">
        <div class="shadow p-8 m-auto lg:w-2/6 rounded-md max-w-screen-sm">
            <img src="<?=get_file_storage('installation/'.$installation->logo)?>" width="70px" alt="" class="mx-auto">
            <div class="text-center my-4">
                <h3 class="font-semibold text-3xl"><?= $installation->app_name ?></h3>
                <h4 class="font-semibold text-xl">Masuk untuk melanjutkan</h4>
            </div>

            <div class="login-form">
                <form id="login-form" action="" method="post" onsubmit="return doLogin();">
                    <div class="form-group mb-2">
                        <input type="text" placeholder="Nama Pengguna" name="username" class="p-2 w-full border rounded">
                    </div>

                    <div class="form-group mb-2">
                        <input type="password" placeholder="Kata Sandi" name="password" class="p-2 w-full border rounded">
                    </div>

                    <div class="form-group">
                        <button class="w-full p-2 bg-indigo-800 text-white rounded" name="login" id="btn-login">Masuk</button>
                    </div>
                </form>
            </div>

            <div class="text-center text-sm mt-8 mb-4 font-semibold text-indigo-800">
                <?= $installation->app_name ?><br>
                Copyright &copy; 2021
            </div>
        </div>
    </div>
    <script>
    function resetForm(){
        document.querySelector("#login-form").reset()
        var btnLogin = document.querySelector('#btn-login')
        btnLogin.innerHTML = "Masuk"
        btnLogin.disabled = false
    }
    async function doLogin()
    {
        event.preventDefault()
        var btnLogin = document.querySelector('#btn-login')
        btnLogin.innerHTML = "Silahkan Tunggu..."
        btnLogin.disabled = true
        var username = document.querySelector('input[name=username]')
        var password = document.querySelector('input[name=password]')
        var request = await fetch('<?=API_URL?>auth/login',{
            method:'POST',
            headers:{
                'content-type':'application/x-www-form-urlencoded'
            },
            body:'username='+username.value+'&password='+password.value
        })
        var response = await request.json()
        alert(response.message)
        if(response.status == 'fail')
            resetForm()
        else
            location.reload()
        
        return false;
    }
    </script>
</body>
</html>
