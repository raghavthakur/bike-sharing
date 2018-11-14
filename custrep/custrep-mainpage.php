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

include "../server.php";
//include "../reset-database.php";

if ($db_conn) {

    if (array_key_exists('resetSystem', $_POST)) {
        // Drop old table...
        dropTables();
        createTables();
        OCICommit($db_conn);
    }

    //Commit to save changes...
    OCILogoff($db_conn);
} else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}

function dropTables() {
    executePlainSQL("drop table Complaint cascade constraints");
    executePlainSQL("drop table Refund cascade constraints");
    executePlainSQL("drop table Replacement_Part cascade constraints");
    executePlainSQL("drop table Issue_Requires_Part cascade constraints");
    executePlainSQL("drop table Maintenance_Issue cascade constraints");
    executePlainSQL("drop table Customer_Service_Rep cascade constraints");
    executePlainSQL("drop table Maintenance_Technician cascade constraints");
    executePlainSQL("drop table Designated_Return_Area cascade constraints");
    executePlainSQL("drop table Trip cascade constraints");
    executePlainSQL("drop table Rider cascade constraints");
    executePlainSQL("drop table Bike cascade constraints");
}

function createTables() {
    executePlainSQL("CREATE TABLE Rider(
	rider_ID 		INTEGER,
	wallet_ID 		INTEGER NOT NULL UNIQUE,
	name 			CHAR(50),
	phone_num 		INTEGER,
	email 			CHAR(50),
	address 		CHAR(100),
	creditCardNo 	INTEGER,
	creditCardExp 	INTEGER,
	eCoins 			INTEGER,
	PRIMARY KEY (rider_ID))");

    executePlainSQL("CREATE TABLE Bike (
	bike_ID 		INTEGER,
	date_purchased 	date,
	latitude 		NUMBER,
	longitude 		NUMBER,
	is_broken 		CHAR(1),
	PRIMARY KEY (bike_ID))");

    executePlainSQL("CREATE TABLE Replacement_Part(
	partNo		INTEGER,
	part_name	CHAR(50),
	quantity 	INTEGER,
	PRIMARY KEY (partNo))");

    executePlainSQL("CREATE TABLE Maintenance_Technician(
	employee_ID 			INTEGER,
	name 					CHAR(50),
	phone_num 				INTEGER,
	email 					CHAR(50),
	address 				CHAR(100),
	drivers_license_num		INTEGER,
	license_expiry_date		date,
	PRIMARY KEY (employee_ID))");

    executePlainSQL("CREATE TABLE Customer_Service_Rep(
	employee_ID 	INTEGER,
	name 			CHAR(50),
	phone_num 		INTEGER,
	email 			CHAR(50),
	address 		CHAR(100),
	alias_name		CHAR(50),
	PRIMARY KEY (employee_ID))");

    executePlainSQL("CREATE TABLE Designated_Return_Area (
	location_ID 	INTEGER,
	latitude 		NUMBER,
	longitude 		NUMBER,
	radius 			NUMBER,
	PRIMARY KEY (location_ID))");

    executePlainSQL("CREATE TABLE Maintenance_Issue(
	issueDateTime		timestamp,
	issue_description	Char(255),
	technican_notes		CHAR(255),
	resolved_date		date,
	bike_ID				INTEGER,
	rider_ID			INTEGER NOT NULL,
	technician_ID		INTEGER NOT NULL,
	PRIMARY KEY (issueDateTime, bike_ID),
	FOREIGN KEY (bike_ID) REFERENCES Bike(bike_ID) ON DELETE CASCADE,
	FOREIGN KEY (rider_ID) REFERENCES Rider(rider_ID) ON DELETE CASCADE,
	FOREIGN KEY (technician_ID) REFERENCES Maintenance_Technician(employee_ID))");

    executePlainSQL("CREATE TABLE Issue_Requires_Part(
	partNo			INTEGER,
	issueDateTime	timestamp,
	bike_ID			INTEGER,
	PRIMARY KEY (partNo, issueDateTime, bike_ID),
	FOREIGN KEY (partNo) REFERENCES Replacement_Part(partNo),
	FOREIGN KEY (issueDateTime, bike_ID) REFERENCES Maintenance_Issue(issueDateTime, bike_ID) ON DELETE CASCADE)");

    executePlainSQL("CREATE TABLE Complaint(
	complaint_ID		INTEGER,
	rider_ID 			INTEGER NOT NULL,
	customer_rep_ID 	INTEGER,
	cust_description 	CHAR(255),
	agent_notes 		CHAR(255),
	urgency_level 		CHAR(50),
	complaintDateTime	timestamp,
	action_taken 		CHAR(255),
	is_resolved 		CHAR(1),
	PRIMARY KEY (complaint_ID),
	FOREIGN KEY (rider_ID) REFERENCES Rider(rider_ID) ON DELETE CASCADE,
	FOREIGN KEY (customer_rep_ID) REFERENCES Customer_Service_Rep(employee_ID))");

    executePlainSQL("CREATE TABLE Trip(
	trip_ID 			INTEGER,
	rider_ID 			INTEGER,
	bike_ID 			INTEGER NOT NULL,
	end_location_ID 	INTEGER,
	start_dateTime 		timestamp,
	end_dateTime		timestamp,
	tokens_due 			INTEGER,
	start_latitude 		NUMBER,
	start_longitude 	NUMBER,
	end_latitude 		NUMBER,
	end_longitude 		NUMBER,
	PRIMARY KEY (trip_ID),
	FOREIGN KEY (rider_ID) REFERENCES Rider(rider_ID) ON DELETE CASCADE,
	FOREIGN KEY (bike_ID) REFERENCES Bike(bike_ID),
	FOREIGN KEY (end_location_ID) REFERENCES Designated_Return_Area(location_ID) ON DELETE SET NULL)");

    executePlainSQL("CREATE TABLE Refund(
	refund_ID 			INTEGER,
	rider_ID 			INTEGER NOT NULL,
	employee_ID 		INTEGER NOT NULL,
	refundDate 			date,
	refundTime 			timestamp,
	reason 				CHAR(255),
	PRIMARY KEY (refund_ID),
	FOREIGN KEY (rider_ID) REFERENCES Rider(rider_ID) ON DELETE CASCADE,
	FOREIGN KEY (employee_ID) REFERENCES Customer_Service_Rep(employee_ID))");
}

?>

