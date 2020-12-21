<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/12/21
 * Time: 10:47
 */

//return [
//    ['GET', '/hello', 'HelloController@index'],
//    ['GET', '/hyperf', 'HelloController@hyperf']
//];

use App\Controller\HelloController;

return [
    ['GET', '/hello/index', [HelloController::class, 'index']],
    ['GET', '/hello/hyperf', [HelloController::class, 'hyperf']],
];