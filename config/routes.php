<?php

use NoahBuscher\Macaw\Macaw;


Macaw::get('(:all)', function($fu) {
  echo '未匹配到路由<br>'.$fu;
});
Macaw::get('/','HomeController@home');
Macaw::get('/translate','HomeController@translate');
Macaw::get('/music_info','MusicController@getMusicInfo');
Macaw::post('/add_user','UserController@addUserInfo');
Macaw::post('/add_like','MusicController@addLike');
Macaw::post('/add_trash','MusicController@addTrash');
Macaw::post('/cancel_like_trash','MusicController@cancelLikeOrTrash');
Macaw::get('/get_like_list','MusicController@getLikeList');
Macaw::get('/get_trash_list','MusicController@getTrashList');


Macaw::dispatch();