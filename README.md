Tool to cleanup redis tags from crontab.
=======================================

rediscli.php
------------
cleaning tags using Redis cache backend 
(https://github.com/colinmollenhour/Cm_Cache_Backend_Redis).  
  
Usage: rediscli.php <args>
    --server <server> - server address  
    --port <port> - server port  
    --verbose - show process status  
    --database <databases> - list of the databases, comma separated  
Example: rediscli.php --server 127.0.0.1 --port 6379 --database 0,1  

rediscache.php
-------------
shows "map" of the cache interactively. "." indicates non-empty tag and +
empty.
