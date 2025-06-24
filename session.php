<?php
session_start();
function displayname(){
    if (!empty($_SESSION['userid'])) {
        echo '<p>'.htmlspecialchars($_SESSION['username']).' さん <a href="logout.php">ログアウト</a></p>';
    } else {
        //header('Location: login.php');
        session_unset();
        session_destroy();
        exit();
    }
}
?>