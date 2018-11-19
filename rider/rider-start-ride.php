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
                    <h3>RIDER - Start Ride</h3>

                    <form method="POST">

                        <p>
                            Logging in as...
                            <input type="number" name="rider_ID" size="20">
                            (enter a rider_ID)
                        </p>

                        <p>Select the bike you would like to rent:</p>
                        <input type="number" name="bike_ID" size="20">

                        <input type="submit" value="Start Rental" name="startRental">


                        <p>
                            Note that a rider shouldn't be allowed to rent a bike if they currently have an active bike
                            rental. They must return the other bike first. We should show an error message if they try
                            to do this. <br> <br>
                            IMPORTANT: In our formal spec document, under Deliverable 11, we said that we would create
                            a VIEW for Riders for the Bike table. Riders are only allowed to see bike_ID, latitude,
                            and longitude. The VIEW would prevent them from seeing other things. On the other hand,
                            since it is not possible for a Rider to access that information using our input boxes above,
                            the VIEW is not really necessary, but I guess we have to do it because of the project
                            requirements.
                        </p>

                        <p>
                            Display a confirmation message here to indicate that the ride has started - or display an
                            error message otherwise.
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

if ($db_conn) {

    if (array_key_exists('startRental', $_POST)) {

        $tuple = array(
            ":bind1" => $_POST['rider_ID'],
            ":bind2" => $_POST['bike_ID']
        );
        $alltuples = array(
            $tuple
        );

        if ($_POST['rider_ID'] != "" && $_POST['bike_ID']) {

            $maxID = executePlainSQL("SELECT MAX(TRIP_ID) AS MAX FROM TRIP");
            $row = OCI_Fetch_Array($maxID, OCI_BOTH);
            $nextNum = $row["MAX"] + 1;

            $maxID1 = executePlainSQL("SELECT MAX(START_LATITUDE) AS MAX FROM TRIP");
            $row1 = OCI_Fetch_Array($maxID1, OCI_BOTH);
            $startLat = $row1["MAX"] + 1;

            $maxID2 = executePlainSQL("SELECT MAX(START_LONGITUDE) AS MAX FROM TRIP");
            $row2 = OCI_Fetch_Array($maxID2, OCI_BOTH);
            $startLon = $row2["MAX"] + 1;


            executeBoundSQL("INSERT INTO TRIP VALUES ($nextNum, :bind1, :bind2, NULL, '$date', NULL, NULL, $startLat, $startLon, NULL, NULL)", $alltuples);
            OCICommit($db_conn);

            $trip = executePlainSQL("SELECT * FROM TRIP");

            $tripNames = array("Trip ID", "Rider ID", "Bike ID", "End Location ID", "Start Date Time", "End Date Time", "Tokens Due", "Start Latitude", "Start Longitude", "End Latitude", "End Longitude");
            printTable($trip, $tripNames);
            echo "<h1 style='color: black'>The Rider ID: " . $_POST['rider_ID'] . " has rented Bike ID: ". $_POST['rider_ID'] . " resolved!</h1>";
        } else {
            echo "<h1 style='color: red'>Error! Enter Customer Rep ID and Complaint ID.</h1>";
        }
    }

    $result = executePlainSQL("SELECT * FROM AVAILABLE_BIKES_FOR_RENT");

    // all riders that are not currently on a trip
    $riders = executePlainSQL("SELECT R.RIDER_ID
                                      FROM RIDER R
                                      WHERE R.RIDER_ID NOT IN (SELECT T.RIDER_ID
                                      FROM TRIP T
                                      WHERE NOT ((T.START_DATETIME IS NOT NULL AND END_DATETIME IS NOT NULL) OR START_DATETIME IS NULL))");

    echo "<h1 style='color: black'>Riders not on trip</h1>";
    $ridersNames = array("Rider ID");
    printTable($riders, $ridersNames);

    echo "<h1 style='color: black'>Available bikes for rent.</h1>";
    $columnNames = array("Bike ID", "Latitude", "Longitude");
    printTable($result, $columnNames);

    // Commit to save changes...
    OCILogoff($db_conn);
} else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}

?>