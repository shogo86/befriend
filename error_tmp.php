<div class="wrapper clearfix">
            <main class="main">
                <ul class = "mypage_gnav">
                    <li><a href="mypage.php">レッスンを承認する</a></li>
                    <li><a href="mypage_lesson_plans.php">参加予定のレッスン</a></li>
                    <li><a href="mypage_lesson_past.php">参加済みのレッスン</a></li>
                    <li><a href="mypage_lesson_all.php">登録済みのレッスン</a></li>
                    <li><a href="">メッセージ</a></li>
                    <li><a href="mypage_profile.php">プロフィール</a></li>
                </ul>
                
                <div class = "profile_picture">
                    <div>
                        <img src ="<?php print $picture_1; ?>" id="bigimg">
                    </div>
                    <ul>
                        <li><img src="<?php print $picture_1; ?>" class="thumb" data-image="<?php print $picture_1; ?>"></li>
                        <li><img src="<?php print $picture_2; ?>" class="thumb" data-image="<?php print $picture_2; ?>"></li>
                        <li><img src="<?php print $picture_3; ?>" class="thumb" data-image="<?php print $picture_3; ?>"></li>
                        <li><img src="<?php print $picture_4; ?>" class="thumb" data-image="<?php print $picture_4; ?>"></li>
                    </ul>
                    
                </div>
                
                <div class = "profile_text">
                    <p class = "desc">名前</p>
                </div>
            
                 </main>
                </div>
                
                <?php
                    print '<div class = "profile_text">';
                    print '<p class = "desc">名前'.$fb_name.'</p>';
                    print '<p class = "desc">email'.$email.'</p>';
                    print '<p class = "desc">性別'.$gender.'</p>';
                    print '<p class = "desc">年齢'.$age.'</p>';
                    print '<p class = "desc">得意な言語'.$main_jp.'</p>';
                    print '<p class = "desc">学びたい言語'.$sub_jp.'</p>';
                    print '<p class = "desc">出身国'.$hometown.'</p>';
                    print '<p class = "desc">所在地'.$location.'</p>';
                    print '<p class = "desc">職業'.$works.'</p>';
                    print '<p class = "desc">大学'.$college.'</p>';
                    print '<p class = "desc">趣味'.$hobby.'</p>';
                    print '</div>';
                ?>