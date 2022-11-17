# STLWD

## Authentication and administrator moderation page
A robust and secure log in page and a page allowing administrators to permit or deny posts from users

Note: database code is set up to run locally on a database named auth with specific tables
Note: make sure to set your tables' categories max size to a big enough size. In particular, account_hash should be at least 256 characters long

Tables:

accounts
- Columns are account_name (varchar), and account_hash (varchar)

posts
- Columns are id (int), text (varchar), image (int), alt (varchar), and coordinates (varchar)


Command line code to clone this particular branch: `git clone -b auth https://comp.umsl.edu/gitlab/epbx7c/stlwd.git`

