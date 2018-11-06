<?php
namespace App\Providers;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use MongoDB\Driver\Manager;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Query;
    class Log
    {
        public static function bootLog()
        {
            $log = new Logger('controller');
            $log->pushHandler(new StreamHandler('../storage/log/' . date('Y-m-d') . '.log', Logger::WARNING));
            return $log;
        }
    }
    class DB{
	    public static function bootDB(){
	        $pdo = '';
		    $dbConfig = config('database');
        	$dsn ="{$dbConfig['driver']}:host={$dbConfig['host']};dbname={$dbConfig['database']}";
        	try{
           		$pdo = new \PDO($dsn,$dbConfig['username'],$dbConfig['password']);
       		}catch(\PDOException $e){
        	    //dump($e->getMessage());
            	app('log')->error('DB_ERROR:'.$e->getMessage());
       		}
       	return $pdo;
    
        }
    }
    class Redis{
        public static function bootRedis(){
            try{
                $redis = '';
                $redisConfig = config('redis');
                $redis = new \Redis();
                $redis->connect($redisConfig['host'],$redisConfig['port']);
                return $redis;
            }catch (\RedisException $e){
                app('log')->error('REDIS_ERROR:'.$e->getMessage());
            }

        }
    }
    class MongoDB{
        public static function bootMongoDB(){
            try{
                $mongodb = '';
                $mongodbConfig = config('mongodb');
                $mongodb = new Manager("mongodb://{$mongodbConfig['host']}:{$mongodbConfig['port']}");
                return $mongodb;
            }catch (\Exception $e){
                app('log')->error('MONGODB_ERROR:'.$e->getMessage());
            }
        }
        public static function insert($insertData){
            try{
                if(!is_array($insertData)){
                    throw new \Exception("insertData is not array");    
                }
                $mongodb = self::bootMongoDB();
                $mongodbConfig = config('mongodb');
                $bulk = new BulkWrite;
                foreach ($insertData as $item) {
                    $bulk->insert($item);
                }
                $mongodb->executeBulkWrite("{$mongodbConfig['database']}.{$mongodbConfig['collect']}",$bulk);
                
            }catch (\Exception $e){
                app('log')->error('MONGODB_ERROR:'.$e->getMessage());
            }
        }
        public static function query($filter,$options){
            try{
                if(!is_array($filter) || !is_array($options)){
                    throw new \Exception("filter or  options is not array");    
                }
                $mongodb = self::bootMongoDB();
                $mongodbConfig = config('mongodb');
                $query = new Query($filter,$options);
                $cursor = $mongodb->executeQuery("{$mongodbConfig['database']}.{$mongodbConfig['collect']}",$query);
            }catch (\Exception $e){
                app('log')->error('MONGODB_ERROR:'.$e->getMessage());
            }
            return $cursor;
        }
        public static function update($updateData){
            try{
                if(!is_array($updateData)){
                    throw new \Exception("updateData is not array");    
                }
                $mongodb = self::bootMongoDB();
                $mongodbConfig = config('mongodb');
                $bulk = new BulkWrite;
                foreach ($updateData as $item) {
                    $bulk->update(...$item);
                }
                $mongodb->executeBulkWrite("{$mongodbConfig['database']}.{$mongodbConfig['collect']}",$bulk);
                
            }catch (\Exception $e){
                app('log')->error('MONGODB_ERROR:'.$e->getMessage());
            }
        }
        public static function delete($delData){
            try{
                if(!is_array($delData)){
                    throw new \Exception("delData is not array");    
                }
                $mongodb = self::bootMongoDB();
                $mongodbConfig = config('mongodb');
                $bulk = new BulkWrite;
                foreach ($delData as $item) {
                    $bulk->delete(...$item);
                }
                $mongodb->executeBulkWrite("{$mongodbConfig['database']}.{$mongodbConfig['collect']}",$bulk);
                
            }catch (\Exception $e){
                app('log')->error('MONGODB_ERROR:'.$e->getMessage());
            }
        }
    }
