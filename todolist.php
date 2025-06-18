<?php require_once 'session.php'; ?>
<?php if($_SERVER['REQUEST_METHOD'] === 'GET'): ?> <!-- 121行目まで -->
<h1>ToDoリスト</h1>
<div class="user_info">
    <?php
    displayname();
    ?>
</div>

<div class="add_task">
    <!-- 自身へ送信 -->
    <form action="" method="post">
    <fieldset>
        <legend>タスク追加</legend>
        <input type="text" name="task" placeholder="タスク内容" required>
        <input type="date" name="due_date" placeholder="年月日" required>
        <select name="priority">
            <option value="1">優先度(低)</option>
            <option value="2">中</option>
            <option value="3">高</option>
        </select>
        <input type="submit" value="追加">
    </fieldset>
    </form>
</div>

<div class="search_task">
    <form action="" method="get">
        <fieldset>
            <legend>フィルタ/検索</legend>
            <input type="text" name="taskname" placeholder="キーワード">
            <select name="status">
                <option value="0">すべて</option>
                <option value="1">未完了</option>
                <option value="2">完了</option>
            </select>
            <select name="priority">
                <option value="0">優先度(全て)</option>
                <option value="1">低</option>
                <option value="2">中</option>
                <option value="3">高</option>
            <input type="submit" value="適用">
        </fieldset>
    </form>
</div>
<!-- 先にTodoリストのデータ取得 -->
<?php
require_once 'DB.php';
$pdo = getDB();
// ベースのSELECT文 検索しない場合はそのまま使う
$sql = 'SELECT * FROM todos WHERE user_id = ?';
// $suffix = ''; // 検索条件がある場合のサフィックス
// $first = true; // 最初の条件かどうか

if (!empty($_GET['taskname'])) {
    $taskname = htmlspecialchars($_GET['taskname']);
    $sql .= " AND task LIKE '%" . $taskname . "%'";
}

if (!empty($_GET['status'])) {
    $status = htmlspecialchars($_GET['status']);
    $sql .= ' AND status = ' . $status;
}

if (!empty($_GET['priority'])) {
    $priority = htmlspecialchars($_GET['priority']);
    $sql .= ' AND priority = ' . $priority;
}

$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['userid']]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$pdo = null;

?>

<div class="task_list">
    <table>
        <thead>
            <tr>
                <th>状態</th>
                <th>タスク</th>
                <th>期限</th>
                <th>優先度</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($result as $row) {
                    echo '<tr>';
                    if ($row['status'] === 'todo') {
                        echo '<td>進行中</td>';
                    }elseif ($row['status'] === 'done') {
                        echo '<td>完了</td>';
                    }
                    echo '<td>' . htmlspecialchars($row['task']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['due_date']) . '</td>';
                    if ($row['priority'] === 1) {
                        echo '<td>低</td>';
                    }elseif ($row['priority'] === 2) {
                        echo '<td>中</td>';
                    }elseif ($row['priority'] === 3) {
                        echo '<td>高</td>';
                    }
                    echo '<td>';
                    echo '<a href="task_edit.php?taskid=' . htmlspecialchars($row['id']) . '">編集</a>';
                    echo '<a href="task_delete.php?taskid=' . htmlspecialchars($row['id']) . '">削除</a>';
                    /* echo '<form action="" method="get">';
                    echo    '<input type="submit" value="編集">';
                    echo '</form>';
                    echo '<form action="" method="post" onsubmit="return confirm(\'本当に削除しますか？\');">';
                    echo    '<input type="hidden" name="taskid" value="' . htmlspecialchars($row['id']) . '">';
                    echo '<input type="submit" value="削除">'; */
                    echo '</td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // タスク追加処理
    if (!empty($_POST['task']) && !empty($_POST['due_date']) && !empty($_POST['priority'])) {
        $task = htmlspecialchars($_POST['task']);
        $due_date = htmlspecialchars($_POST['due_date']);
        $priority = htmlspecialchars($_POST['priority']);
        require_once 'DB.php';
        $pdo = getDB();
        $sql = 'INSERT INTO todos (user_id, task, status, due_date, priority) VALUES (?, ?, ?, ?, ?)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['userid'], $task, 'todo', $due_date, $priority]);
        $pdo = null;

        header('Location: todolist.php');
        exit();
    } else {
        echo '<h2>タスク内容、期限、優先度を入力してください。</h2>';
        echo '<a href="todolist.php">リストへ戻る</a>';
    }
}
?>