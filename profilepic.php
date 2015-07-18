<!DOCTYPE html>
<html>

<head>

<title>Delta Web Dev Task 4</title>

</head>

<body style="background:lightgreen; text-align:center;">

<?php
    $conn=new mysqli("localhost","root","");
    if(mysqli_select_db($conn,'delta')) //execute only if database exists
    {
    	$result=$conn->query("SELECT imageurl FROM userdetails where rollno=".(int)$_GET['rollno']);
    	$url=mysqli_fetch_array($result);
        if($url)
    	    echo "<h1><a href='".$url[0]."'>Profile Picture</a></h1>"; //provides link to profile pic
        else
            echo "<h1>This roll number doesn't exist.</h1>";

    }
    else
    {
    	echo "<h1>This roll number doesn't exist.</h1>";
    }
    $conn->close();
?>

</body>

</html>