<?php include('config.php'); ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title>社員情報追加</title>
</head>
<body>
    <h1>社員情報追加</h1>
    <form method="POST">
        社員ID: <input type="text" name="社員ID" maxlength="10" required><br>
        入社年月日: <input type="text" name="入社年月日" maxlength="10" placeholder="YYYY/MM/DD" required><br>
        氏名: <input type="text" name="氏名" maxlength="20" required><br>
        性別: <input type="text" name="性別" maxlength="3" required><br>
        年齢: <input type="number" name="年齢" max="999" required><br>
        所属: <input type="text" name="所属" maxlength="10" required><br>
        メールアドレス: <input type="email" name="メールアドレス" maxlength="50" required><br>
        <input type="submit" name="add" value="追加">
    </form>

    <?php
    if (isset($_POST['add'])) {
        $社員ID = $_POST['社員ID'];
        $入社年月日 = str_replace('/', '', $_POST['入社年月日']);
        $氏名 = $_POST['氏名'];
        $性別 = $_POST['性別'];
        $年齢 = $_POST['年齢'];
        $所属 = $_POST['所属'];
        $メールアドレス = $_POST['メールアドレス'];

        $sql_insert = "INSERT INTO Kaishain (社員ID, 入社年月日, 氏名, 性別, 年齢, 所属, メールアドレス) 
                       VALUES ('$社員ID', '$入社年月日', '$氏名', '$性別', $年齢, '$所属', '$メールアドレス')";
        if ($conn->query($sql_insert) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    }
    ?>

    <form action="index.php" method="POST">
        <input type="submit" value="戻る">
    </form>

    <?php $conn->close(); ?>
</body>
</html>
