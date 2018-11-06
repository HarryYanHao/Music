<?php
namespace App\Services;
use App\Services\RequestService;
use App\Models\Like;
use App\Models\Music;
use \Imagick;

class MusicService {
    const page_size = 10;
    public static function getMusicInfo($music_id){
        $url = "http://music.163.com/api/song/detail/?id={$music_id}&ids=%5B{$music_id}%5D&csrf_token=";
        
        list($code,$msg,$musicArr) = RequestService::post($url);
       

        $musicJson['name'] = $musicArr->songs[0]->name;//专辑
        $musicJson['url'] = $musicArr->songs[0]->mp3Url; //音乐链接
        $musicJson['pic'] = $musicArr->songs[0]->album->picUrl.'?param=320y320';//音乐封面
        $musicJson['singer'] = $musicArr->songs[0]->album->artists[0]->name;//歌手
        $musicJson['album'] = $musicArr->songs[0]->album->name;//专辑
        

      
        return [0,'ok',$musicJson];
  
    }
    public static function addLikeOrTrash($openid,$song_id,$action){
        $like = Like::where(['openid'=>$openid,'song_id'=>$song_id])->first();
        if($like){
            //更新
            $update_data = ['action'=>$action];
            $res = Like::where(['openid'=>$openid,'song_id'=>$song_id])->update($update_data);
            
        }else{
            //创建
            $create_data = ['openid'=>$openid,'song_id'=>$song_id,'action'=>$action];
            $res = Like::create($create_data);
        }
        if($res){
            return [0,'更新成功',[]];
        }else{
            return [0,'更新失败',[]];
        }
    }
    public static function getLikeOrTrashList($openid,$action,$page){
        $count = $like = Like::where(['openid'=>$openid,'action'=>$action])->get()->count();
        $like = Like::where(['openid'=>$openid,'action'=>$action])->take(self::page_size)->skip(($page-1)*self::page_size)->get()->toArray();
        $song_ids = array_column($like, 'song_id');
        $music = Music::whereIn('song_id',$song_ids)->get()->toArray();
        foreach ($music as $key => $value) {
            # code...
            $music[$key]['music_name'] = $value['song_name'];
        }
        $data['data'] = $music;
        $data['count'] = $count; 
        return [0,'ok',$data]; 
    }
    public static function getMainColor($photo){
        $r = 255;$g=255;$b=255;
        $image = file_get_contents($photo);
        $file_name = '/usr/local/var/www/HP/app/tmp/t1.jpg';
        file_put_contents($file_name, $image);

        $average = new Imagick($file_name);
        $average->quantizeImage( 10, Imagick::COLORSPACE_RGB, 0, false, false );
        $average->uniqueImageColors();
        $colorarr = array();
        $it = $average->getPixelIterator();
        $it->resetIterator();
        while( $row = $it->getNextIteratorRow() ){
            foreach ( $row as $pixel ){
                $colorarr[] = $pixel->getColor();
             }
         }
        foreach($colorarr as $val){
            $r += $val['r'];
            $g += $val['g'];
            $b += $val['b'];

        }   
        $r = round($r/10);
        $g = round($g/10);
        $b = round($b/10);
        $hex = self::RGBToHex([$r,$g,$b]);
        return [$r,$g,$b,$hex];

    }
    private static function RGBToHex($rgb){
        $hexColor = "#";
        $hex = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F');
        for ($i = 0; $i < 3; $i++) {
            $r = null;
            $c = $rgb[$i];
            $hexAr = array();
            while ($c > 16) {
                $r = $c % 16;
                $c = ($c / 16) >> 0;
                array_push($hexAr, $hex[$r]);
            }
            array_push($hexAr, $hex[$c]);
            $ret = array_reverse($hexAr);
            $item = implode('', $ret);
            $item = str_pad($item, 2, '0', STR_PAD_LEFT);
            $hexColor .= $item;
        }
        return $hexColor;
    }


    
      

}

