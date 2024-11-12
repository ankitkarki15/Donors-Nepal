	use dndb;
	CREATE TABLE admins (
		admin_id INT PRIMARY KEY AUTO_INCREMENT,
		email VARCHAR(100) UNIQUE,
		password VARCHAR(255)
	);

	-- here the admin password is K@thm@ndu 
	INSERT INTO admins (email, password) VALUES
	('adminhere@gmail.com', '$2b$12$lpl1T7TMn9pNiPpHoETlW.A/KIhyU9S9bRqi4bBDYYBUJeiYxYNCG'),
	 ('admin@gmail.com', '$2b$12$lpl1T7TMn9pNiPpHoETlW.A/KIhyU9S9bRqi4bBDYYBUJeiYxYNCG');
	 
	 CREATE TABLE seekers (
		sid VARCHAR(50) PRIMARY KEY,     
		name VARCHAR(255) NOT NULL,
		email VARCHAR(255) UNIQUE NOT NULL,
		bg ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+') NOT NULL,
		dob DATE NOT NULL,                     
		phone VARCHAR(15) NOT NULL,
		gender ENUM('Male', 'Female', 'Other') NOT NULL,
		district VARCHAR(255) NOT NULL,
		locallevel VARCHAR(255) NOT NULL,
		latitude DECIMAL(9, 6),                
		longitude DECIMAL(9, 6),             
		password VARCHAR(255) NOT NULL
	);

	select * from donors;
	
	-- Create the donors table with the updated schema
	-- +
	ALTER TABLE donors MODIFY drid INT;        -- Remove AUTO_INCREMENT
	ALTER TABLE donors DROP PRIMARY KEY;       -- Drop primary key constraint
	ALTER TABLE donors MODIFY drid VARCHAR(10); -- Change drid to VARCHAR(10)
	ALTER TABLE donors ADD PRIMARY KEY (drid); -- Add primary key constraint back



	ALTER TABLE donors
	ADD COLUMN password VARCHAR(255) NOT NULL;

	CREATE TABLE districts (
		id INT AUTO_INCREMENT PRIMARY KEY,
		district_name VARCHAR(50) UNIQUE
	);

	select * from admins;
    
	CREATE TABLE locallevels (
		id INT AUTO_INCREMENT PRIMARY KEY,
		locallevel_name VARCHAR(50) UNIQUE,
		district_id INT,
		FOREIGN KEY (district_id) REFERENCES districts(id)
	);
    
    select * from locallevels;
    
ALTER TABLE districts ADD COLUMN latitude FLOAT;
ALTER TABLE districts ADD COLUMN longitude FLOAT;
ALTER TABLE locallevels ADD COLUMN latitude FLOAT;
ALTER TABLE locallevels ADD COLUMN longitude FLOAT;

ALTER TABLE districts MODIFY COLUMN latitude FLOAT NULL;
ALTER TABLE districts MODIFY COLUMN longitude FLOAT NULL;
ALTER TABLE locallevels MODIFY COLUMN latitude FLOAT NULL;
ALTER TABLE locallevels MODIFY COLUMN longitude FLOAT NULL;


	INSERT INTO districts (district_name) VALUES ('Kathmandu');
	INSERT INTO locallevels (locallevel_name, district_id) VALUES
		('Bagbazar', 1),
		('Balaju', 1),
		('Baluwatar', 1),
		('Banasthali', 1),
		('Baneshwor', 1),
		('Basantapur', 1),
		('Bhimsengola', 1),
		('Budhanilkantha', 1),
		('Chabahil', 1),
		('Chandragiri', 1),
		('Dakshinkali', 1),
		('Dillibazar', 1),
		('Durbar Marg', 1),
		('Gaushala', 1),
		('Gokarneshwor', 1),
		('Gongabu', 1),
		('Jorpati', 1),
		('Kageshwari-Manohara', 1),
		('Kalanki', 1),
		('Kamalpokhari', 1),
		('Kathmandu', 1),
		('Kirtipur', 1),
		('Koteshwor', 1),
		('Lainchaur', 1),
		('Lazimpat', 1),
		('Maharajgunj', 1),
		('Maitighar', 1),
		('Nagarjun', 1),
		('Naxal', 1),
		('Newroad', 1),
		('Old Baneshwor', 1),
		('Pashupati', 1),
		('Pradarshani Mard',1),
		('Putalisadak', 1),
		('Ratnapark', 1),
		('Ring Road', 1),
		('Samakhushi', 1),
		('Sankhamul', 1),
		('Shankharapur', 1),
		('Sinamangal', 1),
		('Sorhakhutte', 1),
		('Sundhara', 1),
		('Sukedhara', 1),
		('Swayambhu', 1),
		('Thamel', 1),
		('Tilganga', 1),
		('Tinkune', 1);

UPDATE locallevels
SET locallevel_name = 'Pradarshani Marg'
WHERE locallevel_name = 'Pradarshani Mard' AND district_id = 1;

		select *from donors;
        
        select * from locallevels;
		
	CREATE TABLE bloodreq (
		id INT AUTO_INCREMENT PRIMARY KEY,
		sid VARCHAR(50)  NULL,
		patient_name VARCHAR(255) NOT NULL,
		bg VARCHAR(10) NOT NULL,
		br_date DATE NOT NULL,
		req_date DATE NOT NULL,
		req_time TIME NOT NULL,
		district VARCHAR(255) NOT NULL,
		locallevel VARCHAR(255) NOT NULL,
		hospital VARCHAR(255) NOT NULL,
		phone VARCHAR(20) NOT NULL,
		req_pint INT NOT NULL,
		br_reason TEXT NOT NULL,
		
		FOREIGN KEY (sid) REFERENCES seekers(sid)
	);

	ALTER TABLE bloodreq 
	MODIFY br_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

	SELECT * FROM donors 
    WHERE latitude = null;
SHOW COLUMNS FROM donors LIKE 'status';

ALTER TABLE donors MODIFY COLUMN status VARCHAR(10);

	DESCRIBE donors;
    
  DELETE FROM donors WHERE drid IN ('DN0001', 'DN0002', 'm');
DELETE FROM donors WHERE drid = 'DN5017';

SET SQL_SAFE_UPDATES = 0;
DELETE FROM donors WHERE drid BETWEEN 'DN5014' AND 'DN5021';

SET SQL_SAFE_UPDATES = 1;

	
select * from locallevels;
use dndb;
ALTER TABLE districts MODIFY COLUMN latitude DECIMAL(18, 15) NULL;
ALTER TABLE districts MODIFY COLUMN longitude DECIMAL(18, 15) NULL;

ALTER TABLE locallevels MODIFY COLUMN latitude DECIMAL(18, 15) NULL;
ALTER TABLE locallevels MODIFY COLUMN longitude DECIMAL(18, 15) NULL;

select*from locallevels;
select * from seekers;
select* from donors;
DELETE FROM donors;
-- WHERE drid BETWEEN 'DN5022' AND 'DN5033';-- 

use dndb;


describe donors;
show tables;

select* from locallevels ;

-- 27.693168409664924	85.321445105430840
-- '2', 'Balaju', '1', '27.734199523925780', '85.311698913574220'
select * from donors;

SELECT * FROM locallevels WHERE locallevel_name = 'Maitighar';


-- Create the donation_history table with dhid as the primary key
CREATE TABLE donation_history (
    dhid INT AUTO_INCREMENT PRIMARY KEY, -- Primary key renamed to dhid
    drid VARCHAR(10) NOT NULL,
    donation_date DATE NOT NULL,
    donated_pint INT NOT NULL, -- Represents the number of donated pints
    place VARCHAR(255) NOT NULL, -- Place of donation
    FOREIGN KEY (drid) REFERENCES donors(drid) -- Reference to donors table
);
-- Insert sample data into the donation_history table
INSERT INTO donation_history (drid, donation_date, donated_pint, place) VALUES
('DN5000', '2024-08-15', 2, 'Kathmandu Hospital'),
('DN5001', '2024-09-01', 1, 'Bhaktapur Clinic');

-- Add the donation_reason column to the donation_history table
ALTER TABLE donation_history
ADD COLUMN donation_reason ENUM('Routine', 'Emergency', 'Replacement', 'Voluntary') NOT NULL AFTER place;
-- Insert a new donation record for DN5000 on 2024-05-17
INSERT INTO donation_history (drid, donation_date, donated_pint, place, donation_reason)
VALUES ('DN5000', '2024-05-17', 1, 'City Hospital', 'Routine');

-- Query to fetch donation history with donor details
SELECT 
    dh.dhid, 
    dh.donation_date, 
    dh.place, 
    dh.donated_pint, 
    d.drid, 
    d.bg, 
    d.phone
FROM 
    donation_history dh
JOIN 
    donors d ON dh.drid = d.drid
ORDER BY 
    dh.donation_date DESC;

SELECT * 
FROM donation_history 
WHERE drid = 'DN5000';

-- Change the delimiter to // (or any other character/string that is not used in the trigger body)
DELIMITER //

-- Create the trigger
CREATE TRIGGER update_last_donation
AFTER INSERT ON donation_history
FOR EACH ROW
BEGIN
    UPDATE donors
    SET last_donation = NEW.donation_date
    WHERE drid = NEW.drid;
END//

-- Reset the delimiter back to ;
DELIMITER ;

select * from donors;

SHOW TABLES;
DESCRIBE donation_history;
select * from donation_history;

select * from donors where drid ='DN5000';
select * from bloodreq;

use dndb;

INSERT INTO donors (drid,sid, name, email, phone, bg, dob, district, locallevel, last_donation, donation_count, availability, latitude, longitude, medical_conditions, is_eligible, status, password) 
VALUES ('DN5004', null,'Shristi Poudel', 'shristipoudel834@gmail.com', '9823645664', 'A+', '2003-12-13', 'Kathmandu', 'Sukedhara', '2023-08-15', 3, 1, 27.728011646748115 ,85.345306919320120, 'None', 1, 'Approved', '$2b$12$VYjR99VwhnRiWdlqRmxN2.aRpcjXVMJVBVMjeE2qkLSrmbVjggBLy');

select * from donors;
select * from locallevels;

describe donors;
ALTER TABLE donors
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE donors
ADD COLUMN personal_documents TEXT,
ADD COLUMN medical_documents TEXT;

ALTER TABLE donors MODIFY bg ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-');

SELECT locallevel_name, latitude, longitude FROM locallevels WHERE latitude IS NOT NULL AND longitude IS NOT NULL;

-- disble safe update mode
SET SQL_SAFE_UPDATES = 0;

ALTER TABLE donors
ADD COLUMN gender VARCHAR(10) AFTER dob;


select * from donors ;



use dndb;
show tables;
select * from blooddonationrequests;


CREATE TABLE blooddonationrequests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sid VARCHAR(50) NOT NULL,  -- Seeker ID (foreign key to seekers)
    drid VARCHAR(50) NOT NULL,  -- Donor ID (foreign key to donors, referencing 'drid')
    status ENUM('pending', 'accepted', 'declined') NOT NULL DEFAULT 'pending',  -- Request status
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Timestamp for request creation
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  -- Timestamp for last update
    FOREIGN KEY (sid) REFERENCES seekers(sid) ON DELETE CASCADE,  -- Cascade deletion if seeker is deleted
    FOREIGN KEY (drid) REFERENCES donors(drid) ON DELETE CASCADE,  -- Cascade deletion if donor is deleted
    INDEX (sid),  -- Index for faster lookup on seekers
    INDEX (drid)  -- Index for faster lookup on donors
);

select * from blooddonationrequests;
ALTER TABLE blooddonationrequests AUTO_INCREMENT = 100;
ALTER TABLE admin_notifications ADD COLUMN donor_email VARCHAR(255);

UPDATE donors
SET status = 'pending'
WHERE drid = 'DN5001';

select * from seekers;
describe seekers;
use dndb;
select * from bloodreq;
DELETE FROM bloodreq
WHERE id BETWEEN 4 AND 14;


show tables;
select * from blooddonationrequests;

select * from donors;

CREATE TABLE admin_notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Auto-incrementing primary key
    admin_id INT NOT NULL,  -- Reference to the admin who will receive the notification
    message VARCHAR(255) DEFAULT 'No message',  -- Notification message
    status ENUM('unread', 'read') NOT NULL DEFAULT 'unread',  -- Status of the notification
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Timestamp when the notification was created
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  -- Timestamp for last update
    sid VARCHAR(255),  -- Seeker ID
    donor_email VARCHAR(255),  -- Donor's email
    action VARCHAR(50),  -- Action taken (e.g., 'accept', 'decline')
    seeker_email VARCHAR(255),  -- Seeker's email
    drid VARCHAR(10),  -- Donor ID (match the type in donors table)
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,  -- Additional timestamp for tracking
    FOREIGN KEY (admin_id) REFERENCES admins(admin_id) ON DELETE CASCADE,  -- Foreign key referencing admins table
    FOREIGN KEY (drid) REFERENCES donors(drid) ON DELETE CASCADE,  -- Foreign key referencing donors table
    FOREIGN KEY (seeker_email) REFERENCES seekers(email) ON DELETE CASCADE  -- Foreign key referencing seekers table
) AUTO_INCREMENT=100;  -- Start auto-increment from 100
SELECT * FROM donors WHERE drid = 'DN5000';  -- Replace 'DN5000' with the actual value you're using

SELECT * FROM donors WHERE drid = 'DN5000'; 
SHOW CREATE TABLE admin_notifications;
SELECT drid FROM donors WHERE drid = 'DN5000';

SHOW CREATE TABLE donors;
SET FOREIGN_KEY_CHECKS=1;

DELETE FROM admin_notifications
WHERE id = '100' ;
select * from reviews;

select * from blooddonationrequests;
CREATE TABLE `reviews` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `drid` VARCHAR(50) NOT NULL,         -- Donor ID
  `sid` VARCHAR(50) NOT NULL,          -- Seeker ID
  `rating` DECIMAL(2, 1) NOT NULL,     -- Rating value (1.0 to 5.0)
  `review` TEXT NOT NULL,               -- Review text
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `drid` (`drid`),
  KEY `sid` (`sid`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`drid`) REFERENCES `donors` (`drid`) ON DELETE CASCADE,
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`sid`) REFERENCES `seekers` (`sid`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE blooddonationrequests 
ADD COLUMN scheduled_time DATETIME DEFAULT NULL;

select * from blooddonationrequests;
ALTER TABLE blooddonationrequests 
ADD COLUMN donation_status ENUM('completed', 'not_completed', 'in_progress') DEFAULT 'not_completed';
ALTER TABLE blooddonationrequests ADD donated_blood_pint INT DEFAULT 0;

DESCRIBE blooddonationrequests;


