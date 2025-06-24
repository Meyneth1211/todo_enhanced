<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="taskedit.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post" class="waku">

        <h1>タスク編集</h1>
        <div class="taskall">
            内容<br>
            <textarea name="task_content" class="naiyo"></textarea><br>

            期限<br>

            <input type="date" name="task_deadline" class=kigen><br>


            優先度<br>
            <select name="pr" class="yusen">
                <option value="pr1">優先度(低)</option>
                <option value="pr2">優先度(中)</option>
                <option value="pr3">優先度(高)</option>
            </select><br>

            状態<br>
            <select name="status" class="jotai">
                <option value="status1">未完了</option>
                <option value="status2">完了</option>
            </select><br>

        </div>

        <div class="link">
            <button type="submit">保存</button><a href="">キャンセル</a>
        </div>

    </form>

</body>

</html>