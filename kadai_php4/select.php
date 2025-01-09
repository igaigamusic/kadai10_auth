<?php
// // 0. SESSION開始！！
session_start();

//1.  DB接続＋ログインチェック処理
require_once('funcs.php');
loginCheck();

//２．データ取得SQL作成
$pdo = db_conn();
$stmt = $pdo->prepare("SELECT * FROM kadai_php2_table;");
$status = $stmt->execute();

//３．データ表示
$view = "";
if ($status === false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("ErrorQuery:" . $error[2]);
} else {
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= '<p>';
        $view .= $result['indate'] . '/ ' . h($result['name']) . '/ ' . h($result['birthday']);

            // kanri_flg = 1なら医師画面を表示（診察終了を表示）
            if ($_SESSION['kanri_flg'] === 1){
                $view .= '<a href="delete.php?id=' . $result['id'] . '">';
                $view .= '[診察終了]';
                $view .= '</a>';
            }
        
        $view .= '</p>';
    }
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>受付患者一覧</title>
    <link rel="stylesheet" href="css/range.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        div {
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>

<body id="main">
    <!-- Head[Start] -->
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">受付患者一覧</a>
                </div>
            </div>
        </nav>
    </header>
    <!-- Head[End] -->

    <!-- Main[Start] -->
    <div>
        <div class="container jumbotron"><?= $view ?></div>
    </div>
    <!-- Main[End] -->

</body>

</html>