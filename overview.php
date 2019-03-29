<?php
    include '../config.php';
    $db = new PDO("mysql:host=localhost;dbname={$dbprefix}rateyourteacherdb;charset=utf8",
    $username, $password);
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
    <link rel="stylesheet" type="text/css" href="overview.css">
    <title>Översikt</title>
</head>
<body>
<h1>Översikt</h1>
    <?php
        $sql = "SELECT * FROM user WHERE teacher = 1";
        $ps = $db->prepare($sql);
        $ps->execute();
     
        while ($row = $ps->fetch()) {
            $name = $row['name'];
            $surname = $row['surname'];
            $avg_rating = $row['avg_rating'];
            $pp_name = $row['pp']; //Namn för profilbild
            $dbid = $row['name'].$row['surname'].rand(0,100);
            

     
            echo "
                <div class='teacher' id='$dbid' onClick='on($dbid)'>
                    <img src='pp/$pp_name'>
                    <p>$name $surname</p>
                    <p>Rating: $avg_rating/10</p>
                    <p>ID: $dbid</p>
                </div>"; 

                echo "
                <div class='overlay' id='overlay$dbid' onClick='off($dbid)'>
                    <div id='text'>
                        <p>Namn: $name <p>Efternamn: $surname 
                        <p>Rating: $avg_rating/10
                        <p>ID: $dbid
                    </div>
                </div>"; 
        }
    
    
    
        ?>

<script>


    function on(id) {
        alert('<?=$dbid?>');
        document.getElementById("overlay" + id).style.display = "block";
        
    }

    function off() {
        alert('<?=$dbid?>');
        document.getElementById("overlay" + id).style.display = "none";
    
    }
</script>

    
</body>
</html>