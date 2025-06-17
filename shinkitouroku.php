<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録</title>
</head>
<link rel="stylesheet" href="shinkitouroku.css">
<body>
    <div class="body2">
    <h1>ユーザー登録</h1>
    <form action="login.php" method="post">
        <label>ユーザー名:
            <input type="text" name="username" required>
        </label><br><br>

        <label>パスワード:
            <input type="password" name="password" required>
        </label><br><br>

        <button type="submit">登録</button>
    </form>
    </div>
    <p><a href="login.php" style="color: purple;">ログインはこちら</a></p>
</body>
</html>