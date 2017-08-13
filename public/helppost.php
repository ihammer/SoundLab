<?php 
// //引入发送邮件类
// require("smtp.php"); 
// //使用163邮箱服务器
// $smtpserver = "smtp.163.com";
// //163邮箱服务器端口 
// $smtpserverport = 25;
// //你的163服务器邮箱账号
// $smtpusermail = "qinyujiaofun@163.com";
// // //收件人邮箱
// $smtpemailto = "930381319@qq.com";
// // //你的邮箱账号(去掉@163.com)
// $smtpuser = "qinyujiaofun";//SMTP服务器的用户帐号 
// // //你的邮箱密码
// $smtppass = "19910413"; //SMTP服务器的用户密码 
// // //邮件主题 
// $mailsubject = $_POST['contact'];
// // //邮件内容 
// $mailbody = $_POST['advice'];
// // //邮件格式（HTML/TXT）,TXT为文本邮件 
// $mailtype = "TXT";
// // //这里面的一个true是表示使用身份验证,否则不使用身份验证. 
// $smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
// // //是否显示发送的调试信息 
// $smtp->debug = FALSE;
// // //发送邮件
// $ok = $smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype); 
// echo 1;
?>