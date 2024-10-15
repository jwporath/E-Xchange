<!DOCTYPE html>
<html>

<head>
    <title>Sign Up | E-XChange</title>
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
        <img src="Logo.png" href="index.php">
        <?php
            require('dbConnect.php');
            session_start();
            if(isset($_SESSION['username']))
            {
                echo "<h1>Welcome, ";
                echo $_SESSION['username'];
                echo "</h1>";
            }
        ?>
        <ul>
            <li><a href="index.php">Bulletin Board</a></li>
            <?PHP
                if(isset($_SESSION['username'])) // user is logged in
                {
                    echo "<li><a href=\"post.php\">Create a Post</a></li>
                          <li><a href=\"partnership.php\">Add a Partner</a></li>
                          <li><a href=\"logout.php\">Log Out</a></li>";
                }
                else // user is not logged in
                {
                    echo "<li><a href=\"signup.php\">Sign Up</a></li>
                          <li><a href=\"signin.php\">Sign In</a></li>";
                }
            ?>
        </ul>
    </div>
    <div class="main">
        <form class="form" action="" method="post">
            <h1 class="login-title">Sign Up</h1>
            <input type="text" class="login-input" name="username" placeholder="Username" required />
            <input type="password" class="login-input" name="password" placeholder="Password" required />
            <input type="text" class="login-input" name="email" placeholder="Email@domain.com" required />
            <input type="text" class="login-input" name="addressline1" placeholder="Address line 1" required>
            <input type="text" class="login-input" name="addressline2" placeholder="Address line 2">
            <input type="text" class="login-input" name="city" placeholder="City" required>
            <input type="text" class="login-input" name="state" placeholder="State" required>
            <input type="text" class="login-input" name="zipcode" placeholder="ZipCode" required>
            <input type="submit" name="submit" value="Submit" class="login-button">
            <p class="link"><a href="signin.php">Click to Login</a></p>
        </form>
    
        <?php
            if(isset($_REQUEST['username']))
            {
                // Extract and cleanup data
                $username = stripslashes($_REQUEST['username']);
                $username = mysqli_real_escape_string($conn, $username);
                $password = stripslashes($_REQUEST['password']);
                $password = mysqli_real_escape_string($conn, $password);
                $email = stripslashes($_REQUEST['email']);
                $email = mysqli_real_escape_string($conn, $email);
                $addressline1 = stripslashes($_REQUEST['addressline1']);
                $addressline1 = mysqli_real_escape_string($conn, $addressline1);
                if(isset($_REQUEST['addressline2'])) // only use line 2 if user entered line 2
                {
                    $addressline2 = stripslashes($_REQUEST['addressline2']);
                    $addressline2 = mysqli_real_escape_string($conn, $addressline2);
                }
                else
                {
                    $addressline2 = null;
                }
                $city = stripslashes($_REQUEST['city']);
                $city = mysqli_real_escape_string($conn, $city);
                $state = stripslashes($_REQUEST['state']);
                $state = mysqli_real_escape_string($conn, $state);
                $zipcode = stripslashes($_REQUEST['zipcode']);
                $zipcode = mysqli_real_escape_string($conn, $zipcode);

                // check if email or username are already in use
                $query="SELECT * FROM users WHERE email='$email' OR username='$username'";
                $result=$conn->query($query);

                if($result->num_rows == 0)
                {
                    $query="INSERT INTO users (username,password,email,addressline1,addressline2,city,state,zipcode) 
                    VALUES ('$username','$password','$email','$addressline1','$addressline2','$city','$state','$zipcode')";
                    
                    $result=$conn->query($query);
                    if ($result) // registration success
                    {
                        echo "<div class='form'>
                            <h3>You are registered successfully.</h3><br/>
                            <p class='link'>Click here to <a href='signin.php'>sign in.</a></p>
                            </div>";
                    } 
                    else // registration failure
                    {
                        echo "<div class='form'>
                            <h3>Required fields are missing.</h3><br/>
                            <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                            </div>";
                    }
                }
                else
                {
                    echo "<div class='form'>
                        <h3>Username or Email already in use.</h3><br/>
                        <p class='link'>Click here to <a href='signin.php'>sign in</a> instead.</p>
                        </div>";
                }
            }

        ?>
    </div>
</body>

</html>