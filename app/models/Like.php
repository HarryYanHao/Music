<?php
/**
* Report Model
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model{
	public $timestamps =true;
	protected $table = 'like';
	protected $fillable = [
    	'openid','song_id','action'
    ];
    
    
}