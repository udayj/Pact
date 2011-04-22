<?php
 require_once '/home/uday/code/nrk-predis-8787930/examples/SharedConfigurations.php';

$redis = new Predis\Client($single_server);
$usernames =$redis->lrange('usernames',0,-1);
print_r(count($usernames));
$foo=$redis->get('foo');
echo $foo;

?>
