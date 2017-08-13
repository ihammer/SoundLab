<?php
function isMobile(){
	$useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';    
	$useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';      
	function CheckSubstrs($substrs,$text){    
		foreach($substrs as $substr){  
			if(false!==strpos($text,$substr)){    
				return true;    
			}
		}
		return false;    
	}
	$mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');  
	$mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');    
	$found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) ||    
	CheckSubstrs($mobile_token_list,$useragent);    
	if ($found_mobile){    
		return true;    
	}else{    
		return false;    
	}    
}  
if(1) {
function fgc($url){
	$ch = curl_init();
	//设置选项，包括URL
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	//执行并获取HTML文档内容
	$output = curl_exec($ch);
	//释放curl句柄
	curl_close($ch);
	return $output;
}
$user_data=json_decode(fgc("http://123.57.1.143/api/user/".$_GET["id"]."/show"),1);
$work_data=json_decode(fgc("http://123.57.1.143/api/user/".$_GET["id"]."/feeds?type=0&p=1"),1);

//foreach ($work_data['data'] as $key=>$val){
//    
//  //  foreach ($val  as $k=>$v){
//        echo "<pre>";
//        var_dump($val['id']);
//        echo '</pre>';
//  //  }
//}
//die;
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0"/>
    <link rel="stylesheet" href="css/base.css"/>
    <link rel="stylesheet" href="css/swiper.min.css"/>
    <link rel="stylesheet" href="css/my.css"/>

</head>
<body>
<div class="r_layout">
    <nav>
        <div class="blur">

        </div>
       <div class="nav_main">
           <div class="my_box m15 clearfix ">
               <a class="f_left" href="#">&#xe601;</a>
               <div class="swiper-pagination">
               </div>
           </div>
           <div class="swiper-container">
               <ul class="clearfix swiper-wrapper">
                   <li class="swiper-slide">
                       <div class="my clearfix">
                           <div class="clearfix my_head">
                               <div class="head f_left">
                                   <img src="<?php   echo $user_data['data']['avatar']?>" alt=""/>
                               </div>
                               <a class="follow" href="javascript:void (0);">+关注</a>
                           </div>
                           <div class="my_name clearfix">
                               <span class="name f_left"><?php  echo $user_data['data']['username'];?></span>
                               <div class="sex f_left"><?php if($user_data['data']['sex']==1){  echo '男';}elseif($user_data['data']['sex']==2){ echo '女';}else{ echo '外星人';}   ?></div>
                           </div>
                           <div class="v">
                               <p><?php  echo  $user_data['data']['location']?></p>
                           </div>
                           <div class="tip">
                               
                               <p>
                                   <?php  if(!empty($user_data['data']['introduce'])){
                                       echo $user_data['data']['introduce'];
                                   }else{
                                       echo '这是一个神秘的人。。。。。。';
                                   }
?>
                                   
                               
                               </p>
                           </div>
                       </div>
                   </li>
                   <li class="swiper-slide">
                       <div class="income">
<!--                           <div class="clearfix"><p class="f_left">总收入: </p><p class="f_left">222</p></div>-->
                           <div class="clearfix"><p class="f_left">总积分: </p><p class="f_left"><?php  echo  $user_data['data']['score']?$user_data['data']['score']:0;?></p></div>
                       </div>
                       <div class="my clearfix">
                           <div class="clearfix my_head">
                               <div class="head">
                                   <img src="<?php   echo $user_data['data']['avatar']?>" alt=""/>
                               </div>
                               <a  class="follow" href="javascript:void (0);">+关注</a>
                           </div>
                       </div>
                       <div class="wrap-box">
                           <ul>
                               <li>
                                   <div>
                                       <p><?php  echo  $user_data['data']['fans_count']?$user_data['data']['fans_count']:0;?></p>
                                       <p>粉丝</p>
                                   </div>
                               </li>
                               <li>
                                   <div>
                                       <p><?php  echo  $user_data['data']['follow_count']?$user_data['data']['follow_count']:0;?></p>
                                       <p>关注</p>
                                   </div>
                               </li>
                               <li>
                                   <div>
                                       <p><?php  echo  $user_data['data']['visit']?$user_data['data']['visit']:0;?></p>
                                       <p>总浏览</p>
                                   </div>
                               </li>
                           </ul>
                       </div>
                   </li>
               </ul>
           </div>
       </div>
    </nav>
    <div class="my_works ">
            <div class="swiper-container2">
                 <ul class="tab swiper-wrapper">
                                <li class="tab-item active swiper-slide inp">作品</li>
                                    <?php  $album_list = $user_data['data']['album_list']; ?>

                               
                                <?php
                                 if(!empty($album_list)){
                                
                               
                                    foreach ($album_list as  $key=>$val){

                                echo    '<li class="tab-item swiper-slide"  id='.$val['id'].'>'.$val['albumtitle'].'</li>';
                                }

                                    }  ?>

                            </ul>
            </div>
        <div class="wrapper">
            <div id="works" class="products clearfix selected ">
               <ul> 
                   

                       
               </ul>
            </div>
            <div class="products album">
                <div class="description">
                    <p>作品描述。。。。。</p>
                </div>
               
                <div class="album_content">
                    <ul>
                        
                    </ul>
                </div>
            </div>
            
                <p class="tips loading">正在加载...</p>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/swiper.min.js"></script>
<script src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/template-native.js"></script>
<script src="js/js.js"></script>
<script type="text/template" id="album_ul">
    <% for(var i=0; i<works.length; i++) { %>
    <li>
        <div class="works">
            <div>
                <a href="http://pillele.cn/play.php?id=<%= works[i].id %>">
                    <img src="<%= works[i].cover %>" alt="">
                </a>
            </div>
            <div class="works_message clearfix">
                <div class="works_message_left">
                    <p><%= works[i].title %></p>
                    <div class="love clearfix">
                                        <span class="f_left">
                                            <img class="f_left" src="imgs/3_1.jpg" alt=""/><p class="f_left"><%= works[i].love_count %></p>
                                        </span>
                                        <span class="f_right">
                                            <img class="f_left" src="imgs/4_1.jpg" alt=""/><p class="f_left"><%= works[i].comm_count %></p>
                                        </span>
                    </div>

                </div>
                <div class="works_message_right">
                    <p><%= date[i]%></p>
                    <p><%= num[i]%>月</p>
                </div>
                <div class="class">
                    <P><%= works[i].tags[2]%></P>
                </div>
            </div>
        </div>
    </li>
    <% } %>
</script>
<script type="text/template" id="albums">
    <% for(var i=0; i<works.length; i++) { %>
    <li>
        <div class="album_works">
            <a href="http://pillele.cn/play.php?id=<%= works[i].id %>"><img src="<%= works[i].cover %>" alt=""/></a>
        </div>
        <div class="album_works_message">
            <div class="title"><p><%= works[i].title %></p></div>
            <div class="topic clearfix"><p><%= works[i].tags[2]%></p></div>
            <div class="love clearfix">
                <span class="f_left">
                    <img class="f_left" src="imgs/3_1.jpg" alt=""/><p class="f_left"><%= works[i].love_count %></p>
                </span>
                <span class="f_right">
                    <img class="f_left" src="imgs/4_1.jpg" alt=""/><p class="f_left"><%= works[i].comm_count %></p>
                </span>
            </div>
        </div>
    </li>
    <% } %>
</script>

</body>
</html>
<?php
}

?>