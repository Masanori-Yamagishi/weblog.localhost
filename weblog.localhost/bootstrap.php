<?php

require 'mvc/Loader.php';
$loader = new Loader();

// オートロード対象のディレクトリを登録するメソッド
$loader->regDirectory(dirname(__FILE__).'/mvc');
$loader->regDirectory(dirname(__FILE__).'/models');

// オートロードに登録
$loader->register();
