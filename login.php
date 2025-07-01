<?php if($_SERVER['REQUEST_METHOD'] === 'GET'): // until line 32 ?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <form action="" method="post">
        <div class="box13">
            <h1>ログイン</h1>
            <div class="font">
                ユーザー名: <input type="text" name="username"><br>
                パスワード: <input type="password" name="password"><br>
            </div>
            <div class="btn-border-gradient-wrap btn-border-gradient-wrap--gold">
                <button type="submit" class="btn btn-border-gradient"><span class="btn-text-gradient--gold">ログイン</span></button>
            </div><br><br><br>
    </form>
    <form action="register.php" method="get">       
            <div class="btn-border-gradient-wrap btn-border-gradient-wrap--gold">
                <a href="register.php"><button class="btn btn-border-gradient"><span class="btn-text-gradient--gold">新規登録</span></button></a>
            </div>
    </form>
        </div>
</body>

</html>
<?php endif; ?>
<?php
if ($_SERVER['REQUEST_METHOD']==='POST') {
    //ユーザ名とパスワードが入力されているか判定
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        require_once 'DB.php';
        $pdo= getDB();
        $sql='SELECT id, username FROM users WHERE username = ? AND password = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_POST['username'], $_POST['password']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($result)) {
            session_start();
            $_SESSION['userid'] = $result['id'];
            $_SESSION['username'] = $result['username'];
            header('Location: todolist.php');
        } else {
            echo '<div class="loginmiss">';
            echo '<h2>ユーザー名またはパスワードが間違っています。</h2>';
            echo '<a href="login.php">ログイン画面に戻る</a>';
            echo '</div>';
        }
    } else {
        echo '<div class="loginmiss">';
        echo '<h2>ユーザー名とパスワードを入力してください。</h2>';
        echo '<a href="login.php">ログイン画面に戻る</a>';
        echo '<div class="loginmiss">';
    }
}
?>