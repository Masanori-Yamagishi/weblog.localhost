<?php
// FollowingModelクラス
// フォロー情報をデータベースから出し入れするモデルクラス
class FollowingModel extends ExecuteModel {
    // registerFollowUserメソッド
    // フォローするユーザーIDをデータベースに登録する
    public function registerFollowUser($user_id, $follow) {
    $sql = "INSERT INTO followingUser
            VALUES(:user_id, :following_id)";

    $stmt = $this->execute(
      $sql,
      array(
        ':user_id'      => $user_id,
        ':following_id' => $follow,
    ));
  }

  // isFollowedUserメソッド
  // フォロー済みのユーザーかどうか調べる
  public function isFollowedUser($user_id, $follow) {
    $sql = "SELECT COUNT(user_id) AS count
            FROM   followingUser
            WHERE  user_id = :user_id
            AND    following_id = :following_id";

    $dat = $this->getRecord($sql, array(
        ':user_id'      => $user_id,
        ':following_id' => $follow,
    ));

    if ($dat['count'] !== '0') {
      return true;
    }

    return false;
  }
}