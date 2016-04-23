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
        $request_lesson_id=$_POST['request_lesson_id'];
        $matching=$_POST['matching'];
        
        //SQLを使ってデータの追加
        $sql='UPDATE lesson_request SET matching=? WHERE id=?';
        $stmt=$dbh->prepare($sql);
        $data[]=$matching;
        $data[]=$request_lesson_id;

        $stmt->execute($data);
        
        //DB接続を切断
        $dbh=null;
        
        if($matching=1)
        {
        print 'リクエストを承認しました。 <br />';
        }else{
        print 'リクエストを拒否しました。 <br />';
        }
        
    }
    //サーバーエラー時の対策
    catch(Exception $e)
    {
        
        print 'ただいま障害により大変ご迷惑をお掛けしています。';
        exit();
    }
    ?>
        <a href="mypage.php">戻る</a>

</body>

</html>