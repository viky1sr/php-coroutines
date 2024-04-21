<?php
require_once "vendor/autoload.php";

use Visry\Coroutine;
use Visry\WaitGroup;

$start_time = microtime(true);
$co = new Coroutine();
$co->coroutine(function () use($co){
    $maxWg = 3;
    $wg = new WaitGroup();
    $wg->add($maxWg);

    for($i = 1; $i <= $maxWg; $i++){
        php($co,function () use($wg,$i){
            sleep(2);
            defer(function() use ($wg) { $wg->done(); });
            return "Testing routine $i \n";
        });
    }
    $wg->wait();
});

var_dump($co->fetchAll());
$end_time = microtime(true);
$total_time = number_format($end_time - $start_time,2);
echo "Total time: $total_time seconds\n";
