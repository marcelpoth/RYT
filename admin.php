<?php

    session_start();
    if($_SESSION['loggedin'] != true){
        Header('Location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="login.css">
    <title>Rate your Teacher!</title>
</head>
<body>
    <h1>ADMIN!</h1>
    <p><input type='submit' name='test' value='Jag gör ingenting'></p>

</body>
</html>