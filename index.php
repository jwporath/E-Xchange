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
        ?>
    </div>
    <div class="main">
        <div class="boardPosts">
            <br>
            <table>
                <tr>
                    <th>Offering:</th>
                    <th>Offered Quantity:</th>
                    <th>Seeking:</th>
                    <th>Desired Quantity:</th>
                    <th>Value:</th>
                </tr>
                <?php
                    $query="SELECT * FROM posts WHERE hasmatch='0'";
                    $result=$conn->query($query);

                    while($row = mysqli_fetch_assoc($result))
                    {
                        $itemname = $row['ItemName'];
                        $quantity = $row['Quantity'];
                        $desireditem = $row['DesiredItem'];
                        $desiredquantity = $row['DesiredQuantity'];
                        $value = $row['Value'];
                        $totalValue = $value * $quantity;
                        echo "<tr>
                                <td>$itemname</td>
                                <td>$quantity</td>
                                <td>$desireditem</td>
                                <td>$desiredquantity</td>
                                <td>$$totalValue</td>
                              </tr>";
                    }
                ?>
            </table>
        </div>
    </div>
</body>

</html>