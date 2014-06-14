<?php
$expected = [];
$expected['empty_with_comments'] = <<<CODE
/**
 * Description for name
 *
 * @return
 */
public function name()
{
}
CODE;

$expected['default'] = <<<CODE
public function name()
{
}
CODE;

$expected['has_lines'] = <<<CODE
public function name()
{
    \$a = "apples";
    \$a.= " and nanners";
}
CODE;

$expected['static'] = <<<CODE
public static function name()
{
}
CODE;

$expected['private'] = <<<CODE
private function name()
{
}
CODE;

$expected['protected'] = <<<CODE
protected function name()
{
}
CODE;

$expected['return_statement'] = <<<CODE
public function name()
{
    \$a = 'apples';
    return \$a;
}
CODE;

$expected['chainable'] = <<<CODE
public function name()
{
    return \$this;
}
CODE;

$expected['params.basic'] = <<<CODE
public function name(\$a, \$b)
{
}
CODE;

$expected['params.commented'] = <<<CODE
/**
 * Description for name
 *
 * @param \Models\Model \$a
 * @param string \$b
 *
 * @return
 */
public function name(\Models\Model \$a, \$b)
{
}
CODE;

$expected['indented'] = <<<CODE
    /**
     * Description for name
     *
     * @return
     */
    public function name()
    {
    }
CODE;

return $expected;

