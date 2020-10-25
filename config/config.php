<?php

/*
=====================================================
 Настройки сайта
 -------------------------------------
 Файл: config.php
=====================================================
*/

$system = [];

#Адрес нашего сайта (слеш на конце обязателен)
$system['url'] = 'http://lab.ru/';

$system['recaptcha'] = [

  'public_key' => '6Lfk_NoZAAAAAGa8PL0d2yTnF4uuStbNnrBJ6GUX',
  'secret_key' => '6Lfk_NoZAAAAAOX4GfGr-d_75-5_9KWdcgJwY2jZ',
  'check' => 'https://www.google.com/recaptcha/api/siteverify'

];

$system['vk'] = [

  'info_url' => 'https://api.vk.com/method/users.get',

  'oauth_url' => 'https://oauth.vk.com/access_token',
  'app_url' => 'https://oauth.vk.com/authorize',

  'app_id' => '7639348',
  'secret_key' => 'NRt6KGYPrUgimTaPPp3G'

];

$system['yandex'] = [

  'predictor' => 'pdct.1.1.20201023T221021Z.0e49b2d4c0f48cef.aa34dd487fd9a7d86550e20aaed396dc03aabe76',
  'predictor_url' => 'https://predictor.yandex.net/api/v1/predict.json/complete'

];

if ( isset( $_GET['page'] ) ) {
  $system['page'] = $_GET['page'];
}
else {
  $system['page'] = '';
}

if ( isset( $_GET['subdata'] ) ) {
  $system['subdata'] = $_GET['subdata'];
}

if ( isset( $_GET['subpage'] ) ) {
  $system['subpage'] = $_GET['subpage'];
}

 ?>
