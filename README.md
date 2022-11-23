# STLWD

## Authentication and administrator moderation page
A robust and secure log in page and a page allowing administrators to permit or deny posts from users

Note: database code is set up to run locally on a database named map with specific tables
Note: make sure to set your tables' categories max size to a big enough size. In particular, account_hash should be at least 256 characters long


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
- Columns are id, text, image, alt, lat, and lng
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

Command line code to clone this particular branch: `git clone -b auth_OSM https://comp.umsl.edu/gitlab/epbx7c/stlwd.git`

