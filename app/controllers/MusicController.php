<?php

/**
* \HomeController
*/

use App\Services\RequestService;
use App\Services\MusicService;
use App\Models\Music;


class MusicController extends BaseController
{
    public function getMusicInfo(){
        $song_id = $this->request->get('song_id');
        if($song_id){
            $where = ['song_id'=>$song_id];
        }else{
            $random_id = mt_rand(0,9800);
            $where = ['id'=>$random_id];    
        }
        $music_info = Music::where($where)->first();
        $music_id = $music_info['song_id'];
        $music_name = $music_info['song_name'];
        if(empty($music_info['image_url'])){
            list($code,$msg,$extra_info) = MusicService::getMusicInfo($music_id);
            Music::updateMusic($music_id,$extra_info);
        }else{
            $extra_info['pic'] = $music_info['image_url'];
            $extra_info['album'] = $music_info['album'];
        }
        list($r,$g,$b,$hex) = MusicService::getMainColor($extra_info['pic']);
        $extra_info['main_color'] = ['r'=>$r,'g'=>$g,'b'=>$b,'hex'=>$hex];

        

        $response_data = ['music_id'=>$music_id,'music_name'=>$music_name,'extra_info'=>$extra_info];
        return $this->_outPut(json_encode($response_data));
        
    } 
    public function addLike(){
        $openid = $this->request->get('openid');
        $song_id = $this->request->get('song_id');
        $action = 1;
        list($code,$msg,$data) = MusicService::addLikeOrTrash($openid,$song_id,$action);
        $response_data = ['code'=>$code,'msg'=>$msg,'data'=>$data];
        return $this->_outPut(json_encode($response_data));
    }

    public function addTrash(){
        $openid = $this->request->get('openid');
        $song_id = $this->request->get('song_id');
        $action = -1;
        list($code,$msg,$data) = MusicService::addLikeOrTrash($openid,$song_id,$action);
        $response_data = ['code'=>$code,'msg'=>$msg,'data'=>$data];
        return $this->_outPut(json_encode($response_data));
    }
    public function cancelLikeOrTrash(){
        $openid = $this->request->get('openid');
        $song_id = $this->request->get('song_id');
        $action = 0;
        list($code,$msg,$data) = MusicService::addLikeOrTrash($openid,$song_id,$action);
        $response_data = ['code'=>$code,'msg'=>$msg,'data'=>$data];
        return $this->_outPut(json_encode($response_data));
    }

    public function getLikeList(){
        $openid = $this->request->get('openid');
        $action = 1;
        $page = !is_null($this->request->get('page'))?$this->request->get('page'):1;
        list($code,$msg,$data) = MusicService::getLikeOrTrashList($openid,$action,$page);
        $response_data = ['code'=>$code,'msg'=>$msg,'data'=>$data];
        return $this->_outPut(json_encode($response_data));
    }
    public function getTrashList(){
        $openid = $this->request->get('openid');
        $action = -1;
        $page = !is_null($this->request->get('page'))?$this->request->get('page'):1;
        list($code,$msg,$data) = MusicService::getLikeOrTrashList($openid,$action,$page);
        $response_data = ['code'=>$code,'msg'=>$msg,'data'=>$data];
        return $this->_outPut(json_encode($response_data));
    }



  

}
  

