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
            <li class="submenu active"><span>&gt; </span><a class="active" href="custrep-mainpage.php">Customer Service</a></li>
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
                    <h3>CUSTOMER SERVICE REP. - Delete a Rider</h3>

                    <form method="POST">

                        <p>
                            Delete a rider from the system:
                        </p>

                        <p>
                            Enter rider ID: <input type="number" name="riderID" size="20">
                        </p>

                        <input type="submit" value="Delete Rider" name="deleteRider">

                        <p>
                            Display a short confirmation message here to say rider was deleted.
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

// Connect Oracle...
if ($db_conn) {

    if (array_key_exists('deleteRider', $_POST)) {
        $tuple = array(
            ":bind1" => $_POST['riderID']
        );
        $alltuples = array(
            $tuple
        );
        executeBoundSQL("DELETE FROM CUSTREP_RIDER_VIEW WHERE RIDER_ID=:bind1", $alltuples);
        OCICommit($db_conn);

    } else {
        $result = executePlainSQL("SELECT * FROM CUSTREP_RIDER_VIEW ORDER BY RIDER_ID");

        $columnNames = array("Rider ID", "Wallet ID", "Name of Rider", "Phone Number", "Email", "Address", "Available eCoins", "Number Maintenance Issues", "Number of Complaints");
        printTable($result, $columnNames);
    }
    if ($_POST && $success) {
        echo "<h1 style='color: black'>Rider has been removed!</h1>";
        $result = executePlainSQL("SELECT * FROM CUSTREP_RIDER_VIEW ORDER BY RIDER_ID");

        $columnNames = array("Rider ID", "Wallet ID", "Name of Rider", "Phone Number", "Email", "Address", "Available eCoins", "Number Maintenance Issues", "Number of Complaints");
        printTable($result, $columnNames);
    } else if (!$success) {
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

