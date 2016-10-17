<?php

function p()
{
    foreach (func_get_args() as $arg) {
        $trace = debug_backtrace(2);
        if ($trace[2]['function'] != 'pd') {
            print_r($trace[0]['file'].' ('.$trace[0]['line'].')');
        }

        if (php_sapi_name() !== 'cli') {
            print_r('<pre>');
        }

        print_r($arg);

        if (php_sapi_name() !== 'cli') {
            print_r('</pre>');
        } else {
            print_r(PHP_EOL);
        }
    }
}

function pd()
{
    $trace = debug_backtrace(2);
    print_r($trace[0]['file'].' ('.$trace[0]['line'].')');

    array_map('p', func_get_args());
    exit;
}
