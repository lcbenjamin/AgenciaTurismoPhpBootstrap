<?php

/** Timezone do servidor */
date_default_timezone_set("America/Recife");
setlocale(LC_ALL, 'pt_BR');

/** O nome do banco de dados*/
define('DB_NAME', 'AgenciaTurismo');
/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');
/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '');
/** nome do host do MySQL */
define('DB_HOST', 'localhost');

/** caminho absoluto para a pasta do sistema **/
if (!defined('ABSPATH'))
    define('ABSPATH', dirname(__FILE__) . '/');

/** caminho no server para o sistema **/
if (!defined('BASEURL'))
    define('BASEURL', '/AgenciaTurismoPhpBootstrap/');

/** caminho do arquivo de banco de dados **/
if (!defined('DBAPI'))
    define('DBAPI', ABSPATH . 'model/database.php');

/** caminho do arquivo de banco de dados **/
if (!defined('SITE_RAIZ'))
    define('SITE_RAIZ', $_SERVER['DOCUMENT_ROOT'].BASEURL);

?>