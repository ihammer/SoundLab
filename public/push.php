<?php

set_time_limit(0);
//$db_connect=mysql_connect("127.0.0.1","root","jcc129") or die("Unable to connect to the MySQL!");
//mysql_select_db("capsule",$db_connect);
//$result=mysql_query("SELECT devicetoken FROM device where devicetoken not like 'android_%'");
//while($row=mysql_fetch_row($result)){
//$deviceToken='4770d19e2bb650a4c735637e26aeb9baeac0928c82e17e2733ad14dac8d0cd33';
//$deviceToken= 'd634801517cc416076aae5277e2eefaf845b65cac430ee735a9a26dd0b4c3036';
//$deviceToken= 'e331c0122971371e1bfa200bb4ba4aa8ad5d3b01b9ad078118786dccf33e0a47';
//$deviceToken= '572a0d134c45b81084ec3a3b1c74cee73cb0e943b05e6c34d9b5a89ce01b57c2';
  $deviceToken= 'ddfa4e913681791a0b7fd4f8a8dbe350546dadb79cdbbebbe5e7950986bfb6ca';
$message=isset($_GET["m"]) ? $_GET["m"] : "呦,大家好,犀牛哥无处不在哦！";
$body = array("aps" => array("alert" => $message ,"badge" => 1,"sound"=>'default'),"action"=>"work","detail"=>495);  //推送方式，包含内容和声音
$ctx = stream_context_create();
//如果在Windows的服务器上，寻找pem路径会有问题，路径修改成这样的方法：
//$pem = dirname(__FILE__) . '/' . 'apns-dev.pem';
//linux 的服务器直接写pem的路径即可
stream_context_set_option($ctx,"ssl","local_cert","ck1.pem");
$pass = "love&peace118";
stream_context_set_option($ctx, 'ssl', 'passphrase', $pass);
//此处有两个服务器需要选择，如果是开发测试用，选择第二名sandbox的服务器并使用Dev的pem证书，如果是正是发布，使用Product的pem并选用正式的服务器
//$fp = stream_socket_client("ssl://gateway.push.apple.com:2195", $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
$fp = stream_socket_client("ssl://gateway.sandbox.push.apple.com:2195", $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
if (!$fp) {
echo "Failed to connect 1:".$err." 2:".$errstr;
return;
}
print "Connection OK\n";
$payload = json_encode($body);
/*********************************/

	$fp = stream_socket_client("ssl://gateway.push.apple.com:2195", $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
	//$msg = chr(0) . pack("n",32) . pack("H*", str_replace(' ', '', $row[0])) . pack("n",strlen($payload)) . $payload;
	$msg = chr(0) . pack("n",32) . pack("H*", $deviceToken) . pack("n",strlen($payload)) . $payload;
	echo "sending message :" . $payload ."\n";
	fwrite($fp, $msg);

//$msg = chr(0) . pack("n",32) . pack("H*", str_replace(' ', '', $deviceToken)) . pack("n",strlen($payload)) . $payload;
//echo "sending message :" . $payload ."\n";
//fwrite($fp, $msg);

fclose($fp);
//}
/*
?>

<?php
/*
// 这里是我们上面得到的deviceToken，直接复制过来（记得去掉空格）
$deviceToken = '572a0d134c45b81084ec3a3b1c74cee73cb0e943b05e6c34d9b5a89ce01b57c2';

// Put your private key's passphrase here:
$passphrase = 'love&peace118';

// Put your alert message here:
$message = 'My first push test!';

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
//这个为正是的发布地址
 //$fp = stream_socket_client(“ssl://gateway.push.apple.com:2195“, $err, $errstr, 60, //STREAM_CLIENT_CONNECT, $ctx);
//这个是沙盒测试地址，发布到appstore后记得修改哦
$fp = stream_socket_client(
'ssl://gateway.sandbox.push.apple.com:2195', $err,
$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body['aps'] = array(
'alert' => $message,
'sound' => 'default'
);

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
echo 'Message not delivered' . PHP_EOL;
else
echo 'Message successfully delivered' . PHP_EOL;

// Close the connection to the server
fclose($fp);*/
?>