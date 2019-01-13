<?php
//var_dump($_FILES);
if (!isset($_FILES['baseupload'])) {
    header("location: " . '/web-development/services/mailing');
}
$baseupload = $_FILES['baseupload']['tmp_name'];
$f = fopen($baseupload, "rt") or header("location: " . '/web-development/services/mailing');
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>E-mail рассылка</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">-->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">-->
    <link rel="stylesheet" type="text/css" media="all"
          href="/assets/extra/fontawesome-free-5.4.1-web/css/all.css"/>
    <link rel="stylesheet" type="text/css" href="mailing.css">
</head>
<body class="mailing">

<?php
$base = [];
for ($i = 0; $data = fgetcsv($f, 1000, ";"); $i++) {
    $num = count($data);
    $base[$i][0] = -1; // Not checked
    $base[$i][1] = $i + 1;
    for ($c = 0; $c < $num; $c++) {
        // Конвертация с кодировки cp1251 в utf-8
        $base[$i][2 + $c] = trim(mb_convert_encoding($data[$c], 'utf-8', 'cp1251'));
    }
}
fclose($f);

// Очистка от пустых строк и столбцов
for ($i = 0; $i < 2; $i++) {
    $g = array();
    foreach ($base as $key => $row) {
        if (count(array_filter($row, function ($c) {
            return !empty($c);
        }))) {
            $g[$key] = $row;
        }
    }
    array_unshift($g, null);
    $base = call_user_func_array('array_map', $g);
}

// Вывод таблицы-формы
$emailColumn = -1;
$noticeColumn = -1;
$lineCount = count($base);
$num = count($base[0]);
$testColumn = $num - 1;
$regexp = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';
?>

<div class="container-fluid">
    <form class="form-inline upper-table">
        <div class="form-group">
            <label for="selectFrom">C</label>
            <input type="text" class="form-control" name="selectFrom" id="selectFrom" value="1">
            <label for="selectTo">по</label>
            <input type="text" class="form-control" name="selectTo" id="selectTo" value="<?php echo $lineCount ?>">
            <button type="button" class="btn-d btn-dm" id="selectFromTo">Выбрать</button>
        </div>
        <div>
            <a href="/web-development/services/mailing" class="btn-d btn-dm"><span class="fas fa-times"></span>&nbsp;Отменить&nbsp;и&nbsp;вернуться</a>
        </div>
    </form>
    <form name="emaillist" id="emaillist" action="#">
        <table class='table table-striped table-bordered table-hover'>
            <thead>
            <tr>

<?php
// Определение колонки с почтовыми адресами
foreach ($base as $row) {
    foreach ($row as $column => $foo) {
        if (preg_match($regexp, $foo)) {
            $emailColumn = $column;
        }
    }
}
// Определить, является ли последня колонка заметками
if ($lineCount > 10 && !($emailColumn === $testColumn)) {
    $fooCount = 0;
    for ($i=0; $i<$lineCount; $i++) {
        if ($base[$i][$testColumn]) {$fooCount++;}
    }
    if ($fooCount < round($lineCount/2)) {
        $noticeColumn = $testColumn;
    }
}

for ($i=0; $i<$num; $i++) {
    switch ($i) {
        case 0:
            echo '<th><input type="checkbox"></th>';
            break;
        case 1:
            echo '<th>#</th>';
            break;
        case $emailColumn:
            echo '<th>E-mail</th>';
            break;
        default:
            echo '<th></th>';
    }
}
echo '</tr>';
echo "</thead>";

echo "<tbody>";
foreach ($base as $row) {

    $row[$emailColumn] = preg_replace('/\s*@\s*/', '@', $row[$emailColumn]);
    $row[$emailColumn] = preg_replace('/\s+/', ' ', $row[$emailColumn]);
    $row[$emailColumn] = preg_replace('/\s*,\s*/', ',', trim($row[$emailColumn]));
    $row[$emailColumn] = str_replace(' ', ',', $row[$emailColumn]);
    $emailArray = explode(',',$row[$emailColumn]);
    $matches = [];
    $newValue = '';
    for ($i=0; $i<count($emailArray); $i++) {
        if (preg_match($regexp, $emailArray[$i], $matches) === 1) {
            $row[0] = 0;
            $newValue = $newValue.$matches[0].", ";
        }
    }
    $newValue = substr($newValue,0,-2);

    if ($row[0] === -1 and $row[$emailColumn] !== '' ) {
        echo '<tr class="danger">';
    } else {
        if ($row[0] === -1 and $row[$emailColumn] === '' ) {
            echo '<tr class="greyRow">';
        } else {
            echo '<tr>';
        }
    }

    for ($j=0; $j<$num; $j++) {
        switch ($j) {
            case 0:
                echo '<td><input type="checkbox" name="checkbox[]" value="' . $newValue . '"' . (($row[0] === -1) ? ' disabled="disabled"' : '') . '></td>';
                break;
            case 1:
                echo "<td class='numberColumn'>".$row[$j]."</td>";
                break;
            case $emailColumn:
                echo "<td>";
                $matches = [];
                foreach ($emailArray as $email) {
                    $email = trim($email);
                    preg_match($regexp, $email, $matches);
                    if (!$matches == false) {
                        echo $matches[0]."<br>";
                    } else {
                        if ($email) {
                            echo "<span class='problemEmail redSpan' contenteditable='true'>".$email."</span><br>";
                        }
                    }
                }
                echo "</td>";
                break;
            case $noticeColumn:
                echo "<td><i><small>".$row[$j]."</small></i></td>";
                break;
            default:
                echo "<td>".$row[$j]."</td>";
        }
    }
    echo "</tr>";
}
echo "</tbody>";
?>

        </table>
        <div class="form-group submitListDiv">
            <div>
                <p>Всего выбрано: <span id="reallySelect">0</span></p>
            </div>
            <div>
                <button type="submit" class="btn-d btn-dm" id="submitList">
                    <span class="fas fa-check"></span>&nbsp;Принять&nbsp;список&nbsp;получателей
                </button>
            </div>
        </div>
    </form>
</div>

<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="emaillist.js"></script>
</body>
</html>