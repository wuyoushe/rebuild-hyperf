<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/9/28
 * Time: 15:20
 */

namespace App;


class Bar
{

    public function bar()
    {
        $foo = new Foo();
        echo $foo->foo();
    }

}