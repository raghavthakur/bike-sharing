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
            <a id="customerservice" class="active" href="custrep-mainpage.html">&gt; Customer Serv. Rep.</a>
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
            <li class="submenu active"><span>&gt; </span><a class="active" href="custrep-mainpage.html">Customer
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
                    <h3>CUSTOMER SERVICE REP. - Return Areas</h3>

                    <form method="POST" action="custrep-return-areas.php">

                        <input type="submit" value="Get Return Area Info" name="getReturnAreaInfo">

                        <p>
                            Table showing all return areas and their info. There should be a column for "Number of
                            Rides That Ended Here" to satisfy our GROUP BY requirements. In our formal spec document,
                            under Deliverable 7, the second query we described does not fit well into the current
                            website design, so the query for this page should serve as a replacement GROUP BY query.
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
    echo "<tr><th>LOCATION_ID</th><th>LATITUDE</th><th>LOGITUDE</th><th>RADIUS</th></tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row["LOCATION_ID"] . "</td><td>" . $row["LATITUDE"] . "</td><td>" . $row["LOGITUDE"] . "</td><td>" . $row["RADIUS"] . "</td></tr>"; //or just use "echo $row[0]"
    }
    echo "</table>";

}

// Connect to Oracle Database
if ($db_conn) {

    $result = executePlainSQL("SELECT * FROM DESIGNATED_RETURN_AREA");
    printResult($result);
    echo "Result";

    OCILogoff($db_conn);
} else {
    echo "cannot connect";
    $e = OCI_Error();
    echo htmlentities($e['message']);
}
?>
