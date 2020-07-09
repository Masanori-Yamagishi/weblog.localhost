<?php
// StatusModelクラス
// アカウント情報を使って、記事の投稿・取得を行うモデルクラス
class StatusModel extends ExecuteModel {

  // insertメソッド
  // 投稿記事をデータベースに登録する
	public function insert($user_id, $message) {
    $now = new DateTime();

    $sql = "INSERT INTO status(user_id, message, time_stamp)
            VALUES(:user_id, :message, :time_stamp)";

    $stmt = $this->execute(
      $sql,
      array(
           ':user_id'    => $user_id,
           ':message'    => $message,
           ':time_stamp' => $now->format('Y-m-d H:i:s'),
    ));
	}

  // getUserDataメソッド
  // ログインユーザーの投稿記事を取り出す
	public function getUserData($user_id) {
	  $sql = "
			SELECT   a.*, u.user_name
			FROM     status a LEFT JOIN user u ON a.user_id = u.id
			                  LEFT JOIN followingUser f ON f.following_id = a.user_id
			                                            AND f.user_id = :user_id
			WHERE    f.user_id = :user_id OR u.id = :user_id
      ORDER BY a.time_stamp DESC";

	  $user = $this->getAllRecord(
                   $sql,
                   array(':user_id' => $user_id));
    return $user;
	}

  // getPostedMessageメソッド
  // 指定したユーザーの投稿記事を全て取得する
  public function getPostedMessage($user_id) {
      $sql = "SELECT   a.*, u.user_name
              FROM     status a LEFT JOIN user u ON a.user_id = u.id
              WHERE    u.id = :user_id
              ORDER BY a.time_stamp DESC";

      $postMsg = $this->getAllRecord(
                        $sql,
                        array(':user_id' => $user_id));
      return $postMsg;
  }

  // getSpecificMessageメソッド
  // 投稿記事を一件だけ取得する
  public function getSpecificMessage($id, $user_name) {
      $sql = "SELECT a.* , u.user_name
              FROM   status a LEFT JOIN user u ON u.id = a.user_id
              WHERE  a.id = :id AND u.user_name = :user_name";

      $specMsg = $this->getRecord(
                        $sql,
                        array(':id'        => $id,
                              ':user_name' => $user_name));
      return $specMsg;
  }

  // getWholeStatusesメソッド
  // 投稿された全ての記事を取得する
  public function getWholeStatuses($user_id){
    //sql文
    // $sql = "SELECT * FROM `status` ORDER BY 'id' DESC";

    $sql = "SELECT   a.*, u.user_name
            FROM     status a LEFT JOIN user u ON a.user_id = u.id
            ORDER BY a.time_stamp DESC";

    //SQL文を実行する
    $wholeMsg = $this->getAllRecord(
                        $sql,
                        array(':user_id' => $user_id));
    //結果をreturn
    return $wholeMsg;
  }
}
