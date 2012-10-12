<?php

define("SET_TAGS",'zc:tags');

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->select(1); // select FPC


$tags=$redis->sMembers(SET_TAGS);
$tags_count=count($tags);
$empty_tags_count=0;
$slowttl=0;
foreach($tags as $tag)
{
    $tag="zc:ti:".$tag;
    $tag_members=$redis->sMembers($tag);
    $members_count=0;
    foreach($tag_members as $tag_member) {
	if($redis->exists("zc:k:".$tag_member)) {
	    $members_count++;
	    //$ttl=$redis->ttl("zc:k:".$tag_member);
	    //if($ttl>43200) $slowttl++;
	}
	else {
	    // $ttl=$redis->ttl("zc:k:".$tag_member);
	    // echo $ttl."\n";
	    // echo "zc:k:".$tag_member."\n";
	}
	// sleep(0.01); // dont kill the server
    }
    if($members_count == 0) {
	echo "+";
	$empty_tags_count++;
    }
    else {
	echo ".";
    }
}

print "Tags count: $tags_count, empty tags count: $empty_tags_count, slowttl=$slowttl\n";

?>