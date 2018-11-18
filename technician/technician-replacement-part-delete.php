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
                    <h3>MAINTENANCE TECHNICIAN - Replacement Parts - Delete</h3>

                    <form method="POST">

                        <h4>Delete an Existing Part:</h4>

                        <p>
                            Enter part ID:
                            <input type="number" name="partIDToDelete" size="20">
                        </p>

                        <input type="submit" value="Delete Part" name="deletePart">

                        <p>
                            Display confirmation message that [partID]-[partName] has been deleted. If the partID that
                            they entered does not exist in the DB, then an error message should be displayed here
                            instead.
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

require '../server.php';
include "../print-table.php";

// Prints result from select statement
function printResult($result)
{
    echo "<table>";
    echo "<tr><th>PARTNO</th><th>PART_NAME</th><th>QUANTITY</th></tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row["PARTNO"] . "</td><td>" . $row["PART_NAME"] . "</td><td>" . $row["QUANTITY"] . "</td></tr>"; //or just use "echo $row[0]"
    }
    echo "</table>";

}

// Connect Oracle...
if ($db_conn) {

    if (array_key_exists('deletePart', $_POST)) {
        //include '../debugger.php';
        // Delete tuple using data from user
        $tuple = array(
            ":bind1" => $_POST['partIDToDelete']
        );
        $alltuples = array(
            $tuple
        );
        executeBoundSQL("DELETE FROM REPLACEMENT_PART WHERE PARTNO = :bind1", $alltuples);
        OCICommit($db_conn);

        $result = executePlainSQL("SELECT * FROM REPLACEMENT_PART ORDER BY PART_NO DESC");

        $columnNames = array("Part No", "Part Name", "Quantity");
        printTable($result, $columnNames);

    } else {
        $result = executePlainSQL("SELECT * FROM REPLACEMENT_PART ORDER BY PART_NO DESC");

        $columnNames = array("Part No", "Part Name", "Quantity");
        printTable($result, $columnNames);
    }
    if ($_POST && $success) {
        echo "<h1 style='color: black'>Part has been removed!</h1>";
    } else if (!$success){
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

