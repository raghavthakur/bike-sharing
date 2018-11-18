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
                    <h3>MAINTENANCE TECHNICIAN - Replacement Parts - Add</h3>

                    <form method="POST">
                        <p>
                            Enter part number:
                            <input type="text" name="newPartNo" size="10">
                        </p>
                        <p>
                            Enter part name:
                            <input type="text" name="newPartName" size="20">
                        </p>

                        <p>
                            Enter quantity:
                            <input type="number" name="initialQuantity" size="20">
                        </p>

                        <input type="submit" value="Add New Part" name="addNewPart">

                        <p>
                            Display the partID, partName, and quantity after creation in DB.
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

// Connect Oracle...
if ($db_conn) {

    if (array_key_exists('addNewPart', $_POST)) {
        //include '../debugger.php';
        // Adds tuple using data from user
        $tuple = array(
            ":bind1" => $_POST['newPartNo'],
            ":bind2" => $_POST['newPartName'],
            ":bind3" => $_POST['initialQuantity']

        );
        $alltuples = array(
            $tuple
        );
        executeBoundSQL("INSERT INTO REPLACEMENT_PART VALUES (:bind1, :bind2, :bind3)", $alltuples);
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
        echo "<h1 style='color: black'>New Part has been added!</h1>";
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
