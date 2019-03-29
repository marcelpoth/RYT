<?php
include '../config.php';
include 'functions.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'phpmailer/PHPMailer-master/src/Exception.php';
require 'phpmailer/PHPMailer-master/src/PHPMailer.php';
require 'phpmailer/PHPMailer-master/src/SMTP.php';


$db = new PDO("mysql:host=localhost;dbname={$dbprefix}rateyourteacherdb;charset=utf8",
    $username, $password);
    session_start();

    $message="";

if (isset($_POST['create']) && !empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    

    $email = test_input($_POST['email']);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL) || substr($email, -13) != "skelleftea.se"){
        // Return Error - Invalid Email
        $message = 'Din mejl verkar vara ogiltig. Testa din skolmejl istället!';
    }
    else    {
        $hash = md5(rand(0,1000));


    $mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = 0;                                       
    $mail->isSMTP();                                            
    $mail->Host       = 'nordicwebstudios.com';  
    $mail->SMTPAuth   = true;                                 
    $mail->Username   = 'noreply@nordicwebstudios.com';                     
    $mail->Password   = '}S1aFs]@$1a#07=M';                               
    $mail->SMTPSecure = 'tls';                                  
    $mail->Port       = 587;                                    

    
    $mail->setFrom('noreply@nordicwebstudios.com', 'RateYourTeacher - NoReply');
    $mail->addAddress($_POST['email']);              

    $mail->isHTML(true);                                  
    $mail->Subject = 'Verfiera din epost! - RateYourTeacher';
    $mail->Body    = '
        <html lang="sv">
        <head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
        <body>
        <h2>Tack för att du skapade ett konto!</h2><br>
        Ditt konto har blivit skapat, du kan använda ditt konto efter att du har aktiverat kontot med länken nedan.<br>
        
        Klicka här för att verifiera din epost:
        <a href="https://www.nordicwebstudios.com/verify.php?email='.$email.'&hash='.$hash.'">Klicka här!</a>
        
        </body>
        </html>
        ';

    $mail->send();
    $message = "Vi har skickat en mejl till din epost. Vänligen öppna mejlen och verifiera ditt konto med hjälp av länken";
} catch (Exception $e) {
    echo "Mailet kunde inte skickas. ERROR: {$mail->ErrorInfo} <br>Vänligen kontakta admin@nordicwebstudios.com";
}
        if(substr($email, -14) == "@skelleftea.se"){
            $teacher = 1;
        }else{$teacher = 0;}

        $sql = "INSERT INTO user (name, surname, email, teacher, password, hash) VALUES (:name, :surname, :email, :teacher, :password, :hash)";

        


        $ps = $db->prepare($sql);
 
    
        $ps->bindValue(':name', $_POST['name']);
        $ps->bindValue(':surname', $_POST['surname']);
        $ps->bindValue(':email', $_POST['email']);
        $ps->bindValue(':teacher', $teacher);
        $ps->bindValue(':password', $_POST['password']);
        $ps->bindValue(':hash', $hash);
        
    

        $ok = $ps->execute();

        

        
        
        if (!$ok) {
            $message += "DB-error - Vänligen kontakta admin@nordicwebstudios.com";
        }
    }
    
    
    

    
    
}

if(isset($_POST['return'])){
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="login.css">
    <title>Skapa användare</title>
</head>
<body>
    <h1>Skapa ditt konto här</h1>
    <form method='post' action="cu.php" enctype="multipart/form-data">
        <p><br><input type='text' name='name' placeholder='Namn'></p>
        <p><br><input type='text' name='surname' placeholder='Efternamn'></p>
        <p><br><input type='text' name='email' placeholder='Din epost (som slutar på skelleftea.se)'></p>
        <p><br><input name='password' type="password" placeholder='Lösenord'></p>
        <input type='submit' value='Skapa' name='create'>
        <input type='submit' value='Tillbaka' name='return'>
        
    </form>
    <?php
        echo "<p>$message</p>";
    ?>
</body>
</html>