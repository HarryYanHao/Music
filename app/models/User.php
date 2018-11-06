<?php
/**
* Report Model
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{
	public $timestamps =false;
	protected $table = 'user';
	protected $fillable = [
    	'openid','nickname','gender','avatar_url','country'
    ];
    public static function addUserInfo($param){
        $openid = isset($param['openid'])&&!empty($param['openid'])?$param['openid']:'';
        $nickname = isset($param['nickname'])&&!empty($param['nickname'])?$param['nickname']:'';
        $gender = isset($param['gender'])&&!empty($param['gender'])?$param['gender']:1;
        $avatarUrl = isset($param['avatarUrl'])&&!empty($param['avatarUrl'])?$param['avatarUrl']:'';
        $country = isset($param['country'])&&!empty($param['country'])?$param['country']:'';

        $fill_user_info = ['openid'=>$openid,'nickname'=>$nickname,
        'gender'=>$gender,'avatar_url'=>$avatarUrl,'country'=>$country];

        return self::insert($fill_user_info);
    }
    
}