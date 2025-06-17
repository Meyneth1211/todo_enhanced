<?php
//GETアクセスの場合はログインフォームを表示、自己にPOSTでパラメータ送信してログイン処理
//POSTアクセスの場合はログイン処理を行う
if ($_SERVER['REQUEST_METHOD']==='GET') {
    echo <<<FORM
        <h1>ログイン</h1>
        <form action="login.php" method="post">
            <p>ユーザー名:<input type="text" name="username" placeholder="kazuma" required></p>
            <p>パスワード:<input type="password" name="password" placeholder="kazuma" required></p>
            <button type="submit">ログイン</button>
        </form>
    FORM;
} elseif ($_SERVER['REQUEST_METHOD']==='POST') {
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
            echo '<h2>ユーザー名またはパスワードが間違っています。</h2>';
            echo '<a href="login.php">ログイン画面に戻る</a>';
        }
    } else {
        echo '<h2>ユーザー名とパスワードを入力してください。</h2>';
        echo '<a href="login.php">ログイン画面に戻る</a>';
    }
    
}

?>