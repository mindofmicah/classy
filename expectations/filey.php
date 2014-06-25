<?php
$expected = [];

$expected['file.empty'] = <<<CODE
<?php
CODE;

$expected['file.hasnamespace'] = <<<CODE
<?php
namespace Apple;
CODE;

$expected['file.hascontents'] = <<<CODE
<?php
apples
CODE;

$expected['file.hasuses'] = <<<CODE
<?php
use MindOfMicah\Tacos;
use MindOfMicah\Nachos;
CODE;

$expected['file.with.render'] = <<<CODE
<?php
stuff
CODE;

$expected['file.has.manyuses'] = <<<CODE
<?php
use Apples;
use MindOfMicah\Nachos;
use MindOfMicah\Tacos;
CODE;

return $expected;
