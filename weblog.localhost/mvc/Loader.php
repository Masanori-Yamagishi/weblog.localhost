<?php
class Loader{

  // オートロード対象のディレクトリを保持するプロパティ
  protected $_directories = array();
  public function regDirectory($dir) {
    $this->_directories[] = $dir;
  }

  // registerメソッド
  // クラスを読み込むメソッドをコールバックに登録
  public function register() {
    spl_autoload_register(array($this, 'requireClsFile'));
  }

  // requireClsFileメソッド
  // 指定されたファイルの読み込みを行う
  public function requireClsFile($class)
  {
    foreach ($this->_directories as $dir)
    {
      $file = $dir . '/' . $class . '.php';
      if (is_readable($file)) {
        require $file;
        return;
      }
    }
  }
}