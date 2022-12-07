# STLWD

## We are St. Louis Map Project

### Database Structure

Database:

map


Tables:

accounts
- Columns are account_name and account_hash
	- account_name 
		- type: VARCHAR
		- length: 256
		- Primary
		- Index
	- account_hash
		- type: VARCHAR
		- length: 256

posts
- Columns are id, text, image, alt, lat, lng, and approved
	- id
		- type: INT
		- length: 255
		- Primary
		- Index
		- Auto_Increment
	- text
		- type: VARCHAR
		- length: 280
	- image
		- type: VARCHAR
		- length: 256
		- (path to stored image on the server)
	- alt
		- type: VARCHAR
		- length: 50
	- lat
		- type: DECIMAL
		- length: 9, 6 (First number is the number of total digits allowed and the second is the number of digits allowed following the decimal point) (-999.999999 to 999.999999)
	- lng
		- type: DECIMAL
		- length: 9, 6 (First number is the number of total digits allowed and the second is the number of digits allowed following the decimal point) (-999.999999 to 999.999999)
	- approved
		- type: BOOLEAN



### Copy everything below this line and paste into phpMyAdmin

```
CREATE DATABASE map COLLATE utf8_bin;
CREATE TABLE `map`.`accounts` (
    `account_name` VARCHAR(256) NOT NULL, 
	`account_hash` VARCHAR(256) NOT NULL,
    PRIMARY KEY (`account_name`)
	) ENGINE = InnoDB;
ALTER TABLE `map`.`accounts` ADD INDEX(`account_name`);
CREATE TABLE `map`.`posts` (
    `id` INT(255) NOT NULL AUTO_INCREMENT, 
    `text` VARCHAR(280) NOT NULL,
    `image` VARCHAR(256) NOT NULL,
    `alt` VARCHAR(50) NOT NULL,
    `lat` DECIMAL(9,6) NOT NULL,
    `lng` DECIMAL(9,6) NOT NULL,
    `approved` BOOLEAN NOT NULL,
    PRIMARY KEY (`id`)
	) ENGINE = InnoDB;
ALTER TABLE `map`.`posts` ADD INDEX(`id`);
INSERT INTO `map`.`accounts` (`account_name`, `account_hash`) VALUES ("superadmin", "$2y$10$mhKvdK1EiJSmQznASmx42utj7mNPMAoQRBmwlgSIur1TS7.3xyitm")
```
