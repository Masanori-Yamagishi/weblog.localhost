<?php
// Responseクラス
// レスポンスデータを送信する
class Response{
  protected $_content;
  protected $_statusCode = 200;
  protected $_statusMsg = 'OK';
  protected $_headers = array();
  const HTTP = 'HTTP/1.1 ';

  // setContentメソッド
  // レンダリングされたHTMLをプロパティに格納する
  public function setContent($content){
    $this->_content = $content;
  }

  // setStatusCodeメソッド
  // ステータスコードとメッセージをプロパティに格納する
  public function setStatusCode($code, $msg = ''){
    $this->_statusCode = $code;
    $this->_statusMsg = $msg;
  }

  // setHeaderメソッド
  // レスポンスヘッダーをプロパティに格納する
  public function setHeader($name, $value){
    $this->_headers[$name] = $value;
  }

  // sendメソッド
  // レスポンスを生成する
  public function send(){
    header(self::HTTP . $this->_statusCode . ' ' . $this->_statusMsg);
    foreach ($this->_headers as $name => $value) {
      header($name . ': ' . $value);
    }
    print $this->_content;
  }
}
