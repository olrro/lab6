<?php

/*
=====================================================
 Предсказатель текста (Яндекс.Предиктор) [AJAX]
 -------------------------------------
 Файл: spellchecker.php
=====================================================
*/

session_start();

if ( !isset( $_REQUEST['query'] ) OR !isset( $_SESSION['logged_user'] ) ) {

  header( 'HTTP/1.1 403 Forbidden' );
  header( 'Location: /' );

  exit();

}

define( 'ROOT_DIR', substr( dirname(  __FILE__ ), 0, -5 ) );

# Подключаем все требуемые файлы
require ROOT_DIR . '/config/config.php';

$result = [];

if ( preg_match( '/^[а-яА-ЯЁё]+$/iu', $_REQUEST['query'] ) ) {

  $params = [

    'key' => $system['yandex']['predictor'],
    'q' => $_REQUEST['query'],
    'lang' => 'ru',
    'limit' => 5

  ];

  #Отправляет запрос на сервер Яндекса
  $request = @file_get_contents( $system['yandex']['predictor_url'] . '?' . http_build_query( $params ) );

  if ( $request ) {

    $request = json_decode( $request, 1 );

    if ( isset( $request['text'] ) ) {
      $result = $request['text'];
    }

  }

}

echo json_encode( $result );

 ?>
