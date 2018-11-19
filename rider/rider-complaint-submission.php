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
                            This complaint is about the following customer service rep. (enter ID):
                            <input type="number" name="cust_rep_ID" size="20">
                        </p>

                        <p>
                            Enter your complaint here: <br>
                            <textarea name="description" rows="5"
                                      cols="40"></textarea>
                        </p>

                        <p>
                            What is the priority level of this complaint?
                            <input type="radio" name="urgency" value="LOW" checked>Low
                            <input type="radio" name="urgency" value="MEDIUM">Medium
                            <input type="radio" name="urgency" value="HIGH">High
                        </p>

                        <input type="submit" value="Submit Complaint" name="submitComplaint">

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
            ":bind2" => $_POST['cust_rep_ID'],
            ":bind3" => $_POST['description'],
            ":bind4" => $_POST['urgency']

        );
        $alltuples = array(
            $tuple
        );

        if ($_POST['rider_ID'] != "" && $_POST['cust_rep_ID'] != "" && $_POST['description'] != "") {

            $maxID = executePlainSQL("SELECT MAX(COMPLAINT_ID) AS MAX FROM COMPLAINT");
            $row = OCI_Fetch_Array($maxID, OCI_BOTH);
            $nextNum = $row["MAX"] + 1;

            executeBoundSQL("INSERT INTO COMPLAINT VALUES ($nextNum, :bind1, :bind2, :bind3, null, :bind4, '$date', NULL, 'N')", $alltuples);

            OCICommit($db_conn);

        } else {
            echo "<h1 style='color: red'>Please fill in all fields!</h1>";
        }

        $result = executePlainSQL("SELECT COMPLAINT_ID, RIDER_ID, CUSTOMER_REP_ID, CUST_DESCRIPTION, URGENCY_LEVEL, COMPLAINTDATETIME FROM COMPLAINT");

        $columnNames = array("Complaint ID", "Rider ID", "Customer Rep ID", "Description", "Urgency", "Date and Time");
        printTable($result, $columnNames);
    }
    // show employee IDs and names table before clicking submit complaint
    else {
        // order by employee ID
        $result = executePlainSQL("SELECT EMPLOYEE_ID, NAME FROM CUSTOMER_SERVICE_REP ORDER BY EMPLOYEE_ID ASC");

        $columnNames = array("Employee ID", "Employee Name");
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