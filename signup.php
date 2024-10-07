<!DOCTYPE html>
<html>

<head>
    <title>Welcome!</title>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, inital-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</head>

<body>
    <div class="sidebar">
        <p>E-XChange</p>
        <ul>
            <li><a href="index.php">Bulletin Board</a></li>
            <li><a href="post.php">Create a Post</a></li>
            <li><a href="signup.php">Sign Up</a></li>
            <li><a href="signin.php">Sign In</a></li>
        </ul>
    </div>
    <div class="main">
    <div id="signin">
            <form id="account" action="signup.php" method="post">
                <input class="username" type="username" name="username" placeholder="Username">
                <input class="password" type="password" name="password" placeholder="Password">
                <input class="email" type="email" name="email" placeholder="email">
                <input class="addressline1" type="addressline1" name="addressline1" placeholder="Address Line 1">
                <input class="addressline2" type="addressline2" name="addressline2" placeholder="Address Line 2">
                <input class="city" type="city" name="city" placeholder="City">
                <input class="state" type="state" name="state" placeholder="State">
                <input class="zipcode" type="zipcode" name="zipcode" placeholder="Zipcode">
                <button class="btn btn-primary submit" type="submit">Sign Up</button>
            </form>
        </div>
    </div>

    <?php

        $servername="localhost";
        $username="root";
        $password="";
        $database="E-Xchange";

        $conn=new mysqli($servername,$username,$password,$database); // connect to E-Xchange database

        if($conn->connect_error) // check for connection error
        {
            die("Connection failed: ".$conn->connect_error);
        }

        if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['addressline1'])
        && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['zipcode']))
        {
            $username=$_POST['username'];
            $password=$_POST['password'];
            $email=$_POST['email'];
            $addressline1=$_POST['addressline1'];
            $addressline2=$_POST['addressline2'];
            $city=$_POST['city'];
            $state=$_POST['state'];
            $zipcode=$_POST['zipcode'];

            $query="SELECT * FROM users WHERE email='$email' OR username='$username'";
            $result=$conn->query($query);

            if($result->num_rows == 0)
            {
                $query="INSERT INTO users (username,password,email,addressline1,addressline2,city,state,zipcode) 
                VALUES ('$username','$password','$email','$addressline1','$addressline2','$city','$state','$zipcode')";
                $result=$conn->query($query);

                echo "Sign-Up Successful";

                header("Location: https://localhost/E-Xchange/index.php?username=$username");
                $conn->close();
                exit();
            }
            else
            {
                echo "Sign-Up Failed";
                $conn->close();
            }
        }

    ?>
</body>

</html>