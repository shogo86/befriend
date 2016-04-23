<?php



//性別の関数（日本語表示）
function sex($sex){
    if($sex==0)
    {
        $sex_jp="入力なし";
    }
    if($sex==1)
    {
        $sex_jp="男性";
    }
    if($sex==2)
    {
        $sex_jp="女性";
    }
    return($sex_jp);
    
}

//得意な言語の関数（日本語表示）
function main($main){
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

//学びたい言語の関数（日本語表示）
function sub($sub){
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

//DB接続をする
$dsn='mysql:dbname=language_db;host=localhost';
$user='root';
$password='root';
$dbh=new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');

//DB接続をする
$pdo = new PDO('mysql:dbname=language_db;host=localhost','root','root');

?>