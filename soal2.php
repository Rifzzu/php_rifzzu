<?php
session_start();

$step = isset($_POST['step']) ? (int)$_POST['step'] : 1;
$next_step = $step + 1;

if ($step > 1) {
    if ($step == 2 && isset($_POST['nama'])) {
        $_SESSION['nama'] = htmlspecialchars($_POST['nama']);
    } elseif ($step == 3 && isset($_POST['umur'])) {
        $_SESSION['umur'] = htmlspecialchars($_POST['umur']);
    } elseif ($step == 4 && isset($_POST['hobi'])) {
        $_SESSION['hobi'] = htmlspecialchars($_POST['hobi']);
    }
}

if ($step == 4) {
    $current_step = 'result';
} else {
    $current_step = $step;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        .form-container { 
            border: 1px solid black; 
            padding: 10px; 
            width: 300px; 
        }
        .result-container { 
            border: 1px solid black; 
            padding: 10px; 
            width: 300px; 
            font-size: 18px;
        }
        input[type="text"] { 
            padding: 5px; 
            margin-bottom: 15px; 
        }
        input[type="submit"] { 
            padding: 8px 15px; 
            margin-top: 10px; 
            cursor: pointer; 
        }
        
    </style>
</head>
<body>

<?php 
switch ($current_step) {
    case 1:
        echo "<div class='form-container'>";
        echo "<form method='POST' action='soal2.php'>";
        echo "<label for='nama'>Nama Anda :</label>";
        echo "<input type='text' id='nama' name='nama' required>";
        echo "<input type='hidden' name='step' value='$next_step'>";
        echo "<input type='submit' value='SUBMIT'>";
        echo "</form>";
        echo "</div>";
        break;

    case 2:
        echo "<div class='form-container'>";
        echo "<form method='POST' action='soal2.php'>";
        echo "<label for='umur'>Umur Anda :</label>";
        echo "<input type='text' id='umur' name='umur' required>";
        echo "<input type='hidden' name='step' value='$next_step'>";
        echo "<input type='submit' value='SUBMIT'>";
        echo "</form>";
        echo "</div>";
        break;

    case 3:
        echo "<div class='form-container'>";
        echo "<form method='POST' action='soal2.php'>";
        echo "<label for='hobi'>Hobi Anda :</label>";
        echo "<input type='text' id='hobi' name='hobi' required>";
        echo "<input type='hidden' name='step' value='$next_step'>";
        echo "<input type='submit' value='SUBMIT'>";
        echo "</form>";
        echo "</div>";
        break;
        
    case 'result':
        echo "<div class='result-container'>";
        echo "Nama: " . ($_SESSION['nama'] ?? 'Tidak ada data') . "<br>";
        echo "Umur: " . ($_SESSION['umur'] ?? 'Tidak ada data') . "<br>";
        echo "Hobi: " . ($_SESSION['hobi'] ?? 'Tidak ada data') . "<br>";

        echo "</div>";
        break;
}
?>

</body>
</html>