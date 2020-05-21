<?php

$newLine = 0;
for ($i = ord('a'); $i <=ord('z') ; ++$i ){
    $newLine = $newLine - ord('a') + 1;
//    echo chr($i) .(($i - 1) % 5 ===0 ? PHP_EOL :"");
    $newLine++;
};

echo PHP_EOL;

echo PHP_EOL;
for ($i = ord('a'); $i <=ord('z') ; ++$i ){
//    echo chr($i) .(($i - 1) % 5 ===0 ? PHP_EOL :"");
};
echo PHP_EOL;

for ($i = ord('z'); $i >=ord('a') ; $i-- ){
//    echo chr($i)  .PHP_EOL;
};
echo PHP_EOL;

for ($i = ord('z'); ; $i-- ){
    echo chr($i)  .PHP_EOL;
    if (chr($i) === 'a') {
        break;
    }
};
echo PHP_EOL;
