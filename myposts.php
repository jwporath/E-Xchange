<!DOCTYPE html>
<html>

<head>
    <title>E-XChange</title>
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
        <div class="boardPosts">
            <h1 class="login-title">My Posts:</h1>
            <table>
                <tr>
                    <th>Offering:</th>
                    <th>Offered Quantity:</th>
                    <th>Seeking:</th>
                    <th>Desired Quantity:</th>
                    <th>Value:</th>
                    <th>Partner:</th>
                </tr>
                <?php
                    $Username = $_SESSION['username'];
                    $query="SELECT UserID FROM Users Where Username = '$Username'";
                    $result=$conn->query($query);
                    $row = mysqli_fetch_assoc($result);
                    $UserID = $row['UserID'];

                    $query="SELECT * FROM posts WHERE hasmatch='0' AND UserID = '$UserID'";
                    $result=$conn->query($query);

                    while($row = mysqli_fetch_assoc($result))
                    {
                        $itemname = $row['ItemName'];
                        $quantity = $row['Quantity'];
                        $desireditem = $row['DesiredItem'];
                        $desiredquantity = $row['DesiredQuantity'];
                        $value = $row['Value'];
                        $totalValue = $value * $quantity;

                        if($row['PartnershipID'] != 0)
                        {
                            // get partner name
                            $PartnershipID = $row['PartnershipID'];
                            $query="SELECT * FROM partnerships JOIN users ON partnerships.User1ID = users.UserID OR partnerships.User2ID = users.UserID 
                                    WHERE partnerships.PartnershipID = '$PartnershipID' AND NOT users.UserID = '$UserID'";
                            $result2=$conn->query($query);
                            $row = mysqli_fetch_assoc($result2);
                            $PartnerName = $row['Username'];

                            echo "<tr>
                                    <td>$itemname</td>
                                    <td>$quantity</td>
                                    <td>$desireditem</td>
                                    <td>$desiredquantity</td>
                                    <td>$$totalValue</td>
                                    <td>$PartnerName</td>
                                </tr>";
                        }
                        else
                        {
                            echo "<tr>
                                    <td>$itemname</td>
                                    <td>$quantity</td>
                                    <td>$desireditem</td>
                                    <td>$desiredquantity</td>
                                    <td>$$totalValue</td>
                                    <td>N/A</td>
                                </tr>";
                        }
                    }
                ?>
            </table>
        </div>

        <div class="boardPosts">
            <br>
            <h1 class="login-title">Partner Posts:</h1>
            <table>
                <tr>
                    <th>Offering:</th>
                    <th>Offered Quantity:</th>
                    <th>Seeking:</th>
                    <th>Desired Quantity:</th>
                    <th>Value:</th>
                    <th>Partner:</th>
                </tr>
                <?php
                    $Username = $_SESSION['username'];
                    $query="SELECT * FROM posts JOIN partnerships ON posts.PartnershipID = partnerships.PartnershipID 
                            WHERE (partnerships.User1ID = '$UserID' OR partnerships.User2ID = '$UserID') AND NOT posts.userid = '$UserID' AND posts.hasmatch = '0'";
                    $result=$conn->query($query);

                    while($row = mysqli_fetch_assoc($result))
                    {
                        $itemname = $row['ItemName'];
                        $quantity = $row['Quantity'];
                        $desireditem = $row['DesiredItem'];
                        $desiredquantity = $row['DesiredQuantity'];
                        $value = $row['Value'];
                        $totalValue = $value * $quantity;

                        // get partner name
                        $PartnershipID = $row['PartnershipID'];
                        $query="SELECT * FROM partnerships JOIN users ON partnerships.User1ID = users.UserID OR partnerships.User2ID = users.UserID 
                                WHERE partnerships.PartnershipID = '$PartnershipID' AND NOT users.UserID = '$UserID'";
                        $result2=$conn->query($query);
                        $row = mysqli_fetch_assoc($result2);
                        $PartnerName = $row['Username'];

                        echo "<tr>
                                <td>$itemname</td>
                                <td>$quantity</td>
                                <td>$desireditem</td>
                                <td>$desiredquantity</td>
                                <td>$$totalValue</td>
                                <td>$PartnerName</td>
                              </tr>";
                    }
                ?>
            </table>
        </div>

        <div class="boardPosts">
            <br>
            <h1 class="login-title">Pending Transactions:</h1>
            <table>
                <tr>
                    <th>Offering:</th>
                    <th>Offered Quantity:</th>
                    <th>Seeking:</th>
                    <th>Desired Quantity:</th>
                    <th>Value:</th>
                    <th>Partner:</th>
                    <th>Status:</th>
                </tr>
                <?php
                    $Username = $_SESSION['username'];
                    $query="SELECT PostID, UserID, Itemname, Quantity, Value, DesiredItem, DesiredQuantity, posts.partnershipID, HasMatch, PartnerIsRecipient
                            FROM posts JOIN partnerships ON posts.PartnershipID = partnerships.PartnershipID 
                            WHERE (partnerships.User1ID = '$UserID' OR partnerships.User2ID = '$UserID') AND NOT posts.userid = '$UserID' AND posts.hasmatch = '1'
                            UNION 
                            SELECT *
                            FROM posts WHERE hasmatch='1' AND UserID = '$UserID'";
                    $result=$conn->query($query);

                    while($row = mysqli_fetch_assoc($result))
                    {
                        $itemname = $row['Itemname'];
                        $quantity = $row['Quantity'];
                        $desireditem = $row['DesiredItem'];
                        $desiredquantity = $row['DesiredQuantity'];
                        $value = $row['Value'];
                        $totalValue = $value * $quantity;

                        // determine transaction status
                        $PostID = $row['PostID'];
                        $query="SELECT * FROM Equivalence WHERE Post1ID = '$PostID'";
                        $result2=$conn->query($query);
                        $rows2 = mysqli_num_rows($result2);

                        $StatusMessage;

                        if($rows2 > 0)
                        {
                            $IsPost1 = true;
                            $row2 = mysqli_fetch_assoc($result2);
                            $EquivalenceID = $row2['EquivalenceID'];
                        }
                        else
                        {
                            $IsPost1 = false;
                            $query="SELECT * FROM Equivalence WHERE Post2ID = '$PostID'";
                            $result2=$conn->query($query);
                            $row2 = mysqli_fetch_assoc($result2);
                            $EquivalenceID = $row2['EquivalenceID'];
                        }

                        $query="SELECT * FROM Transactions WHERE EquivalenceID = '$EquivalenceID'";
                        $result2=$conn->query($query);
                        $row2 = mysqli_fetch_assoc($result2);

                        $Party1Received = $row2['Party1Received'];
                        $Party2Received = $row2['Party2Received'];

                        $LeadingHalf = $row2['LeadingHalf'];
                        $TrailingHalf = $row2['TrailingHalf'];

                        if($IsPost1 == true)
                        {
                            if($Party1Received == 0)
                            {
                                $StatusMessage = "Your code is:<b> $LeadingHalf</b><br>Please send your items to E-XChange with the code.";
                            }
                            else
                            {
                                $StatusMessage = "Waiting on other party's items to arrive.";
                            }
                        }
                        else
                        {
                            if($Party2Received == 0)
                            {
                                $StatusMessage = "Your code is:<b> $TrailingHalf</b><br>Please send your items to E-XChange with the code.";
                            }
                            else
                            {
                                $StatusMessage = "Waiting on other party's items to arrive.";
                            }
                        }

                        if($Party1Received != 0 && $Party2Received != 0) // do not display completed transactions
                        {
                            continue;
                        }
                        else if($row['partnershipID'] != 0)
                        {
                            // get partner name
                            $PartnershipID = $row['partnershipID'];
                            $query="SELECT * FROM partnerships JOIN users ON partnerships.User1ID = users.UserID OR partnerships.User2ID = users.UserID 
                                    WHERE partnerships.PartnershipID = '$PartnershipID' AND NOT users.UserID = '$UserID'";
                            $result2=$conn->query($query);
                            $row = mysqli_fetch_assoc($result2);
                            $PartnerName = $row['Username'];

                            echo "<tr>
                                    <td>$itemname</td>
                                    <td>$quantity</td>
                                    <td>$desireditem</td>
                                    <td>$desiredquantity</td>
                                    <td>$$totalValue</td>
                                    <td>$PartnerName</td>
                                    <td>$StatusMessage</td>
                                </tr>";
                        }
                        else
                        {
                            echo "<tr>
                                    <td>$itemname</td>
                                    <td>$quantity</td>
                                    <td>$desireditem</td>
                                    <td>$desiredquantity</td>
                                    <td>$$totalValue</td>
                                    <td>N/A</td>
                                    <td>$StatusMessage</td>
                                </tr>";
                        }
                    }
                ?>
            </table>
        </div>
    </div>
</body>

</html>