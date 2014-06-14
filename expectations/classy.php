<?php
$expected = [];

$expected['class.basic'] = <<<CODE
class Name
{
}
CODE;

$expected['class.extends'] = <<<CODE
class Name extends ParentClass
{
}
CODE;

$expected['class.interfaces'] = <<<CODE
class Name implements Interface1, Interface2, Interface3
{
}
CODE;

return $expected;
