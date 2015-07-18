<!DOCTYPE html>
<html>

<head>

<title>Delta Web Dev Task 4</title>

<script>
function checkrollno(rollno)
{
    if(rollno%1==0)
        return true;
    else
        return false;
}
function checkname(name)
{
    var regexp = /^[a-z A-Z]+$/;
    if(regexp.test(name))
        return true;
    else 
        return false;
}
function checkemail(email)
{
    var regexp=/^[a-zA-Z0-9_.]+@[a-zA-Z]+[.][a-zA-Z]+$/;
    if(regexp.test(email))
        return true;
    else 
        return false;
}
function checkfile()
{
    if(document.getElementById("pp").files[0].size>500000)
        return false;
    else 
        return true;
}
function showpassword()
{
    if(document.getElementById("cbox").checked==true)
        document.forms['delta']['password'].type="text";
    else
        document.forms['delta']['password'].type="password";
}
function formValidate()
{
    var message="";

    //validate roll number
    if(document.forms['delta']['rollno'].value=="")
    {
        message+="Roll number is required\n";
    }
    else if((checkrollno(document.forms['delta']['rollno'].value)===false)&&message.indexOf("Roll number is required")==-1)
    {
        message+="Enter a valid roll number\n";
    }
    else if(checkrollno(document.forms['delta']['rollno'].value)===false)
    {
        message=message.replace("Roll number is required","Enter a valid roll number");
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////

    //validate name
    if(document.forms['delta']['name'].value=="")
    {
        message+="Name is required\n";
    }
    else if((checkname(document.forms['delta']['name'].value)===false)&&message.indexOf("Name is required")==-1)
    {
        message+="Enter a valid name\n";
    }
    else if(checkname(document.forms['delta']['name'].value)===false)
    {
        message=message.replace("Name is required","Enter a valid name");
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //validate email
    if(document.forms['delta']['email'].value=="")
    {
        message+="Email is required \n";
    }
    else if((checkemail(document.forms['delta']['email'].value)===false)&&message.indexOf("Email is required")==-1)
    {
        message+="Enter a valid email\n";
    }
    else if(checkname(document.forms['delta']['email'].value)===false)
    {
        message=message.replace("Email is required","Enter a valid email");
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //validate password
    if(document.forms['delta']['password'].value=="")
    {
        message+="Password is required\n";
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////

    //check if confirm password is empty
    if(document.forms['delta']['confirmpassword'].value=="")
    {
        message+="Confirm Password is required\n";
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////

    //check if passwords match
    if(document.forms['delta']['password'].value!=document.forms['delta']['confirmpassword'].value)
    {
        message+="Passwords don't match\n";
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //validate profile picture
    if(document.getElementById("pp").files[0].size==0)
    {
        message+="No file chosen\n";
    }
    else if(checkfile()==false&&message.indexOf("No file chosen")==-1)
    {
        message+="File size must be less than 500kb\n";
    }
    else if(checkfile()==false)
    {
        message=message.replace("No file chosen","File size must be less than 500kb");
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    
    if(message=="") //if no error message, then submit
    {
        message="Your form is being submitted";
        window.alert(message);
        return true;
    }
    else
    {
        window.alert(message);
        return false;
    }
}
</script>

</head>

<body style="background:lightgreen">
<?php
    //session_start(); //for setting session variables
    $check=0; //
    $existid=0; //variables to check for unique id

    function generate() //function to generate random 9 digit number
    {
        $num=mt_rand(100000000,999999999);
        return $num;
    }

    $conn=new mysqli("localhost","root",""); //establish database connection
    
    if($conn->query("CREATE DATABASE delta")==false) //if database already exists, then check for unique id
    {
        $conn->query("USE delta");
        while($check==0)
        {
            $random_number=(int)generate(); //unique id is sent as a session variable
            $existid=mysqli_num_rows($conn->query('SELECT id FROM userdetails WHERE id='.$random_number));
            if($existid==0)
                $check=1;
        }
        $conn->close();
    }
    else
    {
        $conn->query("DROP DATABASE delta"); //if database doesn't exist, if statement creates one. deleting to prevent errors
        $random_number=(int)generate();
        $conn->close();
    }
?>


<h1 style="margin-left:20px">Registration Form</h1>
<div style="border: 1px solid black; width:700px; padding:20px; background:lightblue">
<form name ="delta" action="formprocess.php" method="POST" onsubmit="return formValidate()">
Roll Number : <input type="text" name="rollno" autocomplete="off"> *<br> <br> <br>
Name : <input type="text" name="name"  autocomplete="off"> * (If you have an initial in your name, use *space* instead of .)<br> <br> <br>
Department : *<br>
<input type="radio" name="dept" value="EEE" required> EEE
<input type="radio" name="dept" value="ECE"> ECE
<input type="radio" name="dept" value="CSE"> CSE
<input type="radio" name="dept" value="ICE"> ICE
<input type="radio" name="dept" value="MECH"> MECH
<input type="radio" name="dept" value="PROD"> PROD
<input type="radio" name="dept" value="CHEM"> CHEM
<input type="radio" name="dept" value="META"> META
<input type="radio" name="dept" value="CIVIL"> CIVIL
<input type="radio" name="dept" value="ARCHI"> ARCHI
<br> <br> <br>
Year of Study : <select name="year">
<option value="I">Ist year</option>
<option value="II">IInd year</option>
<option value="III">IIIrd year</option>
<option value="IV">IVth year</option>
</select> *
<br> <br> <br>
Email : <input type="text" name="email" autocomplete="off"> *<br> <br> <br>
Password : <input type="password" name="password"> * <input type="checkbox" id="cbox" onchange="showpassword()"> Show password<br> <br> <br>
Confirm Password : <input type="password" name="confirmpassword"> *<br> <br> <br>
Profile Picture : <input id="pp" type="file" name="pp" required> *<br> <br> <br>
<input type="submit" formenctype="multipart/form-data">
<input type="hidden" name="randomnumber" value="<?php echo $random_number; ?>">
</form>
</div>
</body>

</html>