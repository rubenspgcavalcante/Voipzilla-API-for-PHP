<?php

/**
 * Socket configuration to access voipzilla servers
 * 
 * @author Mob Dev Team
 * @version 0.1 
 * @package Voipzilla-API-for-PHP
 * 
 */

/*-----------------------------------
-
===== Standart C socket defines =====
-
-----------------------------------*/

define('ENOTSOCK',        88);    /* Socket operation on non-socket */
define('EDESTADDRREQ',    89);    /* Destination address required */
define('EMSGSIZE',        90);    /* Message too long */
define('EPROTOTYPE',      91);    /* Protocol wrong type for socket */
define('ENOPROTOOPT',     92);    /* Protocol not available */
define('EPROTONOSUPPORT', 93);    /* Protocol not supported */
define('ESOCKTNOSUPPORT', 94);    /* Socket type not supported */
define('EOPNOTSUPP',      95);    /* Operation not supported on transport endpoint */
define('EPFNOSUPPORT',    96);    /* Protocol family not supported */
define('EAFNOSUPPORT',    97);    /* Address family not supported by protocol */
define('EADDRINUSE',      98);    /* Address already in use */
define('EADDRNOTAVAIL',   99);    /* Cannot assign requested address */
define('ENETDOWN',        100);   /* Network is down */
define('ENETUNREACH',     101);   /* Network is unreachable */
define('ENETRESET',       102);   /* Network dropped connection because of reset */
define('ECONNABORTED',    103);   /* Software caused connection abort */
define('ECONNRESET',      104);   /* Connection reset by peer */
define('ENOBUFS',         105);   /* No buffer space available */
define('EISCONN',         106);   /* Transport endpoint is already connected */
define('ENOTCONN',        107);   /* Transport endpoint is not connected */
define('ESHUTDOWN',       108);   /* Cannot send after transport endpoint shutdown */
define('ETOOMANYREFS',    109);   /* Too many references: cannot splice */
define('ETIMEDOUT',       110);   /* Connection timed out */
define('ECONNREFUSED',    111);   /* Connection refused */
define('EHOSTDOWN',       112);   /* Host is down */
define('EHOSTUNREACH',    113);   /* No route to host */
define('EALREADY',        114);   /* Operation already in progress */
define('EINPROGRESS',     115);   /* Operation now in progress */
define('EREMOTEIO',       121);   /* Remote I/O error */
define('ECANCELED',       125);   /* Operation Canceled */ 

/*-----------------------------------
===== endifs =====
-----------------------------------*/

if(!isset($config)){
    /**
    * Config variable
    * @var Array
    */
    $config = array();
}

/*-----------------------------------
-
===== Voipzilla configurations ======
-
-----------------------------------*/
if(!array_key_exists('voipzilla', $config))
    $config["voipzilla"] = array();


/*-----------------------------------
        Voipzilla access info
-----------------------------------*/
$config["voipzilla"]["socket-config"] =
    array(
        "server"    => "", // server adress
        "port"      => "8080", //default port
        "domain"    => AF_INET, // Other options: AF_UNIX or AF_INET6
        "type"      => SOCK_STREAM, //TCP socket type (Default)
        "protocol"  => getprotobyname(SOL_TCP), // TCP protocol
        "readtype"  => PHP_NORMAL_READ, //Reads the return string
    );

$config["voipzilla"]["user-info"] =
    array(
        "login"     => "",
        "password"  => "",
    );



/*-----------------------------------
-
===== Log configurations ======
-
-----------------------------------*/
if(!array_key_exists('log', $config))
    $config["log"] = array();


/*-----------------------------------
        Voipzilla access info
-----------------------------------*/
$config["log"]["structure"] = 
    array(
        "name-format"   => "Y-m-d", // Name format using date. See also http://php.net/manual/en/function.date.php
        "extension"     => ".log",
        "directory"     => "log/", // Relative path
        "log-prefix"    => "[H:i:s]", // log-prefix using date too
        );