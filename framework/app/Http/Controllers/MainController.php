<?php

namespace App\Http\Controllers;

use Request;
use App\User;
use Session;
use App\Http\Requests;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Item;
class MainController extends Controller
{
    public function index(){
        return view('login');
    }
    public function Mypage(){
        $data = Item::GetAllCount(Session::get('id'));
        return view('mypage',['data'=>$data]);
    }
    public function Upload(){

        return view('upload');
    }
    public function Main(){
        $data = Item::GetAllCount(Session::get('id'));
        return view('main',['data'=>$data]);
    }
    public function AjaxUpload(){
        $data = Request::all();
        $data['id'] = Session::get('id');
        $file = Input::file('File');
        if(strlen($data['title']) > 60)
            return '0:제목의 길이를 확인해 주세요.';
        if(strlen($data['contents']) > 5000)
            return '0:컨텐츠의 길이를 확인해 주세요.';
        if(Input::hasFile('File')) {
            $rules = ['File' => 'mimes:jpeg,bmp,png|max:10000'];
            $validator = Validator::make(Request::all(), $rules);
            if ($validator->fails()) {
                return '0:메인 이미지의 크기 또는 확장자를 확인 해주세요.';
            }
            $destinationPath = 'images/thumbnail';
            $data['ext'] = $file->getClientOriginalExtension();
            $demoNum = Item::Upload($data);
            $upload_success = $file->move($destinationPath, $demoNum . '.' . $file->getClientOriginalExtension());
            if ($upload_success) {

                return '1:'.$demoNum;
            }
        }
    }
    public function AjaxLogin(){
        $data = Request::all();
        if(User::where('email','=',$data['email'])->count() == 0){
            return '0:아이디 혹은 비밀번호가 잘못되었습니다.';
        }
        $UserData = User::where('email','=',$data['email'])->take(1)->get()[0];
        if($UserData['password'] != $data['password']){
            return '0:아이디 혹은 비밀번호가 잘못되었습니다.';
        }

        Session::put('id',$UserData['id']);
        Session::put('email',$UserData['email']);
        Session::put('password',$UserData['password']);
        Session::put('name',$UserData['name']);
        Session::put('phone',$UserData['phone']);
        return '1:success';
    }
    public function AjaxJoin(){
        $data = Request::all();
        if($data['password'] != $data['confirm']) return '0:비밀번호를 다시 확인해 주세요';
        if(User::where('email','=',$data['email'])->count() != 0){
            return '0:이미 존재하는 이메일입니다.';
        }
        if(strlen($data['password']) < 6){
            return '0:비밀번호의 길이는 6자 이상입니다.';
        }
        if(preg_match('/[^\x{1100}-\x{11FF}\x{3130}-\x{318F}\x{AC00}-\x{D7AF}0-9a-zA-Z]/u',$data['password']))
            return '0:비밀번호는 영문, 숫자만 가능합니다.';
        if(strlen($data['password']) >16){
            return '0:비밀번호의 길이는 16자 미만 입니다.';
        }
        User::JoinUser($data);
        return '1:success';
    }
    public function AjaxGetDetails($id){
        return view('modal',['content'=>Item::GetDetails($id)]);
    }
    public function AjaxContent(){
        $data = Request::all();
        $contents = Item::GetItems($data['which'],$data['status'],$data['skip'],$data['num']);
        return view('ajaxContent',['contents'=>$contents]);
    }
    public function AjaxMyItem(){
        $data = Request::all();
        return view('ajaxMypage',['contents'=>Item::GetMyItem(Session::get('id'),$data['skip'],$data['num'])]);
    }
    public function UpdateItem($id){
//        if($id != Session::get('id')){
//            return 'Error!';
//        }
        $data = Request::all();
        Item::UpdateStatus($id,$data);
    }
    public function rootCheck(){
        Session::put('root','on');
    }
}
