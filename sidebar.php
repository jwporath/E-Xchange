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
        <?PHP
            if(isset($_SESSION['username'])) // user is logged in
            {
                echo "<li><a href=\"index.php\">Bulletin Board</a></li>
                        <li><a href=\"myposts.php\">My Posts</a></li>
                        <li><a href=\"post.php\">Create a Post</a></li>
                        <li><a href=\"partnership.php\">Add a Partner</a></li>
                        <li><a href=\"logout.php\">Log Out</a></li>";
            }
            else // user is not logged in
            {
                echo "<li><a href=\"index.php\">Bulletin Board</a></li>
                        <li><a href=\"signup.php\">Sign Up</a></li>
                        <li><a href=\"signin.php\">Sign In</a></li>";
            }
        ?>
    </ul>