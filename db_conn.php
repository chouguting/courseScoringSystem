<?php
    $user='root2';
    $password='20010122';

    try{
        $db = new PDO('mysql:host=course-scoring-db.mariadb.database.azure.com;dbname=coursescoringsystem;charset=utf8',$user,$password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }catch (PDOException $e){
        Print "Error".$e->getMessage();
        die();
    }
?>
