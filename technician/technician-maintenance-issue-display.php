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
                    <h3>MAINTENANCE TECHNICIAN - Maintenance Issues</h3>

                    <form method="POST">

                        <p>
                            Enter rider ID (optional): <input type="number" name="riderID" size="20">
                        </p>

                        <p>
                            Enter bike ID (optional): <input type="number" name="bikeID" size="20">
                        </p>

                        <p>
                            Sort by:
                            <select name="sortBy">
                                <option value="MI.RESOLVED_DATE">Resolved?</option>
                                <option value="MI.RIDER_ID">Rider ID</option>
                                <option value="MI.BIKE_ID">Bike ID</option>
                                <option value="MI.ISSUEDATETIME">Date and Time</option>
                            </select>
                        </p>

                        <input type="submit" value="View Maintenance Issues" name="viewIssues">

                        <p>
                            Display a table here according to the above input. Make sure to include columns for
                            riderName,
                            riderPhoneNum, bikeLatitude, and bikeLongitude so that we have to join 3 tables.
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

if ($db_conn) {

    if (array_key_exists('viewIssues', $_POST)) {

        $tuple = array(
            ":bind1" => $_POST['riderID'],
            ":bind2" => $_POST['bikeID']
        );
        $alltuples = array(
            $tuple
        );

        if ($_POST['riderID'] != "" && $_POST['bikeID'] == "") {
            $result = executeResultBoundSQL("SELECT MI.RIDER_ID, R.NAME, R.PHONE_NUM, B.BIKE_ID, B.LATITUDE, B.LONGITUDE, MI.ISSUEDATETIME, MI.ISSUE_DESCRIPTION, MI.TECHNICIAN_ID, MT.NAME, MI.TECHNICIAN_NOTES, MI.RESOLVED_DATE
                                                    FROM BIKE B, RIDER R, MAINTENANCE_ISSUE MI, MAINTENANCE_TECHNICIAN MT
                                                    WHERE MI.TECHNICIAN_ID = MT.EMPLOYEE_ID AND MI.BIKE_ID = B.BIKE_ID AND MI.RIDER_ID = R.RIDER_ID AND MI.RIDER_ID = :bind1
                                                    ORDER BY " . $_POST['sortBy'], $alltuples);
        } else if ($_POST['riderID'] == "" && $_POST['bikeID'] != "") {
            $result = executeResultBoundSQL("SELECT MI.RIDER_ID, R.NAME, R.PHONE_NUM, B.BIKE_ID, B.LATITUDE, B.LONGITUDE, MI.ISSUEDATETIME, MI.ISSUE_DESCRIPTION, MI.TECHNICIAN_ID, MT.NAME, MI.TECHNICIAN_NOTES, MI.RESOLVED_DATE
                                                    FROM BIKE B, RIDER R, MAINTENANCE_ISSUE MI, MAINTENANCE_TECHNICIAN MT
                                                    WHERE MI.TECHNICIAN_ID = MT.EMPLOYEE_ID AND MI.BIKE_ID = B.BIKE_ID AND MI.RIDER_ID = R.RIDER_ID AND MI.BIKE_ID = :bind2
                                                    ORDER BY " . $_POST['sortBy'], $alltuples);
        } else if ($_POST['riderID'] != "" && $_POST['bikeID'] != "") {
            $result = executeResultBoundSQL("SELECT MI.RIDER_ID, R.NAME, R.PHONE_NUM, B.BIKE_ID, B.LATITUDE, B.LONGITUDE, MI.ISSUEDATETIME, MI.ISSUE_DESCRIPTION, MI.TECHNICIAN_ID, MT.NAME, MI.TECHNICIAN_NOTES, MI.RESOLVED_DATE
                                                    FROM BIKE B, RIDER R, MAINTENANCE_ISSUE MI, MAINTENANCE_TECHNICIAN MT
                                                    WHERE MI.TECHNICIAN_ID = MT.EMPLOYEE_ID AND MI.BIKE_ID = B.BIKE_ID AND MI.RIDER_ID = R.RIDER_ID AND MI.RIDER_ID = :bind1 AND MI.BIKE_ID = :bind2
                                                    ORDER BY " . $_POST['sortBy'], $alltuples);
        } else {
            $result = executePlainSQL("SELECT MI.RIDER_ID, R.NAME, R.PHONE_NUM, B.BIKE_ID, B.LATITUDE, B.LONGITUDE, MI.ISSUEDATETIME, MI.ISSUE_DESCRIPTION, MI.TECHNICIAN_ID, MT.NAME, MI.TECHNICIAN_NOTES, MI.RESOLVED_DATE
                                                    FROM BIKE B, RIDER R, MAINTENANCE_ISSUE MI, MAINTENANCE_TECHNICIAN MT
                                                    WHERE MI.TECHNICIAN_ID = MT.EMPLOYEE_ID AND MI.BIKE_ID = B.BIKE_ID AND MI.RIDER_ID = R.RIDER_ID
                                                    ORDER BY " . $_POST['sortBy']);
        }

        $columnNames = array("Rider ID", "Rider Name", "Phone Number", "Bike ID", "Latitude", "Longitude", "Issue Date(YY-MM-DD)/Time(HH-MM-SS)", "Issue Description", "Technician ID", "Technician Name", "Technician Notes", "Resolved Date");
        printTable($result, $columnNames);
    }

    // Commit to save changes...
    OCILogoff($db_conn);
} else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}

?>