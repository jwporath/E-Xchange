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
        <?php
            require('dbConnect.php');
            include("auth_session.php");
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
            <h1 class="login-title">Add a Partner</h1>
            <input type="text" class="login-input" name="partnername" placeholder="Partner's Username" required />
            <input type="submit" name="submit" value="Submit" class="login-button">
        </form>
    
        <?php
            if(isset($_REQUEST['partnername']))
            {
                $partnername = stripslashes($_REQUEST['partnername']);
                $partnername = mysqli_real_escape_string($conn, $partnername);

                // Find account with that username
                $query="SELECT * FROM users WHERE username='$partnername'";
                $result=$conn->query($query);

                if($result->num_rows == 1)
                {
                    $row = mysqli_fetch_assoc($result);
                    $user2id =$row['UserID'];

                    $username = $_SESSION['username'];
                    
                    $query="SELECT * FROM users WHERE username='$username'";
                    $result=$conn->query($query);

                    $row = mysqli_fetch_assoc($result);
                    $user1id =$row['UserID'];

                    $query="INSERT INTO partnerships(user1id,user2id,confirmed) VALUES ($user1id,$user2id,TRUE);";
                    
                    $result=$conn->query($query);
                    if ($result) // partner added successfully
                    {
                        echo "<div class='form'>
                              <h3>Partnership added successfully.</h3><br/>
                              <p class='link'>Click here to <a href='signin.php'>sign in.</a></p>
                              </div>";
                    } 
                    else // partnership failed
                    {
                        echo "<div class='form'>
                              <h3>Required fields are missing.</h3><br/>
                              <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                              </div>";
                    }
                }
                else // partner's username does not exist
                {
                    echo "<div class='form'>
                          <h3>No accound exists with that username.</h3><br/>
                          </div>";
                }
            }
        ?>
    </div>
</body>

</html>