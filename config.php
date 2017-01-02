<?php
// ** MySQL settings ** //
define('APC_DB_DSN','mysql:host=localhost;dbname=amicapackdb');
define('APC_DB_HOST','localhost');
define('APC_DB_USER', 'root');     // Your MySQL username
define('APC_DB_PASSWORD', 'Admin123'); // ...and password
define('APC_DB_NAME','amicapackdb');

//define('APC_DB_DSN','mysql:host=localhost;dbname=u494783460_apdb');
//define('APC_DB_HOST','localhost');
//define('APC_DB_USER', 'u494783460_root');     // Your MySQL username
//define('APC_DB_PASSWORD', 'Admin123'); // ...and password
//define('APC_DB_NAME','u494783460_apdb');

// Automatically make db connection inside lib
define("AUTOCONNECT",0);

define('ABSPATH', dirname(__FILE__).'/');
define('LOGPATH',ABSPATH . 'logs/');


?>