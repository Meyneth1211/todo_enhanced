<?php if($_SERVER['REQUEST_METHOD'] === 'GET'): // until line 25 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録</title>
</head>
<link rel="stylesheet" href="register.css">
<body>
    <form action="" method="post">
    <h1>ユーザー登録</h1>

    <label for="username">ユーザー名:</label>
    <input type="text" id="username" name="username" placeholder="例: yamada123"><br>

    <label for="password">パスワード:</label>
    <input type="password" id="password" name="password" placeholder="8文字以上の英数字">

        <button type="submit">登録</button>
    <p><a href="login.php" style="color: purple;">ログインはこちら</a></p>
    </form>
</body>
</html>
<?php endif; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        require_once 'DB.php';
        $pdo = getDB();
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $sql = 'SELECT username FROM users WHERE username = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($result)) {
            $sql = 'INSERT INTO users (username, password) VALUES (?, ?)';
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$username, $password]);
            if ($result) {
                session_start();
                session_unset();
                session_destroy();
                $sql='SELECT id, username FROM users WHERE username = ? AND password = ?';
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$_POST['username'], $_POST['password']]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!empty($result)) {
                    session_start();
                    $_SESSION['userid'] = $result['id'];
                    $_SESSION['username'] = $result['username'];
                    echo '<h2>登録が完了しました。</h2>';
                    echo '<a href="todolist.php">ToDoリストへ</a>';
                } else {
                    echo '<h2>ユーザー名またはパスワードが間違っています。</h2>';
                    echo '<a href="login.php">ログイン画面に戻る</a>';
                }
            } else {
                echo '<h2>登録に失敗しました。</h2>';
                echo '<a href="register.php">新規登録画面へ</a>';
            }
        } else {
            echo '<h2>そのユーザー名はすでに使用されています。</h2>';
            echo '<a href="register.php">新規登録画面へ</a>';
        }
    } else {
        echo '<h2>ユーザー名とパスワードを入力してください。</h2>';
        echo '<a href="register.php">新規登録画面へ</a>';
    }


} else {
    echo '不正な操作が行われました。';
    echo '<a href="register.php">新規登録画面へ</a>';
}

?>