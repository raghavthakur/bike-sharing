<!doctype html>
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
            <a id="rider" class="active" href="rider-mainpage.html">&gt; Rider</a>
            <a id="customerservice" href="../custrep/custrep-mainpage.php">&gt; Customer Serv. Rep.</a>
            <a id="maintenance" href="../technician/technician-mainpage.html">&gt; Maintenance Tech.</a>
            <a href="../about.html">About</a>
            <a href="../faq.html">FAQ</a>
            <a href="../ourbikes.html">Our Bikes</a>
            <a href="../contact.html">Contact</a>
        </div>

        <ul id="desktopnavigation">
            <li><span class="dot"></span><a href="../index.html">Home</a></li>
            <li><span class="dot"></span><a href="../login.html">Login</a></li>
            <li class="submenu active"><span>&gt; </span><a class="active" href="rider-mainpage.html">Rider</a></li>
            <li class="submenu"><span>&gt; </span><a href="../custrep/custrep-mainpage.php">Customer Service</a></li>
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
                    <h3>RIDER - End Ride</h3>

                    <form method="POST">

                        <p>
                            Logging in as...
                            <input type="number" name="rider_ID" size="20">
                            (enter a rider_ID)
                        </p>

                        <p>Where will you be ending your ride? Please choose a return area below to end your current
                            ride at that location.</p>

                        <p>
                            <select name="returnAreas">
                                <option value="00000001">Location 1</option>
                                <option value="00000002">Location 2</option>
                                <option value="00000003">Location 3</option>
                                <option value="00000004">Location 4</option>
                                <option value="00000005">Location 5</option>
                                <option value="00000006">Location 6</option>
                                <option value="00000007">Location 7</option>
                                <option value="00000008">Location 8</option>
                                <option value="00000009">Location 9</option>
                            </select>
                        </p>

                        <input type="submit" value="End Rental" name="endRental">

                        <p>
                            Display a confirmation message here to say that their ride has been ended.
                        </p>

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

$date = date("y-m-d h:i:s");

// Connect Oracle...
if ($db_conn) {

    if (array_key_exists('endRental', $_POST)) {
        $tuple = array(
            ":bind1" => $_POST['rider_ID'],
            ":bind2" => $_POST['returnAreas']

        );
        $alltuples = array(
            $tuple
        );

        if ($_POST['rider_ID'] != "" && $_POST['returnAreas'] != "") {
            executeBoundSQL("UPDATE TRIP SET END_LOCATION_ID = :bind2 WHERE ", $alltuples);

            OCICommit($db_conn);

        } else {
            echo "<h1 style='color: red'>Please fill in all fields!</h1>";
        }

        $result = executePlainSQL("SELECT ISSUEDATETIME, BIKE_ID, RIDER_ID, ISSUE_DESCRIPTION FROM MAINTENANCE_ISSUE ORDER BY ISSUEDATETIME DESC");

        $columnNames = array("Date", "Bike ID", "Rider ID", "Issue Description");
        printTable($result, $columnNames);
    }
    // show bike table before clicking addBike
    else {
        // order bike table by bike purchase date to see newest bikes first
        $result = executePlainSQL("SELECT ISSUEDATETIME, BIKE_ID, RIDER_ID, ISSUE_DESCRIPTION FROM MAINTENANCE_ISSUE ORDER BY ISSUEDATETIME DESC");

        $columnNames = array("Date", "Bike ID", "Rider ID", "Issue Description");
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