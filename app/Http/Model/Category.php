<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='category';
    protected $primaryKey='id';
    public $timestamps=false;
    protected $guarded=[];

    public function tree()
    {
        $categorys = $this->orderBy('order','asc')->get();
        return $this->getTree($categorys,'name','id','pid');
    }

//    public static function tree()
//    {
//        $categorys = Category::all();
//        return (new Category)->getTree($categorys,'name','id','pid');
//    }

    public function getTree($data,$field_name,$field_id='id',$field_pid='pid',$pid=0)
    {
        $arr = array();
        foreach ($data as $k=>$v){
            if($v->$field_pid==$pid){
                $data[$k]["_".$field_name] = $data[$k][$field_name];
                $arr[] = $data[$k];
                foreach ($data as $m=>$n){
                    if($n->$field_pid == $v->$field_id){
                        $data[$m]["_".$field_name] = '├─ '.$data[$m][$field_name];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }
}
