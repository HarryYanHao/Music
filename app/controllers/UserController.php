<?php

/**
* \HomeController
*/

use App\Services\RequestService;
use App\Services\MusicService;
use App\Models\User;


class UserController extends BaseController
{
    public function getUserInfo(){
        $code  = $this->request->get('code');
        $appid = config('mini.appid');
        $secret = config('mini.secret');
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';
        $res = RequestService::get($url);
        $res = json_decode($res,true);
        return $this->_output(json_encode(['code'=>0,'msg'=>'ok','data'=>$res]));
    }
    public function addUserInfo(){
        $param['openid'] = $this->request->get('openid');
        $param['avatarUrl'] = $this->request->get('avatarUrl');
        $param['country'] = $this->request->get('country');
        $param['gender'] = $this->request->get('gender');
        $param['nickname'] = $this->request->get('nickname');
        $res = User::addUserInfo($param);
        if($res){
            return $this->_output(json_encode(['code'=>0,'msg'=>'更新成功','data'=>[]]));
        }else{
            return $this->_output(json_encode(['code'=>-1,'msg'=>'更新失败','data'=>[]]));
        }
    }
  

}
  

