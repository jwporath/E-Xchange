<!DOCTYPE html>
<html>

<head>
    <title>Sign In | E-XChange</title>
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
        <?php
            include('sidebar.php');
        ?>
    </div>
    <div class="main">
        <form class="form" method="post" name="login">
            <h1 class="login-title">Sign In</h1>
            <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true" required/>
            <input type="password" class="login-input" name="password" placeholder="Password" required/>
            <input type="submit" value="Submit" name="submit" class="login-button"/>
            <p class="link"><a href="signup.php">New Registration</a></p>
        </form>
        <?php
            if(isset($_POST['username']))
            {
                $username = stripslashes($_REQUEST['username']);
                $username = mysqli_real_escape_string($conn, $username);
                $password = stripslashes($_REQUEST['password']);
                $password = mysqli_real_escape_string($conn, $password);

                $query="SELECT * FROM users WHERE username='$username' AND password='$password'";
                $result=$conn->query($query);
                $rows = mysqli_num_rows($result);
                if ($rows == 1) 
                {
                    $_SESSION['username'] = $username;
                    echo "<div class='form'>
                          <h3>Sign in Successful.</h3><br/>";
                    header("location: index.php");
                } 
                else 
                {
                    echo "<div class='form'>
                          <h3>Incorrect Username/password.</h3><br/>
                          <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                          </div>";
                }
            }
        ?>
    </div>
</body>

</html>