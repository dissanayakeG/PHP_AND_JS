<?php
// Set a breakpoint on line 3 by clicking in the gutter
$numbers = [1, 2, 3, 4, 5];
$sum = 0; // <- Breakpoint here

foreach ($numbers as $number) {
    $sum += $number; // <- Another breakpoint here
    echo "Current sum: $sum\n";
}

echo "Final sum: $sum\n";
?>