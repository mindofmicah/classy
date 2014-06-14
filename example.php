<?php
require 'vendor/autoload.php';

$class=  new \MindOfMicah\Classy\Classy('myclass');
$class->willExtend('Taco');
$class->willImplement('myInterface');

$function = new MindOfMicah\Classy\Funky('methodname');
$function->isPrivate()->isStatic();
$function->hasComments();
$function->param('\My\Model $model');
$function->param('$b');
$function->line('$this->b = "$b"');
$function->ischainable();

$class->addFunction($function);

echo $class->render();
