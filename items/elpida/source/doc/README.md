# Readme

## Config

### Error Log 
1. php.ini
```
error_log = C:\Githup\Odusseus\php\items\elpida\log\php_errors.log
```

### xdebug
[Plugin PHP Debug](https://github.com/felixfbecker/vscode-php-debug)
1. launch.json
```
{  
  "version": "0.2.0",
  "configurations": [
    {
      "name": "Listen for XDebug",
      "type": "php",
      "request": "launch",
      "port": 9090
    }
  ]
}
```

2. php.ini
```
 zend_extension = "C:\php\ext\php_xdebug-2.8.0-7.3-vc15-nts-x86_64.dll"

[Xdebug]
xdebug.remote_enable = 1
xdebug.remote_autostart = 1
xdebug.remote_host=localhost
xdebug.remote_port=9090
xdebug.remote_handler=dbgp
xdebug.remote_log="C:\tmp\xdebug.log"
xdebug.max_nesting_level=10000
xdebug.idekey="VSCODE"
```

### PHPUnit
[Phpunit for VSCode](https://github.com/elonmallin/vscode-phpunit)
1) settings.json
```
"phpunit.php": "C:\\php\\php.exe",
    "phpunit.phpunit": "c:\\phpunit\\phpunit-9.0.1.phar",
    "phpunit.args": [
        "--verbose",
        "--configuration", "c:\\Githup\\Odusseus\\php\\items\\elpida\\test\\phpunit.xml"
    ],
```