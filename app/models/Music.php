<?php
/**
* Report Model
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music extends Model{
	public $timestamps =false;
	protected $table = 'music163';
	protected $fillable = [
    	'song_id','song_name','author','image_url','album'
    ];
    public static function updateMusic($song_id,$extra_info){
    	$where = ['song_id'=>$song_id];
    	$field_update = ['image_url'=>$extra_info['pic'],'album'=>$extra_info['album']];
    	self::where($where)->update($field_update);
    }
}