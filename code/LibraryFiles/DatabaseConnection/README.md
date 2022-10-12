# Library for ED-EZ

This contains mainly 3 libraries that are basically collection of programs used repeatedly throughout the program.

###### The 3 libraries are:

1) Database Connection: A single database class with all the required database functionalities for this web platform
2)  URLFinder: Gives the URL of the current file being worked on or the directory it is currently in
3)  MailServer: The SMTP used to carry out various vital mail sending activities such as email verification and forgot password feature using the sendin-blue SMTP server

# Using these libraries:

###### Database Connection

First include the required library files as basically a header using 

```php
include 'LibraryFiles/DatabaseConnection/config.php'; //The path may change depending on location of Library Files as a relative path to the current working file
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
