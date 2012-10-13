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
	"\t--server <server> - server address\n".
	"\t--port <port> - server port\n".
	"\t--verbose - show process status\n".
	"\t--database <databases> - list of the databases, comma separated\n".
	"Example: rediscli.php --server 127.0.0.1 --port 6379 --database 0,1\n\n";
	exit(0);
}
/* parsing command line options */
$longopts  = array(
	"server:",
	"port:",   
	"database:", 
	"verbose"
	);
$options = getopt("", $longopts);
if(!isset($options["server"]) || !isset($options["port"]) || !isset($options["database"])) {
	showHelp();
} 
$databases=preg_split('/,/',$options["database"]);

foreach($databases as $db) {
	$db = (int) $db;
	if(isset($options["verbose"]))
		echo "Cleaing database $db:";
	

	try {
		$cache = new Cm_Cache_Backend_Redis(array('server' => $options["server"], 'port' => $options["port"], 'database' => $db));
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
	
	if(isset($options["verbose"]))
		echo " [done]\n";
	unset($cache);
}

?>