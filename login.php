<?php
    // session_start();
    // if(isset($_SESSION['usr_id'])!="") {
    //     header("Location: index.php");
    // }

    //connection
    include'connection.php';

    //check if form is submitted
    if(isset($_POST['login'])){
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);   
        $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '" .$email. "' and password = '" .md5($password) . "'");
    
        if($row = mysqli_fetch_array($result)){

            // $_SESSION['usr_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            // if($_SESSION['']==1){
            //     header("Location : admin.php");
            // }else{
            //     header("Location : customer.php");
            // }

        }else{
            $errormsg = "Incorrect Email or Password !!!";
        }
    }
?>




<!-- Html of login page-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <!-- Bootstrap links-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <!--navbar-->
    <?php
        include 'navbar.php';
    ?>

    <!--Login Form-->
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 well">
                <form role="form" action="login.php" method="post" name="loginform">
                    <fieldset>
                        <legend>Login</legend>
                        <div class="form-group">
                            <label for="name">Email</label>
                            <input type="text" name="email" placeholder="Your Email" required class ="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="name">Password</label>
                            <input type="password" name="password" placeholder="Your Password" required class ="form-control"/>
                        </div>

                        <div class="form-group">
                            <input type="submit" name="login" value="Login" class="btn btn-primary"/>
                            <input type="reset" name="reset" value="Reset" class="btn btn-danger"/>
                        </div>


                        <div class="form-group">
                            <a href="signup.php" >Create New Account</a>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>


    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>