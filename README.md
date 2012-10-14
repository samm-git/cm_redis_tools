Tool to cleanup redis tags from cron
====================================

rediscli.php
------------
cleaning tags using Redis cache backend 
(https://github.com/colinmollenhour/Cm_Cache_Backend_Redis).  
  
	Usage: rediscli.php <args>
	    -s <server> - server address  
	    -p <port> - server port  
	    -v - show process status  
	    -d <databases> - list of the databases, comma separated  
	Example: rediscli.php -s 127.0.0.1 -p 6379 -d 0,1  

rediscache.php
-------------
shows "map" of the cache interactively. "." indicates non-empty tag and +
empty.
