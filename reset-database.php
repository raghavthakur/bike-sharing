<?php
/**
 * Created by PhpStorm.
 * User: Raghav Thakur
 * Date: 2018-11-13
 * Time: 7:37 PM
 */

require "server.php";

executePlainSQL("drop table Complaint cascade constraints");
//executePlainSQL("drop table Refund cascade constraints");
//executePlainSQL("drop table Replacement_Part cascade constraints");
//executePlainSQL("drop table Issue_Requires_Part cascade constraints");
//executePlainSQL("drop table Maintenance_Issue cascade constraints");
//executePlainSQL("drop table Customer_Service_Rep cascade constraints");
//executePlainSQL("drop table Maintenance_Technician cascade constraints");
//executePlainSQL("drop table Designated_Return_Area cascade constraints");
//executePlainSQL("drop table Trip cascade constraints");
//executePlainSQL("drop table Rider cascade constraints");
//executePlainSQL("drop table Bike cascade constraints");

commit;

//    echo "<br>Creating new tables...<br>";
//
//    executePlainSQL("CREATE TABLE Rider(
//	rider_ID 		INTEGER,
//	wallet_ID 		INTEGER NOT NULL UNIQUE,
//	name 			CHAR(50),
//	phone_num 		INTEGER,
//	email 			CHAR(50),
//	address 		CHAR(100),
//	creditCardNo 	INTEGER,
//	creditCardExp 	INTEGER,
//	eCoins 			INTEGER,
//	PRIMARY KEY (rider_ID))");
//
//    executePlainSQL("CREATE TABLE Bike (
//	bike_ID 		INTEGER,
//	date_purchased 	date,
//	latitude 		NUMBER,
//	longitude 		NUMBER,
//	is_broken 		CHAR(1),
//	PRIMARY KEY (bike_ID))");
//
//    executePlainSQL("CREATE TABLE Replacement_Part(
//	partNo		INTEGER,
//	part_name	CHAR(50),
//	quantity 	INTEGER,
//	PRIMARY KEY (partNo))");
//
//    executePlainSQL("CREATE TABLE Maintenance_Technician(
//	employee_ID 			INTEGER,
//	name 					CHAR(50),
//	phone_num 				INTEGER,
//	email 					CHAR(50),
//	address 				CHAR(100),
//	drivers_license_num		INTEGER,
//	license_expiry_date		date,
//	PRIMARY KEY (employee_ID))");
//
//    executePlainSQL("CREATE TABLE Customer_Service_Rep(
//	employee_ID 	INTEGER,
//	name 			CHAR(50),
//	phone_num 		INTEGER,
//	email 			CHAR(50),
//	address 		CHAR(100),
//	alias_name		CHAR(50),
//	PRIMARY KEY (employee_ID))");
//
//    executePlainSQL("CREATE TABLE Designated_Return_Area (
//	location_ID 	INTEGER,
//	latitude 		NUMBER,
//	longitude 		NUMBER,
//	radius 			NUMBER,
//	PRIMARY KEY (location_ID))");
//
//    executePlainSQL("CREATE TABLE Maintenance_Issue(
//	issueDateTime		timestamp,
//	issue_description	Char(255),
//	technican_notes		CHAR(255),
//	resolved_date		date,
//	bike_ID				INTEGER,
//	rider_ID			INTEGER NOT NULL,
//	technician_ID		INTEGER NOT NULL,
//	PRIMARY KEY (issueDateTime, bike_ID),
//	FOREIGN KEY (bike_ID) REFERENCES Bike(bike_ID) ON DELETE CASCADE,
//	FOREIGN KEY (rider_ID) REFERENCES Rider(rider_ID) ON DELETE CASCADE,
//	FOREIGN KEY (technician_ID) REFERENCES Maintenance_Technician(employee_ID))");
//
//    executePlainSQL("CREATE TABLE Issue_Requires_Part(
//	partNo			INTEGER,
//	issueDateTime	timestamp,
//	bike_ID			INTEGER,
//	PRIMARY KEY (partNo, issueDateTime, bike_ID),
//	FOREIGN KEY (partNo) REFERENCES Replacement_Part(partNo),
//	FOREIGN KEY (issueDateTime, bike_ID) REFERENCES Maintenance_Issue(issueDateTime, bike_ID) ON DELETE CASCADE)");
//
//    executePlainSQL("CREATE TABLE Complaint(
//	complaint_ID		INTEGER,
//	rider_ID 			INTEGER NOT NULL,
//	customer_rep_ID 	INTEGER,
//	cust_description 	CHAR(255),
//	agent_notes 		CHAR(255),
//	urgency_level 		CHAR(50),
//	complaintDateTime	timestamp,
//	action_taken 		CHAR(255),
//	is_resolved 		CHAR(1),
//	PRIMARY KEY (complaint_ID),
//	FOREIGN KEY (rider_ID) REFERENCES Rider(rider_ID) ON DELETE CASCADE,
//	FOREIGN KEY (customer_rep_ID) REFERENCES Customer_Service_Rep(employee_ID))");
//
//    executePlainSQL("CREATE TABLE Trip(
//	trip_ID 			INTEGER,
//	rider_ID 			INTEGER,
//	bike_ID 			INTEGER NOT NULL,
//	end_location_ID 	INTEGER,
//	start_dateTime 		timestamp,
//	end_dateTime		timestamp,
//	tokens_due 			INTEGER,
//	start_latitude 		NUMBER,
//	start_longitude 	NUMBER,
//	end_latitude 		NUMBER,
//	end_longitude 		NUMBER,
//	PRIMARY KEY (trip_ID),
//	FOREIGN KEY (rider_ID) REFERENCES Rider(rider_ID) ON DELETE CASCADE,
//	FOREIGN KEY (bike_ID) REFERENCES Bike(bike_ID),
//	FOREIGN KEY (end_location_ID) REFERENCES Designated_Return_Area(location_ID) ON DELETE SET NULL)");
//
//    executePlainSQL("CREATE TABLE Refund(
//	refund_ID 			INTEGER,
//	rider_ID 			INTEGER NOT NULL,
//	employee_ID 		INTEGER NOT NULL,
//	refundDate 			date,
//	refundTime 			timestamp,
//	reason 				CHAR(255),
//	PRIMARY KEY (refund_ID),
//	FOREIGN KEY (rider_ID) REFERENCES Rider(rider_ID) ON DELETE CASCADE,
//	FOREIGN KEY (employee_ID) REFERENCES Customer_Service_Rep(employee_ID))");
//
//    echo "<br>Populating new tables...<br>";
//
//    executePlainSQL("INSERT INTO Rider
//VALUES (1000, 00000000, 'John Bick', 778423456, 'johnbick@gmail.com', '3275 Royal Oak Ave, Burnaby, BC', 4520855199102345, 1119, 0)");
//
//executePlainSQL("INSERT INTO Rider
//VALUES (1001, 00000001, 'John Wick', 778123456, 'johnwick@gmail.com', '3650 Douglas Rd, Burnaby, BC', 5541009187462856, 0120, 0)");
//
//executePlainSQL("INSERT INTO Rider
//VALUES (1002, 00000002, 'Ali Ramsey', 7782315456, 'aliramsey@gmail.com', '2160 Jordan Dr, Burnaby, BC', 9285748823459855, 0319, 0)");
//
//executePlainSQL("INSERT INTO Rider
//VALUES (1003, 00000003, 'Reis Atkins', 7781238456, 'reisatkins@gmail.com', '1670 Giles Pl, Burnaby, BC', 1299473944738844, 1022, 0)");
//
//executePlainSQL("INSERT INTO Rider
//VALUES (1004, 00000004, 'Kaiya Pittman', 7785559456, 'kaiyapittman@gmail.com', '6871 Dunnedin St, Burnaby, BC', 2345948522004856, 0519, 0)");
//
//executePlainSQL("INSERT INTO Rider
//VALUES (1005, 00000005, 'Elmer Gibbons', 7783665456, 'elmergibbons@gmail.com', '7225 Braeside Dr, Burnaby, BC', 2145847593448576, 0721, 0)");
//
//executePlainSQL("INSERT INTO Rider
//VALUES (1006, 00000006, 'Bobbie Wardle', 7787866456, 'bobbiewardle@gmail.com', '1281 Marsden Ct', 1112948558222399, 0419, 0)");
//
//executePlainSQL("INSERT INTO Rider
//VALUES (1007, 00000007, 'Willem Case', 7789752456, 'willemcase@gmail.com', '1281 Marsden Ct, Burnaby, BC', 1234876545994285, 0922, 0)");
//
//executePlainSQL("INSERT INTO Rider
//VALUES (1008, 00000008, 'Karen Sutherland', 7781785456, 'karensutherland@gmail.com', '907 Cottonwood Ave, Coquitlam, British Columbia', 9012884477228765, 0121, 0)");
//
//executePlainSQL("INSERT INTO Rider
//VALUES (1009, 00000009, 'Thierry Mckay', 7781273456, 'thierrymckay@gmail.com', '455 Decaire St, Coquitlam, British Columbia', 9184485592850194, 1220, 0)");
//
//executePlainSQL("INSERT INTO Rider
//VALUES (1010, 00000010, 'Georgie Edge', 7786123456, 'georgie_edge@gmail.com', '12597 98 Ave, Surrey, British Columbia', 4780194833850398, 0320, 0)");
//
//executePlainSQL("INSERT INTO Rider
//VALUES (1011, 00000011, 'Ho Mathis', 7781923456, 'homathis@gmail.com', '12690 114 Ave, Surrey, British Columbia', 3628993587450924, 0819, 0)");
//
//
//
//executePlainSQL("INSERT INTO Bike
//VALUES (200, '2018-05-06', 49.257858, -123.248172, 'Y')");
//
//executePlainSQL("INSERT INTO Bike
//VALUES (201,' 2018-05-06', 49.258754, -123.245340, 'N')");
//
//executePlainSQL("INSERT INTO Bike
//VALUES (202, '2018-05-10', 49.260379, -123.252034, 'N')");
//
//executePlainSQL("INSERT INTO Bike
//VALUES (203, '2018-05-10', 49.265445, -123.250038, 'N')");
//
//executePlainSQL("INSERT INTO Bike
//VALUES (204, '2018-05-28', 49.267940, -123.243194, 'N')");
//
//executePlainSQL("INSERT INTO Bike
//VALUES (205, '2018-05-28', 49.267156, -123.256239, 'Y')");
//
//     executePlainSQL("INSERT INTO Bike
//VALUES (206, '2018-05-30', 49.254914, -123.233817, 'N')");
//
// executePlainSQL("INSERT INTO Bike
//VALUES (207, '2018-06-01', 49.262757, -123.245146, 'N')");
//
// executePlainSQL("INSERT INTO Bike
//VALUES (208, '2018-06-01', 49.260124, -123.252955, 'N')");
//
// executePlainSQL("INSERT INTO Bike
//VALUES (209, '2018-06-06', 49.266733, -123.249093, 'N')");
//
// executePlainSQL("INSERT INTO Bike
//VALUES (210, '2018-06-06', 49.261132, -123.247549, 'N')");
//
// executePlainSQL("INSERT INTO Bike
//VALUES (211, '2018-06-06', 49.254522, -123.243172, 'N')");
//
//
//
//
//
// executePlainSQL("INSERT INTO Replacement_Part
//VALUES (00000001, 'Bike Seat', 50)");
//
// executePlainSQL("INSERT INTO Replacement_Part
//VALUES (00000002, 'Bike Pedal', 20)");
//
// executePlainSQL("INSERT INTO Replacement_Part
//VALUES (00000003, 'Bike Seat Post', 50)");
//
// executePlainSQL("INSERT INTO Replacement_Part
//VALUES (00000004, 'Bike Brakes', 100)");
//
// executePlainSQL("INSERT INTO Replacement_Part
//VALUES (00000005, 'Bike Brake Pad', 150)");
//
// executePlainSQL("INSERT INTO Replacement_Part
//VALUES (00000006, 'Bike Caliper', 0)");
//
// executePlainSQL("INSERT INTO Replacement_Part
//VALUES (00000007, 'Bike Tire', 60)");
//
// executePlainSQL("INSERT INTO Replacement_Part
//VALUES (00000008, 'Bike Wheel', 40)");
//
// executePlainSQL("INSERT INTO Replacement_Part
//VALUES (00000009, 'Bike Drivetrain', 2)");
//
// executePlainSQL("INSERT INTO Replacement_Part
//VALUES (00000010, 'Bike Handle', 35)");
//
//
//
//
//
// executePlainSQL("INSERT INTO Maintenance_Technician
//VALUES (00000011, 'Henry Mabasa', 6048781234, 'henry@bikeshare.com', '1132 West 11th, Vancouver, BC', 123156889, '2020-05-28')");
//
// executePlainSQL("INSERT INTO Maintenance_Technician
//VALUES (00000012, 'Justin Ng', 6048834234, 'justin@bikeshare.com', '4432 Carnarvon St., Vancouver, BC', 333456788, '2019-01-28')");
//
// executePlainSQL("INSERT INTO Maintenance_Technician
//VALUES (00000013, 'Damian Lim', 6048881334, 'damian@bikeshare.com', '5435 Elm St., Vancouver, BC', 123446789, '2021-12-28')");
//
// executePlainSQL("INSERT INTO Maintenance_Technician
//VALUES (00000014, 'Bruce Lee', 6048681494, 'bruce@bikeshare.com', '7279 Angus Drive, Vancouver, BC', 123455569, '2020-05-28')");
//
// executePlainSQL("INSERT INTO Maintenance_Technician
//VALUES (00000015, 'Kevin Lam', 6048989124, 'kevin@bikeshare.com', '4221 Vine St., Vancouver, BC', 133356789, '2019-10-27')");
//
// executePlainSQL("INSERT INTO Maintenance_Technician
//VALUES (00000016, 'Donald Felbaum', 7789891234, 'donald@bikeshare.com', '1224 Main St., Vancouver, BC', 123346789, '2021-03-22')");
//
// executePlainSQL("INSERT INTO Maintenance_Technician
//VALUES (00000017, 'Jaime Young', 6048891234, 'jaime@bikeshare.com', '1324 Quebec St., Vancouver, BC', 422456889, '2020-05-28')");
//
// executePlainSQL("INSERT INTO Maintenance_Technician
//VALUES (00000018, 'Kieran Tan', 6048891234, 'kieran@bikeshare.com', '1143 Davie St., Vancouver, BC', 923456789, '2018-12-30')");
//
// executePlainSQL("INSERT INTO Maintenance_Technician
//VALUES (00000019, 'Michael Tan', 6048891234, 'michael@bikeshare.com', '1134 Robson St., Vancouver, BC', 823456789, '2020-11-21')");
//
// executePlainSQL("INSERT INTO Maintenance_Technician
//VALUES (00000020, 'Gerard Tecson', 7788982210, 'gerard@bikeshare.com', '777 Richards St., Vancouver, BC', 633456789, '2022-11-11')");
//
//
//
//
//
// executePlainSQL("INSERT INTO Customer_Service_Rep
//VALUES (00000001, 'Daniel Ng', 7788891234, 'daniel@bikeshare.com', '1234 Main St., Vancouver, BC', 'Dan')");
//
// executePlainSQL("INSERT INTO Customer_Service_Rep
//VALUES (00000002, 'Kevin Li', 7788895678, 'kevin@bikeshare.com', '5678 Main St., Vancouver, BC', 'Kevin')");
//
// executePlainSQL("INSERT INTO Customer_Service_Rep
//VALUES (00000003, 'Raghav Thakur', 7789891233, 'raghav@bikeshare.com', '1243 W King Edward, Vancouver, BC', 'Raghav')");
//
// executePlainSQL("INSERT INTO Customer_Service_Rep
//VALUES (00000004, 'Derrick Ng', 7788891234, 'Derrick@bikeshare.com', '4321 Blenheim St., Vancouver, BC', 'Deck')");
//
// executePlainSQL("INSERT INTO Customer_Service_Rep
//VALUES (00000005, 'John Lim', 7788891234, 'john@bikeshare.com', '5553 West 14th., Vancouver, BC', 'John')");
//
// executePlainSQL("INSERT INTO Customer_Service_Rep
//VALUES (00000006, 'Anna Sy', 7788891234, 'anna@bikeshare.com', '6191 Maple Rd, Richmond, BC', 'Anna')");
//
// executePlainSQL("INSERT INTO Customer_Service_Rep
//VALUES (00000007, 'Ed Knorr', 7788891234, 'ed@bikeshare.com', '1452 West 10th., Vancouver, BC', 'Ed')");
//
// executePlainSQL("INSERT INTO Customer_Service_Rep
//VALUES (00000008, 'Andrew Kim', 7788891234, 'andrew@bikeshare.com', '1324 Main St., Vancouver, BC', 'Andrew')");
//
// executePlainSQL("INSERT INTO Customer_Service_Rep
//VALUES (00000009, 'Kimberly Ho', 7788891234, 'kimberly@bikeshare.com', '1234 Main St., Vancouver, BC', 'Kimmy')");
//
// executePlainSQL("INSERT INTO Customer_Service_Rep
//VALUES (00000010, 'David Go', 7788891234, 'david@bikeshare.com', '1432 MacDonald St., Vancouver, BC', 'David')");
//
//
//
//
//
// executePlainSQL("INSERT INTO Designated_Return_Area
//VALUES(00000001, 49.272614, -123.245232, 8)");
//
// executePlainSQL("INSERT INTO Designated_Return_Area
//VALUES(00000002, 49.270990, -123.251840, 6)");
//
// executePlainSQL("INSERT INTO Designated_Return_Area
//VALUES(00000003, 49.267518, -123.256389, 11)");
//
// executePlainSQL("INSERT INTO Designated_Return_Area
//VALUES(00000004, 49.264101, -123.257247, 10)");
//
// executePlainSQL("INSERT INTO Designated_Return_Area
//VALUES(00000005, 49.265445, -123.250038, 15)");
//
// executePlainSQL("INSERT INTO Designated_Return_Area
//VALUES(00000006, 49.265476, -123.243023, 13)");
//
// executePlainSQL("INSERT INTO Designated_Return_Area
//VALUES(00000007, 49.262955, -123.240705, 8)");
//
// executePlainSQL("INSERT INTO Designated_Return_Area
//VALUES(00000008, 49.261499, -123.246026, 5)");
//
// executePlainSQL("INSERT INTO Designated_Return_Area
//VALUES(00000009, 49.258922, -123.236843, 12)");
//
// executePlainSQL("INSERT INTO Designated_Return_Area
//VALUES(00000010, 49.254441, -123.234440, 10)");
//
//
//
//
// executePlainSQL("INSERT INTO Maintenance_Issue
//VALUES('2018-02-07 12:22:45', 'Bike seat broken' , 'Bike seat requires new seat', '2018-03-22', 209, 1002, 00000011)");
//
// executePlainSQL("INSERT INTO Maintenance_Issue
//VALUES('2018-05-24 15:05:11', 'Bike pedal broken', 'need new metal pedal', null, 211, 1000, 00000012)");
//
// executePlainSQL("INSERT INTO Maintenance_Issue
//VALUES('2018-06-04 11:55:33', 'Bike seat post broken', 'Need new bike seat  post with lubricants', '2018-07-13', 201, 1002, 00000013)");
//
// executePlainSQL("INSERT INTO Maintenance_Issue
//VALUES('2018-10-28 02:30:25', 'Bike pedal broken', 'need new metal pedal', '2018-11-01', 202, 1009, 00000011)");
//
// executePlainSQL("INSERT INTO Maintenance_Issue
//VALUES('2018-10-28 08:25:05', 'Bike seat broken', 'Bike seat requires new seat', null, 201, 1005, 00000015)");
//
// executePlainSQL("INSERT INTO Maintenance_Issue
//VALUES('2018-08-25 18:34:43', 'Bike brakes not working', 'replace bike brakes', '2018-09-07', 209, 1011, 00000016)");
//
// executePlainSQL("INSERT INTO Maintenance_Issue
//VALUES('2018-07-30 22:11:24', 'Bike brake pads worn out', 'replace old brakes with new ones', '2018-08-15', 206, 1005, 00000017)");
//
// executePlainSQL("INSERT INTO Maintenance_Issue
//VALUES('2018-02-16 23:27:14', 'Bike tire out of air', 'replace front tire', '2018-03-03', 202, 1008, 00000013)");
//
// executePlainSQL("INSERT INTO Maintenance_Issue
//VALUES('2018-03-15 07:45:09', 'Bike pedal broken', 'need new metal pedal', null, 206, 1000, 00000019)");
//
// executePlainSQL("INSERT INTO Maintenance_Issue
//VALUES('2018-05-04 06:02:36', 'Bike seat post broken', 'Need new bike seat  post with lubricants', '2018-06-22', 200, 1001, 00000020)");
//
// executePlainSQL("INSERT INTO Maintenance_Issue
//VALUES('2018-10-05 17:07:22', 'Bike seat broken', 'Bike seat requires new seat', '2018-10-06', 203, 1002, 00000012)");
//
//
//
//
//
// executePlainSQL("INSERT INTO Issue_Requires_Part
//VALUES(00000001, '2018-02-07 12:22:45', 209)");
//
// executePlainSQL("INSERT INTO Issue_Requires_Part
//VALUES(00000002, '2018-05-24 15:05:11', 211)");
//
// executePlainSQL("INSERT INTO Issue_Requires_Part
//VALUES(00000003, '2018-06-04 11:55:33', 201)");
//
// executePlainSQL("INSERT INTO Issue_Requires_Part
//VALUES(00000002, '2018-10-28 02:30:25', 202)");
//
// executePlainSQL("INSERT INTO Issue_Requires_Part
//VALUES(00000001, '2018-10-28 08:25:05', 201)");
//
// executePlainSQL("INSERT INTO Issue_Requires_Part
//VALUES(00000004, '2018-08-25 18:34:43', 209)");
//
// executePlainSQL("INSERT INTO Issue_Requires_Part
//VALUES(00000005, '2018-07-30 22:11:24', 206)");
//
// executePlainSQL("INSERT INTO Issue_Requires_Part
//VALUES(00000007, '2018-02-16 23:27:14', 202)");
//
// executePlainSQL("INSERT INTO Issue_Requires_Part
//VALUES(00000002, '2018-03-15 07:45:09', 206)");
//
// executePlainSQL("INSERT INTO Issue_Requires_Part
//VALUES(00000003, '2018-05-04 06:02:36', 200)");
//
// executePlainSQL("INSERT INTO Issue_Requires_Part
//VALUES(00000001, '2018-10-05 17:07:22', 203)");
//
//
//
//
//
// executePlainSQL("INSERT INTO Complaint
//VALUES (00000001, 1006, 00000001, 'Charged extra', 'Customer was charged extra for...', 'LOW', '2018-03-04 22:15:33', 'Refunded them for the entire cost', 'Y')");
//
// executePlainSQL("INSERT INTO Complaint
//VALUES (00000002, 1007, 00000002, 'Rep. was rude on the phone', '', 'LOW', '2018-03-04 22:15:33', '', 'N')");
//
// executePlainSQL("INSERT INTO Complaint
//VALUES (00000003, 1003, 00000003, 'I dont understand the reps accent', '', 'MEDIUM', '2018-03-04 22:15:33', '', 'N')");
//
// executePlainSQL("INSERT INTO Complaint
//VALUES (00000004, 1004, 00000004, 'Instead of giving me a refund, they charged me again', 'We have now corrected this', 'MEDIUM', '2018-03-04 22:15:33', 'Gave a refund for the original and the duplicate', 'Y')");
//
// executePlainSQL("INSERT INTO Complaint
//VALUES (00000005, 1005, 00000005, 'I am going to write the longest complaint that I can write, just to test whether your system can actually handle it. How about I write a second sentence to make it even longer.', 'Not a real complaint', 'MEDIUM', '2018-03-04 22:15:33', 'None', 'Y')");
//
// executePlainSQL("INSERT INTO Complaint
//VALUES (00000006, 1006, 00000006, 'I dont like your website design!', '', 'HIGH', '2018-03-04 22:15:33', '', 'N')");
//
// executePlainSQL("INSERT INTO Complaint
//VALUES (00000007, 1001, 00000007, 'When is the McRib coming back?', 'This is the kind of stuff we should be focused on as a society. Lets make this rider our CEO.', 'HIGH', '2018-03-04 22:15:33', 'Went to Burger King across the street because this made me hungry.', 'Y')");
//
// executePlainSQL("INSERT INTO Complaint
//VALUES (00000008, 1007, 00000008, 'The rep. was eating while helping me over the phone...', 'We checked on this and its true. It was Taco Tuesday in the office.', 'LOW', '2018-03-04 22:15:33', 'Changed to soft shell tacos', 'Y')");
//
// executePlainSQL("INSERT INTO Complaint
//VALUES (00000009, 1009, 00000009, 'Why dont you guys rent unicycles?', 'Because clown phobia is a real thing. Lets not contact this rider back.', 'HIGH', '2018-03-04 22:15:33', 'Laughed and then cried.', 'Y')");
//
// executePlainSQL("INSERT INTO Complaint
//VALUES (00000010, 1003, 00000010, 'I was on hold for such a long time.', 'Ah, this was my fault. I was swept up in a riveting game of Solitaire at the time.', 'MEDIUM', '2018-03-04 22:15:33', 'Pretend it never happened.', 'Y')");
//
//
//
//
//
// executePlainSQL("INSERT INTO Trip
//VALUES(1, 1000, 211, null, '2018-11-11 11:45:30', null, null, 49.254522, -123.243172, null, null)");
//
// executePlainSQL("INSERT INTO Trip
//VALUES(2, 1002, 203, 00000005, '2018-11-12 10:02:02', '2018-11-12 12:05:07', 8, 49.254522, -123.243172, 49.265445, -123.250038)");
//
// executePlainSQL("INSERT INTO Trip
//VALUES(3, 1007, 205, 00000006, '2018-11-12 14:14:14', '2018-11-12 14:25:10', 1, 49.254522, -123.243172, 49.265476, -123.243023)");
//
// executePlainSQL("INSERT INTO Trip
//VALUES(4, 1002, 201, 00000001, '2018-10-02 13:00:14', '2018-10-02 17:30:00', 3, 49.267156, -123.256239, 49.272614, -123.245232)");
//
// executePlainSQL("INSERT INTO Trip
//VALUES(5, 1003, 207, null, '2018-11-10 18:45:32', null, null, 49.254441, -123.234440, null, null)");
//
// executePlainSQL("INSERT INTO Trip
//VALUES(6, 1004, 209, null, '2018-11-11 08:00:01', null, null, 49.264101, -123.257247, null, null)");
//
// executePlainSQL("INSERT INTO Trip
//VALUES(7, 1011, 205, null, '2018-11-12 16:00:09', null, null, 49.265445, -123.250038, null, null)");