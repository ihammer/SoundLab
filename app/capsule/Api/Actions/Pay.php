<?php
namespace Capsule\Api\Actions;

use Cache;
class Pay {
    
    //appid
    private static  $appid                   ="wxd6ba59c454ddb799";
    //密匙
    private static  $secret                  ="41a77900d0fc452ca91d2914ae8c1942";
    //商户号
    private static  $mch_id                  ="1408649802";
    //商户后台API密匙
    private static  $key                     ="BJE07ERUPBHGQFOMWW4SJR7ICW8ENNSR";
    
    
    //url
    private static  $gettokenurl             ="https://api.weixin.qq.com/cgi-bin/token";
    private static  $authorize               ="https://open.weixin.qq.com/connect/oauth2/authorize";
    private static  $access_token_oauth2     ="https://api.weixin.qq.com/sns/oauth2/access_token";
    private static  $userinfourl             ="https://api.weixin.qq.com/sns/userinfo";
    //统一下单地址
    private static  $unifiedOrder_url        ="https://api.mch.weixin.qq.com/pay/unifiedorder";
    //统一下单回调地址
    private static  $notify_url              ="http://www.pillele.cn/api/wxpay/update";
    
    
//     MGGC4D86ST1TN01S7G8UE5FVFHKX3K36
    
    //随机数
    public function getRandom($param){
        $str="0123456789abcdefghigkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $key = "";
        for($i=0;$i<$param;$i++)
        {
            $key .= $str{mt_rand(0,32)};    //生成php随机数
        }
        return  strtoupper($key);//大写
    }
    
    //curl
    public function curl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL,$url);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
    //post curl
    public function postcurl($url,$data){
        $body=$this->ToXml($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array());
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    
    /**
     * 输出xml字符
     * @throws WxPayException
     **/
    public function ToXml($data)
    {
        header("Content-type:text/xml");
        ksort($data);
    	$xml = "<xml>";
    	foreach ($data as $key=>$val)
    	{
    	    $xml.="<".$key.">".$val."</".$key.">";
        }
        $xml.="</xml>";
//         print_r($xml);die;
        return $xml;
    }
    
    /**
     * 生成签名
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    public function MakeSign($data)
    {
        //签名步骤一：按字典序排序参数
        ksort($data);
        $string = $this->ToUrlParams($data);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".self::$key;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }
    
    /**
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
    public static function Init($xml)
    {
        $obj = new self();
        $data=$obj->FromXml($xml);
        //fix bug 2015-06-29
        if($data['return_code'] != 'SUCCESS'){
            return $obj->GetValues($data);
        }
        $obj->CheckSign($data);
        return $obj->GetValues($data);
    }
    
    /**
     *
     * 检测签名
     */
    public function CheckSign($data)
    {
        //fix异常
        if(!$this->IsSignSet($data)){
            $this->errorMessage("签名错误！");
        }
    
        $sign = $this->MakeSign($data);
        if($this->GetSign($data) == $sign){
            return true;
        }
         $this->errorMessage("签名错误！");
    }
    
    /**
     * 判断签名，详见签名生成算法是否存在
     * @return true 或 false
     **/
    public function IsSignSet($data)
    {
        return array_key_exists('sign', $data);
    }
    

    /**
     * 获取签名，详见签名生成算法的值
     * @return 值
     **/
    public function GetSign($data)
    {
        return $data['sign'];
    }
    
    //错误提示
    public function errorMessage($str)
    {
        echo $str;die;
    }
    
    /**
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
    public function FromXml($xml)
    {
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $data;
    }
    
    
    /**
     * 获取设置的值
     */
    public function GetValues($data)
    {
        return $data;
    }
    
    /**
     * 格式化参数格式化成url参数
     */
    public function ToUrlParams($data)
    {
    	$buff = "";
		foreach ($data as $k => $v)
		{
			if($k != "sign" && $v != "" && !is_array($v)){
				$buff .= $k . "=" . $v . "&";
			}
		}
		$buff = trim($buff, "&");
		return $buff;
    }
    
    //获取weixin  access_token
    public function getToken(){
        $url=self::$gettokenurl."?grant_type=client_credential&appid=".self::$appid."&secret=".self::$secret;
        $ch = curl_init();
        $result=$this->curl($url);
        $result=json_decode($result);
        return $result->access_token;
    }
    
    //授权获取code
    public function getCode($redirect_uri){
        $url=self::$authorize."?appid=".self::$appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=".$this->getRandom(20)."#wechat_redirect";
        return $url;
    }
    
    //授权获取openid
    public function getuserinfo($code){
        $url=self::$access_token_oauth2."?appid=".self::$appid."&secret=".self::$secret."&code=".$code."&grant_type=authorization_code";
        $result=$this->curl($url);
        $result=json_decode($result);
        $url2=self::$userinfourl."?access_token=".$result->access_token."&openid=".$result->openid."&lang=zh_CN ";
        $result2=$this->curl($url2);
        $result2=json_decode($result2);
        return $result2;
        
//         Cache::put("access_token", $result->access_token, 60);
//         $access_token = Cache::get('access_token');
//         if(!empty($access_token)){
//             $url2=self::$userinfourl."?access_token=".$access_token."&openid=".$result->openid."&lang=zh_CN ";
//             $result2=$this->curl($url2);
//             $result2=json_decode($result2);
//             return $result2;
//         }else{
//             $url2=self::$userinfourl."?access_token=".$result->access_token."&openid=".$result->openid."&lang=zh_CN ";
//             $result2=$this->curl($url2);
//             $result2=json_decode($result2);
//             Cache::put("access_token", $result->access_token, 60);
//             return $result2;
//         }
       
    }
    
    //获取用户信息
    
    public  function getwxuserData($access_token,$openid){
        $url2=self::$userinfourl."?access_token=".$access_token."&openid=".$openid."&lang=zh_CN ";
        $result2=$this->curl($url2);
        $result2=json_decode($result2);
        return $result2;
    }
    
    //统一下单
    public function unifiedOrder($data){
         
        $newdata['appid']           =self::$appid;
        $newdata['mch_id']          =self::$mch_id;
        $newdata['device_info']     ="WEB";                     //设备号
        $newdata['nonce_str']       =$this->getRandom(32);      //随机字符串
        $newdata['body']            =$data['title'];            //商品简介
        $newdata['out_trade_no']    =$data['orderNO'];          //商家订单号
        $newdata['fee_type']        ="CNY";                     //货币类型
        $newdata['total_fee']       =$data['price']*100;       //总金额
        $newdata['spbill_create_ip']=$_SERVER["REMOTE_ADDR"];   //终端IP
        $newdata['time_start']      =date("YmdHis",time());     //交易起始时间
        $newdata['time_expire']     =date("YmdHis",time()+1800);//交易过期时间
        $newdata['notify_url']      =self::$notify_url;	        //接收微信支付异步通知回调地址
        $newdata['trade_type']      ="JSAPI";                   //交易类型
        $newdata['product_id']      =$data['work_id'];          //商户自定义商品ID
        $newdata['openid']          =$data['openid'];
        $newdata['sign_type']       ="MD5";//签名类型
        $newdata['sign']            =$this->MakeSign($newdata);
        
        $xml=$this->postcurl(self::$unifiedOrder_url, $newdata);
        return $res=self::Init($xml);
        
    }
    
    /**
     *
     * 支付结果通用通知
     * @param function $callback
     * 直接回调函数使用方法: notify(you_function);
     * 回调类成员函数方法:notify(array($this, you_function));
     * $callback  原型为：function function_name($data){}
     */
    public static function notify()
    {
        //获取通知的数据
        $xml = file_get_contents("php://input");
        
//         $xml ="<xml>
//    <return_code><![CDATA[SUCCESS]]></return_code>
//    <return_msg><![CDATA[OK]]></return_msg>
//    <appid><![CDATA[wx2421b1c4370ec43b]]></appid>
//    <mch_id><![CDATA[10000100]]></mch_id>
//    <nonce_str><![CDATA[IITRi8Iabbblz1Jc]]></nonce_str>
//    <sign><![CDATA[7921E432F65EB8ED0CE9755F0E86D72F]]></sign>
//    <result_code><![CDATA[SUCCESS]]></result_code>
//    <prepay_id><![CDATA[wx201411101639507cbf6ffd8b0779950874]]></prepay_id>
//    <trade_type><![CDATA[JSAPI]]></trade_type>
//         </xml>";
        //如果返回成功则验证签名
//         $result = self::Init($xml);
        $obj = new self();
        $result=$obj->FromXml($xml);
        return $result;
    }
    
    //获取openid
    public function getOpenid(){
        return self::$appid;
    }
    
    public function getKey(){
        return self::$key;
    }
    
    
}