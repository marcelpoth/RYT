<?php
    include '../config.php';
    $db = new PDO("mysql:host=localhost;dbname={$dbprefix}rateyourteacherdb;charset=utf8",
    $username, $password);

    if(isset($_POST['submit'])){
        $mail = $_GET['email'];
        $hash = $_GET['hash'];

        $sql = "SELECT * FROM user WHERE email = :mail";
        $ps = $db->prepare($sql);
        $ps->bindValue(":mail", $mail);
        $ps->execute();

        if($row = $ps->fetch()){
            $hashdb = $row['hash'];
            if($hash == $hashdb){
                $sql = "UPDATE user SET verified=1 WHERE email = :mail";  
                $ps = $db->prepare($sql);
                $ps->bindValue(":mail", $mail);
                $ps->execute();
                
                echo "Verifierat!";
            }else{echo "Din verifieringskod stämde tyvärr inte överrens. Försök igen!";}
        }else{echo "Nejjj";}

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="login.css">
    <title>Verifiera din epost</title>
</head>
<body>
    <form method="post">
        <input type="submit" name="submit" value="Verifiera!">
    </form>
    
</body>
</html>