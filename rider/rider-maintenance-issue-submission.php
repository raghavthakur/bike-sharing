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
                    <h3>RIDER - Maintenance Issue Submission Form</h3>

                    <form method="POST">

                        <p>
                            Logging in as...
                            <input type="number" name="rider_ID" size="20">
                            (enter a rider_ID)
                        </p>

                        <p>
                            This maintenance issue is about bike ID:
                            <input type="number" name="bikeID" size="20">
                        </p>

                        <p>
                            Describe the maintenance issue here: <br>
                            <textarea name="description" rows="5"
                                      cols="40"></textarea>
                        </p>

                        <input type="submit" value="Submit Issue" name="submitIssue">

                        <p>
                            Display a confirmation message containing the "issueID" and the current date/time here.
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

    if (array_key_exists('submitIssue', $_POST)) {
        $tuple = array(
            ":bind1" => $_POST['rider_ID'],
            ":bind2" => $_POST['bikeID'],
            ":bind3" => $_POST['description']

        );
        $alltuples = array(
            $tuple
        );

        if ($_POST['rider_ID'] != "" && $_POST['bikeID'] != "" && $_POST['description'] != "") {
            executeBoundSQL("INSERT INTO MAINTENANCE_ISSUE VALUES ('$date', :bind3, NULL, NULL, :bind1, :bind2, '00000011')", $alltuples);

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

    $riders = executePlainSQL("SELECT RIDER_ID FROM TRIP");

    $ridersNames = array("Rider ID");

    echo "<h1 style='color: black'>Showing all riders below.</h1>";
    printTable($riders, $ridersNames);

    $bikes = executePlainSQL("SELECT BIKE_ID FROM TRIP");

    $bikesNames = array("Bike ID");

    echo "<h1 style='color: black'>Showing all bikes below.</h1>";
    printTable($bikes, $bikesNames);

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