<?php

use Mudrock\Helpers\Time;

require "vendor/autoload.php";

$t1 = new Time('2021-10-29 08:05:00');
$t2 = new Time();

echo 'Passando parâmetro (T1) &nbsp; = &nbsp; ' . $t1->now('d-m-Y H:i') . '<br><br><hr><br>';
echo 'Gerando data atual (T2) &nbsp; = &nbsp; ' . $t2->now() . '<br><br><hr><br>';
echo 'Com erro (T2) &nbsp; = &nbsp; ' . $t2->now('ahsdajsdj') . '<br><br><hr><br>';