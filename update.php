<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>更新画面</title>
</head>

<body>
    <?php
    session_start();
    session_regenerate_id();
    $id=$_SESSION['id'];
    
    //自作関数の読み込み
    require_once('function/function.php');
    
    //SQLを使ってデータの取得
    $sql='SELECT * FROM user WHERE id=?';
    $stmt=$dbh->prepare($sql);
    $data[]=$id;
    $stmt->execute($data);
    
    //$stmtから一行レコードを取り出し
    $rec=$stmt->fetch(PDO::FETCH_ASSOC);
    $name=$rec['name'];
    $email=$rec['email'];
    $sex=$rec['sex'];
    $age=$rec['age'];
    $main=$rec['main_language'];
    $sub=$rec['sub_language'];
    
    //項目を日本語に変換
    //性別
    $sex_jp=sex($sex);
    //得意な言語
    $main_jp=main($main);
    //学びたい言語
    $sub_jp=sub($sub);
    
    //DB接続を切断
    $dbh=null;
    
    ?>
        情報の更新
        <br />
        <br />
        <form method="post" action="update_check.php" enctype="multipart/form-data">
            お名前を入力してください。
            <br />
            <input type="text" name="name" style="width:200px" value="<?php print $name;?>">
            <br /> メールアドレスを入力してください。
            <br />
            <input name="email" type="text" style="width:200px" value="<?php print $email; ?>">
            <br /> 性別を教えてください。
            <br />
            <select name="sex">
                <option value="1">男性</option>
                <option value="2">女性</option>
            </select>
            <br /> 年齢を教えてください。
            <br />
            <input name="age" type="text" style="width:50px" value="<?php print $age; ?>">
            <br /> 得意な言語を選択してください
            <br />
            <select name="main">
                <option value="1">日本語</option>
                <option value="2">英語</option>
                <option value="3">中国語</option>
            </select>
            <br />学びたい言語を選択してください
            <br />
            <select name="sub">
                <option value="1">日本語</option>
                <option value="2">英語</option>
                <option value="3">中国語</option>
            </select>
            <br />プロフィール画像を登録してください
            <br />
            <input type="file" name="picture" style="width:400px">
            <br />
            <input type="button" onclick="history.back()" value="戻る">
            <input type="submit" name="update" value="更新">
        </form>

</body>

</html>