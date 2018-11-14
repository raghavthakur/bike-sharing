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
            <a id="customerservice" class="active" href="custrep-mainpage.php">> Customer Serv. Rep.</a>
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
                    <h3>CUSTOMER SERVICE REP. MAIN PAGE</h3>

                    <h4>Riders:</h4>

                    <p>
                        <a href="custrep-rider-info.php">Rider Info</a> <br> <br>
                        <a href="custrep-delete-rider.php">Delete a Rider</a> <br> <br>
                        <a href="custrep-rider-password-reset.php">Rider Password Reset</a> <br> <br>
                    </p>

                    <h4>Bikes and Areas:</h4>

                    <p>
                        <a href="custrep-bike-info.php">Bike Info</a> <br> <br>
                        <a href="custrep-return-areas.php">Return Areas</a> <br> <br>
                        <a href="custrep-maintenance-issues.php">Maintenance Issues</a> <br> <br>
                    </p>

                    <h4>Problems:</h4>

                    <p>
                        <a href="custrep-complaint-view.php">View Complaints</a> <br> <br>
                        <a href="custrep-complaint-resolve.php">Resolve Complaint</a>
                    </p>
                </div>
            </main>

            <footer>
                <p>
                    Copyright &copy; 2018 Bike Sharing <br>
                    <a href="mailto:email@domain.com">email@domain.com</a>
                </p>
                <form method="POST">
                    <input type="submit" value="Reset System" name="resetSystem">
                </form>
            </footer>
        </div>
    </div>
</div>
</html>

<?php

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_f4l0b", "a60250157", "dbhost.ugrad.cs.ubc.ca:1522/ug");

function executePlainSQL($cmdstr)
{
    // takes a plain (no bound variables) SQL command and executes it
    // echo "<br>running ".$cmdstr."<br>";
    global $db_conn, $success;
    $statement = OCIParse($db_conn, $cmdstr); // There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

    if (!$statement) {
        echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($db_conn); // For OCIParse errors pass the
        // connection handle
        echo htmlentities($e['message']);
        $success = False;
    }

    $r = OCIExecute($statement, OCI_DEFAULT);
    if (!$r) {
        echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
        $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
        echo htmlentities($e['message']);
        $success = False;
    } else {

    }
    return $statement;

}

function executeBoundSQL($cmdstr, $list)
{
    /* Sometimes the same statement will be executed for several times ... only
     the value of variables need to be changed.
     In this case, you don't need to create the statement several times;
     using bind variables can make the statement be shared and just parsed once.
     This is also very useful in protecting against SQL injection.
     See the sample code below for how this functions is used */

    global $db_conn, $success;
    $statement = OCIParse($db_conn, $cmdstr);

    if (!$statement) {
        echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($db_conn);
        echo htmlentities($e['message']);
        $success = False;
    }

    foreach ($list as $tuple) {
        foreach ($tuple as $bind => $val) {
            // echo $val;
            // echo "<br>".$bind."<br>";
            OCIBindByName($statement, $bind, $val);
            unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype

        }
        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($statement); // For OCIExecute errors pass the statement handle
            echo htmlentities($e['message']);
            echo "<br>";
            $success = False;
        }
    }

}

//include "../server.php";
//include "../reset-database.php";

if ($db_conn) {

    if (array_key_exists('resetSystem', $_POST)) {
        // Drop old table...
        echo "<br> dropping table <br>";
        include '../debugger.php';
        executePlainSQL("Drop table COMPLAINT cascade constraints");

        OCICommit($db_conn);

    }

    if ($_POST && $success) {
        //POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
        header("location: custrep-mainpage.php");
    } else {
        echo nl2br("POST Fail! \r\n");
    }

    //Commit to save changes...
    OCILogoff($db_conn);
} else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}
?>

