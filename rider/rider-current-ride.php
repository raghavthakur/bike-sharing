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
                    <h3>RIDER - Current (Active) Ride</h3>

                    <form method="POST">

                        <p>
                            Logging in as...
                            <input type="number" name="rider_ID" size="20">
                            (enter a rider_ID)
                        </p>

                        <p>
                            If you have an active bike rental, you can get information about your current rental here.
                        </p>

                        <input type="submit" value="Get Info About Current Rental" name="getCurrentRentalInfo">

                        <p>
                            A table which displays information about the rider's current active rental. There should
                            also be a "Total Cost" column. If they don't have a current active rental, a message
                            should be displayed to tell them that they don't have an active rental.
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

    if (array_key_exists('getCurrentRentalInfo', $_POST)) {

        $tuple = array(
            ":bind1" => $_POST['rider_ID']
        );
        $alltuples = array(
            $tuple
        );

        if ($_POST['rider_ID'] != "") {

            $result = executePlainSQL("SELECT * FROM TRIP WHERE RIDER_ID = :bind1");

            $columnNames = array("Complaint ID", "Rider ID", "Rider Name", "Customer Rep. ID", "Customer Rep. Name", "Complaint Description", "Customer Rep. Notes", "Level of Urgency", "Date(YY-MM-DD)/Time(HH-MM-SS)", "Action Taken", "Resolved?");
            printTable($result, $columnNames);

            echo "<h1 style='color: black'>Showing trip for Rider ID: " . $_POST['rider_ID'] . " !</h1>";
        } else {
            echo "<h1 style='color: red'>Error! Enter Rider ID.</h1>";
        }
    } else {

        $result = executePlainSQL("SELECT RIDER_ID FROM TRIP");

        $columnNames = array("Rider ID");
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
