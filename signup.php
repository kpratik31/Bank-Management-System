<?php

    include 'connection.php';

    if(isset($_POST['create'])){

        $name  = $_POST['name'];
        $username  = $_POST['username'];
        $password  = $_POST['password'];
        $mobile  = $_POST['mobile'];
        $dob  = $_POST['dob'];
        $email  = $_POST['email'];
        $pincode  = $_POST['pincode'];
        
        // name credentials
        if(strlen($name)<2){
            echo '<script>alert("Name is too short")</script>';
            exit;
        }
        else if(strlen($name)>50){
            echo '<script> alert("Name is too large")</script>';
            exit;
        }
        else if(!preg_match("/^[a-zA-Z\s]+$/", $name)){
            echo '<script> alert("Invalid Characters in Name")</script>';
            exit;
        }

        //username
        if(strlen($username)<2){
            echo '<script>alert("Username is too short")</script>';
            exit;
        }
        $sql1 = "SELECT username FROM users";
        $result1 = mysqli_query($conn,$sql1);
        if(mysqli_num_rows($result1)>0){
            while($row=mysqli_fetch_array($result1)){
                if($row['username'] == $username){
                    echo '<script>alert("Username is already taken")</script>';
                    exit;
                }
            }
        }

        //password
        if(strlen($password)<6){
            echo '<script>alert("Password should be of Minimum 6 characters")</script>';
            exit;
        }

        $isuppercharPresent = false;
        $islowercharPresent = false;
        $isspecialcharPresent = false;
        $isnumericcharPresent = false;

        for($i=0; $i<strlen($password);$i++){
            if(ord($password[$i])>=65 && ord($password[$i])<=90){
                $isuppercharPresent = true;
            }
            if(ord($password[$i])>=97 && ord($password[$i])<=122){
                $islowercharPresent = true;
            }
   
            if (preg_match('/[\'^£$%&*()}{@#~?><,|=_+¬-]/', $password[$i])){
                $isspecialcharPresent = true;
            }
            if(is_numeric($password[$i])){
                $isnumericcharPresent = true;
            }
        }
        if(!($islowercharPresent && $isnumericcharPresent  && $isspecialcharPresent  && $isuppercharPresent)){
            echo '<script>alert("Password should contain at least one uppercase,one lowercase,one special and one Numeric Character")</script>';
            exit;
        }

        //mobile
        if(!(strlen((string)$mobile)== 10)){
            echo '<script>alert("Please Enter Valid Mobile No")</script>';
            exit;
        }

        //dateofbirth
        $Usersyear = date('Y', strtotime($dob));
        $Currentyear = date("Y"); 
        if(($Currentyear- $Usersyear)<16){
            echo '<script>alert("Your age is below 16")</script>';
            exit;
        }
        
        //email
        $sql2 = "SELECT email FROM users";
        $result2 = mysqli_query($conn,$sql2);
        if(mysqli_num_rows($result2)>0){
            while($row=mysqli_fetch_array($result2)){
                if($row['email'] == $email){
                    echo '<script>alert("Email is already used")</script>';
                    exit;
                }
            }
        }

        $indexOfAt = strpos($email,'@');
        $indexOfDot = false;
        if($indexOfAt != false && $indexOfAt!=0){
            $indexOfDot = strpos($email,'.',$indexOfAt);
            if($indexOfDot==false){
                echo'<script>alert("Email is not valid")</script>';
                exit;
            }
        }
        else{
            echo'<script>alert("Email is not valid")</script>';
            exit;
        }
        
        //pincode
        if(!(strlen((string)$pincode)== 6)){
            echo '<script>alert("Please Enter Valid Pincode")</script>';
            exit;
        }

        //insertion in user table of new user
        $sql= "INSERT INTO `users` (`name`, `username`, `password`, `mob`, `dob`, `email`, `pincode`) VALUES ('$name', '$username', '$password', '$mobile', '$dob', '$email', '$pincode')";
        $result = mysqli_query($conn,$sql);
        
        if($result == true){
            echo '<script>alert("New user Created")</script>';
        }else{
            echo '<script>alert("Error")</script>';
        }
        
        //for user_account_details table

        //account no
        
        function randomNumber($length) {
            $result = '38';
        
            for($i = 0; $i < $length-2; $i++) {
                $result .= mt_rand(0, 9);
            }
        
            return $result;
        }
        
        $account_no = randomNumber(11);
        	

        //account balance
        $account_bal = 200;


        // insertion into user_account_details Table
        $sql_acc = "INSERT INTO `user_account_details` (`account_no`, `account_bal`, `username`) VALUES('$account_no', '$account_bal', '$username')";

        mysqli_query($conn, $sql_acc);        
        

    }


?>


<!--HTML page of Signup.php-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap links-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <?php
        include 'navbar.php';
    ?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 well">
            <form role="form" action="signup.php" method="post" name="loginform">
                <fieldset>
                    <legend>New User Registration</legend>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" placeholder="Your Name" required class ="form-control"/>
                    </div>
                    
                    <div class="form-group">
                        <label for="name">User Name</label>
                        <input type="text" name="username" placeholder="Username" required class ="form-control"/>
                    </div>

                    <div class="form-group">
                        <label for="name">Password</label>
                        <input type="password" name="password" placeholder="Your Password" required class ="form-control"/>
                    </div>

                    <div class="form-group">
                        <label for="name">Mobile No</label>
                        <input type="number" name="mobile" placeholder="Your Mobile No" required class ="form-control"/>
                    </div>
                    
                    <div class="form-group">
                        <label for="name">DOB</label>
                        <input type="date" name="dob" placeholder="Your DOB" required class ="form-control"/>
                    </div>

                    <div class="form-group">
                        <label for="name">Email</label>
                        <input type="text" name="email" placeholder="Your Email" required class ="form-control"/>
                    </div>

                    <div class="form-group">
                        <label for="name">Pincode</label>
                        <input type="number" name="pincode" placeholder="Pincode" required class ="form-control"/>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="create" value="Create" class="btn btn-primary"/>
                        <input type="reset" name="reset" value="Reset" class="btn btn-danger"/>
                    </div>
                <fieldset>
            </form>
        </div>
    </div>
</div>
</body>
</html>
