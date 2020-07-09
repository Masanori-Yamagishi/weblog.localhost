<?php
// ExecuteModelクラス
// データベースのデータ操作を行う、抽象的なモデルクラス
abstract class ExecuteModel{
    // PDOオブジェクトを保持するプロパティ
    protected $_pdo;

    // setPdoメソッドを呼び出すコンストラクタ
    public function __construct($pdo){
        $this->setPdo($pdo);
    }

    // setPdoメソッド
    // PDOオブジェクトをプロパティに登録する
    public function setPdo($pdo){
        $this->_pdo = $pdo;
    }

    // executeメソッド
    // SQLのクエリを発行する
    public function execute($sql, $parameter = array()){
      // プリペアドステートメントを生成
      $stmt = $this->_pdo
                   ->prepare(
                       $sql,
                       array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      // プリペアドステートメントを実行
      $stmt->execute($parameter);
      // 戻り値としてPDOStatementオブジェクトを返す
      return $stmt;
    }

    // getAllRecordメソッド
    // クエリの結果を全て取得する
    public function getAllRecord($sql,
                                 $parameter = array()
    ){
      $all_rec = $this->execute($sql, $parameter)
                      ->fetchAll(PDO::FETCH_ASSOC);
      return $all_rec;
    }

    // getRecordメソッド
    // クエリの結果を１行分だけ取得する
    public function getRecord($sql, $parameter = array()){
      $rec = $this->execute($sql, $parameter)
                  ->fetch(PDO::FETCH_ASSOC);
      return $rec;
    }
}