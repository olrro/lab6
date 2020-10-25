<?php

/*
=====================================================
 Некоторые функции для важной работы
 -------------------------------------
 Файл: functions.php
=====================================================
*/

#Возвращает суффикс для года (например 2 года или 7 лет)
function yearSuffix( $year ) {

    $year = floor( ( time() - intval( $year ) ) / 31536000 );
    $year = abs( $year );

    $t1 = $year % 10;
    $t2 = $year % 100;

    if ( $t1 == 1 AND $t2 != 11 ) return "{$year} год";
    elseif ( $t1 >= 2 AND $t1 <= 4 AND ($t2 < 10 || $t2 >= 20 ) ) return "{$year} года";
    else return "{$year} лет";

}

#Возвращает текущий IP адрес пользователя
function returnIP()
{

  if( filter_var( @$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP ) ) return @$_SERVER['HTTP_CLIENT_IP'];
  elseif( filter_var( @$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP ) ) return @$_SERVER['HTTP_X_FORWARDED_FOR'];
  else return $_SERVER['REMOTE_ADDR'];

}

#Возвращает название пола для человека ( 1 = мужской , 0 = женский)
function returnGender( $gender )
{

  if ( intval( $gender ) ) return 'мужской';
  else return 'женский';

}

#Простой генератор никнеймов
#Мы делим все буквы латинского алфавита на гласные и согласные, далее собираем из них слово нужной длины
function returnNickname() {

    $symbol_arr = [ 'aeiouy', 'bcdfghjklmnpqrstvwxz' ];
    $length = mt_rand( 6, 8 );
    $return = [];

    foreach ($symbol_arr as $k => $v) $symbol_arr[$k] = str_split($v);

    for ($i = 0; $i < $length; $i++) {
        while (true) {
            $symbol_x = mt_rand(0, sizeof($symbol_arr) - 1);
            $symbol_y = mt_rand(0, sizeof($symbol_arr[$symbol_x]) - 1);
            if ($i > 0 && in_array($return[$i - 1], $symbol_arr[$symbol_x]))
                continue;
            $return[] = $symbol_arr[$symbol_x][$symbol_y];
            break;
        }
    }

    $return = ucfirst(implode('', $return));
    return $return;

}

# Возвращает панель пользователя сверху
function returnPopUpProfile()
{

  global $system;

  $tpl = new Template;

  if ( isset( $_SESSION['logged_user'] ) ){

    return $tpl->load( 'user.tpl' )
    ->set( '{username}', $system['user_data']['login'] )
    ->set( '[logged]', '' )
    ->set( '[/logged]', '' )
    ->block( "'\\[not-logged\\](.*?)\\[/not-logged\\]'si", "" )
    ->compile();

  }
  else {

    return $tpl->load( 'user.tpl' )
    ->set( '{username}', '' )
    ->set( '[not-logged]', '' )
    ->set( '[/not-logged]', '' )
    ->block( "'\\[logged\\](.*?)\\[/logged\\]'si", "" )
    ->compile();

  }

}

function removePhoto( $avatar )
{

  $file = ROOT_DIR . '/template/images/database/' . $avatar;
  if ( file_exists( $file ) ) return unlink( $file );
  else return 1;

}

#Удаляет объект из базы данных (студент или преподаватель) и сообщает о статусе операции
function removeObject( $id, $type )
{

  global $database;

  if ( in_array( $type, ['teachers', 'students'] ) ) {

    if ( $type == 'teachers' ) {

      $query = $database->prepare( 'SELECT photo FROM students WHERE teacher_id = ?' );
      $query->execute( [ intval( $id ) ] );

      while ( $row = $query->fetch() ) removePhoto( $row['photo'] );

    }

    $part = 'FROM ' . $type . ' WHERE id = ?';

    $query = $database->prepare( 'SELECT photo ' . $part );
    $query->execute( [ intval( $id ) ] );

    if ( $row = $query->fetch() ) {

      $query = $database->prepare( 'DELETE ' . $part );
      $query->execute( [ intval( $id ) ] );

      return removePhoto( $row['photo'] );

    } else return 0;

  }
  else return 0;

}

#Загружает файл в папку и сообщает о статусе операции
function uploadFile( $name )
{

  if ( isset( $_FILES[$name] ) ) {

    if ( $_FILES[$name]['type'] == 'image/png' ) $img_type = 'png';
    elseif( $_FILES[$name]['type'] == 'image/jpeg') $img_type = 'jpg';
    else return 0;

    if ( $_FILES[$name]['size'] > 1048576 ) return 0;
    if ( $_FILES[$name]['error'] != UPLOAD_ERR_OK ) return 0;

    do {

      $file = md5( basename( $_FILES[$name]["name"] ) . time() ) . '.' . $img_type;
      $dir = ROOT_DIR . '/template/images/database/' . $file;

    } while ( file_exists( $dir ) );

    if ( move_uploaded_file( $_FILES[$name]["tmp_name"], $dir ) ) return $file;
    else return 0;

  }
  else return 0;


}

# Выводит окно с информацией на сайте
function returnInformationBox( $title, $info, $icon = '' )
{

  $tpl = new Template;

  $tpl->load( 'info.tpl' )->set( '{title}', $title );

  if ( $icon ) $tpl->set( '{icon}', "<i class=\"{$icon} text-primary\"></i>" );
  else $tpl->set( '{icon}', '' );

  return $tpl->set( '{info}', $info )->compile();

}


 ?>
