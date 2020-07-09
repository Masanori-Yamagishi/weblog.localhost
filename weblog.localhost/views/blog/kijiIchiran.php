<?php
// 今回は新たにページを作る
// リンクをtemplateの「トップページ」「アカウント」の隣に作る
// データベースから最新10件の記事を持ってくるSQL
      // SELECT * FROM `status` ORDER BY 'id' DESC LIMIT 10
// データベースに接続してデータを持ってきてレンダリングしてページを生成する仕組み
      // コントローラー経由でモデルがDBを叩き、その結果がビューに渡される
        // BlogController
          // specificActionに類似したwholeActionメソッドを用意した。ルーティング処理をなんとかして確認したい
        // StatusModel
          // getSpecificMessageにgetWholeStatusesメソッドを用意。うまくいった。
        // ビュー
          // templateを骨組みにするビューphpファイルKijiIchiran.phpを用意
        // BlogApp
          // ルーティングの記述をする
//既存のメソッド真似しつつ、とりあえずでページとリンク作って、それを落とし込んでいくのが吉
// まずどんな手段を使ってもいいからページを実装して、中身を作り変えていこう
?>
