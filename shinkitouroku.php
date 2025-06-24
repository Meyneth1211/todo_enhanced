<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録</title>
</head>
<link rel="stylesheet" href="shinkitouroku.css">
<body>
    <form action="login.php" method="post">
    <h1>ユーザー登録</h1>

    <label for="username">ユーザー名:</label>
    <input type="text" id="username" name="username" placeholder="例: yamada123"><br>

    <label for="password">パスワード:</label>
    <input type="password" id="password" name="password" placeholder="8文字以上の英数字">

        <button type="submit">登録</button>
    <button><a href="login.php" style="color: purple;">ログインはこちら</a></button>
    </form>
</body>
</html>