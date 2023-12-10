<?php

use Ascetik\ObjectStorage\Container\Box;
use Ascetik\ObjectStorage\Enums\BoxSortOrder;

require 'vendor/autoload.php';

// echo ('a' <=> 'b') . PHP_EOL;
// echo strcmp('a', 'b') . PHP_EOL;

// class Number
// {
//     public function __construct(public readonly int $value)
//     {
//     }
// }

// $range = [40, 23, 10, 57, 27, 12, 34, 49, 20,57, 51, 69, 44];
// $box = new Box();
// foreach ($range as $key => $number) {
//     echo $number . ' ';
//     $box->push(new Number($number), $key);
// }
// echo PHP_EOL;

// $box->sort(function (Number $a, Number $b) {
//     return $a->value - $b->value;
// });

// echo 'résultat ASC : ' . PHP_EOL;

// foreach ($box as $content) {
//     echo $content->value;
//     echo  ' ';
//     // echo $box->content()->offsetGet($content).PHP_EOL;
// }
// echo PHP_EOL;

// $box->clear();
// foreach ($range as $key => $number) {
//     // echo $number.' ';
//     $box->push(new Number($number), $key);
// }

// $box->sort(
//     fn (Number $a, Number $b) => $a->value - $b->value,
//     BoxSortOrder::DESC
// );

// echo 'résultat DESC : ' . PHP_EOL;

// foreach ($box as $content) {
//     echo $content->value;
//     echo  ' ';
//     // echo $box->content()->offsetGet($content).PHP_EOL;
// }
echo PHP_EOL;
echo 'essai avec des strings' . PHP_EOL;

// echo strcmp('a', 'b') . PHP_EOL;
// echo strcmp('abc', 'acd') . PHP_EOL;

$names = [
    'Richard', 'Willfried', 'Henri', 'Simon', 'Igor', 'Bernardine',
    'Gontran', 'Thomas', 'Ernest', 'Zoé', 'Christophe',
    'Daphné', 'Jennifer', 'Antoinette', 'Gérard', 'Bernard'
];

class User
{
    public function __construct(public readonly string $name)
    {
    }
}

$box = new Box();
foreach ($names as $name) {
    echo $name . ' ';
    $user = new User($name);
    $box->push($user);
}
echo PHP_EOL;

$sorting = function (User $a, User $b) {
    return strcmp($a->name, $b->name);
};
$box->sort($sorting);

foreach ($box as $user) {
    echo $user->name . ' ';
}
echo PHP_EOL;

$box->sortReverse($sorting);

foreach ($box as $user) {
    echo $user->name . ' ';
}
echo PHP_EOL;
