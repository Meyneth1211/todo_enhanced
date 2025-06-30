<?php if($_SERVER['REQUEST_METHOD'] === 'GET'): // 55行目まで? ?>
<?php
session_start();
if (empty($_GET['taskid']) || !ctype_digit((string)$_GET['taskid']) || empty($_SESSION['userid'])) {
    header('Location: todolist.php');
    exit();
}
$taskid = htmlspecialchars($_GET['taskid']);
require_once 'DB.php';
$pdo = getDB();
$sql = 'SELECT * FROM todos WHERE id = ? AND user_id = ?';
$stmt = $pdo->prepare($sql);
$stmt->execute([$taskid, $_SESSION['userid']]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$task) {
    header('Location: todolist.php');
    exit();
}else {
    $content = htmlspecialchars($task['task']);
    $due_date = htmlspecialchars($task['due_date']);
    $priority = htmlspecialchars($task['priority']);
    $status = htmlspecialchars($task['status']);
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="task_edit.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク編集</title>
</head>

<body>
    <form action="" method="post" class="waku">
    <input type="hidden" name="taskid" value="<?= htmlspecialchars($_GET['taskid']) ?>">
        <h1>タスク編集</h1>
        <div class="taskall">
            内容<br>
            <textarea name="task" class="naiyo"><?= $content ?></textarea><br>

            期限<br>

            <input type="date" name="due_date" class=kigen value="<?= $due_date ?>"><br>


            優先度<br>
            <select name="priority" class="yusen">
                <?php
                if ($priority == 1) {
                    echo '<option value="1" selected>低</option>';
                }else {
                    echo '<option value="1">低</option>';
                }
                if ($priority == 2) {
                    echo '<option value="2" selected>中</option>';
                }else {
                    echo '<option value="2">中</option>';
                }
                if ($priority == 3) {
                    echo '<option value="3" selected>高</option>';
                }else {
                    echo '<option value="3">高</option>';
                }
                ?>
            </select><br>

            状態<br>
            <select name="status" class="jotai">
                <?php
                if ($status == 'todo') {
                    echo '<option value="todo" selected>未完了</option>';
                } else {
                    echo '<option value="todo">未完了</option>';
                }
                if ($status == 'done') {
                    echo '<option value="done" selected>完了</option>';
                } else {
                    echo '<option value="done">完了</option>';
                }
                ?>
            </select><br>

        </div>

        <div class="link">
            <button type="submit">保存</button><a href="todolist.php">キャンセル</a>
        </div>

    </form>

</body>
</html>
<?php endif; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (empty($_POST['task']) || empty($_POST['due_date']) || empty($_POST['priority']) || empty($_POST['status']) || empty($_SESSION['userid'])) {
        header('Location: todolist.php');
        exit();
    }
    $sql = 'UPDATE todos SET task = ?, status = ?, due_date = ?, priority = ? WHERE id = ? AND user_id = ?';
    require_once 'DB.php';
    $pdo = getDB();
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        htmlspecialchars($_POST['task']),
        htmlspecialchars($_POST['status']),
        htmlspecialchars($_POST['due_date']),
        htmlspecialchars($_POST['priority']),
        htmlspecialchars($_POST['taskid']),
        $_SESSION['userid']
    ]);
    if ($result) {
        header('Location: todolist.php');
        exit();
    } else {
        echo '<h2>タスクの更新に失敗しました。</h2>';
        echo '<a href="todolist.php">ToDoリストに戻る</a>';
    }
}
?>