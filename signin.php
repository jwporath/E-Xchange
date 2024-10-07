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
            <form id="account" action="signin.php" method="post">
                <input class="username" type="username" name="username" placeholder="Username">
                <input class="password" type="password" name="password" placeholder="Password">
                <button class="btn btn-primary submit" type="submit">Sign In</button>
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

        if(isset($_POST['username']) && isset($_POST['password']))
        {
            $username=$_POST['username'];
            $password=$_POST['password'];

            $query="SELECT * FROM users WHERE username='$username' AND password='$password'";

            $result=$conn->query($query);

            if($result->num_rows > 0)
            {
                echo "Sign-In Successful";

                header("Location: https://localhost/E-Xchange/index.php?username=$username");
                $conn->close();
                exit();
            }
            else
            {
                echo "Sign-In Failed";
                $conn->close();
            }
        }

    ?>
</body>

</html>