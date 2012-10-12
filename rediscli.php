<?php
include_once("lib/Credis/Client.php");

abstract class Zend_Cache
{
    const CLEANING_MODE_ALL              = 'all';
    const CLEANING_MODE_OLD              = 'old';
    const CLEANING_MODE_MATCHING_TAG     = 'matchingTag';
    const CLEANING_MODE_NOT_MATCHING_TAG = 'notMatchingTag';
    const CLEANING_MODE_MATCHING_ANY_TAG = 'matchingAnyTag';
    function throwException($text) {
	die($text."\n");
    }
}

abstract class Zend_Cache_Backend
{
}

interface Zend_Cache_Backend_ExtendedInterface 
{
}

include_once("Cm/Cache/Backend/Redis.php");

echo "Cleaning DB 0\n";
$cache = new Cm_Cache_Backend_Redis(array('server' => "127.0.0.1", 'port' => "6379", 'database' => 0));
$cache->clean(Zend_Cache::CLEANING_MODE_OLD);

echo "Cleaning DB 1\n";
$cache = new Cm_Cache_Backend_Redis(array('server' => "127.0.0.1", 'port' => "6379", 'database' => 1));
$cache->clean(Zend_Cache::CLEANING_MODE_OLD);

?>