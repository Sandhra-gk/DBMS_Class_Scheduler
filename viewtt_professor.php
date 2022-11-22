<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="bg.css">
    <link href='https://css.gg/log-out.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/faeaa9a8c9.js" crossorigin="anonymous"></script>
</head>
<nav>
        <ul>
          <li><a href='functions.php'> &laquo Back</a></li>
         </ul>
       </nav>
        <!-- logo -->
            <div class="logo"><span><img src="Nitc_logo.png"> </span></div>
            <body>
<style>
<?php include 'tt2.css'; ?>

</style>
</body>
</html>
<?php
    session_start();
    include 'dbconnection.php';
    $conn = OpenCon();
    $_SESSION["cday"] = flush_database($conn,$_SESSION["cday"]);

    $days = array("Monday","Tuesday","Wednesday","Thursday","Friday");
    $all_slots = array("8-9 AM","9-10 AM","10:15-11:15 AM","11:15-12:15 PM","1-2 PM","2-3 PM","3-4 PM","4-5 PM");
    $slot_id_arr = array(1,2,3,4,5,6,7,8);
    $p_id=$_SESSION["pid"];
    echo "<html><body><br><br><br>";
    echo "<center><table class='table1'cellspacing=0 cellpadding=0>";
    echo '<tr><center>';
    echo '<th class="days"><center>' . "DAY/SLOT" . '</center></th>';
    
    foreach($all_slots as $s){
        echo '<th class="days"><center>' . $s . '</center></th>';
    }
    echo '</center></tr>';
    function slots_for_day($day,$conn,$p_id,$all_slots){
        echo '<tr>';
        echo '<th class="days"><center>' . $day . '</center></th>';
        foreach ($all_slots as $slot){
            selected_slot($slot,$day,$conn,$p_id);
        }
    
    }
    function selected_slot($slot,$day,$conn,$p_id){
        $q="SELECT course.course_id,classroom.building,classroom.room FROM weeklytable INNER JOIN course ON course.course_id=weeklytable.course_id INNER JOIN classroom ON weeklytable.room_id = classroom.room_id WHERE day = ? AND slot_id = ? AND prof_id = ?";
        $q1=$conn->prepare($q);
        $q1->bind_param("sdd",$day,$slot,$p_id);
        $q1->execute();
        $q1->bind_result($course,$building,$room);
        $q1->store_result();
        $flag = 0;
        echo '<td class="t2"><center>';
        while($q1->fetch())
        {
            $flag = 1;
            echo $course.'<br>'.$building.' '.$room.'<br>';
        }
        if(!$flag){
            echo "<br>-</br>";
        }
        echo '</center></td>';
    }
    echo '</tr>';

    

    

    foreach ($days as $d){
        slots_for_day($d,$conn,$p_id,$slot_id_arr);
    }
    echo"</table></center></body></html>";

    if(isset($_POST["back"])){
        header('Location: ' . "functions.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
</body>
</html>