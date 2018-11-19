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
                    <h3>MAINTENANCE TECHNICIAN - Replacement Parts - Increment/Decrement Quantity</h3>

                    <form method="POST">

                        <h4>Increment/Decrement Quantity:</h4>

                        <p>
                            Enter a part ID:
                            <input type="number" name="partID" size="20">
                        </p>

                        <input type="submit" value="Increment Quantity" name="incrementQuantity">
                        <input type="submit" value="Decrement Quantity" name="decrementQuantity">

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


// Connect Oracle....
if ($db_conn) {

    if (array_key_exists('incrementQuantity', $_POST)) {

        $tuple = array(
            ":bind1" => $_POST['partID']
        );
        $alltuples = array(
            $tuple
        );

        if ($_POST['partID'] != "") {
            executeBoundSQL("UPDATE REPLACEMENT_PART SET QUANTITY = QUANTITY + 1 WHERE PARTNO = :bind1", $alltuples);
            OCICommit($db_conn);
        } else {
            echo "<h1 style='color: red'>Error! Enter Part ID.</h1>";
        }
    }

    if (array_key_exists('decrementQuantity', $_POST)) {

        $tuple = array(
            ":bind1" => $_POST['partID']
        );
        $alltuples = array(
            $tuple
        );

        if ($_POST['partID'] != "") {
            executeBoundSQL("UPDATE REPLACEMENT_PART SET QUANTITY = QUANTITY - 1 WHERE PARTNO = :bind1", $alltuples);
            OCICommit($db_conn);
        } else {
            echo "<h1 style='color: red'>Error! Enter Part ID.</h1>";
        }
    }

    $result = executePlainSQL("SELECT * FROM REPLACEMENT_PART ORDER BY PARTNO");

    $columnNames = array("Part ID", "Part Name", "Quantity");
    printTable($result, $columnNames);

    if (!$success){
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
