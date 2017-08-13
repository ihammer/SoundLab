<?php namespace Capsule\Api\Actions\Enroll;
use DB,Response;
use Capsule\Api\Actions\Base;
use Capsule\Core\Enroll\Enroll;
class Create extends Base {

    public function run()
    {
        $phone             =$this->input("phone");//手机号
        $enroll_name       =$this->input('name');//姓名
        $activity_id       =$this->input('activity_id','0');//活动id
        $activity_name     =$this->input('activity_name');//活动名称
        $is_original       =$this->input('is_original','0');//是否原创
        $age               =$this->input('age','0');//年龄
        $occupation        =$this->input('occupation','');//职业
        $style             =$this->input('style','');//风格


        if (empty($phone) || empty($enroll_name) || empty($activity_name) || empty($age)|| empty($occupation)) {
            return Response::json(['success' => 'error', 'reason' => '参数错误']);
        }
        /*$is_tags = DB::table("tags")->where("id", "=", $activity_id)->first();
        if(empty($is_tags)){
            return Response::json(['success' => 'error', 'reason' => '活动不存在！']);
        }*/
        $is_enroll=DB::table("enroll")->where('phone','=',$phone)->where('activity_name','=',$activity_name)->first();
        if($is_enroll){
            return Response::json(['success' => 'error', 'reason' => '您已经报名！']);
        }
        $data_enroll['phone']           =$phone;
        $data_enroll['enroll_name']     =$enroll_name;
        $data_enroll['activity_id']     =$activity_id;
        $data_enroll['activity_name']   =$activity_name;
        $data_enroll['is_original']     =$is_original;
        $data_enroll['age']             =$age;
        $data_enroll['occupation']      =$occupation;
        $data_enroll['style']           =$style;
        DB::table("enroll")->insert($data_enroll);
        return Response::json(['success' => 'success', 'reason' => '报名成功！']);
    }
}