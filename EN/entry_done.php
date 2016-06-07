<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>エントリー画面</title>
</head>

<body>
    <?php
    //自作関数の読み込み
    require_once('function/function.php');
    
    //サーバーエラー時の対策
    try
    {
        //データの受け取り
        $name=$_POST['name'];
        $email=$_POST['email'];
        $pass=$_POST['pass'];
        $main=$_POST['main'];
        $sub=$_POST['sub'];
        //入力データのサニタイジング
        $email=htmlspecialchars($email);
        $pass=htmlspecialchars($pass);
        
        //SQLを使ってデータの追加
        $sql='INSERT INTO user(name,email,password,main_language,sub_language) VALUES (?,?,?,?,?)';
        $stmt=$dbh->prepare($sql);
        $data[]=$name;
        $data[]=$email;
        $data[]=$pass;
        $data[]=$main;
        $data[]=$sub;
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
        <a href="toppage.php">戻る</a>

</body>

</html>