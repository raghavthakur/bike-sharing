<html lang="en">
<head>
    <title>Bike Sharing</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../project.js" type="text/javascript" defer></script>
    <link rel="stylesheet" href="../project.css">
</head>
<div id="wrapper">

    <nav>
        <div id="mysidenav" class="sidenavigation">
            <a href="javascript:void(0)" id="closebutton" onclick="closeNav()">&times;</a>
            <a href="../index.html">Home</a>
            <a href="../login.html">Login</a>
            <a id="rider" href="../rider/rider-mainpage.html">&gt; Rider</a>
            <a id="customerservice" class="active" href="custrep-mainpage.php">> Customer Serv. Rep.</a>
            <a id="maintenance" href="../technician/technician-mainpage.html">&gt; Maintenance Tech.</a>
            <a href="../about.html">About</a>
            <a href="../faq.html">FAQ</a>
            <a href="../ourbikes.html">Our Bikes</a>
            <a href="../contact.html">Contact</a>
        </div>

        <ul id="desktopnavigation">
            <li><span class="dot"></span><a href="../index.html">Home</a></li>
            <li><span class="dot"></span><a href="../login.html">Login</a></li>
            <li class="submenu"><span>&gt; </span><a href="../rider/rider-mainpage.html">Rider</a></li>
            <li class="submenu active"><span>&gt; </span><a class="active" href="custrep-mainpage.php">Customer
                    Service</a></li>
            <li class="submenu"><span>&gt; </span><a href="../technician/technician-mainpage.html">Maintenance Tech.</a>
            </li>
            <li><span class="dot"></span><a href="../about.html">About</a></li>
            <li><span class="dot"></span><a href="../faq.html">FAQ</a></li>
            <li><span class="dot"></span><a href="../ourbikes.html">Our Bikes</a></li>
            <li><span class="dot"></span><a href="../contact.html">Contact</a></li>
        </ul>
    </nav>

    <div id="rightcol">

        <header>
            <div id="navicon">
                <img src="../images/navicon.png" alt="three horizontal bars" width="30" onclick="openNav()">
            </div>

            <h1>Bike Sharing</h1>
        </header>

        <div id="shadowbox">
            <main>
                <div>
                    <h3>CUSTOMER SERVICE REP. MAIN PAGE</h3>

                    <h4>Riders:</h4>

                    <p>
                        <a href="custrep-rider-info.php">Rider Info</a> <br> <br>
                        <a href="custrep-delete-rider.php">Delete a Rider</a> <br> <br>
                        <a href="custrep-rider-password-reset.php">Rider Password Reset (Delete this?)</a> <br> <br>
                    </p>

                    <h4>Bikes and Areas:</h4>

                    <p>
                        <a href="custrep-bike-info.php">Bike Info</a> <br> <br>
                        <a href="custrep-return-areas.php">Return Areas</a> <br> <br>
                        <a href="custrep-maintenance-issues.php">Maintenance Issues</a> <br> <br>
                    </p>

                    <h4>Problems:</h4>

                    <p>
                        <a href="custrep-complaint-view.php">View Complaints</a> <br> <br>
                        <a href="custrep-complaint-resolve.php">Resolve Complaint</a>
                    </p>
                </div>
            </main>

            <footer>
                <p>
                    Copyright &copy; 2018 Bike Sharing <br>
                    <a href="mailto:email@domain.com">email@domain.com</a>
                </p>
                <form method="POST">
                    <input type="submit" value="Reset System" name="resetSystem">
                </form>
            </footer>
        </div>
    </div>
</div>
</html>

<?php

require "../server.php";
include "../reset-database.php";

if ($db_conn) {

    if (array_key_exists('resetSystem', $_POST)) {
        dropTables();
        createTables();
        insertRowsTables();
        OCICommit($db_conn);
    }

    if ($_POST && $success) {
        echo "<h1 style='color: black'>System has been reset!</h1>";
    } else if (!$success){
        echo "<h1 style='color: red'>Error!</h1>";
    }

    // Commit to save changes...
    OCILogoff($db_conn);
} else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}

?>

