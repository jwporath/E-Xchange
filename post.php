<!DOCTYPE html>
<html>

<head>
    <title>Create a Post | E-XChange</title>
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
            require('auth_session.php');
        ?>
    </div>
    <div class="main">
        <form class="form" action="" method="post">
            <h1 class="login-title">Create a Post</h1>
            <input type="text" class="login-input" name="itemname" placeholder="Item Name" required />
            <input type="text" class="login-input" name="quantity" placeholder="Quantity" required />
            <input type="text" class="login-input" name="value" placeholder="Value per Item" required />
            <input type="text" class="login-input" name="desireditem" placeholder="Desired Item" required>
            <input type="text" class="login-input" name="desiredquantity" placeholder="Quantity of Desired Item" required>

            <?PHP
                $username = $_SESSION['username'];

                // get user's id
                $query="SELECT * FROM users WHERE username='$username'";
                $result=$conn->query($query);

                $row = mysqli_fetch_assoc($result);
                $userid = $row['UserID'];

                // find all partnerships
                $query = "SELECT * FROM partnerships WHERE user1id='$userid' OR user2id='$userid'";
                $result=$conn->query($query);

                if($result->num_rows > 0) // print first partner and prompt
                {
                    echo "<br><p>Select a partner:</p>";
                    $row = mysqli_fetch_assoc($result);
                    $partnerid = $row['User1ID'];
                    if($partnerid == $userid)
                    {
                        $partnerid = $row['User2ID'];
                    }

                    $query="SELECT * FROM users WHERE userid='$partnerid'";
                    $result1=$conn->query($query);

                    $row = mysqli_fetch_assoc($result1);
                    $partnername = $row['Username'];

                    echo "<input type=\"radio\" name=\"partner\" value=\"$partnername\">$partnername";
                    while($row = mysqli_fetch_assoc($result)) // print all other partners (if any)
                    {
                        $partnerid = $row['User1ID'];
                        if($partnerid == $userid)
                        {
                            $partnerid = $row['User2ID'];
                        }

                        $query="SELECT * FROM users WHERE userid='$partnerid'";
                        $result1=$conn->query($query);

                        $row = mysqli_fetch_assoc($result1);
                        $partnername = $row['Username'];

                        echo "<br><input type=\"radio\" name=\"partner\" value=\"$partnername\">$partnername";
                    }
                }
            ?>
            <br><br><p>Select a recipient:</p>
            <input type="radio" name="recipient" value="me" required>Me
            <br><input type="radio" name="recipient" value="mypartner" required>My partner
            <input type="submit" name="submit" value="Submit" class="login-button">
        </form>

        <?PHP
            if(isset($_POST['itemname']))
            {
                // save info
                $itemname = stripslashes($_POST['itemname']);
                $itemname = mysqli_real_escape_string($conn, $itemname);
                $quantity = stripslashes($_POST['quantity']);
                $quantity = mysqli_real_escape_string($conn, $quantity);
                $value = stripslashes($_POST['value']);
                $value = mysqli_real_escape_string($conn, $value);
                $desireditem = stripslashes($_POST['desireditem']);
                $desireditem = mysqli_real_escape_string($conn, $desireditem);
                $desiredquantity = stripslashes($_POST['desiredquantity']);
                $desiredquantity = mysqli_real_escape_string($conn, $desiredquantity);
                if($_POST['recipient'] != "me")
                {
                    $partnerisrecipient = 1;
                }
                else
                {
                    $partnerisrecipient = 0;
                }
                
                if(isset($_POST['partner']))
                {
                    $partnername = $_POST['partner'];

                    $query="SELECT * FROM users WHERE username='$partnername'";
                    $result=$conn->query($query);

                    $row = mysqli_fetch_assoc($result);
                    $partnerid = $row['UserID'];

                    $query="SELECT * FROM partnerships WHERE (user1id='$partnerid' AND user2id='$userid') OR (user1id='$userid' AND user2id='$partnerid')";
                    $result=$conn->query($query);

                    $row = mysqli_fetch_assoc($result);
                    $partnershipid = $row['PartnershipID'];
                }
                else
                {
                    $partnerisrecipient = 0;
                    $partnershipid = null;
                }

                $query="INSERT INTO posts (userid,itemname,quantity,value,desireditem,desiredquantity,partnershipid,partnerisrecipient) 
                VALUES ('$userid','$itemname','$quantity','$value','$desireditem','$desiredquantity','$partnershipid','$partnerisrecipient')";
                
                $result=$conn->query($query);
                if ($result) // post created
                {
                    echo "<div class='form'>
                        <h3>Post created.</h3><br/>
                        </div>";
                } 
                else // failed to create post
                {
                    echo "<div class='form'>
                        <h3>Failed to create post.</h3><br/>
                        </div>";
                }

                // get postID
                $query="SELECT * FROM Posts WHERE desireditem='$desireditem' AND itemname='$itemname' AND UserID='$userid' AND HasMatch='0'";
                $result=$conn->query($query);
                $row = mysqli_fetch_assoc($result);
                $postid = $row['PostID'];

                // check for compatible posts
                $query="SELECT * FROM Posts 
                WHERE desireditem='$itemname' AND itemname='$desireditem' 
                AND quantity='$desiredquantity' AND desiredquantity='$quantity'
                AND HasMatch='0'";
                $MATCH_result=$conn->query($query);
                if ($MATCH_result->num_rows > 0) // Compatible post found
                {
                    $i = 0;
                    $numRows = $MATCH_result->num_rows;

                    while($i < $numRows)
                    {
                        // get match info
                        $row = mysqli_fetch_assoc($MATCH_result);
                        $i++;
                        $MATCH_PostID = $row['PostID'];
                        $MATCH_Quantity = $row['Quantity'];
                        $MATCH_DesiredQuantity = $row['DesiredQuantity'];
                        $MATCH_Value = $row['Value'];

                        // Compare post values
                        $equivalence = ($value * $quantity) / ($MATCH_Value * $MATCH_Quantity);
                        if($equivalence <= 1.1 && $equivalence >= 0.9) // within 10% value = valid transaction
                        {
                            // update posts "has match" 
                            $query="UPDATE Posts SET HasMatch = '1' WHERE PostID = '$postid' OR PostID = '$MATCH_PostID';";
                            $result=$conn->query($query);

                            // create equivalence entry
                            $query="INSERT INTO equivalence (Post1ID,Post2ID,Equivalence) 
                            VALUES ('$postid','$MATCH_PostID','$equivalence')";
                            $result=$conn->query($query);

                            // get equivalenceID
                            $query="SELECT EquivalenceID FROM equivalence WHERE Post1ID='$postid' AND Post2ID='$MATCH_PostID'";
                            $result=$conn->query($query);
                            $row = mysqli_fetch_assoc($result);
                            $equivalenceID = $row['EquivalenceID'];

                            // create hashes
                            $leadinghalf = hash('crc32', $postid);
                            $trailinghalf = hash('crc32', $MATCH_PostID);
                            // $leadinghalf = $postid;
                            // $trailinghalf = $MATCH_PostID;
                            $hashkey = $leadinghalf;
                            $hashkey .= $trailinghalf;

                            // create transaction entry
                            $query="INSERT INTO transactions (HashKey,LeadingHalf,TrailingHalf,Party1Received,Party2Received,EquivalenceID) 
                            VALUES ('$hashkey','$leadinghalf','$trailinghalf','0','0','$equivalenceID')";
                            $result=$conn->query($query);

                            // break out of loop
                            break;
                        }
                    }
                }
            }

        ?>
    </div>
</body>

</html>