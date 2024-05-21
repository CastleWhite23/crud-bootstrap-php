<?php
 
/** O nome do banco de dados*/
if ( !defined('DB_NAME') )
   define('DB_NAME', 'wda_crud');
 
/** Usuário do banco de dados MySQL */
if ( !defined('DB_USER') )
   define('DB_USER', 'root');
 
/** Senha do banco de dados MySQL */
if ( !defined('DB_PASSWORD') )
   define('DB_PASSWORD', '');
 
/** nome do host do MySQL */
if ( !defined('SERVERNAME') )
   define('SERVERNAME', 'localhost');
 
/** caminho absoluto para a pasta do sistema **/
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');
   
/** caminho no server para o sistema **/
if ( !defined('BASEURL') )
    define('BASEURL', '/crud-bootstrap-php/');
   
/** caminho do arquivo de banco de dados **/
if ( !defined('DBAPI') )
    define('DBAPI', ABSPATH . 'inc/database.php');
 
    /** caminhos dos templates de header e footer **/
if ( !defined('HEADER_TEMPLATE') )
    define('HEADER_TEMPLATE', ABSPATH . 'inc/header.php');
if ( !defined('FOOTER_TEMPLATE') )
    define('FOOTER_TEMPLATE', ABSPATH . 'inc/footer.php');
 
    /** caminho para o PDF */
    if ( !defined('PDF') )
        define('PDF', ABSPATH . 'inc/pdf.php');
