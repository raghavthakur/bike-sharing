CREATE TABLE Rider(
	rider_ID 		INTEGER,
	wallet_ID 		INTEGER NOT NULL UNIQUE,
	name 			CHAR(50),
	phone_num 		INTEGER,
	email 			CHAR(50),
	address 		CHAR(100),
	creditCardNo 	INTEGER,
	creditCardExp 	INTEGER,
	eCoins 			INTEGER,
	PRIMARY KEY (rider_ID));

CREATE VIEW CustRep_Rider(rider_ID, wallet_ID, name, phone_num, email, address, eCoins)
	AS SELECT rider_ID, wallet_ID, name, phone_num, email, address, eCoins
		 FROM Rider r;

CREATE TABLE Bike (
	bike_ID 		INTEGER,
	date_purchased 	date,
	latitude 		NUMBER,
	longitude 		NUMBER,
	is_broken 		CHAR(1),
	PRIMARY KEY (bike_ID));

CREATE VIEW Rider_Bike(bike_ID, latitude, longitude)
	AS SELECT bike_ID, latitude, longitude
	FROM Bike b
	WHERE b.is_broken = 'Y';

CREATE TABLE Replacement_Part(
	partNo		INTEGER,
	part_name	CHAR(50),
	quantity 	INTEGER,
	PRIMARY KEY (partNo));

CREATE TABLE Maintenance_Technician(
	employee_ID 			INTEGER,
	name 					CHAR(50),
	phone_num 				INTEGER,
	email 					CHAR(50),
	address 				CHAR(100),
	drivers_license_num		INTEGER,
	license_expiry_date		date,
	PRIMARY KEY (employee_ID));

CREATE TABLE Customer_Service_Rep(
	employee_ID 	INTEGER,
	name 			CHAR(50),
	phone_num 		INTEGER,
	email 			CHAR(50),
	address 		CHAR(100),
	alias_name		CHAR(50),
	PRIMARY KEY (employee_ID));

CREATE TABLE Designated_Return_Area (
	location_ID 	INTEGER,       
	latitude 		NUMBER,
	longitude 		NUMBER,
	radius 			NUMBER,
	PRIMARY KEY (location_ID));

CREATE TABLE Maintenance_Issue(
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
	FOREIGN KEY (technician_ID) REFERENCES Maintenance_Technician(employee_ID));

CREATE TABLE Issue_Requires_Part(
	partNo			INTEGER,
	issueDateTime	timestamp,
	bike_ID			INTEGER,
	PRIMARY KEY (partNo, issueDateTime, bike_ID),
	FOREIGN KEY (partNo) REFERENCES Replacement_Part(partNo),
	FOREIGN KEY (issueDateTime, bike_ID) REFERENCES Maintenance_Issue(issueDateTime, bike_ID) ON DELETE CASCADE);

CREATE TABLE Complaint(
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
	FOREIGN KEY (customer_rep_ID) REFERENCES Customer_Service_Rep(employee_ID));

CREATE TABLE Trip(
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
	FOREIGN KEY (end_location_ID) REFERENCES Designated_Return_Area(location_ID) ON DELETE SET NULL);

CREATE TABLE Refund(
	refund_ID 			INTEGER,
	rider_ID 			INTEGER NOT NULL,
	employee_ID 		INTEGER NOT NULL,
	refundDate 			date,
	refundTime 			timestamp,
	reason 				CHAR(255),
	PRIMARY KEY (refund_ID),
	FOREIGN KEY (rider_ID) REFERENCES Rider(rider_ID) ON DELETE CASCADE,
	FOREIGN KEY (employee_ID) REFERENCES Customer_Service_Rep(employee_ID));
