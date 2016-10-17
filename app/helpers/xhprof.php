<?php

class xhprof
{
    public static function start()
    {
        xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
    }

    public static function end($exit = false)
    {
        $xhprof_data = xhprof_disable();

        include_once 'xhprof_lib/utils/xhprof_lib.php';
        include_once 'xhprof_lib/utils/xhprof_runs.php';

        $xhprof_runs = new XHProfRuns_Default();

        $run_id = $xhprof_runs->save_run($xhprof_data, 'test');

        $link = "http://xhprof.loc/index.php?run={$run_id}&source=test";
        print_r("<a target='_blank' href='{$link}'>{$link}</a>");
        print_r("\n");

        if ($exit) {
            exit;
        }
    }
}
