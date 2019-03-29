<?php
include '../config.php';
$db = new PDO("mysql:host=localhost;dbname={$dbprefix}rateyourteacherdb;charset=utf8",
    $username, $password);
    session_start();
    $message="";

    $_SESSION['loggedin']=false;
   
    if(isset($_POST['submit'])){
        $inputemail = htmlspecialchars($_POST['email']);
        $inputpassword = htmlspecialchars($_POST['password']);

        
        $sql = "SELECT * FROM user";
            $ps = $db->prepare($sql);
            $ps->execute();
            while ($row = $ps->fetch()) {
                $email = $row['email'];
                $password = $row['password'];
                $verified = $row['verified'];
                
                if($inputemail == $email && $inputpassword == $password){
                    if($verified == 1){
                        $_SESSION['loggedin']=true;
                        Header('Location: overview.php');  
                    }else{$message = "Ditt konto har ännu inte blivit verifierad.";}
                    
                } else{$message="Fel mail/lösenord - Vänligen försök igen";}
            }
            




    }

    if(isset($_POST['createuser'])){
        header("Location: cu.php");
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
<h1>Rate Your Teacher</h1>
<h2>Login</h2>
    <form method="post">
        <input type="text" name="email" placeholder="E-mail"><br>
        <input type="password" name="password" placeholder="Lösenord"><br>
        <input type="submit" name="submit" value="Logga in">
        <input type="submit" name="createuser" value="Skapa användare">
    </form>
    <?php
        echo "<p>$message</p>";
    ?>
    
    
</body>
</html>