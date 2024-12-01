<!DOCTYPE html>
<html>

<head>
    <title>Admin DashBoard | E-XChange</title>
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
            require('admin_auth_session.php');
        ?>
    </div>
    <div class="main">
        <form class="form" action="" method="post">
            <h1 class="login-title">Enter HashKey</h1>
            <input type="text" class="login-input" name="HashKey" placeholder="HashKey" required />
            <input type="submit" name="submit" value="Submit" class="login-button">
        </form>

        <?PHP
            if(isset($_POST['HashKey']))
            {
                $HashKey = $_POST['HashKey'];
                $IsPost1 = -1;

                $query="SELECT * FROM Transactions WHERE LeadingHalf = '$HashKey'";
                $result=$conn->query($query);
                $rows = mysqli_num_rows($result);

                if($rows > 0)
                {
                    $IsPost1 = 1;
                }
                else
                {
                    $query="SELECT * FROM Transactions WHERE TrailingHalf = '$HashKey'";
                    $result=$conn->query($query);
                    $rows = mysqli_num_rows($result);

                    if($rows > 0)
                    {
                        $IsPost1 = 0;
                    }
                }

                if($IsPost1 != -1) // a match was found.
                {
                    $row = mysqli_fetch_assoc($result);
                    $EquivalenceID = $row['EquivalenceID'];

                    $query="SELECT * FROM Equivalence WHERE EquivalenceID = '$EquivalenceID'";
                    $result=$conn->query($query);
                    $row = mysqli_fetch_assoc($result);

                    if($IsPost1 == 1) // post1id
                    {
                        $PostID = $row['Post1ID'];
                    }
                    else //post2id
                    {
                        $PostID = $row['Post2ID'];
                    }

                    $query="SELECT * FROM Posts WHERE PostID = '$PostID'";
                    $result=$conn->query($query);
                    $row = mysqli_fetch_assoc($result);

                    $itemname = $row['ItemName'];
                    $quantity = $row['Quantity'];

                    $_SESSION['HashKey'] = $HashKey;
                    $_SESSION['IsPost1'] = $IsPost1;
                
                    echo "<form class=\"form\" action=\"\" method=\"post\">
                          <h3>Did the user provide $quantity $itemname?</h3><br/>
                          <input type=\"radio\" name=\"confirm\" value=\"Yes\" required>Yes
                          <br><input type=\"radio\" name=\"confirm\" value=\"No\" required>No
                          <input type=\"submit\" name=\"submit\" value=\"Submit\" class=\"login-button\">
                          </div>";
                }
                else // no match found
                {
                    echo "<div class='form'>
                          <h3>No transactions found. Return any provided items to sender.</h3><br/>
                          </div>";
                }

            }

            if(isset($_POST['confirm']))
            {
                $confirm = $_POST['confirm'];

                if($confirm == "Yes") // yes
                {
                    $IsPost1 = $_SESSION['IsPost1'];
                    $HashKey = $_SESSION['HashKey'];

                    if($IsPost1 == 1) // party1
                    {
                        $query="UPDATE Transactions SET Party1Received = 1 WHERE LeadingHalf = '$HashKey'";
                        $result=$conn->query($query);
                    }
                    else // party2
                    {
                        $query="UPDATE Transactions SET Party2Received = 1 WHERE TrailingHalf = '$HashKey'";
                        $result=$conn->query($query);
                    }
                }
                else // no
                {
                    echo "<div class='form'>
                          <h3>Items not provided. Return to sender. No changes made.</h3><br/>
                          </div>";
                }
            }

        ?>
    </div>
</body>

</html>