<!DOCTYPE html>
<html>

<head>

<title>Delta Web Dev Task 4</title>
 
</head>

<body style="background:lightgreen">
<div style="text-align:center">
<?php
    error_reporting(E_ERROR | E_PARSE);
    //session_start(); //access session variables
    $error=0; //for validation
    $existid=0; //validate id
    $existrollno=0; //validate roll no
    $rollno=$name=$dept=$year=$email=$password="";
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
    	$name=trim($_POST['name']);
    	$rollno=trim($_POST['rollno']);
    	$dept=$_POST['dept'];
    	$year=$_POST['year'];
    	$email=trim($_POST['email']);
    	$password=$_POST['password'];
        $random_number=$_POST['randomnumber'];
    }
    if(empty($name)==true||empty($rollno)==true||empty($dept)==true||empty($year)==true||empty($email)==true||empty($password)==true)
    {
    	$error=1;
    	echo '<h1>Form is not fully filled.<h1>';
    }
    //variables for image upload
    $target_dir="formuploads/";
    $target_file=$target_dir.basename($_FILES["pp"]["tmp_name"]);

    $conn=new mysqli("localhost","root",""); //set up database connection
    $conn->query("CREATE DATABASE delta");
    $conn->query("USE delta");
    $conn->query("CREATE TABLE userdetails(rollno int, name varchar(25), dept varchar(5),year varchar(10), email varchar(25), password varchar(100), imageurl varchar(100), id bigint)");

    $existid=mysqli_num_rows($conn->query('SELECT id FROM userdetails WHERE id='.$random_number)); //verify id
    if($existid==1)
    {
        $error=1;
        echo "<h1>This entry already exists.</h1>";
    }

    $existrollno=mysqli_num_rows($conn->query('SELECT rollno FROM userdetails WHERE rollno='.$rollno)); //verify roll no
    if($existrollno==1&&$existid==1)
    {
        $error=1;
    }
    if($existrollno==1&&$existid==0)
    {
        $error=1;
        echo "<h1>This entry already exists.</h1>";
    }

    if(getimagesize($_FILES["pp"]["tmp_name"])==false) //verify that file is an image
    {
    	$error=1;
    	echo "<h1>Your file is not an image.</h1>";
    }
    if ($_FILES["pp"]["size"] > 500000) //verify that file isn't bigger than 500kb
    {
    	echo "<h1>Sorry, your file is too large.<h1>";
    	$error=1;
    }

    if($error==1)
    {
        echo "\n<h1>Your form was not submitted.</h1>";
    }
    else
    {
        move_uploaded_file($_FILES["pp"]["tmp_name"],$target_dir.$random_number.".jpg"); //uploads the file
        $password=sha1($password); //encrypt password for security
        echo "<h1>Your unique ID is ".$random_number."</h1>";
        $conn->query("INSERT INTO userdetails VALUES(".$rollno.",'".$name."','".$dept."','".$year."','".$email."','".$password."','".$target_dir.$random_number.".jpg',".$random_number.")");
        $conn->close();
    }

?>
</div>
</body>

</html>