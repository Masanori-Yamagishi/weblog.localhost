<?php
// Requestクラス
// クライアントからのリクエストを処理する
class Request{
  // isPostメソッド
  // リクエストメソッドがPOSTか判定する
  public function isPost(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      return true;
    }
    return false;
  }

  // getGetメソッド
  // GETで送信された情報を取得する
  public function getGet($name, $param = null){
    if (isset($_GET[$name])) {
      return $_GET[$name];
    }
    return $param;
  }

  // getPostメソッド
  // POSTで送信された情報を取得する
  public function getPost($name, $param = null){
    if (isset($_POST[$name])) {
      return $_POST[$name];
    }
    return $param;
  }

  // getHostNameメソッド
  // ホスト名を取得する
  public function getHostName(){
    if (!empty($_SERVER['HTTP_HOST'])) {
      return $_SERVER['HTTP_HOST'];
    }
    return $_SERVER['SERVER_NAME'];
  }

  // getRequestUriメソッド
  // ホスト部分より後ろの値を返す
  public function getRequestUri(){
    return $_SERVER['REQUEST_URI'];
  }

  // getBaseUrlメソッド
  // フロントコントローラーまでのパスを返す
  public function getBaseUrl(){
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $requestUri = $this->getRequestUri();

    if (0 === strpos($requestUri, $scriptName)) {
      return $scriptName;
    } else if (0 === strpos($requestUri,
                            dirname($scriptName))
    ){
      return rtrim(dirname($scriptName), '/');
    }
    return '';
  }

  // getPathメソッド
  // フロントコントローラーの後に続くパスを返す
  public function getPath(){
    $base_url = $this->getBaseUrl();
    $requestUri = $this->getRequestUri();

    if (false !== ($sp = strpos($requestUri, '?'))){
      $requestUri = substr($requestUri, 0, $sp);
    }

    $path = (string)substr($requestUri,
                           strlen($base_url));
    return $path;
  }
}
