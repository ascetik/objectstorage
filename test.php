<?php

use Ascetik\ObjectStorage\Container\Box;
use Ascetik\ObjectStorage\Enums\BoxSortOrder;

require 'vendor/autoload.php';

// echo ('a' <=> 'b') . PHP_EOL;
// echo strcmp('a', 'b') . PHP_EOL;

class Number
{
    public function __construct(public readonly int $value)
    {
    }
}

$range = [40, 23, 10, 57, 27, 12, 34, 49, 20,57, 51, 69, 44];
$box = new Box();
foreach ($range as $key => $number) {
    echo $number . ' ';
    $box->push(new Number($number), $key);
}
echo PHP_EOL;

$box->sort(function (Number $a, Number $b) {
    return $a->value - $b->value;
});

echo 'résultat ASC : ' . PHP_EOL;

foreach ($box as $content) {
    echo $content->value;
    echo  ' ';
    // echo $box->content()->offsetGet($content).PHP_EOL;
}
echo PHP_EOL;

$box->clear();
foreach ($range as $key => $number) {
    // echo $number.' ';
    $box->push(new Number($number), $key);
}

$box->sort(
    fn (Number $a, Number $b) => $a->value - $b->value,
    BoxSortOrder::DESC
);

echo 'résultat DESC : ' . PHP_EOL;

foreach ($box as $content) {
    echo $content->value;
    echo  ' ';
    // echo $box->content()->offsetGet($content).PHP_EOL;
}
echo PHP_EOL;
