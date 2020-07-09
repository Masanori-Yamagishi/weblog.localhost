<?php

// 抽象クラスController
// URLに応じてアクションを実行する
abstract class Controller {

  // アプリケーションクラスのインスタンスを保持
  protected $_application;
  // コントローラーのクラスを保持
  protected $_controller;
  // アクション名を保持
  protected $_action;
  // Requestオブジェクトを保持
  protected $_request;
  // Responseオブジェクトを保持
  protected $_response;
  // Sessionオブジェクトを保持
  protected $_session;
  // ConnetModelオブジェクトを保持
  protected $_connect_model;
  // 認証が必要なページかどうかboolean型で保持
  protected $_authentication = array();
  // プロトコルを保持した定数
  const PROTOCOL = 'http://';
  // アクションメソッド名のベース部分を格納してある定数
  const ACTION = 'Action';

  // コンストラクター
  // アプリケーションクラスのインスタンスを渡す
  public function __construct($application){

    // アプリケーション本体のクラスのインスタンスをプロパティに格納
    $this->_application    = $application;
    // コントローラーのクラス名を生成し、$_controllerプロパティに格納
    $this->_controller     = strtolower(substr(get_class($this), 0, -10));
    // 各クラスのインスタンスを取得
    $this->_request        = $application->getRequestObject();
    $this->_response       = $application->getResponseObject();
    $this->_session        = $application->getSessionObject();
    $this->_connect_model  = $application->getConnectModelObject();
  }

  // dispatchメソッド
  // サブクラスのアクションを実行する
  public function dispatch($action, $params = array()) {
    // action名をプロパティに保存
    $this->_action = $action;
    // アクションメソッド名を、アクション名+Actionとして生成し、プロパティに格納
    $action_method = $action . self::ACTION;

    // アクションメソッドがなければhttpNotFoundを呼び出す
    if (!method_exists($this, $action_method)) {
        $this->httpNotFound();
    }

    // 認証を必要とするアクションで、かつ認証済みでない場合に、例外を投げる
    if ($this->isAuthentication($action)
        && !$this->_session->isAuthenticated()
    ){
      throw new AuthorizedException();
    }

    // アクションメソッドを実行し、戻り値としてコンテンツを返す
    $content = $this->$action_method($params);
    return $content;
  }

  //httpNotFoundメソッド
  // エラー画面としてFileNotFoundExceptionオブジェクトを生成
  protected function httpNotFound() {
    throw new FileNotFoundException('FILE NOT FOUND '
        . $this->_controller . '/' . $this->_action);
  }

  // isAuthenticationメソッド
  // 認証が必要なアクションかを判定する
  protected function isAuthentication($action) {
    if ($this->_authentication === true
        || (is_array($this->_authentication)
        && in_array($action, $this->_authentication))
    ){
      return true;
    }
    return false;
  }

  // renderメソッド
  // コンテンツを描写するメソッド
  protected function render(
    $param = array(), $viewFile = null, $template = null
  ){
    $info = array(
        'request'  => $this->_request,
        'base_url' => $this->_request->getBaseUrl(),
        'session'  => $this->_session,
    );

    $view = new View($this->_application
                          ->getViewDirectory(),
                     $info);

    if (is_null($viewFile)) {
        $viewFile = $this->_action;
    }

    if (is_null($template)) {
        $template = 'template';
    }

    // パス情報「コントローラー名/ビューファイル名」を生成する
    $path = $this->_controller . '/' .$viewFile;

    $contents = $view->render($path,
                              $param,
                              $template);
    return $contents;
  }


  // redirectメソッド
  // 指定されたURLへリダイレクトするメソッド
  protected function redirect($url) {
    $host     = $this->_request->getHostName();
    $base_url = $this->_request->getBaseUrl();
    $url      = self::PROTOCOL . $host . $base_url . $url;
    $this->_response
         ->setStatusCode(302, 'Found');
    $this->_response
         ->setHeader('Location', $url);
  }

  // getTokenメソッド
  // トークン(ワンタイムパスワード)を生成するメソッド
  protected function getToken($form) {
    // トークンを格納する際のキーを作成
    $key      = 'token/' . $form;
    // トークンを取得し、トークン数が１０個を超えないようにする
    $tokens   = $this->_session
                     ->get($key, array());
    if (count($tokens) >= 10) {
        array_shift($tokens);
    }
    // パスワードハッシュをトークンにして戻り値として返す
    $password = session_id() . $form;
    $token    = password_hash($password,
                              PASSWORD_DEFAULT);
    $tokens[] = $token;

    $this->_session->set($key, $tokens);

    return $token;
  }

  // checkTokenメソッド
  // トークンをチェックするメソッド
  protected function checkToken($form, $token) {
    $key    = 'token/' . $form;
    $tokens = $this->_session->get($key, array());

    if (false !== ($present = array_search($token,
                                           $tokens,
                                           true))
    ){
      unset($tokens[$present]);
      $this->_session
           ->set($key, $tokens);

      return true;
    }
    return false;
  }
}
