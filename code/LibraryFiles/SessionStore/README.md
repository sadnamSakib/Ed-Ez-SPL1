

# SessionStore Documentation

First include the required library files as basically a header using 

```php

$root_path='../' //something that basically takes you to root directory using a series of '../'
include $root_path.'LibraryFiles/SessionStore/session.php'; //The path may change depending on location of Library Files as a relative path to the current working file
```


Redirect Profile based on student or teacher when required as per the control flow of the program

```php
session::redirectProfile($profile) //The name of the profile you wish to redirect to
```

Create or resume existing session to basically access the session data or the session variables in store

```php
session::create_or_resume_session(); //basically does a session start and error_reporting
```

Profile Not Set basically checks if profile is not set and redirects to root page accordingly if required

```php
session::profile_not_set($root_path) //basically $root_path gives the path to root or the pathway to go to root when required
```




