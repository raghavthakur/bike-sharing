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
                    <h3>MAINTENANCE TECHNICIAN - Add a New Bike</h3>

                    <form method="POST">
                        <p>
                            Enter bike id:
                            <input type="number" name="bikeID" size = "10">
                        </p>

                        <p>
                            Enter date purchased:
                            <input type="date" name="datePurchased">
                        </p>

                        <p>
                            Enter latitude:
                            <input type="number" name="latitude" size="20">
                        </p>

                        <p>
                            Enter longitude:
                            <input type="number" name="longitude" size="20">
                        </p>

                        <p>
                            Enter bike status:
                            <input type="text" name="bikeStatus" size="5">
                        </p>

                        <input type="submit" value="Add Bike" name="addBike">

                        <p>
                            Display confirmation message showing bikeID of the new bike.
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

// Prints result from select statement
function printResult($result)
{
    echo "<table>";
    echo "<tr><th>BIKE_ID</th><th>DATE_PURCHASED</th><th>LATITUDE</th><th>LONGITUDE</th><th>IS_BROKEN</th></tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row["BIKE_ID"] . "</td><td>" . $row["DATE_PURCHASED"] . "</td><td>" . $row["LATITUDE"] . "</td><td>" . $row["LONGITUDE"] . "</td><td>" . $row["IS_BROKEN"] . "</td></tr>"; //or just use "echo $row[0]"
    }
    echo "</table>";

}

// Connect Oracle...
if ($db_conn) {

    if (array_key_exists('addBike', $_POST)) {
        //include '../debugger.php';
        // Adds tuple using data from user
        $tuple = array(
            ":bind1" => $_POST['bikeID'],
            ":bind2" => $_POST['datePurchased'],
            ":bind3" => $_POST['latitude'],
            ":bind4" => $_POST['longitude'],
            ":bind5" => $_POST['bikeStatus']

        );
        $alltuples = array(
            $tuple
        );
        executeBoundSQL("INSERT INTO BIKE VALUES (BIKE_ID =:bind1, DATE_PURCHASED= :bind2, LATITUDE= :bind3, LONGITUDE = :bind4, is_BROKEN = :bind5)", $alltuples);
        printResult($result);
        OCICommit($db_conn);

    } else {
        $result = executePlainSQL("SELECT * FROM BIKE");
        printResult($result);
    }
    if ($_POST && $success) {
        echo "<h1 style='color: black'>Bike has been added!</h1>";
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

