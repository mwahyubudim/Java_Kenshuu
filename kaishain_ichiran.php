<?php
include('config.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>社員管理システム</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>社員管理システム</h1>
        <form action="logout.php" method="POST">
            <input type="submit" class="close-button" value="閉じる">
        </form>
    </header>

    <div class="main-container">
        <!-- Search Form -->
        <div class="search-container">
            <form class="search-form" method="POST">
                <div class="search-row">
                    <p>社員ID: <input type="text" name="search_id" maxlength="10"></p>
                    <p>所属: <input type="text" name="search_dept" maxlength="10"></p>
                    <p>入社年月日: <input type="text" name="search_date" maxlength="10" placeholder="YYYY/MM/DD"></p>
                </div>
                <input type="submit" name="search" value="検索">
            </form>
        </div>

        <!-- Action Buttons -->
        <div class="action-container">
            <form action="add.php" method="POST">
                <button type="submit" class="add-button">追加</button>
            </form>

            <form method="POST">
                <button type="submit" name="delete" class="delete-button">削除</button>
            </form>
        </div>
    </div>

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

    <!-- Display Records -->
    <form method="POST">
        <div class="table-container">
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
        </div>
    </form>
</body>
</html>
