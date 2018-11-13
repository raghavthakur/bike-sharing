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
                    <h3>CUSTOMER SERVICE REP. - Delete a Rider</h3>

                    <form method="POST" action="custrep-delete-rider.php">

                        <p>
                            Delete a rider from the system:
                            <?php
                            if ($db_conn) {
                                echo "<select name='RIDER_ID'>";
                                foreach ($results as $row) {
                                    echo "<option value='" . $row['RIDER_ID'] . "'>" . $row['RIDER_ID'] . "</option>";
                                }
                                echo "</select>";
                             }
                            ?>
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

require '../server.php';

// Connect Oracle...
if ($db_conn) {

    if (array_key_exists('deleteRider', $_POST)) {
        // Delete tuple using data from user
        $tuple = array(
            ":bind1" => $_POST['riderID']
        );
        $alltuples = array(
            $tuple
        );
        executeBoundSQL("DELETE FROM RIDER WHERE RIDER_ID=:bind1", $alltuples);
        OCICommit($db_conn);

    }

    if ($_POST && $success) {
// POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
        header("location: custrep-delete-rider.php");
    }


// Commit to save changes...
    OCILogoff($db_conn);
} else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}

?>

