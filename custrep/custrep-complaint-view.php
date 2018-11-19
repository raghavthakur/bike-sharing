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
            <a id="customerservice" class="active" href="custrep-mainpage.php">&gt; Customer Serv. Rep.</a>
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
                    <h3>CUSTOMER SERVICE REP. - View Complaints</h3>

                    <form method="POST">

                        <p>
                            Enter rider ID (optional): <input type="number" name="riderID" size="20">
                        </p>

                        <p>
                            Enter employee ID (optional): <input type="number" name="custrepID" size="20">
                        </p>

                        <p>
                            Sort by:
                            <select name="sortBy">
                                <option value="C.URGENCY_LEVEL"
                                <option value="C.IS_RESOLVED">Resolved?</option>
                                <option value="R.RIDER_ID">Rider ID</option>
                                <option value="C.CUSTOMER_REP_ID">Customer Rep ID</option>
                                <option value="C.COMPLAINTDATETIME">Date and Time</option>
                            </select>
                        </p>

                        <input type="submit" value="View All Complaints" name="viewAllComplaints">

                        <p>
                            Display a table here according to the above input. Make sure to include columns for
                            riderName and employeeName so that we have to join 3 tables.
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

    if (array_key_exists('viewAllComplaints', $_POST)) {

        $tuple = array(
            ":bind1" => $_POST['riderID'],
            ":bind2" => $_POST['custrepID']
        );
        $alltuples = array(
            $tuple
        );

        if ($_POST['riderID'] != "" && $_POST['custrepID'] == "") {
            $result = executeResultBoundSQL("SELECT C.COMPLAINT_ID, C.RIDER_ID, R.NAME, C.CUSTOMER_REP_ID, CSR.NAME, C.CUST_DESCRIPTION, C.AGENT_NOTES, C.URGENCY_LEVEL, C.COMPLAINTDATETIME, C.ACTION_TAKEN, C.IS_RESOLVED
                                                    FROM COMPLAINT C, RIDER R, CUSTOMER_SERVICE_REP CSR
                                                    WHERE C.RIDER_ID = R.RIDER_ID AND C.CUSTOMER_REP_ID = CSR.EMPLOYEE_ID AND R.RIDER_ID = :bind1
                                                    ORDER BY " . $_POST['sortBy'], $alltuples);
        } else if ($_POST['riderID'] == "" && $_POST['custrepID'] != "") {
            $result = executeResultBoundSQL("SELECT C.COMPLAINT_ID, C.RIDER_ID, R.NAME, C.CUSTOMER_REP_ID, CSR.NAME, C.CUST_DESCRIPTION, C.AGENT_NOTES, C.URGENCY_LEVEL, C.COMPLAINTDATETIME, C.ACTION_TAKEN, C.IS_RESOLVED
                                                    FROM COMPLAINT C, RIDER R, CUSTOMER_SERVICE_REP CSR
                                                    WHERE C.RIDER_ID = R.RIDER_ID AND C.CUSTOMER_REP_ID = CSR.EMPLOYEE_ID AND C.CUSTOMER_REP_ID = :bind2
                                                    ORDER BY " . $_POST['sortBy'], $alltuples);
        } else if ($_POST['riderID'] != "" && $_POST['custrepID'] != "") {
            $result = executeResultBoundSQL("SELECT C.COMPLAINT_ID, C.RIDER_ID, R.NAME, C.CUSTOMER_REP_ID, CSR.NAME, C.CUST_DESCRIPTION, C.AGENT_NOTES, C.URGENCY_LEVEL, C.COMPLAINTDATETIME, C.ACTION_TAKEN, C.IS_RESOLVED
                                                    FROM COMPLAINT C, RIDER R, CUSTOMER_SERVICE_REP CSR
                                                    WHERE C.RIDER_ID = R.RIDER_ID AND C.CUSTOMER_REP_ID = CSR.EMPLOYEE_ID AND R.RIDER_ID = :bind1 AND C.CUSTOMER_REP_ID = :bind2
                                                    ORDER BY " . $_POST['sortBy'], $alltuples);
        } else {
            $result = executePlainSQL("SELECT C.COMPLAINT_ID, C.RIDER_ID, R.NAME, C.CUSTOMER_REP_ID, CSR.NAME, C.CUST_DESCRIPTION, C.AGENT_NOTES, C.URGENCY_LEVEL, C.COMPLAINTDATETIME, C.ACTION_TAKEN, C.IS_RESOLVED
                                                    FROM COMPLAINT C, RIDER R, CUSTOMER_SERVICE_REP CSR
                                                    WHERE C.RIDER_ID = R.RIDER_ID AND C.CUSTOMER_REP_ID = CSR.EMPLOYEE_ID
                                                    ORDER BY " . $_POST['sortBy']);
        }

        $columnNames = array("Complaint ID", "Rider ID", "Rider Name", "Customer Rep. ID", "Customer Rep. Name", "Complaint Description", "Customer Rep. Notes", "Level of Urgency", "Date(YY-MM-DD)/Time(HH-MM-SS)", "Action Taken", "Resolved?");
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