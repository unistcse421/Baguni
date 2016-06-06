<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;
class Item extends Model
{
    protected $table = 'item';
    protected $fillable = ['buyer_id','seller_id','price','status',
        'title','contents','reg_time','zim_time','inpro_time',
        'baguni_time','done_time'];
    protected function GetAllCount($id){
        $result = [];
        $arr = ['reg','zzim','in_progress','in_baguni','done'];
        foreach($arr as $each){
            $tmp =  DB::select("SELECT count(id) AS cnt FROM item WHERE uploader = '$id' AND status = '$each' GROUP BY uploader");
            if(count($tmp) == 0) $result[$each] = 0;
            else $result[$each] = $tmp[0]->cnt;
        }
        $tmp =  DB::select("SELECT money_remain FROM user_account WHERE uid = '$id' ORDER BY created_at DESC LIMIT 0,1");
        if(count($tmp) == 0) $result['remain'] = 0;
        else $result['remain'] = $tmp[0];
        return $result;
    }
    protected function Upload($data){
        $item = new Item;
        $item->title = $data['title'];
        $item->uploader = $data['id'];
        $item->image_ext = $data['ext'];
        $item->contents = $data['contents'];
        $item->status = 'reg';
        $item->price = $data['price'];
        if($data['type'] == 'sell'){
            $item->seller_id = $data['id'];
        }else{
            $item->buyer_id = $data['id'];
        }
        $item->save();
        return DB::select("SELECT id FROM item WHERE (seller_id = '".$data['id']."' OR buyer_id = '".$data['id']."') ORDER BY created_at DESC LIMIT 0,1")[0]->id;
    }
    protected function GetDetails($id){
        return DB::select("SELECT T.*, S.name AS name FROM item AS T,user AS S WHERE T.id = '$id' AND T.uploader = S.id")[0];
    }
    protected function GetItems($which,$status,$skip,$num){
        switch($which){
            case 'all':{
                return DB::select("SELECT T.*, S.name AS name FROM item AS T, user AS S WHERE T.status = '$status' AND T.uploader = S.id LIMIT $skip,$num");
            }
            case 'buy':{
                return DB::select("SELECT T.*, S.name AS name FROM item AS T, user AS S WHERE T.seller_id = '0' AND T.status = '$status' AND T.uploader = S.id LIMIT $skip,$num");
            }
            case 'sell':{
                return DB::select("SELECT T.*, S.name AS name FROM item AS T, user AS S WHERE T.buyer_id = '0' AND T.status = '$status' AND T.uploader = S.id LIMIT $skip,$num");
            }
        }
    }
    protected function GetMyItem($id,$skip,$num){
        return DB::select("SELECT * FROM item WHERE uploader='$id'OR seller_id = $id OR buyer_id = $id LIMIT $skip,$num");
    }
    protected function UpdateStatus($id,$data){
        $updated = '';
        $i = 0;
        $len = count($data);
        foreach($data as $key=>$value){
            if($i++ != $len - 1)
                $updated .= "$key = '$value', ";
            else
                $updated .= "$key = '$value'";
        }
        $updated = "UPDATE item SET $updated WHERE id = $id";
        echo $updated;
        DB::update($updated);
    }
}
//SELECT count(id) AS cnt FROM item WHERE uploader = 1 AND status = 'reg' GROUP BY uploader
//SELECT * FROM item WHERE buyer_id = '0' AND status = 'reg' LIMIT 0,4