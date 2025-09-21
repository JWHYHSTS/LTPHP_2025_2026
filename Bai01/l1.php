<?php
// index.php

// Hàm kiểm tra số nguyên tố
function isPrime($num) {
    if ($num < 2) return false;
    if ($num == 2) return true;
    if ($num % 2 == 0) return false;
    $sqrtNum = sqrt($num);
    for ($i = 3; $i <= $sqrtNum; $i += 2) {
        if ($num % $i == 0) return false;
    }
    return true;
}

// Xử lý tab được chọn (mặc định là bài 1)
$tab = isset($_GET['tab']) ? $_GET['tab'] : '1';

// Biến lưu kết quả hiển thị
$result1 = '';
$result2 = '';
$result3 = '';

// Xử lý bài 1: Giải phương trình bậc 2
if ($tab === '1' && isset($_POST['solve_quadratic'])) {
    $a = isset($_POST['a']) ? floatval($_POST['a']) : 0;
    $b = isset($_POST['b']) ? floatval($_POST['b']) : 0;
    $c = isset($_POST['c']) ? floatval($_POST['c']) : 0;

    if ($a == 0) {
        if ($b == 0) {
            if ($c == 0) {
                $result1 = "<p>Phương trình có vô số nghiệm.</p>";
            } else {
                $result1 = "<p>Phương trình vô nghiệm.</p>";
            }
        } else {
            $x = -$c / $b;
            $result1 = "<p>Phương trình bậc nhất có nghiệm: x = <strong>" . round($x, 4) . "</strong></p>";
        }
    } else {
        $delta = $b * $b - 4 * $a * $c;
        if ($delta < 0) {
            $result1 = "<p>Phương trình vô nghiệm.</p>";
        } elseif ($delta == 0) {
            $x = -$b / (2 * $a);
            $result1 = "<p>Phương trình có nghiệm kép: x = <strong>" . round($x, 4) . "</strong></p>";
        } else {
            $sqrtDelta = sqrt($delta);
            $x1 = (-$b + $sqrtDelta) / (2 * $a);
            $x2 = (-$b - $sqrtDelta) / (2 * $a);
            $result1 = "<p>Phương trình có 2 nghiệm phân biệt:</p>";
            $result1 .= "<ul>";
            $result1 .= "<li>x₁ = <strong>" . round($x1, 4) . "</strong></li>";
            $result1 .= "<li>x₂ = <strong>" . round($x2, 4) . "</strong></li>";
            $result1 .= "</ul>";
        }
    }
}

// Xử lý bài 2: Kiểm tra từng phần tử mảng có phải số nguyên tố không
if ($tab === '2' && isset($_POST['check_prime'])) {
    $n = isset($_POST['n2']) ? intval($_POST['n2']) : 0;
    $arrStr = isset($_POST['array2']) ? trim($_POST['array2']) : '';
    $result2 = '';

    // chia theo khoảng trắng (1 hoặc nhiều), loại bỏ phần tử rỗng
    $arr = array_filter(preg_split('/\s+/', trim($arrStr)), function($v){ return $v !== ''; });

    if ($n <= 0) {
        $result2 = "<p class='error'>Vui lòng nhập số phần tử n lớn hơn 0.</p>";
    } elseif (count($arr) != $n) {
        $result2 = "<p class='error'>Số phần tử nhập không khớp với n.</p>";
    } else {
        $result2 .= "<table>";
        $result2 .= "<thead><tr><th>Phần tử</th><th>Kiểm tra số nguyên tố</th></tr></thead><tbody>";
        foreach ($arr as $val) {
            if (is_numeric($val) && intval($val) == floatval($val)) {
                $num = intval($val);
                $prime = isPrime($num) ? "<span class='prime'>Là số nguyên tố</span>" : "<span class='not-prime'>Không phải số nguyên tố</span>";
            } else {
                $prime = "<span class='not-int'>Không phải số nguyên</span>";
            }
            $result2 .= "<tr><td>" . htmlspecialchars($val) . "</td><td>$prime</td></tr>";
        }
        $result2 .= "</tbody></table>";
    }
}

// Xử lý bài 3: Xử lý mảng - sắp xếp, tìm max, min
if ($tab === '3' && isset($_POST['process_array'])) {
    $n = isset($_POST['n3']) ? intval($_POST['n3']) : 0;
    $arrStr = isset($_POST['array3']) ? trim($_POST['array3']) : '';
    $result3 = '';

    // chia theo khoảng trắng (1 hoặc nhiều), loại bỏ phần tử rỗng
    $arr = array_filter(preg_split('/\s+/', trim($arrStr)), function($v){ return $v !== ''; });

    $arrNum = [];
    foreach ($arr as $v) {
        if (is_numeric($v)) {
            $arrNum[] = floatval($v);
        } else {
            $arrNum[] = null;
        }
    }

    if ($n <= 0) {
        $result3 = "<p class='error'>Vui lòng nhập số phần tử n lớn hơn 0.</p>";
    } elseif (count($arrNum) != $n) {
        $result3 = "<p class='error'>Số phần tử nhập không khớp với n.</p>";
    } elseif (in_array(null, $arrNum, true)) {
        $result3 = "<p class='error'>Mảng chứa phần tử không phải số hợp lệ.</p>";
    } else {
        $arrAsc = $arrNum;
        sort($arrAsc, SORT_NUMERIC);
        $arrDesc = $arrNum;
        rsort($arrDesc, SORT_NUMERIC);
        $max = max($arrNum);
        $min = min($arrNum);

        $result3 .= "<div class='array-output'>";
        $result3 .= "<p><strong>Mảng tăng dần:</strong> <span class='array'>" . implode(", ", $arrAsc) . "</span></p>";
        $result3 .= "<p><strong>Mảng giảm dần:</strong> <span class='array'>" . implode(", ", $arrDesc) . "</span></p>";
        $result3 .= "<p><strong>Số lớn nhất:</strong> <span class='highlight max'>$max</span></p>";
        $result3 .= "<p><strong>Số nhỏ nhất:</strong> <span class='highlight min'>$min</span></p>";
        $result3 .= "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>3 Bài Tập PHP - Giải phương trình, Kiểm tra số nguyên tố, Xử lý mảng</title>
    <style>
        /* Reset cơ bản */
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 15px 50px;
        }
        h1 {
            color: #fff;
            margin-bottom: 40px;
            font-weight: 700;
            text-shadow: 0 2px 6px rgba(0,0,0,0.3);
            font-size: 2.8rem;
            text-align: center;
            max-width: 700px;
        }
        /* Thanh tab */
        .tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            border-radius: 50px;
            background: rgba(255,255,255,0.15);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            overflow: hidden;
            max-width: 700px;
            width: 100%;
        }
        .tab {
            flex: 1;
            text-align: center;
            padding: 14px 0;
            cursor: pointer;
            font-weight: 600;
            font-size: 1.1rem;
            color: #e0e0e0;
            text-decoration: none;
            transition: all 0.3s ease;
            user-select: none;
            position: relative;
            letter-spacing: 0.03em;
        }
        .tab:hover:not(.active) {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .tab.active {
            background: #fff;
            color: #764ba2;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(118,75,162,0.4);
            z-index: 1;
        }
        /* Form */
        form {
            background: #fff;
            padding: 30px 35px 35px;
            border-radius: 15px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.15);
            max-width: 500px;
            width: 100%;
            transition: box-shadow 0.3s ease;
        }
        form:hover {
            box-shadow: 0 16px 40px rgba(0,0,0,0.25);
        }
        label {
            display: block;
            margin-top: 20px;
            font-weight: 600;
            color: #555;
            font-size: 1rem;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 12px 15px;
            margin-top: 8px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #764ba2;
            outline: none;
            box-shadow: 0 0 8px rgba(118,75,162,0.4);
        }
        button {
            margin-top: 30px;
            width: 100%;
            padding: 14px 0;
            background: #764ba2;
            border: none;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 6px 15px rgba(118,75,162,0.5);
            transition: background 0.3s ease, box-shadow 0.3s ease;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        button:hover {
            background: #5a357a;
            box-shadow: 0 8px 20px rgba(90,53,122,0.7);
        }
        /* Kết quả */
        .result {
            max-width: 500px;
            margin: 25px auto 50px;
            background: #fff;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.15);
            font-size: 1.1rem;
            color: #444;
            line-height: 1.6;
            user-select: text;
        }
        .result p {
            margin: 0 0 12px;
        }
        .result ul {
            margin: 10px 0 0 20px;
            padding: 0;
        }
        .result ul li {
            margin-bottom: 6px;
        }
        /* Bảng bài 2 */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            font-size: 1rem;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
        }
        thead tr {
            background: #764ba2;
            color: #fff;
            font-weight: 700;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        /* Màu sắc trạng thái số nguyên tố */
        .prime {
            color: #2e7d32;
            font-weight: 600;
        }
        .not-prime {
            color: #c62828;
            font-weight: 600;
        }
        .not-int {
            color: #f9a825;
            font-weight: 600;
        }
        /* Lỗi */
        .error {
            color: #d32f2f;
            font-weight: 700;
            font-size: 1.1rem;
            margin-top: 15px;
            text-align: center;
        }
        /* Bài 3 output */
        .array-output p {
            margin: 12px 0;
            font-weight: 600;
            color: #444;
        }
        .array-output .array {
            font-weight: 400;
            color: #555;
            background: #f0f0f0;
            padding: 4px 8px;
            border-radius: 6px;
            font-family: 'Courier New', Courier, monospace;
            user-select: all;
        }
        .highlight {
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 8px;
            color: #fff;
            user-select: all;
        }
        .highlight.max {
            background: #2e7d32;
            box-shadow: 0 0 8px #2e7d32aa;
        }
        .highlight.min {
            background: #c62828;
            box-shadow: 0 0 8px #c62828aa;
        }
        /* Responsive */
        @media (max-width: 600px) {
            h1 {
                font-size: 2rem;
                margin-bottom: 30px;
            }
            .tabs {
                flex-direction: column;
                border-radius: 12px;
            }
            .tab {
                padding: 12px 0;
                border-bottom: 1px solid rgba(255,255,255,0.3);
                margin-right: 0;
            }
            .tab:last-child {
                border-bottom: none;
            }
            form, .result {
                max-width: 100%;
                padding: 20px 20px 25px;
            }
            button {
                font-size: 1rem;
                padding: 12px 0;
            }
        }
    </style>
</head>
<body>
    <h1>Bài_01_PHP</h1>

    <!-- Thanh tab chuyển bài -->
    <div class="tabs" role="tablist" aria-label="Chọn bài tập">
        <a href="?tab=1" class="tab <?= $tab === '1' ? 'active' : '' ?>" role="tab" aria-selected="<?= $tab === '1' ? 'true' : 'false' ?>" tabindex="<?= $tab === '1' ? '0' : '-1' ?>">Bài 1: Phương trình bậc 2</a>
        <a href="?tab=2" class="tab <?= $tab === '2' ? 'active' : '' ?>" role="tab" aria-selected="<?= $tab === '2' ? 'true' : 'false' ?>" tabindex="<?= $tab === '2' ? '0' : '-1' ?>">Bài 2: Kiểm tra số nguyên tố</a>
        <a href="?tab=3" class="tab <?= $tab === '3' ? 'active' : '' ?>" role="tab" aria-selected="<?= $tab === '3' ? 'true' : 'false' ?>" tabindex="<?= $tab === '3' ? '0' : '-1' ?>">Bài 3: Xử lý mảng</a>
    </div>

    <!-- Nội dung bài 1 -->
    <?php if ($tab === '1'): ?>
    <form method="post" action="?tab=1" novalidate aria-labelledby="tab1-title">
        <label for="a">Hệ số a:</label>
        <input type="text" id="a" name="a" required value="<?= isset($_POST['a']) ? htmlspecialchars($_POST['a']) : '' ?>" placeholder="Nhập số thực" autocomplete="off">

        <label for="b">Hệ số b:</label>
        <input type="text" id="b" name="b" required value="<?= isset($_POST['b']) ? htmlspecialchars($_POST['b']) : '' ?>" placeholder="Nhập số thực" autocomplete="off">

        <label for="c">Hệ số c:</label>
        <input type="text" id="c" name="c" required value="<?= isset($_POST['c']) ? htmlspecialchars($_POST['c']) : '' ?>" placeholder="Nhập số thực" autocomplete="off">

        <button type="submit" name="solve_quadratic" aria-label="Giải phương trình bậc 2">Giải</button>
    </form>
    <?php if ($result1): ?>
    <div class="result" role="region" aria-live="polite" aria-atomic="true"><?= $result1 ?></div>
    <?php endif; ?>
    <?php endif; ?>

    <!-- Nội dung bài 2 -->
    <?php if ($tab === '2'): ?>
    <form method="post" action="?tab=2" novalidate aria-labelledby="tab2-title">
        <label for="n2">Số phần tử n:</label>
        <input type="number" id="n2" name="n2" min="1" required value="<?= isset($_POST['n2']) ? htmlspecialchars($_POST['n2']) : '' ?>" placeholder="Nhập số nguyên dương" autocomplete="off">

        <label for="array2">Mảng các phần tử (ngăn cách bởi khoảng trắng):</label>
        <input type="text" id="array2" name="array2" required value="<?= isset($_POST['array2']) ? htmlspecialchars($_POST['array2']) : '' ?>" placeholder="Ví dụ: 2 3 4 5" autocomplete="off">

        <button type="submit" name="check_prime" aria-label="Kiểm tra số nguyên tố từng phần tử">Kiểm tra</button>
    </form>
    <?php if ($result2): ?>
    <div class="result" role="region" aria-live="polite" aria-atomic="true"><?= $result2 ?></div>
    <?php endif; ?>
    <?php endif; ?>

    <!-- Nội dung bài 3 -->
    <?php if ($tab === '3'): ?>
    <form method="post" action="?tab=3" novalidate aria-labelledby="tab3-title">
        <label for="n3">Số phần tử n:</label>
        <input type="number" id="n3" name="n3" min="1" required value="<?= isset($_POST['n3']) ? htmlspecialchars($_POST['n3']) : '' ?>" placeholder="Nhập số nguyên dương" autocomplete="off">

        <label for="array3">Mảng các phần tử (ngăn cách bởi khoảng trắng):</label>
        <input type="text" id="array3" name="array3" required value="<?= isset($_POST['array3']) ? htmlspecialchars($_POST['array3']) : '' ?>" placeholder="Ví dụ: 10 5 7 3" autocomplete="off">

        <button type="submit" name="process_array" aria-label="Xử lý mảng">Xử lý</button>
    </form>
    <?php if ($result3): ?>
    <div class="result" role="region" aria-live="polite" aria-atomic="true"><?= $result3 ?></div>
    <?php endif; ?>
    <?php endif; ?>

</body>
</html>
