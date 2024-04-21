<?php

use Visry\Coroutine;

if(!function_exists("php")){
    /**
     * @param Coroutine $co
     * @param callable $callback
     * @return void
     */
    function php(Coroutine $co, callable $callback): void
    {
        if (pcntl_fork()) { return; }
        pcntl_signal(SIGCHLD, SIG_IGN);
        $args = func_get_args();
        array_shift($args);
        $result = call_user_func_array($callback, $args);
        $co->write($result);
        die;
    }
}

if(!function_exists("defer")){
    /**
     * @param callable $callback
     * @return void
     */
    function defer(callable $callback): void
    {
        register_shutdown_function($callback);
    }
}
