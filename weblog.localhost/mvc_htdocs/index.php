<?php
require '../bootstrap.php';
require '../BlogApp.php';

// boolean型でエラーメッセージの表示をコントロール。FALSEでエラー表示がOFFになる。
$app = new BlogApp(false);
$app->run();
