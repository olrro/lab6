<?php

/*
=====================================================
 Поиск преподавателей и студентов
 -------------------------------------
 Файл: manager.search.php
=====================================================
*/

$params = $query = [];

#Изменение режима работы редактора объектов (1 = преподаватель, 0 = студент)
if ( isset( $_POST['editor_type'] ) ) {

  if ( intval( $_POST['editor_type'] ) ) {
    $editor_mode = 1;
  }
  else {
    $editor_mode = 0;
  }

}
else {
  $editor_mode = 1;
}

if ( $editor_mode ) {
  $query[] = 'SELECT * FROM teachers';
}
else {
  $query[] = 'SELECT * FROM students';
}

if ( !empty( $_POST['editor_search'] ) ) {

  if ( $editor_mode ) {
    $query[] = 'WHERE MATCH (name, biography) AGAINST (:search)';
  }
  else {
    $query[] = 'WHERE MATCH (name) AGAINST (:search)';
  }

  $params['search'] = $_POST['editor_search'];

}

if ( isset( $_POST['editor_sort'] ) ) {

  if ( intval( $_POST['editor_sort'] ) ) {
    $query[] = 'ORDER BY id DESC';
  }
  else {
    $query[] = 'ORDER BY id ASC';
  }

}

$results = [];

$tpl = new Template;

$query = $database->prepare( implode( " ", $query ) );
$query->execute( $params );

while ( $row = $query->fetch() ) {

  #Строим элементы редактора (список с преподавателями или студентами)
   $tpl->load( 'manager.editor.item.tpl' )
   ->set( '{name}', $row['name'] )
   ->set( '{id}', $row['id'] )
   ->set( '{error}', '' )
   ->block( "'\\[not-found\\](.*?)\\[/not-found\\]'si", "" )
   ->set( '{foto}', '/template/images/database/' . $row['photo'] );

   if ( $editor_mode ) {

     $tpl->block( "'\\[student\\](.*?)\\[/student\\]'si", "" )
     ->set( '[teacher]', '' )
     ->set( '[/teacher]', '' )
     ->set( '{biography}', mb_strimwidth( $row['biography'], 0, 80, "...") )
     ->set( '{experience}', yearSuffix( strtotime( $row['experience'] ) ) );

   }
   else {

     $tpl->block( "'\\[teacher\\](.*?)\\[/teacher\\]'si", "" )
     ->set( '[student]', '' )
     ->set( '[/student]', '' )
     ->set( '{gender}', returnGender( $row['gender'] ) )
     ->set( '{birthday}', $row['birthday'] );

   }

   $results[] = $tpl->compile();

}

if ( $results  ) {

  $results = implode( "", $results );

}
else {

  $results = $tpl->load( 'manager.editor.item.tpl' )
    ->block( "'\\[teacher\\](.*?)\\[/teacher\\]'si", "" )
    ->block( "'\\[student\\](.*?)\\[/student\\]'si", "" )
    ->set( '[not-found]', '' )
    ->set( '[/not-found]', '' )
    ->set( '{name}', '' )
    ->set( '{error}', 'Ничего не найдено' )
    ->set( '{id}', '' )
    ->set( '{foto}', '' )
    ->set( '{biography}', '' )
    ->set( '{experience}', '' )
    ->set( '{gender}', '' )
    ->set( '{birthday}', '' )
    ->compile();

}

 ?>
