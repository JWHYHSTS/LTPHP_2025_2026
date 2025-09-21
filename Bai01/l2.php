<?php
// Câu 1: Giải phương trình bậc 2: ax2 + bx + c = 0. Với a,b,c 
$a = 1;
$b = 6;
$c = 9;
$delta = $b * $b - 4 * $a * $c;
echo "PT {$a}x^2 + {$b}x + {$c} = 0"."<br>";
if($a == 0) {
    if($b == 0) {
        if($c == 0) {
            echo "PTVSN";
        } else {
            echo "PTVN";
        }
    } else {
        $x = -$c / $b;
        echo "PT có nghiệm: x = $x";
    }
} else {
    if($delta < 0) {
        echo "PTVN";
    } elseif($delta == 0) {
        $x = -$b / (2 * $a);
        echo "PT có nghiệm kép: x1 = x2 = $x";
    } else {
        $x1 = (-$b + sqrt($delta)) / (2 * $a);
        $x2 = (-$b - sqrt($delta)) / (2 * $a);
        echo "PT có hai nghiệm phân biệt: x1 = $x1, x2 = $x2";
    }
}
echo "<br>"."-------------------------------"."<br>";

// Câu 2: Cho mảng bất kỳ. Viết chương trình kiểm tra từng phần tử có phải là số nguyên tố
function isPrime($num){
    if($num < 2) return false;
    for($i = 2; $i <= sqrt($num); $i++){
        if($num % $i == 0) return false;
    }
    return true;
}
$a = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
foreach($a as $num){
    if(isPrime($num)){
        echo "$num là SNT"."<br>";
    } else {
        echo "$num không phải là SNT"."<br>";
    }
}
echo "<br>"."-------------------------------"."<br>";

// Câu 3: Cho mảng. In ra mảng từ bé đến lớn, từ lớn đến bé, số lớn nhất, số nhỏ nhất
$b = [5, 3, 8, 1, 2, 7, 4, 6];
// Từ bé --> lớn
sort($b);
echo implode(", ", $b)."<br>";

// Từ lớn --> bé
rsort($b);
echo implode(", ", $b)."<br>";

// Số lớn nhất
echo "Max: " . max($b)."<br>";

// Số nhỏ nhất
echo "Min: " . min($b)."<br>";
?>