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
        <div class="shadow p-8 m-auto lg:w-2/6 rounded-md max-w-screen-sm" style="max-width:450px">
            <img src="<?=get_file_storage('installation/'.$installation->logo)?>" width="70px" alt="" class="mx-auto">
            <div class="text-center my-4">
                <h3 class="font-semibold text-3xl"><?= $installation->app_name ?></h3>
                <h4 class="font-semibold text-xl">Masuk untuk melanjutkan</h4>
            </div>

            <div class="login-form">
                <?php if($msg): ?>
                <div id="login-error" class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-6" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                        <div class="flex items-center">
                        <p class="m-0"><b>Login Gagal!</b> Username dan Password salah</p>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                <form id="login-form" action="index.php?action=auth/login" onsubmit="doLogin" method="post">
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
    function doLogin()
    {
        event.preventDefault()
        var btnLogin = document.querySelector('#btn-login')
        btnLogin.innerHTML = "Silahkan Tunggu..."
        btnLogin.disabled = true
    }
    </script>
</body>
</html>
