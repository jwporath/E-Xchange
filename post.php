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
            <li><a href="partnership.php">Add a Partner</a></li>
            <li><a href="signup.php">Sign Up</a></li>
            <li><a href="signin.php">Sign In</a></li>
        </ul>
    </div>
    <div class="main">
        <form class="form" action="" method="post">
            <h1 class="login-title">Create a Post</h1>
            <input type="text" class="login-input" name="itemname" placeholder="Item Name" required />
            <input type="text" class="login-input" name="quantity" placeholder="Quantity" required />
            <input type="text" class="login-input" name="value" placeholder="Value per Item" required />
            <input type="text" class="login-input" name="desireditem" placeholder="Desired Item" required>
            <input type="text" class="login-input" name="desiredquantity" placeholder="Quantity of Desired Item" required>
            <br><p>Select a partner:</p>
            <input type="radio" name="partner">Partner 1
            <br><input type="radio" name="partner">Partner 2
            <br><br><p>Who is the recipient?</p>
            <input type="radio" name="recipient">Username
            <br><input type="radio" name="recipient">Partner
            <input type="submit" name="submit" value="Submit" class="login-button">
        </form>
    
        <?php

            require('dbConnect.php');
            include("auth_session.php");

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