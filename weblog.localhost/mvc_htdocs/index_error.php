<?php
require '../bootstrap.php';
require '../BlogApp.php';

// boolean型でエラーメッセージの表示をコントロール。TRUEでエラー表示がONになる。
$app = new BlogApp(true);
$app->run();