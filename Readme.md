# IsItUp
A php script to test server resources. Currently it is testing database connection and redis connection.

## Install
composer install

## Configure
Make your copy of .env from the provided .env.dist file and edit the appropriate credentials to match your system.

## Run the script directly
```shell
php index.php
```
*Successful response (response code 0):*

none


*Failure responses (response code 1):*

Database: SQLSTATE[HY000] [2002] Connection refused

Redis: Redis server went away


## Call the script from a shell script:
Don't forget to make the script executable first.

```shell
./call_is_it_up
```

*Successful response:*

SUCCESS


*Failure responses:*

FATAL ERROR:  Database: SQLSTATE[HY000] [2002] Connection refused

FATAL ERROR:  Redis: Redis server went away

## Http request:
Point your web server to index.php

*Successful response:*

HTTP status code 200 OK

Possible body content:

empty


*Failure responses:*

HTTP status code 500 internal server error

Possible body content:

Database: SQLSTATE[HY000] [2002] Connection refused

Redis: Redis server went away
