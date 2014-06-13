classy
======

As strange as it may sound Classy abstracts writing php functions into a chainable object-oriented syntax.

Why would you ever want this?
-------------------
This approach allows me to create files quickly when deploying other projects. Instead of manipulating template files, we can generate well-formed php classes in a readable format.

Example
----------------
    $funky = new Funky('myFunction');
    $funky->hasComments()
        ->isStatic()
        ->param('Models\Model $m')
        ->isProtected()
        ->line('$ret = \'hello world\'')
        ->returns('$ret')
        ->render();


    /**
     * Description for myFunction
     *
     * @param Models\Model $m
     *
     * @return
     */
    protected static function myFunction(Models\Model $m)
    {
        $ret = 'hello world';
        return $ret;
    }
