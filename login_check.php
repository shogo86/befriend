<?php
//自作関数の読み込み
require_once('function/function.php');

try
    
{
    $email=$_POST['email'];
    $pass=$_POST['pass'];
    
    $email=htmlspecialchars($email);
    $pass=htmlspecialchars($pass);
    
    $pass=md5($pass);
    
    //SQLでデータの取得
    $sql='SELECT * FROM user WHERE email=:email AND password=:password';
    $stmt=$dbh->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $pass);
    $stmt->execute();
    
    //DB接続を切断
    $dbh=null;
    
    //$stmtから一行レコードを取り出し
    $rec=$stmt->fetch(PDO::FETCH_ASSOC);
    
    if($rec==false)
    {
        print $rec;
        print 'メールアドレスかパスワードが間違っています。<br />';
        print '<a href="toppage.php#login">戻る</a>';
        
    }
    else
    {
        session_start();
        $_SESSION['login']=1;
        $_SESSION['id']=$rec['id'];
        $_SESSION['email']=$email;
        $_SESSION['name']=$rec['name'];
        $_SESSION['main']=$rec['main_language'];
        $_SESSION['sub']=$rec['sub_language'];
        header('Location:lesson_list.php');
        
    }
    
}
catch(Exception $e)
{
    print 'ただいま障害により大変ご迷惑をお掛けしています';
    exit();
     
    
}
?>