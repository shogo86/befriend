<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>ログインチェック</title>
</head>

<body>
    <?php
    //セッションスタート
    session_start();
    session_regenerate_id();
    $id=$_SESSION['id'];
    
    //自作関数の読み込み
    require_once('function/function.php');
    
    //データの受け取り
    $name=$_POST['name'];
    $email=$_POST['email'];
    $sex=$_POST['sex'];
    $age=$_POST['age'];
    $main=$_POST['main'];
    $sub=$_POST['sub'];
    $picture=$_FILES['picture'];
    
    $name=htmlspecialchars($name);
    $email=htmlspecialchars($email);
    
    if($name=='')
    {
        print '名前が入力されていません。<br />';
    }
    else
    {
        print '名前：';
        print $name;
        print '<br />';
        
    }
    
    
    if($email=='')
    {
        print 'emailが入力されていません。<br />';
    }
    else
    {
        print 'email：';
        print $email;
        print '<br />';
        
    }
    
    if($picture['size']>0)
    {
        if($picture['size']>10000000)
        {
            print '画像が大きすぎます';
        }
        else
        {
            move_uploaded_file($picture['tmp_name'],'./picture/'.$picture['name']);
            print '<img src="./picture/'.$picture['name'].'">';
            print '<br />';
            print $picture['name'];
        }
    }
    
    
    if($name==''||$email==''||$picture['size']<1)
    {
        print '<form>';
        print '<input type="button" onclick="history.back()" value="戻る">';
        print '</form>';
    }
    else
    {
        print '<form method="post" action="update_done.php">';
        print '<input type="hidden" name="name" value="'.$name.'">';
        print '<input type="hidden" name="email" value="'.$email.'">';
        print '<input type="hidden" name="sex" value="'.$sex.'">';
        print '<input type="hidden" name="age" value="'.$age.'">';
        print '<input type="hidden" name="main" value="'.$main.'">';
        print '<input type="hidden" name="sub" value="'.$sub.'">';
        print '<input type="hidden" name="picture_name" value="'.$picture['name'].'">';
        print '<br />';
        print '<input type="button" onclick="history.back()" value="戻る">';
        print '<input type="submit" value="OK">';
        print '</form>';
    }
    
    ?>


</body>

</html>