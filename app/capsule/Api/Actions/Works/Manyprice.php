<?php namespace Capsule\Api\Actions\Works;
use DB, Sentry, Response,Cache;
use Capsule\Core\Works\Work;
use Capsule\Api\Actions\Base;
class Manyprice extends Base {

public function run(){
$id = $_GET['id'];

$get = Cache::get('price_list'.$id);
echo  $get;
}




}
?>	