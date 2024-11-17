<?php
    session_start();

    include("db.php");

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        $firstname=$_POST['fname'];
        $lastname=$_POST['lname'];
        $gender=$_POST['gender'];
        $cnum=$_POST['number'];
        $address=$_POST['add'];
        $gmail=$_POST['mail'];
        $password=$_POST['pass'];

        if(!empty($gmail) && !empty($password && !is_numeric($gmail)))
        
        {
            $query="insert into form (fname,lname,gender,cnum,address,email,pass)  values('$firstname','$lastname','$gender','$cnum','$address','$gmail','$password')";

            mysqli_query($con,$query);
           echo"<script type='text/javascript'> alert('Successfully Register')</script>";
        }
        else
        {
            echo"<script type='text/javascript'> alert('Please Enter some valid Information')</script>";
        }
    }
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Form login and Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="signup">
        <h1>Sign up</h1>
        <h4>It's free and it takes only a min</h4>
        <form method="POST">
            <label>First Name</label>
            <input type="text" name="fname"required>
            <label>Last Name</label>
            <input type="text" name="lname"required>
            <label>Gender</label>
            <input type="text" name="gender"required>
            <label>Contact Address</label>
            <input type="tel" name="number"required>
            <label>Address</label>
            <input type="text" name="add"required>
            <label>Email</label>
            <input type="email" name="mail"required>
            <label>Password</label>
            <input type="password" name="pass"required>
            <input type="submit" name="" value="Submit">
        </form>
        <p>By clicking the sign up button, you agree to out our<br>
        <a href="">Terms And Conditions</a> and <a href="">Policy Privacy</a>
    </p>
    <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>