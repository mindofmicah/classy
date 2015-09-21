<?php
$expected = [];

$expected['default.public'] = <<<CODE
public \$name = 'santa';
CODE;

$expected['default.private'] = <<<CODE
private \$name = 'santa';
CODE;

$expected['default.protected'] = <<<CODE
protected \$name = 'santa';
CODE;

$expected['static'] = <<<CODE
public static \$name = 'santa';
CODE;

$expected['nullable'] = <<<CODE
public \$name;
CODE;

$expected['boolean.true'] = <<<CODE
public \$name = true;
CODE;

$expected['boolean.false'] = <<<CODE
public \$name = false;
CODE;

$expected['arrays.indexed'] = <<<CODE
public \$names = [
    'santa',
    'rudolph'
];
CODE;

$expected['arrays.assoc'] = <<<CODE
public \$names = [
    'first' => 'santa',
    'second' => 'rudolph'
];
CODE;

$expected['property.indented'] = <<<CODE
    public \$name = 'santa';
CODE;

return $expected;
