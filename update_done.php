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
        $name=$_POST['name'];
        $email=$_POST['email'];
        $sex=$_POST['sex'];
        $age=$_POST['age'];
        $main=$_POST['main'];
        $sub=$_POST['sub'];
        $picture=$_POST['picture_name'];
        
        //SQLを使ってデータの追加
        $sql='UPDATE user SET name=?,email=?,sex=?,age=?,main_language=?,sub_language=?,picture=? WHERE id=?';
        $stmt=$dbh->prepare($sql);
        $data[]=$name;
        $data[]=$email;
        $data[]=$sex;
        $data[]=$age;
        $data[]=$main;
        $data[]=$sub;
        $data[]=$picture;
        $data[]=$id;
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
        <a href="mypage.php">マイページへ</a>
        <br />
        <a href="lesson_list.php">レッスン一覧へ</a>
</body>

</html>