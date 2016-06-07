<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>レッスン登録チェック</title>
</head>

<body>
    <?php
    //自作関数の読み込み
    require_once('function/function.php');
    
    session_start();
    session_regenerate_id();
    
    $title=$_POST['title'];
    $starttime=$_POST['starttime'];
    $time=$_POST['time'];
    $location=$_POST['location'];
    $detail=$_POST['detail'];
    
    $title=htmlspecialchars($title);
    $starttime=htmlspecialchars($starttime);
    $time=htmlspecialchars($time);
    $location=htmlspecialchars($location);
    $detail=htmlspecialchars($detail);
    
    
    if($title=='')
    {
        print 'レッスン名が入力されていません。<br />';
    }
    else
    {
        print 'レッスン名：';
        print $name;
        print '<br />';
        
    }
    
    
    if($starttime=='')
    {
        print '日時が入力されていません。<br />';
    }
    else
    {
        print '日時：';
        print $starttime;
        print '<br />';
        
    }
    
    if($time==0)
    {
        print 'レッスン時間が入力されていません。<br />';
    }
    
    if($location=='')
    {
        print '場所が入力されていません。<br />';
    }
    else
    {
        print '場所：';
        print $location;
        print '<br />';
        
    }
    
    
    if($title==''||$starttime==''||$time==0||$location=='')
    {
        print '<form>';
        print '<input type="button" onclick="history.back()" value="戻る">';
        print '</form>';
    }
    else
    {
        print '<form method="post" action="lesson_entry_done.php">';
        print '<input type="hidden" name="title" value="'.$title.'">';
        print '<input type="hidden" name="starttime" value="'.$starttime.'">';
        print '<input type="hidden" name="time" value="'.$time.'">';
        print '<input type="hidden" name="location" value="'.$location.'">';
        print '<input type="hidden" name="detail" value="'.$detail.'">';
        print '<br />';
        print '<input type="button" onclick="history.back()" value="戻る">';
        print '<input type="submit" value="OK">';
        print '</form>';
    }
    
    ?>


</body>

</html>