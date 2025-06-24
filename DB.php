<?php
    function getDB(){
        $dsn='mysql:host=mysql323.phy.lolipop.lan;dbname=LAA1557132-todoenhanced;charset=utf8';
        $username='LAA1557132';
        $password='sanoharutosd3b';
        $pdo=new PDO($dsn,$username,$password);

        return $pdo;
    }
    

?>