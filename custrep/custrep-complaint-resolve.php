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
                    <h3>CUSTOMER SERVICE REP. - Resolve Complaint</h3>

                    <form method="POST">

                        <p>
                            Logging in as...
                            <input type="number" name="cust_rep_ID" size="20">
                            (enter a customer_rep_ID)
                        </p>

                        <p>
                            Enter the complaint ID resolve:
                            <input type="number" name="complaint_ID" size="20">
                        </p>

                        <p>
                            If you have any notes about the complaint, enter them here: <br>
                            <textarea name="agentNotes" rows="5"
                                      cols="40">Please enter your notes.</textarea>
                        </p>

                        <p>
                            What action is being taken to resolve this complaint? <br>
                            <textarea name="actionTaken" rows="5"
                                      cols="40">Please enter your action.</textarea>
                        </p>

                        <input type="submit" value="Resolve Complaint" name="resolveComplaint">

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

    if (array_key_exists('resolveComplaint', $_POST)) {

        $tuple = array(
            ":bind1" => $_POST['cust_rep_ID'],
            ":bind2" => $_POST['complaint_ID'],
            ":bind3" => $_POST['agentNotes'],
            ":bind4" => $_POST['actionTaken']
        );
        $alltuples = array(
            $tuple
        );

        if ($_POST['cust_rep_ID'] != "" && $_POST['complaint_ID'] != "") {
            executeBoundSQL("UPDATE COMPLAINT SET IS_RESOLVED = 'Y', AGENT_NOTES = :bind3, ACTION_TAKEN = :bind4 WHERE CUSTOMER_REP_ID = :bind1 AND COMPLAINT_ID = :bind2", $alltuples);
            OCICommit($db_conn);

            echo "<h1 style='color: black'>The complaint " . $_POST['complaint_ID'] . " has been resolved!</h1>";
        } else {
            echo "<h1 style='color: red'>Error! Enter Customer Rep ID and Complaint ID.</h1>";
        }
    }

    $result = executePlainSQL("SELECT C.COMPLAINT_ID, C.RIDER_ID, R.NAME, C.CUSTOMER_REP_ID, CSR.NAME, C.CUST_DESCRIPTION, C.AGENT_NOTES, C.URGENCY_LEVEL, C.COMPLAINTDATETIME, C.ACTION_TAKEN, C.IS_RESOLVED
                                                    FROM COMPLAINT C, RIDER R, CUSTOMER_SERVICE_REP CSR
                                                    WHERE C.RIDER_ID = R.RIDER_ID AND C.CUSTOMER_REP_ID = CSR.EMPLOYEE_ID");
    $columnNames = array("Complaint ID", "Rider ID", "Rider Name", "Customer Rep. ID", "Customer Rep. Name", "Complaint Description", "Customer Rep. Notes", "Level of Urgency", "Date(YY-MM-DD)/Time(HH-MM-SS)", "Action Taken", "Resolved?");
    printTable($result, $columnNames);

    // Commit to save changes...
    OCILogoff($db_conn);
} else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}

?>
