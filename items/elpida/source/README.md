# Item System
For a App can a user set and get a item.
The item is a binary value like { "value":"toto tata titi tutu"}

## Api's
1. Post userCreateApi
* body : json {
  "appname": "APPLICATIONNAME",
  "nickname": "NAME",
  "password": "PASSAWORD",
  "email": "EMAIL"
}
* send activation email.
2. Get  userActivateApi
* Query parameters :
 nickname=NAME
 activationcode=CODE
3. POST  loginApi
* body : json {
  "appname": "APPLICATIONNAME",
  "nickname": "NAME",
  "password": "PASSWORD"
}
* retrive a cookie
4. Post itemSetApi
{ "value":"VALUE"}
* send cookie
5. Get  itemGetApi
* send cookie 
* retrive : the value as json