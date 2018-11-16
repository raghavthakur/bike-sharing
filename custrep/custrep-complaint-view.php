<html lang="en">
<head>
    <title>Bike Sharing</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../project.js" type="text/javascript" defer></script>
    <link rel="stylesheet" href="../project.css">
    <style>
        /* Table */
        table {
            width: 100%;
            border: 1px solid black;
        }

        th {
            font-family: Arial, Helvetica, sans-serif;
            font-size: .7em;
            background: #666;
            color: #FFF;
            padding: 2px 6px;
            border-collapse: separate;
            border: 1px solid #000;
        }

        td {
            font-family: Arial, Helvetica, sans-serif;
            font-size: .7em;
            border: 1px solid #DDD;
            color: black;
        }
    </style>
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
                            Enter employee ID (optional): <input type="number" name="employeeID" size="20">
                        </p>

                        <p>
                            Sort by:
                            <select name="groupBy">
                                <option value="is_resolved" selected="selected">Status (Resolved/Unresolved)</option>
                                <option value="employeeID">Employee ID</option>
                                <option value="riderID">Rider ID</option>
                                <option value="complaintDateTime">Date</option>
                            </select>
                        </p>

                        <input type="submit" value="View Complaints" name="viewComplaints">

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

// Prints result from select statement
function printResult($result)
{
    echo "<table>";
    echo "<tr>
<th>complaint_ID</th>
<th>rider_ID</th>
<th>rider_name</th>
<th>customer_rep_ID</th>
<th>employee_name</th>
<th>cust_description</th>
<th>agent_notes</th>
<th>urgency_level</th>
<th>complaintDateTime</th>
<th>action_taken</th>
<th>is_resolved</th>
</tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr>
<td>" . $row["complaint_ID"] . "</td>
<td>" . $row["rider_ID"] . "</td>
<td>" . $row["name"] . "</td>
<td>" . $row["customer_rep_ID"] . "</td>
<td>" . $row["name"] . "</td>
<td>" . $row["cust_description"] . "</td>
<td>" . $row["agent_notes"] . "</td>
<td>" . $row["urgency_level"] . "</td>
<td>" . $row["complaintDateTime"] . "</td>
<td>" . $row["action_taken"] . "</td>
<td>" . $row["is_resolved"] . "</td>
</tr>"; //or just use "echo $row[0]"
    }
    echo "</table>";

}

if ($db_conn) {

    if (array_key_exists('viewComplaints', $_POST)) {
        //Getting the values from user and insert data into the table
        $tuple = array(
            ":bind1" => $_POST['riderID'],
            ":bind2" => $_POST['employeeID'],
            ":bind3" => $_POST['groupBy']
        );
        $alltuples = array(
            $tuple
        );
        executeBoundSQL("SELECT complaint_ID, c.rider_ID, r.name, customer_rep_ID, csr.name, cust_description, agent_notes, urgency_level, complaintDateTime, action_taken, is_resolved
        FROM COMPLAINT c, RIDER r, CUSTOMER_SERVICE_REP csr
        WHERE c.RIDER_ID = r.RIDER_ID AND c.CUSTOMER_REP_ID = csr.EMPLOYEE_ID", $alltuples);
        OCICommit($db_conn);
    }

    // Commit to save changes...
    OCILogoff($db_conn);
} else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}

?>