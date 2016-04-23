<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>レッスン登録完了</title>
</head>

<body>
    <?php
    //自作関数の読み込み
    require_once('function/function.php');
    
    session_start();
    session_regenerate_id();
        
    $id=$_SESSION['id'];
    
    //サーバーエラー時の対策
    try
    {
        //データの受け取り
        $lessonid=$_POST['lessonid'];
        $entryid=$_POST['userid'];
        
        //SQLを使ってデータの追加
        $sql='INSERT INTO lesson_request(request_user_id,entry_user_id,lesson_id) VALUES (?,?,?)';
        $stmt=$dbh->prepare($sql);
        $data[]=$id;
        $data[]=$entryid;
        $data[]=$lessonid;

        $stmt->execute($data);
        
        //DB接続を切断
        $dbh=null;
        
        print 'リクエストを送りました。 <br />';
        
    }
    //サーバーエラー時の対策
    catch(Exception $e)
    {
        
        print 'ただいま障害により大変ご迷惑をお掛けしています。';
        exit();
    }
    ?>
        <a href="lesson_list.php">戻る</a>

</body>

</html>