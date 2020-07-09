<?php
// UserModelクラス
// アカウント情報をデータベースから出し入れするモデルクラス
class UserModel extends ExecuteModel {

  // insertメソッド
  // ユーザーIDとパスワードをデータベースに登録する
  public function insert($user_name, $password) {
      $password = password_hash($password,
                                PASSWORD_DEFAULT);
      $now = new DateTime();
      $sql = "INSERT INTO user(user_name, password, time_stamp)
              VALUES(:user_name, :password, :time_stamp)";
      $stmt = $this->execute($sql, array(
          ':user_name'  => $user_name,
          ':password'   => $password,
          ':time_stamp' => $now->format('Y-m-d H:i:s'),
      ));
  }

  // getUserRecordメソッド
  // ユーザーIDを使って、アカウント情報をデータベースから抽出する
  public function getUserRecord($user_name) {
      $sql = "SELECT *
              FROM   user
              WHERE  user_name = :user_name";

      $userData = $this->getRecord(
                         $sql,
                         array(':user_name' => $user_name));
      return $userData;
  }

  // isOverlapUserNameメソッド
  // ユーザーIDが既に登録済みでないか調べる
  // AccountControllerのregisterActionで呼び出す
  public function isOverlapUserName($user_name) {
      $sql = "SELECT COUNT(id) as count
              FROM   user
              WHERE  user_name = :user_name";

      $row = $this->getRecord(
                    $sql,
                    array(':user_name' => $user_name));
      if ($row['count'] === '0') {
          return true;
      }
      return false;
  }

  // getFollowingUserメソッド
  // サインイン中のユーザーのフォロー先を全て取得する
  public function getFollowingUser($user_id) {
    $sql = "SELECT    u.*
            FROM      user u
            LEFT JOIN followingUser f ON f.following_id = u.id
            WHERE     f.user_id = :user_id";
    $follows = $this->getAllRecord(
                      $sql,
                      array(':user_id' => $user_id));
    return $follows;
  }
}
