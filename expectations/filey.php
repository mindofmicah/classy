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

return $expected;
