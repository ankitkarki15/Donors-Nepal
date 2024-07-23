create database dn;
use dn;
CREATE TABLE users (
    mem_id VARCHAR(20) PRIMARY KEY,
    fullname VARCHAR(100),
    bloodgroup ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'),
    -- province VARCHAR(50),
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
ALTER TABLE users CHANGE COLUMN bloodgroup bg ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-');
ALTER TABLE users
CHANGE COLUMN mem_id user_id VARCHAR(20);

CREATE TABLE admins (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255)
);
	CREATE TABLE bloodreq (
    br_id INT PRIMARY KEY AUTO_INCREMENT,
    mem_id VARCHAR(20),
    contact_person VARCHAR(100), -- New field for contact person name
    bg ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'),
    req_date DATE,
    required_date DATE,
    required_time TIME, -- New field for required time
    district VARCHAR(50),
    locallevel VARCHAR(50),
    hospital VARCHAR(100),
    phone VARCHAR(15), -- Changed field name to 'phone'
    required_pint INT, -- New field for required pint
    reason VARCHAR(255), -- Changed field name to 'req_reason'
    status ENUM('Pending', 'Approved', 'Cancelled'), -- Changed 'Fulfilled' to 'Approved'
    FOREIGN KEY (mem_id) REFERENCES users(mem_id)
);
	
    