<?php

/*
=====================================================
 Менеджер объектов в базе данных
 -------------------------------------
 Файл: manager.php
=====================================================
*/

#Если пользователь авторизован - выводим панель управления
if ( isset( $_SESSION['logged_user'] ) ) {

  if ( isset( $system['subpage'] ) ) {

    switch ( $system['subpage'] ) {

      case 'editor':

        require ROOT_DIR . '/modules/manager.search.php';

        #Строим шаблон редактора
        $page = $tpl->load( 'manager.editor.tpl' )
        ->set( '{results}', $results )
        ->compile();

      break;

      case 'teacher':

        #Если создается или редактируется преподаватель
        require_once ROOT_DIR . '/modules/manager.teacher.php';

      break;

      case 'student':

        #Если создается или редактируется студент
        require_once ROOT_DIR . '/modules/manager.student.php';

      break;

      default:

        # Отдаем 404 и информацию об ошибке
        header( 'HTTP/1.1 404 Not Found' );

        $page = returnInformationBox(
          'Ничего не найдено',
          'Похоже, что данной страницы не существует, либо она скрыта для вас. Перейти на <a href="/">главную</a> страницу',
          'fas fa-search'
        );

      break;
    }

  }
  else {

    #Если подстраница не указана - выводим страницу с управлением (/manager)
    $tpl = new Template;
    $page = $tpl->load( 'manager.tpl' )->compile();

  }

}
else {

  $page = returnInformationBox(
    'Вы не авторизованы',
    'Чтобы использовать эту страницу необходимо авторизоваться. Перейти на <a href="/login">страницу</a> авторизации',
    'fas fa-lock'
  );

}





 ?>
