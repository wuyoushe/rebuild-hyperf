<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/9/29
 * Time: 13:10
 */
use Rebuild\Command\StartCommand;

return [
    //使用ClassName::class可以获取一个字符串，包含了类ClassName的完全限定名称，这对使用了命名空间的类尤其有用
    StartCommand::class,
];

//namespace ddd\vector
// class Demo{
//public function test(){
//      code...
//  }
//}
//echo Demo::class  //打印//ddd\vector\Demo
