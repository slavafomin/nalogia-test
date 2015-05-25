<?php

require 'Utils/StringComparator.php';

use Utils\StringComparator;

$comparator = new StringComparator;

$errorsCount = 0;

// Testing for equality.
$errorsCount += ($comparator->compare('кот', 'кот') == 'РАВЕНСТВО' ? 0 : 1);

// Testing for removal.
$errorsCount += ($comparator->compare('кот', 'скот') == 'ВСТАВИТЬ с' ? 0 : 1);
$errorsCount += ($comparator->compare('кот', 'коты') == 'ВСТАВИТЬ ы' ? 0 : 1);

// Testing for addition.
$errorsCount += ($comparator->compare('коты', 'кот') == 'УДАЛИТЬ ы' ? 0 : 1);
$errorsCount += ($comparator->compare('скот', 'кот') == 'УДАЛИТЬ с' ? 0 : 1);

// Testing for permutations.
$errorsCount += ($comparator->compare('зол', 'зло') == 'ПОМЕНЯТЬ о л' ? 0 : 1);

if (0 === $errorsCount) {
    print 'No errors!' . PHP_EOL;
} else {
    printf('There are %d errors!' . PHP_EOL, $errorsCount);
}

return $errorsCount;
