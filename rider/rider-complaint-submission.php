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
                    <h3>RIDER - Complaint Submission Form</h3>

                    <form method="POST">

                        <p>
                            Logging in as...
                            <input type="number" name="rider_ID" size="20">
                            (enter a rider_ID)
                        </p>

                        <p>
                            This complaint is about the following employee:
                            <select name="employeeId">
                                <option value="put the employee ID here">Show employee name and ID from the DB here
                                </option>
                                <option value="put the employee ID here">Show employee name and ID from the DB here
                                </option>
                                <option value="put the employee ID here">Show employee name and ID from the DB here
                                </option>
                                <option value="put the employee ID here">Show employee name and ID from the DB here
                                </option>
                            </select>
                        </p>

                        <p>
                            Enter your complaint here: <br>
                            <textarea name="description" rows="5"
                                      cols="40">Use PHP to get the contents of this textarea</textarea>
                        </p>

                        <p>
                            What is the priority level of this complaint?
                            <input type="radio" name="urgency" value="Low">Low
                            <input type="radio" name="urgency" value="Moderate">Moderate
                            <input type="radio" name="urgency" value="High">High
                        </p>

                        <input type="submit" value="Submit Complaint" name="submitcomplaint">

                        <p>Display a confirmation message containing the "complaintID" and the current date/time
                            here.</p>

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

    if (array_key_exists('submitComplaint', $_POST)) {
        $tuple = array(
            ":bind1" => $_POST['rider_ID'],
            ":bind2" => $_POST['employeeID'],
            ":bind3" => $_POST['description'],
            ":bind4" => $_POST['urgency']

        );
        $alltuples = array(
            $tuple
        );

        if ($_POST['rider_ID'] != "" && $_POST['employeeID'] != "" && $_POST['description'] != "" && $_POST['ugrency'] != "" ) {
            executeBoundSQL("INSERT INTO COMPLAINT VALUES ('$date', :bind3, NULL, NULL, :bind1, :bind2, '00000011')", $alltuples);

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