<?php
/* Load Credis client library */
include_once("lib/Credis/Client.php");

/* emulation of the ZF to work standalone */
abstract class Zend_Cache
{
	const CLEANING_MODE_ALL              = 'all';
	const CLEANING_MODE_OLD              = 'old';
	const CLEANING_MODE_MATCHING_TAG     = 'matchingTag';
	const CLEANING_MODE_NOT_MATCHING_TAG = 'notMatchingTag';
	const CLEANING_MODE_MATCHING_ANY_TAG = 'matchingAnyTag';
	function throwException($text) {
		die("Exception: ".$text."\n");
	}
}

abstract class Zend_Cache_Backend {}
interface Zend_Cache_Backend_ExtendedInterface {}

/* loading Redis cache backend */ 
include_once("Cm/Cache/Backend/Redis.php");

function showHelp(){
	echo "Usage: rediscli.php\n".
	"\t-s <server> - server address\n".
	"\t-p <port> - server port\n".
	"\t-v show status messages\n".
	"\t-d <database list> - list of the databases, comma separated\n".
	"Example: rediscli.php -s 127.0.0.1 -p 6379 -d 0,1\n\n";
	exit(0);
}
/* parsing command line options */
$opts  = "s:p:vd:";
$options = getopt($opts);
if(!isset($options["s"]) || !isset($options["p"]) || !isset($options["d"])) {
	showHelp();
} 
$databases=preg_split('/,/',$options["d"]);

foreach($databases as $db) {
	$db = (int) $db;
	if(isset($options["v"]))
		echo "Cleaing database $db:";
	

	try {
		$cache = new Cm_Cache_Backend_Redis(array('server' => $options["s"], 'port' => $options["p"], 'database' => $db));
	} catch (CredisException $e) {
		echo "\nError: ".$e->getMessage()."\n";
		exit(1);
	}

	
	if($cache === false ){
		echo "\nERROR: Unable to clean database $db\n";
	}
	try {
		$cache->clean(Zend_Cache::CLEANING_MODE_OLD);
	} catch (CredisException $e) {
		echo "\nError: ".$e->getMessage()."\n";
		exit(1);
	}
	
	if(isset($options["v"]))
		echo " [done]\n";
	unset($cache);
}

?>