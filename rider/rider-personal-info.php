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
                    <h3>RIDER - Personal Information</h3>

                    <form method="POST" action="new-oracle-test.php">

                        <p>
                            Logging in as...
                            <input type="number" name="riderID" size="20">
                            (enter a rider_ID)
                        </p>

                        <input type="submit" value="Display Personal Info" name="getPersonalInfo">

                        <p>
                            A table showing the rider's personal information here.
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

    if (array_key_exists('getPersonalInfo', $_POST)) {
        //include '../debugger.php';
        // Delete tuple using data from user
        $tuple = array(
            ":bind1" => $_POST['riderID']
        );
        $alltuples = array(
            $tuple
        );
        executeBoundSQL("SELECT NAME, EMAIL, PHONE_NUM, ADDRESS FROM RIDER WHERE RIDER_ID = :bind1", $alltuples);
        OCICommit($db_conn);

        $result = executePlainSQL("SELECT NAME, EMAIL, PHONE_NUM, ADDRESS FROM RIDER WHERE RIDER_ID = :bind1");

        $columnNames = array("Name of Rider", "Email", "Phone Number", "Address");
        printTable($result, $columnNames);

    } else {
        $default = executePlainSQL("SELECT NAME, EMAIL, PHONE_NUM, ADDRESS FROM RIDER");

        $riderTable = array("Name of Rider", "Email", "Phone Number", "Address");
        printTable($default, $riderTable);
    }

    // Commit to save changes...
    OCILogoff($db_conn);
} else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}

?>