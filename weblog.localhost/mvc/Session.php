<?php
class Session{
  protected static $_session_flag = false;
  protected static $_generated_flag = false;

  // コンストラクター
  // セッションが開始済みか調べる
  public function __construct(){
    if (!self::$_session_flag) {
      session_start();
      self::$_session_flag = true;
    }
  }

  // setメソッド
  // セッションに値を設定
  public function set($key, $value){
    $_SESSION[$key] = $value;
  }

  // getメソッド
  // $_SESSIONから値を取得する
  public function get($key, $par = null){
    if (isset($_SESSION[$key])) {
      return $_SESSION[$key];
    }
    return $par;
  }

  // generateSessionメソッド
  // セッションIDを生成する
  public function generateSession($del = true){
    if (!self::$_generated_flag) {
        session_regenerate_id($del);

        self::$_generated_flag = true;
    }
  }

  // setAuthenticateStatusメソッド
  // サインインの状態を登録する
  public function setAuthenticateStatus($flag){
    $this->set('_authenticated', (bool)$flag);
    $this->generateSession();
  }

  // isAuthenticatedメソッド
  // 認証済みか判定する
  public function isAuthenticated(){
    return $this->get('_authenticated', false);
  }


  // clearメソッド
  // $_SESSIONを空にする
  public function clear(){
    $_SESSION = array();
  }
}
