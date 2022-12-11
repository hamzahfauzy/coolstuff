<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Drive Videos Login Page</title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
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
    Loading...
    <script>
    async function doLogin()
    {
        var request = await fetch('<?=API_URL?>site/validate-token?token=<?=$_GET['token']?>')
        var response = await request.json()
        if(request.status != 200 || response.message == 'Login gagal')
        {
            alert('Login Gagal! Email atau Password Salah')
            location='index.php'
            return
        }
        response.message = 'Login Sukses'
        fetch('?action=auth/login',{
            method:'POST',
            headers:{
                'content-type':'application/json'
            },
            body:JSON.stringify(response)
        })
        .then(res => res.text())
        .then(res => {
            if(res == "Sukses")
                location='index.php'
        })
        return false;
    }
    doLogin()
    </script>
</body>
</html>
