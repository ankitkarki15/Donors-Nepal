create database dn;
use dn;
CREATE TABLE users (
    mem_id VARCHAR(20) PRIMARY KEY,
    fullname VARCHAR(100),
    bloodgroup ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'),
    province VARCHAR(50),
    district VARCHAR(50),
    locallevel VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    dob DATE,
    phone VARCHAR(15),
    gender ENUM('Male', 'Female', 'Other'),
    password VARCHAR(255),
    lastdonationdate DATE,
    donationcount INT,
    availability BOOLEAN
);


ALTER TABLE users DROP COLUMN status;
ALTER TABLE users CHANGE COLUMN bloodgroup bg ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-');
ALTER TABLE users CHANGE COLUMN mem_id user_id VARCHAR(20);


CREATE TABLE admins (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255)
);

-- here the admin password is K@thm@ndu 
INSERT INTO admins (email, password) VALUES
('adminhere@gmail.com', '$2b$12$lpl1T7TMn9pNiPpHoETlW.A/KIhyU9S9bRqi4bBDYYBUJeiYxYNCG'),
 ('admin@gmail.com', '$2b$12$lpl1T7TMn9pNiPpHoETlW.A/KIhyU9S9bRqi4bBDYYBUJeiYxYNCG');


 

	CREATE TABLE bloodreq (
    br_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id VARCHAR(20),
    contact_person VARCHAR(100),
    bg ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'),
    br_date DATE,
    required_date DATE,
    required_time TIME, 
    district VARCHAR(50),
    locallevel VARCHAR(50),
    hospital VARCHAR(100),
    phone VARCHAR(15),
    required_pint INT,
    br_reason VARCHAR(255), 
    status ENUM('Pending', 'Approved', 'Cancelled'),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
ALTER TABLE bloodreq
  RENAME COLUMN required_date TO req_date,
  RENAME COLUMN required_time TO req_time,
  RENAME COLUMN required_pint TO req_pint;
  
    show tables;
    ALTER TABLE bloodreq 
	MODIFY COLUMN br_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

-- adding status on user--  
ALTER TABLE users
ADD COLUMN status ENUM('Approved', 'Pending', 'Rejected') DEFAULT 'Pending';




ALTER TABLE users
ALTER COLUMN status DROP DEFAULT;

ALTER TABLE users
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

 SELECT * FROM dn.users;	
    SELECT * FROM dn.bloodreq;
    
   -- Disable safe update mode
SET SQL_SAFE_UPDATES = 0;

-- Delete user by fullname
DELETE FROM users WHERE fullname = 'dn';

-- Re-enable safe update mode
SET SQL_SAFE_UPDATES = 1;
 SELECT * FROM dn.users;
 SHOW COLUMNS FROM users LIKE 'status';
 SELECT DISTINCT status FROM users;

ALTER TABLE users DROP COLUMN status;

SELECT * FROM users WHERE status = 'Pending';

CREATE TABLE donorreq (
    dr_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(20),
    bg ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'),
    district VARCHAR(50),
    locallevel VARCHAR(50),
    dob DATE,
    gender ENUM('Male', 'Female', 'Other'),
    status ENUM('Approved', 'Pending', 'Rejected') DEFAULT 'Pending',
    dr_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    availability BOOLEAN,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
ALTER TABLE donorreq AUTO_INCREMENT = 100;

ALTER TABLE users
ADD latitude DECIMAL(10, 8),
ADD longitude DECIMAL(11, 8);

 use dn;
 SELECT * FROM dn.users;
 
DELETE FROM users
WHERE user_id BETWEEN 'DN0007' AND 'DN0044';

CREATE TABLE districts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    district_name VARCHAR(50) UNIQUE
);

CREATE TABLE locallevels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    local_level_name VARCHAR(50) UNIQUE,
    district_id INT,
    FOREIGN KEY (district_id) REFERENCES districts(id)
);
ALTER TABLE locallevels
CHANGE COLUMN local_level_name locallevel_name VARCHAR(50);

ALTER TABLE users
ADD COLUMN district_id INT,
ADD COLUMN locallevel_id INT,
ADD FOREIGN KEY (district_id) REFERENCES districts(id),
ADD FOREIGN KEY (locallevel_id) REFERENCES locallevels(id);

INSERT INTO districts (district_name) VALUES
('Kathmandu'),
('Bhaktapur'),
('Jhapa');

-- Assuming Kathmandu has local levels
INSERT INTO locallevels (locallevel_name, district_id) VALUES
('Budhanilkantha', 1),
('Chandragiri', 1),
('Dakshinkali', 1),
('Gokarneshwor', 1),
('Kageshwari-Manohara', 1),
('Kathmandu', 1),
('Kirtipur', 1),
('Nagarjun', 1),
('Shankharapur', 1);


-- Assuming Bhaktapur has local levels
INSERT INTO locallevels (locallevel_name, district_id) VALUES
('Balakot', 2),
('Bhaktapur', 2),
('Changunarayan', 2),
('Duwakot', 2),
('Gathhaghar', 2),
('Kausaltar', 2),
('Lokanthali', 2),
('Madhyapur Thimi', 2),
('Nagarkot', 2),
('Radhe Radhe', 2),
('Sanothimi',2),
('Suryabinayak',2);

-- Assuming Jhapa has local levels
INSERT INTO locallevels (locallevel_name, district_id) VALUES
('Arjundhara', 3),
('Birtamode', 3),
('Chandragadhi', 3),
('Damak', 3),
('Gauradaha', 3),
('Haldibari', 3),
('Jhapa', 3),
('Kakarbhitta', 3),
('Mechinagar', 3),
('Rajgadh', 3);


 SELECT * FROM dn.users;
 select*From dn.donorreq;
 ALTER TABLE users
ADD COLUMN donor_status ENUM('Approved', 'Pending', 'Rejected') DEFAULT 'Pending';

-- newcode
ALTER TABLE donorreq
ADD COLUMN bg ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'),
ADD COLUMN district VARCHAR(50),
ADD COLUMN locallevel VARCHAR(50),
ADD COLUMN dob DATE,
ADD COLUMN gender ENUM('Male', 'Female', 'Other'),
ADD COLUMN availability BOOLEAN;

ALTER TABLE donorreq AUTO_INCREMENT = 1;

SELECT * FROM donorreq WHERE status = 'Approved';
select * from users;

-- Update donorreq table and users table where status is Approved
UPDATE donorreq dr
JOIN users u ON dr.user_id = u.user_id
SET u.bg = dr.bg,
    u.district = dr.district,
    u.locallevel = dr.locallevel,
    u.dob = dr.dob,
    u.gender = dr.gender,
    u.availability = dr.availability,
    u.donor_status = 'Approved'
WHERE dr.status = 'Approved';

ALTER TABLE users 
-- ADD COLUMN status ENUM('Approved', 'Pending', 'Rejected') DEFAULT 'Pending';
Drop column status;
use dn