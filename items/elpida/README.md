# [README](https://www.odusseus.org/php/elpida/README.md)
# Item System
Save or get a item. Can be use by a app or site.
The item is a binary value like { "value":"toto tata titi tutu"}

## Api's
1. UserCreateApi
<br />
https://www.odusseus.org/php/elpida/UserCreateApi.php

a. isalive (GET)
<br />
https://www.odusseus.org/php/elpida/userCreateApi.php?isalive


b. new User (POST)
<br />
https://www.odusseus.org/php/elpida/userCreateApi.php

* body : json 
```
{
  "appname": "APPLICATIONNAME",
  "nickname": "NAME",
  "password": "PASSAWORD",
  "email": "EMAIL"
} 
```

* will send a activation email.

2. UserActivateApi
a. isalive (GET)
<br/>
https://www.odusseus.org/php/elpida/UserActivateApi.php?isalive

b. user activate is account (POST)
<br />
https://www.odusseus.org/php/elpida/UserActivateApi.php
* Query parameters :
 nickname=NAME
 activationcode=CODE

3. UserLoginApi
a. isalive (GET)
<br />
https://www.odusseus.org/php/elpida/UserLoginApi.php?isalive

b. User log in (POST)
<br />
https://www.odusseus.org/php/elpida/UserLoginApi.php

* body : json 
```
{
  "appname": "APPLICATIONNAME",
  "nickname": "NAME",
  "password": "PASSWORD"
}
```
* retrive a cookie

4. ItemSetApi
a. isalive (GET)
<br />
https://www.odusseus.org/php/elpida/ItemSetApi.php?isalive

b. set a item (POST)
<br />
https://www.odusseus.org/php/elpida/ItemSetApi.php
```
{ 
	"value":"VALUE",
	"version": 0
}
```
* send cookie

5. ItemGetApi
a. isalive (GET)
<br />
https://www.odusseus.org/php/elpida/ItemGetApi.php?isalive

b. get a itiem (GET)
<br />
https://www.odusseus.org/php/elpida/ItemGetApi.php

* send cookie 
* retrive : the value as json