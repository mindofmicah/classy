classy
======

As strange as it may sound Classy abstracts writing php functions into a chainable object-oriented syntax.

Why would you ever want this?
-------------------
This approach allows me to create files quickly when deploying other projects. Instead of manipulating template files, we can generate well-formed php classes in a readable format.

Example
----------------
$funky = new Funky('myFunction');
$funky->comments()->isStatic()->isProtected()->line('$ret = \'hello world\'')->returns('$ret')->render();

Yields:
/**
 * Description for myFunction
 *
 * @return
 */
protected static function myFunction()
{
  $ret = 'hello world';
  return $ret;
}
