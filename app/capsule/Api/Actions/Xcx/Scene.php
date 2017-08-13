<?php
/**
 * Created by PhpStorm.
 * User: 武德安
 * Date: 2017/7/11
 * Time: 17:52
 */

namespace Capsule\Api\Actions\Xcx;
use DB;
use Response;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;

class Scene extends Base {

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    //微信小程序风格列表
    public function run()
    {
//咖啡厅、教室、厨房、火车、森林、海中、雨、十字路口、现场
        $data = array(
            'data'  => array(
                'kft'=>'咖啡厅',//咖啡厅
                'js'=>'教室',//教室
                'cf'=>'厨房',//厨房
                'hc'=>'火车',//火车
                'sl'=>'森林',//森林
                'hz'=>'海中',//海中
                'y'=>'雨',//雨
                'szlk'=>'十字路口',//十字路口
                'xc'=>'现场'//现场
            ),
            'status'=> 200
        );

        return  Response::json($data);
    }
}