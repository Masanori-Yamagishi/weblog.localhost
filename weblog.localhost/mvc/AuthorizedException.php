<?php

// AuthorizedExceptionクラス
// 認証していない状態で、認証が必要なアクションを実行した際の例外
class AuthorizedException extends Exception {};
