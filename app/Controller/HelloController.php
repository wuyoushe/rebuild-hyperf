<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/12/21
 * Time: 11:32
 */

namespace App\Controller;


class HelloController
{
    /**
     * @path /hello/index
     * @return string
     */
    public function index()
    {
        return 'Hello index';
    }

    /**
     * @path /hello/hyperf
     * @return string
     */
    public function hyperf()
    {
        return 'Hello hyperf';
    }

}