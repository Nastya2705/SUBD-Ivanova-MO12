<?php

    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'zhkh');

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if (mysqli_connect_errno()){
        echo "Ошибка соединения с базой данных: " . mysqli_connect_error();
        $db_conn = '<b style="color:red">ошибка</b>';
    }else{
        $db_conn = '<b style="color:green">успешно</b>';
    }
    
?>