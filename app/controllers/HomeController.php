<?php

/**
* \HomeController
*/

use App\Services\YoudaoService;
use App\Services\RequestService;
use App\Services\TranslateService;
use App\Providers\MongoDB;

class HomeController extends BaseController
{
  public function home(){
    echo 'Hi Hp framework';
    //dump($this->request->get('test'));
    //dump($this->_outPut('Harry'));
    //$insertData = [['x' => 1, 'name'=>'菜鸟教程', 'url' => 'http://www.runoob.com'],
    //    ['x' => 2, 'name'=>'Google', 'url' => 'http://www.google.com'],
    //    ['x' => 3, 'name'=>'taobao', 'url' => 'http://www.taobao.com']
    //];
    //MongoDB::insert($insertData);
    // $filter = ['x'=>['$gt' => 1]];
    // $option = ['projection'=>['_id'=>0],
    //         'sort'=>['x'=> -1]
    //     ];
    // $res = MongoDB::query($filter,$option);
    // $updateData = [[['x' => 2],
    // ['$set' => ['name' => '菜鸟工具', 'url' => 'tool.runoob.com']],
    // ['multi' => true, 'upsert' => false]]];
    // MongoDB::update($updateData);
    //   $delData = [[['x' => 1], ['limit' => 0]]];
    //   MongoDB::delete($delData);
    $this->_outPut('test');
   
  }
  

}
  

