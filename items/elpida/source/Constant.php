<?php namespace Items;
    require_once("Environment.php");
    
    define("ACTIVATION_CODE", "activationcode");
    define("APPNAME", "appname");
    define("COOKIE_TOKEN_PERMANENT", 315360000); // (10 * 365 * 24 * 60 * 60)) = 10 years.
    define("COOKIE_TIMEOUT", 3600); // The cookie will expire when the browser closes.
    define("COOKIE_TOKEN", "token");
    define("EMAIL", "email");
    define("ID", "id");
    define("BADIP", "badip");
    define("ITEMLENGTH", "itemlength");
    define("IS_ALIVE", "isalive");
    define("IS_COOKIE_PERMANENT", "iscookiepermanent"); //secondes
    define("IS_LOGGED_IN", "isloggedin");
    define("JSON_DIR", "json");
    define("MAIL_DIR", "mail");
    define("MAX_BYTE", 10000);
    define("MAX_LENGTH", "maxlength");
    define("MAX_CREATEUSER", "createuser");
    define("NICKNAME", "nickname");
    define("PASSWORD", "password");
    define("STATE_TRUE", "true");
    define("STATE_FALSE", "false");
    define("SUCCESS", "Success");
    define("TXT_DIR", "txt");
    define("USER_DIR", "user");
    define("VALUE", "value");
    define("VERSION", "version");
    define("VERSION_CHECK_ENABLED", false);
    define("VALUE_DIR", "value");
?>