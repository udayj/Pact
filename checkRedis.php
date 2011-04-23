<?php
 require_once '/home/uday/code/nrk-predis-8787930/examples/SharedConfigurations.php';

$redis = new Predis\Client($single_server);
$usernames =$redis->smembers('usernames');
print_r(count($usernames));
$foo=$redis->get('foo');
echo $foo;
echo md5("checking");

?>
