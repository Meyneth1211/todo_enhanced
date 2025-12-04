<?php
// DB接続情報
$dsn = 'mysql:host=mysql304.phy.lolipop.lan;
dbname=LAA1553914-php2024;charset=utf8';
$user='LAA1553914';
$password='Pass0223';

try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    exit('DB接続エラー: ' . $e->getMessage());
}

// フォームから受け取ったデータ
$title = $_POST['title'] ?? '';
$genre = $_POST['genre'] ?? '';
$director = $_POST['director'] ?? '';

// アップロードされたファイル処理
$imageFileName = '';
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'img/';
    $tmpName = $_FILES['image']['tmp_name'];
    $origName = basename($_FILES['image']['name']);
    $imageFileName = date('YmdHis') . '_' . $origName; // ファイル名の重複防止
    $savePath = $uploadDir . $imageFileName;

    if (!move_uploaded_file($tmpName, $savePath)) {
        exit('画像の保存に失敗しました。');
    }
}

// データベースに追加
$sql = 'INSERT INTO movies (title, genre, director, image) VALUES (:title, :genre, :director, :image)';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':title', $title);
$stmt->bindValue(':genre', $genre);
$stmt->bindValue(':director', $director);
$stmt->bindValue(':image', $imageFileName);
$stmt->execute();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>登録完了</title>
</head>
<body>
    <p>映画が追加されました。</p>
    <a href="index.php">戻る</a>
</body>
</html>
