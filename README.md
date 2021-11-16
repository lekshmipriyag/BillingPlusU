# BillingPlusU
This repository contains all the code for BillingPlusU (Frontend + Backend)  
Current testing domain name for BillingPlusU is [https://rmit.billingplus.com](https://rmit.billingplus.com)  

## Setting Up The Local Development Environment
The easiest way would be install some software like WAMP, MAMP or LAMP.  
But for our team we choose [AMPPS](http://www.ampps.com/)  
After that change the version of [PHP to 7.x](https://www.ampps.com/wiki/How_to_change_php_version)  
Put the whole BillingPlusU folder into `Ampps/www/` folder  
Uncomment `Artisan::call('migrate');` in BillingPlusU/routes/web.php file  
Config .env file to match the local database setting
```
DB_DATABASE=local_database_name
DB_USERNAME=username
DB_PASSWORD=password
```
Config .env file to send an email for forgot password function (RMIT mail setting)
```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.office365.com
MAIL_PORT=587
MAIL_USERNAME=sXXXXXXX@student.rmit.edu.au
MAIL_PASSWORD=password
MAIL_ENCRYPTION=tls
```
Generate [Google Recaptcha v2 API key](https://codeforgeek.com/google-recaptcha-tutorial/)
Inside .env file set the key and secret
```
GOOGLE_RECAPTCHA_KEY=generated_key
GOOGLE_RECAPTCHA_SECRET=generated_secret
```
Go to page [http://localhost/Path to folder/BillingPlusU/public/test](http://localhost)
If `Hello, World` is shown mean the Database is successfully populated


## Prerequisites
The programming language, framework, and library used
```
PHP 7.1
[Carbon](https://carbon.nesbot.com/)
Laravel 5.7
Bootstrap 4
Jquery-3.3.1.min.js
Vue.js
[Tesseract.js](https://unpkg.com/tesseract.js@v2.0.0-alpha.13/dist/tesseract.min.js)
Selenium 5 (for testing)
```
* For Vue.js the whole project need to be compile locally first before deploy it to the current web hosting
* If any other modules for PHP is needed you can install via [Composer](https://getcomposer.org/)


## Key Files
### .env on Quadra (Out Dated)
```
....
DB_CONNECTION=mysql
DB_HOST=mysql25.quadrahosting.com.au
DB_PORT=3306
DB_DATABASE=smartbr_billingplusu
DB_USERNAME=smartbr_rmitteam
DB_PASSWORD=BILLINGPLUSU
....
MAIL_DRIVER=smtp
MAIL_HOST=mail14.qnetau.com
MAIL_PORT=587
MAIL_USERNAME=rmitteam@rmit.billingplus.com
MAIL_PASSWORD=BILLINGPLUSU
MAIL_ENCRYPTION=tls
....
GOOGLE_RECAPTCHA_KEY=6LfuA7wUAAAAAHETZgWj1FqJ1uUxN-XQhDw7fPmT
GOOGLE_RECAPTCHA_SECRET=6LfuA7wUAAAAALBdPrqPmlcuawOsCoo05Ww8-PnV
```

### Migrations
* BillingPlusU/database/migrations/*.php

### Eloquent Model
* BillingPlusU/app/*.php

### Controllers
* BillingPlusU/app/http/controllers/MainController.php
* BillingPlusU/app/http/controllers/UserController.php

### Mail
* BillingPlusU/app/Mail/MailNotify.php

### Public
* BillingPlusU/public/images/sticker
* BillingPlusU/public/images/
* BillingPlusU/public/css/
* BillingPlusU/public/js/

### Resources
* BillingPlusU/resources/views/*.php
* BillingPlusU/resources/js/

### Routes
* BillingPlusU/routes/web.php

## Issues with AMPPS or Quadra Web hosting
* [Cannot Start mysql](https://gist.github.com/irazasyed/c516682e34068b14b55d#gistcomment-1833295)
* [There is no existing directory at /storage/logs and its not buildable: Permission denied](https://stackoverflow.com/a/53776826)
* Other issue clear cache might help

## IDE tools
* VScode
* VS 2019

## Versioning

Version 1.0

## RMIT BillingPlusU Team

* Suwat Tangtragoonviwatt (s3710374)
* Laura Jonathan (s3696013)
* Xinhong Chen (s3710646)
* Qiren Zhao (s3637084)
* Fengning Tian (s3582667)
* Xun Li (s3639678)


## Acknowledgments

* Barti Murugesan (Project Advisor)
