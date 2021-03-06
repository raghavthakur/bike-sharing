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
            <a id="customerservice" href="../custrep/custrep-mainpage.php">&gt; Customer Serv. Rep.</a>
            <a id="maintenance" class="active" href="technician-mainpage.html">&gt; Maintenance Tech.</a>
            <a href="../about.html">About</a>
            <a href="../faq.html">FAQ</a>
            <a href="../ourbikes.html">Our Bikes</a>
            <a href="../contact.html">Contact</a>
        </div>

        <ul id="desktopnavigation">
            <li><span class="dot"></span><a href="../index.html">Home</a></li>
            <li><span class="dot"></span><a href="../login.html">Login</a></li>
            <li class="submenu"><span>&gt; </span><a href="../rider/rider-mainpage.html">Rider</a></li>
            <li class="submenu"><span>&gt; </span><a href="../custrep/custrep-mainpage.php">Customer Service</a></li>
            <li class="submenu active"><span>&gt; </span><a class="active" href="technician-mainpage.html">Maintenance
                    Tech.</a></li>
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
                    <h3>MAINTENANCE TECHNICIAN - Add a New Bike</h3>

                    <form method="POST">
                        <p>
                            Enter bike id:
                            <input type="number" name="bikeID" size="10">
                        </p>

                        <p>
                            Enter date purchased:
                            <input type="date" name="datePurchased">
                        </p>

                        <p>
                            Enter latitude:
                            <input type="number" name="latitude" size="20">
                        </p>

                        <p>
                            Enter longitude:
                            <input type="number" name="longitude" size="20">
                        </p>

                        <p>
                            Enter bike status:<br>
                            <input type="radio" name="bikeStatus" value="Y">Broken<br>
                            <input type="radio" name="bikeStatus" value="N" checked>Not Broken<br>
                        </p>

                        <input type="submit" value="Add Bike" name="addBike">

                        <p>The output table below will be ordered by date purchased.</p>

                    </form>
                </div>
            </main>

            <footer>
                <p>
                    Copyright &copy; 2018 Bike Sharing <br>
                    <a href="mailto:email@domain.com">email@domain.com</a>
                </p>
            </footer>
        </div>
    </div>
</div>
</html>

<?php

require "../server.php";
include "../print-table.php";

// Connect Oracle...
if ($db_conn) {

    if (array_key_exists('addBike', $_POST)) {
        $tuple = array(
            ":bind1" => $_POST['bikeID'],
            ":bind2" => $_POST['datePurchased'],
            ":bind3" => $_POST['latitude'],
            ":bind4" => $_POST['longitude'],
            ":bind5" => $_POST['bikeStatus']

        );
        $alltuples = array(
            $tuple
        );

        if ($_POST['bikeID'] != "" && $_POST['datePurchased'] != "" && $_POST['latitude'] != "" && $_POST['longitude'] != "") {
            executeBoundSQL("INSERT INTO BIKE VALUES (:bind1, :bind2, :bind3, :bind4, :bind5)", $alltuples);

            OCICommit($db_conn);
            echo "<h1 style='color: black'>Bike ID: " . $_POST['bikeID'] . " has been added!</h1>";
        } else {
            echo "<h1 style='color: red'>Please fill in all fields!</h1>";
        }

        // order bike table by bike purchase date to see newest bikes first
        $result = executePlainSQL("SELECT * FROM BIKE ORDER BY DATE_PURCHASED DESC");

        $columnNames = array("Bike ID", "Date Purchased", "Latitude", "Longitude", "Bike Broken?");
        printTable($result, $columnNames);
    }
    // show bike table before clicking addBike
    else {
        // order bike table by bike purchase date to see newest bikes first
        $result = executePlainSQL("SELECT * FROM BIKE ORDER BY DATE_PURCHASED DESC");

        $columnNames = array("Bike ID", "Date Purchased", "Latitude", "Longitude", "Bike Broken?");
        printTable($result, $columnNames);
    }

    if (!$success) {
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

