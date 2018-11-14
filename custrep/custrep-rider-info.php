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
                    <h3>CUSTOMER SERVICE REP. - Rider Info</h3>

                    <form method="POST">

                        <input type="submit" value="Get All Rider Info" name="getAllRiderInfo">

                        <p>
                            Table showing all riders and their info. We have to use a VIEW to satisfy the project
                            requirements. As we wrote in Deliverable 11 of our formal spec document, we will use
                            a VIEW for Customer Service Reps for the Rider table to prevent them from gaining access
                            to the Riders' credit card information (and password if we have that in the database). <br>
                            <br>
                            IMPORTANT: we should have a column for "Number of Maintenance Issues Submitted". This is
                            to satisfy the first query listed under Deliverable 7 in our formal spec - have to do a
                            GROUP BY. We could also have a column for "Number of Complaints Submitted"
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
    echo "<br>Got data from table Bike:<br>";
    echo "<table>";
    echo "<tr><th>BIKE_ID</th><th>DATE_PURCHASED</th><th>LATITUDE</th><th>LOGITUDE</th></tr><th>IS_BROKEN</th>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row["BIKE_ID"] . "</td><td>" . $row["DATE_PURCHASED"] . "</td><td>" . $row["LATITUDE"] . "</td><td>" . $row["LOGITUDE"] . "</td><td>" . $row["IS_BROKEN"] . "</td></tr>"; //or just use "echo $row[0]"
    }
    echo "</table>";

}

if ($db_conn) {

    if (array_key_exists('getAllRiderInfo', $_POST)) {
        $result = executePlainSQL("SELECT * FROM RIDER");
        printResult($result);
        OCICommit($db_conn);
    }

    if ($_POST && $success) {
        echo "<h1 style='color: black'>Showing all riders!</h1>";
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