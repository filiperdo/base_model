<?php

// Always provide a TRAILING SLASH (/) AFTER A PATH
if ($_SERVER['HTTP_HOST'] == "localhost")
	define('URL', 'http://localhost/khas/');
else
	define('URL', '');
	
define('LIBS', 'libs/');

define('DB_TYPE', 'mysql');

define('DB_HOST', 'cpmy0125.servidorwebfacil.com');
define('DB_NAME', 'nepali_khas');
define('DB_USER', 'nepali_userkhas');
define('DB_PASS', 'Inicial@123');

//Nome do sistema
define('SYSTEM_NAME','KHAS');

define('PREFIX_SESSION', 'khas_');
