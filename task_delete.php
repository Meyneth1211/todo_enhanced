<?php
session_start();
if (!empty($_SESSION['userid']) && !empty($_GET['taskid'])) {
    require_once 'DB.php';
    $pdo = getDB();
    $taskid = htmlspecialchars($_GET['taskid']);
    $sql = 'DELETE FROM todos WHERE id = ? AND user_id = ?';
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$taskid, $_SESSION['userid']]);
    if ($result) {
        header('Location: todolist.php');
        exit();
    } else {
        echo '<h2>タスクの削除に失敗しました。</h2>';
        echo '<a href="todolist.php">タスクリストに戻る</a>';
    }
} else {
    header('Location: login.php');
    session_unset();
    session_destroy();
    exit();
}
?>