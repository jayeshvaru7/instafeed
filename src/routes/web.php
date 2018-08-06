<?php

$namespace = 'Jvaru\Instagram\Http\Controllers';

Route::group([
    'namespace' => $namespace,
    'prefix' => 'jvaru',
], function (){
    Route::get('/instafeed', function(){
        return ['Hello', 'this is Insta feed.'];
    });
	Route::get('/fbfeed', function(){
        return ['Hello', 'this is Facebook feed.'];
    });
	Route::get('/twitterfeed', function(){
        return ['Hello', 'this is Twitter feed.'];
    });
});