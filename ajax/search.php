<?php

/*
=====================================================
 Поиск преподавателей и студентов [AJAX]
 -------------------------------------
 Файл: search.php
=====================================================
*/

session_start();

if ( !isset( $_SESSION['logged_user'] ) ) {

  header( 'HTTP/1.1 403 Forbidden' );
  header( 'Location: /' );

  exit();

}

define( 'ROOT_DIR', substr( dirname(  __FILE__ ), 0, -5 ) );

# Подключаем все требуемые файлы
require ROOT_DIR . '/config/db.php';
require ROOT_DIR . '/classes/template.class.php';

require ROOT_DIR . '/modules/functions.php';
require ROOT_DIR . '/modules/manager.search.php';

#Символическая задержка для имитации поиска
sleep( 1 );

echo $results;


 ?>
