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
                            Ending ride...
                            <input type="number" name="trip_ID" size="20">
                            (enter a trip_ID)
                        </p>

                        <p>Thanks for riding with us!</p>

                        <input type="submit" value="End Rental" name="endRental">

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
            ":bind1" => $_POST['trip_ID']

        );
        $alltuples = array(
            $tuple
        );

        $maxID1 = executePlainSQL("SELECT MAX(END_LATITUDE) AS MAX FROM TRIP");
        $row1 = OCI_Fetch_Array($maxID1, OCI_BOTH);
        $endLat = $row1["MAX"] + 1;

        $maxID2 = executePlainSQL("SELECT MAX(END_LATITUDE) AS MAX FROM TRIP");
        $row2 = OCI_Fetch_Array($maxID2, OCI_BOTH);
        $enLon = $row2["MAX"] + 1;

        $maxID3 = executePlainSQL("SELECT MAX(END_LOCATION_ID) AS MAX FROM TRIP");
        $row3 = OCI_Fetch_Array($maxID3, OCI_BOTH);
        $enLoc = $row3["MAX"] + 1;

        if ($_POST['trip_ID'] != "") {
            executeBoundSQL("UPDATE TRIP SET END_LOCATION_ID = $enLoc, END_LATITUDE = $endLat, END_LONGITUDE = $enLon, END_DATETIME = '$date' WHERE TRIP_ID = :bind1", $alltuples);

            OCICommit($db_conn);

            $result = executePlainSQL("SELECT * FROM TRIP ORDER BY TRIP_ID");

            $tripColumnNames = array("Trip ID", "Rider ID", "Bike ID", "End Location ID", "Start Time",
                "End Time", "Tokens Due", "Start Latitude", "Start Longitude", "End Latitude",
                "End Longitude");
            printTable($result, $tripColumnNames);

        } else {
            echo "<h1 style='color: red'>Please fill in all fields!</h1>";
        }
    }

    else {

        $availableTrips = executePlainSQL("SELECT T.TRIP_ID, T.RIDER_ID FROM TRIP T WHERE NOT ((T.START_DATETIME IS NOT NULL AND END_DATETIME IS NOT NULL) OR START_DATETIME IS NULL)");

        $columnNames = array("Active Trip ID", "Rider ID");
        printTable($availableTrips, $columnNames);
    }

    // Commit to save changes...
    OCILogoff($db_conn);
} else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}

?>