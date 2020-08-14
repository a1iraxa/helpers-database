# MySQL Cheat Sheet

> Help with SQL commands to interact with a MySQL Database

## MySQL Locations
* Mac             */usr/local/mysql/bin*
* Windows         */Program Files/MySQL/MySQL _version_/bin*
* Xampp           */xampp/mysql/bin*

## Add mysql to your PATH

```bash
# Current Session
export PATH=${PATH}:/usr/local/mysql/bin
# Permanantly
echo 'export PATH="/usr/local/mysql/bin:$PATH"' >> ~/.bash_profile
```

On Windows - https://www.qualitestgroup.com/resources/knowledge-center/how-to-guide/add-mysql-path-windows/

## Login

```bash
mysql -u root -p
```

## Show Users

```sql
SELECT User, Host FROM mysql.user;
```

## Create User

```sql
CREATE USER 'someuser'@'localhost' IDENTIFIED BY 'somepassword';
```

## Grant All Priveleges On All Databases

```sql
GRANT ALL PRIVILEGES ON * . * TO 'someuser'@'localhost';
FLUSH PRIVILEGES;
```

## Show Grants

```sql
SHOW GRANTS FOR 'someuser'@'localhost';
```

## Remove Grants

```sql
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'someuser'@'localhost';
```

## Delete User

```sql
DROP USER 'someuser'@'localhost';
```

## Exit

```sql
exit;
```

## Show Databases

```sql
SHOW DATABASES
```

## Create Database

```sql
CREATE DATABASE acme;
```

## Delete Database

```sql
DROP DATABASE acme;
```

## Select Database

```sql
USE acme;
```

## Create Table

```sql
CREATE TABLE users(
id INT AUTO_INCREMENT,
   first_name VARCHAR(100),
   last_name VARCHAR(100),
   email VARCHAR(50),
   password VARCHAR(20),
   location VARCHAR(100),
   dept VARCHAR(100),
   is_admin TINYINT(1),
   register_date DATETIME,
   PRIMARY KEY(id)
);
```

## Delete / Drop Table

```sql
DROP TABLE tablename;
```

## Show Tables

```sql
SHOW TABLES;
```

## Insert Row / Record

```sql
INSERT INTO users (first_name, last_name, email, password, location, dept, is_admin, register_date) values ('Brad', 'Traversy', 'brad@gmail.com', '123456','Massachusetts', 'development', 1, now());
```

## Insert Multiple Rows

```sql
INSERT INTO users (first_name, last_name, email, password, location, dept,  is_admin, register_date) values ('Fred', 'Smith', 'fred@gmail.com', '123456', 'New York', 'design', 0, now()), ('Sara', 'Watson', 'sara@gmail.com', '123456', 'New York', 'design', 0, now()),('Will', 'Jackson', 'will@yahoo.com', '123456', 'Rhode Island', 'development', 1, now()),('Paula', 'Johnson', 'paula@yahoo.com', '123456', 'Massachusetts', 'sales', 0, now()),('Tom', 'Spears', 'tom@yahoo.com', '123456', 'Massachusetts', 'sales', 0, now());
```

## Select

```sql
SELECT * FROM users;
SELECT first_name, last_name FROM users;
```

## Where Clause

```sql
SELECT * FROM users WHERE location='Massachusetts';
SELECT * FROM users WHERE location='Massachusetts' AND dept='sales';
SELECT * FROM users WHERE is_admin = 1;
SELECT * FROM users WHERE is_admin > 0;
```

## Delete Row

```sql
DELETE FROM users WHERE id = 6;
```

## Update Row

```sql
UPDATE users SET email = 'freddy@gmail.com' WHERE id = 2;

```

## Add New Column

```sql
ALTER TABLE users ADD age VARCHAR(3);
```

## Modify Column

```sql
ALTER TABLE users MODIFY COLUMN age INT(3);
```

## Order By (Sort)

```sql
SELECT * FROM users ORDER BY last_name ASC;
SELECT * FROM users ORDER BY last_name DESC;
```

## Concatenate Columns

```sql
SELECT CONCAT(first_name, ' ', last_name) AS 'Name', dept FROM users;

```

## Select Distinct Rows

```sql
SELECT DISTINCT location FROM users;

```

## Between (Select Range)

```sql
SELECT * FROM users WHERE age BETWEEN 20 AND 25;
```

## Like (Searching)

```sql
SELECT * FROM users WHERE dept LIKE 'd%';
SELECT * FROM users WHERE dept LIKE 'dev%';
SELECT * FROM users WHERE dept LIKE '%t';
SELECT * FROM users WHERE dept LIKE '%e%';
```

## Not Like

```sql
SELECT * FROM users WHERE dept NOT LIKE 'd%';
```

## IN

```sql
SELECT * FROM users WHERE dept IN ('design', 'sales');
```

## Create & Remove Index

```sql
CREATE INDEX LIndex On users(location);
DROP INDEX LIndex ON users;
```

## New Table With Foreign Key (Posts)

```sql
CREATE TABLE posts(
id INT AUTO_INCREMENT,
   user_id INT,
   title VARCHAR(100),
   body TEXT,
   publish_date DATETIME DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY(id),
   FOREIGN KEY (user_id) REFERENCES users(id)
);
```

## Add Data to Posts Table

```sql
INSERT INTO posts(user_id, title, body) VALUES (1, 'Post One', 'This is post one'),(3, 'Post Two', 'This is post two'),(1, 'Post Three', 'This is post three'),(2, 'Post Four', 'This is post four'),(5, 'Post Five', 'This is post five'),(4, 'Post Six', 'This is post six'),(2, 'Post Seven', 'This is post seven'),(1, 'Post Eight', 'This is post eight'),(3, 'Post Nine', 'This is post none'),(4, 'Post Ten', 'This is post ten');
```

## INNER JOIN

```sql
SELECT
  users.first_name,
  users.last_name,
  posts.title,
  posts.publish_date
FROM users
INNER JOIN posts
ON users.id = posts.user_id
ORDER BY posts.title;
```

## New Table With 2 Foriegn Keys

```sql
CREATE TABLE comments(
    id INT AUTO_INCREMENT,
    post_id INT,
    user_id INT,
    body TEXT,
    publish_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) references users(id),
    FOREIGN KEY(post_id) references posts(id)
);
```

## Add Data to Comments Table

```sql
INSERT INTO comments(post_id, user_id, body) VALUES (1, 3, 'This is comment one'),(2, 1, 'This is comment two'),(5, 3, 'This is comment three'),(2, 4, 'This is comment four'),(1, 2, 'This is comment five'),(3, 1, 'This is comment six'),(3, 2, 'This is comment six'),(5, 4, 'This is comment seven'),(2, 3, 'This is comment seven');
```

## Left Join

```sql
SELECT
comments.body,
posts.title
FROM comments
LEFT JOIN posts ON posts.id = comments.post_id
ORDER BY posts.title;

```

## Join Multiple Tables

```sql
SELECT
comments.body,
posts.title,
users.first_name,
users.last_name
FROM comments
INNER JOIN posts on posts.id = comments.post_id
INNER JOIN users on users.id = comments.user_id
ORDER BY posts.title;

```

## Aggregate Functions

```sql
SELECT COUNT(id) FROM users;
SELECT MAX(age) FROM users;
SELECT MIN(age) FROM users;
SELECT SUM(age) FROM users;
SELECT UCASE(first_name), LCASE(last_name) FROM users;

```

## Group By

```sql
SELECT age, COUNT(age) FROM users GROUP BY age;
SELECT age, COUNT(age) FROM users WHERE age > 20 GROUP BY age;
SELECT age, COUNT(age) FROM users GROUP BY age HAVING count(age) >=2;

```
## Recon

## Show Version
```sql
SHOW VARIABLES LIKE "%version%";
```

## Show System Status
```sql
SHOW STATUS;
```

## Show Environmental Variables
```sql
SHOW VARIABLES;
```

## Show Current User
```sql
SELECT USER();
```

## Show Current User's Permissions
```sql
SHOW GRANTS FOR CURRENT_USER;
```

## List Databases
```sql
SHOW DATABASES;
```

## Show Current Database
```sql
SELECT DATABASE();
```

## Show All Tables in Database
```sql
SHOW TABLES;
```

## List Functions
```sql
SELECT * FROM mysql.func;
```
## Users

## List All Users Name, Host, Password
```sql
SELECT User,Host,Password,Grant_priv,Super_priv FROM mysql.user;
```

## List All Users
```sql
SELECT * FROM mysql.user;
```

## Create User
http://dev.mysql.com/doc/refman/5.6/en/create-user.html
```sql
CREATE USER '<username>'@'localhost' IDENTIFIED BY '<password>';
```

## Drop User
http://dev.mysql.com/doc/refman/5.6/en/drop-user.html
```sql
DROP USER <username>;
```

## Alter User's Password
http://dev.mysql.com/doc/refman/5.6/en/set-password.html
```sql
SET PASSWORD FOR '<username>'@'localhost' = PASSWORD('<password>');
```

## Show Current User's Permissions
```sql
SHOW GRANTS FOR CURRENT_USER;
```

## Reload Permissions
```sql
FLUSH PRIVILEGES;
```

## Grant All Permissions to User DANGEROUS!!!
```sql
GRANT ALL PRIVILEGES ON *.* TO '<username>'@'localhost';
```

## Grant Permissions to Select, Update, Insert, Delete, on All Tables
```sql
GRANT SELECT,UPDATE,INSERT,DELETE ON <database_name>.* TO '<username>'@'localhost';
```

## Grant Permissions to Select, Insert, on All Tables
```sql
GRANT SELECT,INSERT ON <database_name>.* TO '<username>'@'localhost';
```

## Grant Permissions to Select, on All Tables
```sql
GRANT SELECT ON <database_name>.* TO '<username>'@'localhost';
```

## List All Tables
http://dev.mysql.com/doc/refman/5.6/en/show-tables.html
```sql
SHOW TABLES;
```

## List Tables Schema
```sql
DESCRIBE <table_name>;
SHOW COLUMNS FROM <table_name>;
```

## Create Table
http://dev.mysql.com/doc/refman/5.6/en/create-table.html
```sql
CREATE TABLE <table_name> (
  <col_name> INT,
  <col_name> VARCHAR(128)
);
```

## Delete Table
http://dev.mysql.com/doc/refman/5.6/en/drop-table.html
```sql
DROP TABLE <table_name>;
```

## Rename Table
http://dev.mysql.com/doc/refman/5.6/en/rename-table.html
```sql
RENAME TABLE <old_name> TO <new_name>;
```

## Add Column
http://dev.mysql.com/doc/refman/5.6/en/alter-table.html
```sql
ALTER TABLE <table_name> IF EXISTS
ADD COLUMN <column_name> <column_type>;
```

## Update Column
```sql
ALTER TABLE <table_name> IF EXISTS
MODIFY COLUMN <column_name> <column_type>;
```

## Delete Column
```sql
ALTER TABLE <table_name> IF EXISTS
DROP COLUMN <column_name>;
```

## Update Column to be An Auto-Increment Primary Key
```sql
ALTER TABLE <table_name> IF EXISTS
MODIFY COLUMN <column_name> INT auto_increment;
```

## Read All Data
http://dev.mysql.com/doc/refman/5.6/en/select.html
```sql
SELECT * FROM <table_name>;
```

## Read First Row of Data
```sql
SELECT * FROM <table_name> LIMIT 1;
```

## Search for Data
```sql
SELECT * FROM <table_name> WHERE <column_name> = <value>;
```

## Insert Data
http://dev.mysql.com/doc/refman/5.6/en/insert.html
```
INSERT INTO <table_name> VALUES();
```

## Edit Data
http://dev.mysql.com/doc/refman/5.6/en/Update.html
```sql
UPDATE <table_name>
SET <column_1> = <value_1>, <column_2> = <value_2>
WHERE <column_1> = <value_1>;
```

## Delete all Data
http://dev.mysql.com/doc/refman/5.6/en/Delete.html
```sql
DELETE FROM <table_name>;
```

## Delete specific Data
```sql
DELETE FROM <table_name>
WHERE <column_name> = <value>;
```

## List Functions
```sql
SELECT * FROM mysql.func;
```
