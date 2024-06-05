<?php include('config.php'); ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>社員管理システム</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .scrollable-table {
            height: 400px;
            overflow-y: scroll;
            display: block;
        }
    </style>
</head>
<body>
    <h1>社員管理システム</h1>

    <!-- Search Form -->
    <form method="POST">
        社員ID: <input type="text" name="search_id" maxlength="10"><br>
        所属: <input type="text" name="search_dept" maxlength="10"><br>
        入社年月日: <input type="text" name="search_date" maxlength="10" placeholder="YYYY/MM/DD"><br>
        <input type="submit" name="search" value="検索">
    </form>

    <?php
    // Search functionality
    $condition = [];
    if (isset($_POST['search'])) {
        if (!empty($_POST['search_id'])) {
            $condition[] = "社員ID LIKE '%" . $_POST['search_id'] . "%'";
        }
        if (!empty($_POST['search_dept'])) {
            $condition[] = "所属 LIKE '%" . $_POST['search_dept'] . "%'";
        }
        if (!empty($_POST['search_date'])) {
            $search_date = str_replace('/', '', $_POST['search_date']);
            $condition[] = "入社年月日 LIKE '%" . $search_date . "%'";
        }
    }

    // Delete functionality
    if (isset($_POST['delete'])) {
        if (!empty($_POST['delete_ids'])) {
            foreach ($_POST['delete_ids'] as $delete_id) {
                $sql_delete = "DELETE FROM Kaishain WHERE 社員ID = '$delete_id'";
                $conn->query($sql_delete);
            }
        }
    }

    // Fetch records
    $sql = "SELECT * FROM Kaishain";
    if (!empty($condition)) {
        $sql .= " WHERE " . implode(' AND ', $condition);
    }
    $result = $conn->query($sql);
    ?>

    <!-- Add New Record -->
    <form action="add.php" method="POST">
        <input type="submit" value="追加">
    </form>

    <!-- Delete Records -->
    <form method="POST">
        <table class="scrollable-table">
            <thead>
                <tr>
                    <th>選択</th>
                    <th>社員ID</th>
                    <th>入社年月日</th>
                    <th>氏名</th>
                    <th>性別</th>
                    <th>年齢</th>
                    <th>所属</th>
                    <th>メールアドレス</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><input type='checkbox' name='delete_ids[]' value='" . $row['社員ID'] . "'></td>";
                        echo "<td>" . $row['社員ID'] . "</td>";
                        echo "<td>" . date('Y/m/d', strtotime($row['入社年月日'])) . "</td>";
                        echo "<td>" . $row['氏名'] . "</td>";
                        echo "<td>" . $row['性別'] . "</td>";
                        echo "<td>" . $row['年齢'] . "</td>";
                        echo "<td>" . $row['所属'] . "</td>";
                        echo "<td>" . $row['メールアドレス'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <input type="submit" name="delete" value="削除">
    </form>

    <!-- Close Session -->
    <form action="logout.php" method="POST">
        <input type="submit" value="閉じる">
    </form>

    <?php $conn->close(); ?>
</body>
</html>
