

# MailServer Documentation

First include the required library files as basically a header using 

```php

$root_path='../' something that basically takes you to root directory using a series of '../'
include $root_path.'LibraryFiles/MailServer/smtp.php'; //The path may change depending on location of Library Files as a relative path to the current working file
```

Setting an Email

```php
$emailContent = new Email('Receiver\'s Address','Email Body Goes Here','Email Subject Goes Here');
```

Sending an Email

```php
$smtp=new SMTP($emailContent);//where emailContent is of Email object type
$error_message=$smtp->sendMail(); //error_message is the result of failed sending of emails via smtp, the error_message stores the reason behind the failure as a string message
```




