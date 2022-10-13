

# Database Connection Documentation

First include the required library files as basically a header using 

```php
$root_path='../' //something that basically takes you to root directory using a series of '../'
include $root_path.'LibraryFiles/DatabaseConnection/config.php'; //The path may change depending on location of Library Files as a relative path to the current working file
```

Create Database Connection

```php
$database=new Database("Database_User","DNS/IP of Database Server","Database_User_Password","Database_Name"); //In our case the server name(DNS) is localhost
```

Connect to the Database

```php
$database->connect();
```

Getter for Connection

```php
$var=$database->get_connection();
```

Setter for Connection

```php
$database->set_connection("Database_User","DNS/IP of Database Server","Database_User_Password","Database_Name"); //In our case the server name(DNS) is localhost
//This will set and connect to the required database
```

Perform Queries

```php
$var=$database->performQuery(SQL_Query_DML);
```

All mysqli functions are valid on the results of the queries such as mysqli_fetch_assoc which is commonnly used along with other functions, based on the result from the queries
