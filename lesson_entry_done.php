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
        $title=$_POST['title'];
        $starttime=$_POST['starttime'];
        $time=$_POST['time'];
        $location=$_POST['location'];
        $detail=$_POST['detail'];
        
        //SQLを使ってデータの追加
        $sql='INSERT INTO lesson(user_id,title,start_time,time,location,detail) VALUES (?,?,?,?,?,?)';
        $stmt=$dbh->prepare($sql);
        $data[]=$id;
        $data[]=$title;
        $data[]=$starttime;
        $data[]=$time;
        $data[]=$location;
        $data[]=$detail;
        $stmt->execute($data);
        
        //DB接続を切断
        $dbh=null;
        
        print '追加しました。 <br />';
        
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