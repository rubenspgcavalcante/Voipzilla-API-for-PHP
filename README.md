Voipzilla Socket for PHP
===========

### A class to connect, send commands and receive data using the voipzilla socket API

About
========

**Voipzilla Socket** it's a class package of connection and log system. For a single command, that create one connection, send the command, gets it returns and close the connection. For every connection, there's a log marked by *<CONNECTED NOW>* and *<DISCONECTED NOW>*. Errors are logged too, with the mark *[ERROR]*.


How To Use
========

First include the Voipzilla_Socket.php file, after that, instatiate the object:

     <?php
        $socket_example = new Voipzilla();
        $response = $socket_example->command("foo");
In *$response* is the server response to the command. Just simple.



Warning
============

**Please be careful, Voipzilla Socket for PHP is under development. Please test before utilizing in production servers.**

Author
============

Created and coded by the Rubens Pinheiro Gonçalves Cavalcante
from *Mobtelecom Dev Team*.


License & Legal
==============

Utilizing GNU LESSER GENERAL PUBLIC LICENSE *Version 3, 29 June 2007*
**See LICENSE.txt file**