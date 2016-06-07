<?php

//エスケープする関数
function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
    }

//ホーム画面へ飛ばす関数
function goHome() {
  header('Location: http://' . $_SERVER['HTTP_HOST']. '/toppage.php');
  exit;
}

//レッスン一覧へ飛ばす関数
function goLessonlist() {
  header('Location: http://' . $_SERVER['HTTP_HOST']. '/lesson_list.php');
  exit;
}

//レッスン時間の分数の変更
function minute($minute){
    if($minute==1)
    {
        $minute_change='0';
    }
    if($minute==2)
    {
        $minute_change='15';
    }
    if($minute==3)
    {
        $minute_change='30';
    }
    if($minute==4)
    {
        $minute_change='45';
    }
    return($minute_change);
}

//レッスン時間の所要時間の変更
function time_change($time){
    if($time==1)
    {
        $time_change='30';
    }
    if($time==2)
    {
        $time_change='60';
    }
    return($time_change);
}

//都道府県の関数
function state_jp($state){
    if($state==1)
    {
        $state_jp='北海道';
    }
    if($state==2)
    {
        $state_jp='青森県';
    }
    if($state==3)
    {
        $state_jp='岩手県';
    }
    if($state==4)
    {
        $state_jp='宮城県';
    }
    if($state==5)
    {
        $state_jp='秋田県';
    }
    if($state==6)
    {
        $state_jp='山形県';
    }
    if($state==7)
    {
        $state_jp='福島県';
    }
    if($state==8)
    {
        $state_jp='茨城県';
    }
    if($state==9)
    {
        $state_jp='栃木県';
    }
    if($state==10)
    {
        $state_jp='群馬県';
    }
    if($state==11)
    {
        $state_jp='埼玉県';
    }
    if($state==12)
    {
        $state_jp='千葉県';
    }
    if($state==13)
    {
        $state_jp='東京都';
    }
    if($state==14)
    {
        $state_jp='神奈川県';
    }
    if($state==15)
    {
        $state_jp='新潟県';
    }
    if($state==16)
    {
        $state_jp='富山県';
    }
    if($state==17)
    {
        $state_jp='石川県';
    }
    if($state==18)
    {
        $state_jp='福井県';
    }
    if($state==19)
    {
        $state_jp='山梨県';
    }
    if($state==20)
    {
        $state_jp='長野県';
    }
    if($state==21)
    {
        $state_jp='岐阜県';
    }
    if($state==22)
    {
        $state_jp='静岡県';
    }
    if($state==23)
    {
        $state_jp='愛知県';
    }
    if($state==24)
    {
        $state_jp='三重県';
    }
    if($state==25)
    {
        $state_jp='滋賀県';
    }
    if($state==26)
    {
        $state_jp='京都府';
    }
    if($state==27)
    {
        $state_jp='大阪府';
    }
    if($state==28)
    {
        $state_jp='兵庫県';
    }
    if($state==29)
    {
        $state_jp='奈良県';
    }
    if($state==30)
    {
        $state_jp='和歌山県';
    }
    if($state==31)
    {
        $state_jp='鳥取県';
    }
    if($state==32)
    {
        $state_jp='島根県';
    }
    if($state==33)
    {
        $state_jp='岡山県';
    }
    if($state==34)
    {
        $state_jp='広島県';
    }
    if($state==35)
    {
        $state_jp='山口県';
    }
    if($state==36)
    {
        $state_jp='徳島県';
    }
    if($state==37)
    {
        $state_jp='香川県';
    }
    if($state==38)
    {
        $state_jp='愛媛県';
    }
    if($state==39)
    {
        $state_jp='高知県';
    }
    if($state==40)
    {
        $state_jp='福岡県';
    }
    if($state==41)
    {
        $state_jp='佐賀県';
    }
    if($state==42)
    {
        $state_jp='長崎県';
    }
    if($state==43)
    {
        $state_jp='熊本県';
    }
    if($state==44)
    {
        $state_jp='大分県';
    }
    if($state==45)
    {
        $state_jp='宮崎県';
    }
    if($state==46)
    {
        $state_jp='鹿児島県';
    }
    if($state==47)
    {
        $state_jp='沖縄県';
    }   
    return($state_jp);
}

//得意な言語の関数（日本語表示）
function main($main){
    if($main=='')
    {
        $main_jp='未入力';
    }
    if($main==1)
    {
        $main_jp='日本語';
    }
    if($main==2)
    {
        $main_jp='英語';
    }
    if($main==3)
    {
        $main_jp='中国語';
    } 
    return($main_jp);
}


//性別の関数（日本語表示）
function gender($gender){
    if($gender=="")
    {
        $gender_jp="未入力";
    }
    if($gender==1)
    {
        $gender_jp="男性";
    }
    if($gender==2)
    {
        $gender_jp="女性";
    }
    return($gender_jp);
    
}


//学びたい言語の関数（日本語表示）
function sub($sub){
    if($sub=='')
    {
        $sub_jp='未入力';
    }
    if($sub==1)
    {
        $sub_jp='日本語';
    }
    if($sub==2)
    {
        $sub_jp='英語';
    }
    if($sub==3)
    {
        $sub_jp='中国語';
    }
    return($sub_jp);
}

//レッスン所用時間（日本語表示）

function jikan($time){
    if($time==1)
    {
        $time_jp='30分';
    }
    if($time==2)
    {
        $time_jp='1時間';
    }
    if($time==3)
    {
        $time_jp='1時間30分';
    }
    if($time==4)
    {
        $time_jp='2時間';
    }
    return($time_jp);
}

function gengo($seireki)
{
    if(1868<=$seireki && $seireki<=1911)
    {
        $gengo='明治';
    }
    
    if(1912<=$seireki && $seireki<=1925)
    {
        $gengo='大正';
    }

    if(1926<=$seireki && $seireki<=1988)
    {
        $gengo='昭和';
    }    

    if(1989<=$seireki)
    {
        $gengo='平成';
    }    
    
    return($gengo);
}

function sanitize($before)
{
    foreach($before as $key=>$value)
    {
        $after[$key]=htmlspecialchars($value);
    }
    return $after;
}

function pulldown_year()
{
    print '<select name="year">';
    print '<option value="2013">2013</option>';
    print '<option value="2014">2014</option>';
    print '<option value="2015">2015</option>';
    print '<option value="2016">2016</option>';
    print '</select>';
}

function pulldown_month()
{
    print '<select name="month">';
    print '<option value="01">01</option>';
    print '<option value="02">02</option>';
    print '<option value="03">03</option>';
    print '<option value="04">04</option>';
    print '<option value="05">05</option>';
    print '<option value="06">06</option>';
    print '<option value="07">07</option>';
    print '<option value="08">08</option>';
    print '<option value="09">09</option>';
    print '<option value="10">10</option>';
    print '<option value="11">11</option>';
    print '<option value="12">12</option>';
    print '</select>';
}

function pulldown_day()
{
    print '<select name="day">';
    print '<option value="01">01</option>';
    print '<option value="02">02</option>';
    print '<option value="03">03</option>';
    print '<option value="04">04</option>';
    print '<option value="05">05</option>';
    print '<option value="06">06</option>';
    print '<option value="07">07</option>';
    print '<option value="08">08</option>';
    print '<option value="09">09</option>';
    print '<option value="10">10</option>';
    print '<option value="11">11</option>';
    print '<option value="12">12</option>';
    print '<option value="13">13</option>';
    print '<option value="14">14</option>';
    print '<option value="15">15</option>';
    print '<option value="16">16</option>';
    print '<option value="17">17</option>';
    print '<option value="18">18</option>';
    print '<option value="19">19</option>';
    print '<option value="20">20</option>';
    print '<option value="21">21</option>';
    print '<option value="22">22</option>';
    print '<option value="23">23</option>';
    print '<option value="24">24</option>';
    print '<option value="25">25</option>';
    print '<option value="26">26</option>';
    print '<option value="27">27</option>';
    print '<option value="28">28</option>';
    print '<option value="29">29</option>';
    print '<option value="30">30</option>';
    print '<option value="31">31</option>';
    print '</select>';
}


?>