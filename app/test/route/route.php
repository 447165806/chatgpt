<?php
/**
 * Created by PhpStorm.
 * User: lj
 * Date: 2023/1/28
 * Time: 17:49
 */

use think\facade\Route;


//Route::miss(function () {
//    return fail('接口不存在', 99999);
//});

Route::group(function () {
    //分组demo
    Route::group('v1/test', function () {
        Route::rule('t1', 'v1.Test/t1');
        Route::get('t2', 'v1.Test/t2');
        Route::rule('t3', 'v1.Test/t3');
    });

})->allowCrossDomain();
