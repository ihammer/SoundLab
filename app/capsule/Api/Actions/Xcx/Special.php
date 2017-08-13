<?php
/**
 * Created by PhpStorm.
 * User: 武德安
 * Date: 2017/7/10
 * Time: 15:13
 */
namespace Capsule\Api\Actions\Xcx;
use DB;
use Response;
use Capsule\Core\Users\User;
use Capsule\Core\Works\Work;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkBasicSerializer;

class Special extends Base {

    protected $work;

    public function __construct(Work $work)
    {
        $this->work = $work;
    }
    //
    public function run()
    {
        //special 专题

        //名字
        $name  = htmlentities(trim($this->param('name')));
        //渠道
        $channel=$this->param('channel','region');

        if($channel=="region"){
            //地域列表 //全拼
            $list = array('beijing'=>'北京','shanghai'=>'上海','guangzhou'=>'广州','hangzhou'=>'杭州');
            //预检索
            if(!array_key_exists($name, $list)){
                $data['status']="400";
                $data['mag']="该地域暂时不开放！";
                return Response::json($data);
            }
        }elseif($channel=="scene"){
            //场景 //首字母
            $list = array('kft'=>'咖啡厅','js'=>'教室', 'cf'=>'厨房','hc'=>'火车','sl'=>'森林','hz'=>'海中','y'=>'雨','szlk'=>'十字路口','xc'=>'现场');
            //预检索
            if(!array_key_exists($name, $list)){
                $data['status']="400";
                $data['mag']="该场景待挖掘！";
                return Response::json($data);
            }
        }

        //指定用户id
        $user_id=202391167;

        //标签信息
        $tag_info=DB::table('tags')->where('name','=',$list[$name])->first();
        $place_tag_id=$tag_info->id;

        //随机作品
        $wt_info = DB::table('works_tags as wt')->where('wt.tag_id','=',$place_tag_id)->where('w.user_id','=',$user_id)->leftjoin('works as w','wt.work_id','=','w.id')->select("wt.*","w.title","w.user_id")->orderByRaw('RAND()')->first();

        //上一个
        $previousId=DB::table('works_tags as wt')->where('wt.tag_id','=',$place_tag_id)->where('w.user_id','=',$user_id)->where('wt.work_id', '<', $wt_info->work_id)->leftjoin('works as w','wt.work_id','=','w.id')->select("wt.*","w.title","w.user_id")->max('work_id');

        //下一个
        $nextId=DB::table('works_tags as wt')->where('wt.tag_id','=',$place_tag_id)->where('w.user_id','=',$user_id)->where('wt.work_id', '>', $wt_info->work_id)->leftjoin('works as w','wt.work_id','=','w.id')->select("wt.*","w.title","w.user_id")->min('work_id');

        //作品数据
        $works = $this->work->with('author')->where('id','=',$wt_info->work_id)->first();

        //推荐数据
        $recomend = $this->work->with('author')->where('top_sort','<>',0)->take(4)->orderBy('play_count','desc')->get();
        $serializer = new WorkBasicSerializer();
        $recomend = $serializer->collection($recomend);
        $data = array(
            'status'=>200,
            'work'  => array(
                'id'      => $works->id,
                'play_url' => $works->playurl,
                'username' => $works->author->username,
                'title'    => $works->title,
                'previous_id' => $previousId,
                'next_id'     => $nextId,
                'duration'     => $works->duration

            ),
            'recommend' =>$recomend->toArray()
        );
        return Response::json($data);

    }
}