<?php
namespace App\Services;


class RequestService {
    

    const TIMEOUT = 3;
    static public function get($url, $timeout = 0) {
        $errno = -1; $error = '系统错误'; $data  = [];
        try {
            if(empty($timeout))
                $timeout = self::TIMEOUT;

            $_start = microtime(true);
            $s = curl_init();
            curl_setopt($s, CURLOPT_URL, $url);
            curl_setopt($s, CURLOPT_TIMEOUT, $timeout);
            //curl_setopt($s, CURLOPT_HTTPHEADER, ['Authorization: '.self::getAuth()]);
            curl_setopt($s, CURLOPT_MAXREDIRS, 2);
            curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($s, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($s, CURLOPT_ENCODING, "gzip");
            $res = curl_exec($s);
            //logger('request_res'.$res);
            $msg =   curl_error($s) . curl_getinfo($s, CURLINFO_HTTP_CODE);
            //logger('request_msg'.$msg);
            curl_close($s);
            
        } catch(\Exception $e) {
            $errno = 20385;
            $error = "网络异常";
            //self::__log_request( $e->getMessage());
        }
        return $res;
    }

    // Post
    static public function post($url, $header = [],$post_data = [], $timeout = 0) {
        $errno = -1; $error = '系统错误'; $data  = [];
        try {
            if(empty($timeout))
                $timeout = self::TIMEOUT;

            $_start = microtime(true);

            $s = curl_init();
            curl_setopt($s, CURLOPT_URL, $url);
            curl_setopt($s, CURLOPT_TIMEOUT, $timeout);
            if(!empty($header)){
                curl_setopt($s, CURLOPT_HTTPHEADER, $header);
            }   
            curl_setopt($s, CURLOPT_MAXREDIRS, 2);
            curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($s, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($s, CURLOPT_ENCODING, "gzip");
            curl_setopt($s, CURLOPT_POSTFIELDS, http_build_query($post_data));
                
            $res = curl_exec($s);
            $msg =   curl_error($s) . curl_getinfo($s, CURLINFO_HTTP_CODE);
            curl_close($s);
            if (false === $res)
                throw new \Exception("{$url}  返回内容为空 ".$msg, 133231);

            $ret = json_decode($res);
            
        } catch(\Exception $e) {
            $errno = 20386;
            $error = "网络异常";
            //self::__log_request( $e->getMessage());
            dump($e->getMessage());
        }
        
        return [0, $error, $ret];
    }




    

}

