<?php
// ** MySQL settings ** //
define('AXA_DB_DSN','mysql:host=localhost;dbname=amicapackdb');
define('AXA_DB_HOST','localhost');
define('AXA_DB_USER', 'root');     // Your MySQL username
define('AXA_DB_PASSWORD', 'Admin123'); // ...and password
define('AXA_DB_NAME','amicapackdb');

//define('AXA_DB_DSN','mysql:host=localhost;dbname=u494783460_apdb');
//define('AXA_DB_HOST','localhost');
//define('AXA_DB_USER', 'u494783460_root');     // Your MySQL username
//define('AXA_DB_PASSWORD', 'Admin123'); // ...and password
//define('AXA_DB_NAME','u494783460_apdb');

// Automatically make db connection inside lib
define("AUTOCONNECT",0);

define('ABSPATH', dirname(__FILE__).'/');
define('LOGPATH',ABSPATH . 'logs/');


?>