<?php
// Viewクラス
// HTMLをレンダリングするクラス
class View{
    // ビューファイルのディレクトリパスを保持
    protected $_baseUrl;
    // ビューファイルへ渡すデータを保持
    protected $_initialValue;
    // ページタイトルを保持
    protected $_passValues = array();

    // コンストラクター
    // パラメータで取得したデータをプロパティにセットする
    public function __construct($baseUrl,
                                $initialValue = array()){
        $this->_baseUrl = $baseUrl;
        $this->_initialValue = $initialValue;
    }

    // setPageTitleメソッド
    // レイアウトファイルに渡すデータを設定する
    public function setPageTitle($name, $value){
      $this->_passValues[$name] = $value;
    }

    // renderメソッド
    // ビューファイルを読み込む
    // Controllerのrenderメソッドに呼び出される
    public function render($filename,$parameters = array(),$template = false){
      // ビューファイルへのパスを生成
      $view = $this->_baseUrl . '/' . $filename . '.php';
      // コントローラで設定したデータとアクションメソッドから渡されたデータを結合し、キーごとに変数として展開できるようにする
      extract(array_merge($this->_initialValue,
                          $parameters));
      // バッファリングでビューファイルを読み込む
      ob_start();
      ob_implicit_flush(0);
      require $view;
      $content = ob_get_clean();
      // レイアウトファイルを読み込み、HTMLドキュメントを生成する
      if ($template) {
        $content = $this->render(
          $template,
          array_merge($this->_passValues,
          array('_content' => $content)
        ));
      }
      return $content;
    }

    // escapeメソッド
    // HTMLエスケープする
    public function escape($string){
        return htmlspecialchars($string,
                                ENT_QUOTES,
                                'UTF-8');
    }
}