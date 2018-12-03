
<?php
include('./classes/DB.php');
include('./classes/Login.php');
$showTimeline = False;
$username = "";


if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
        $showTimeline = True;
        $username = DB::query('SELECT username FROM users WHERE id=:username', array(':username'=>$userid))[0]['username'];
         $test = "profile.php?username=$username";
         $test1 = "logout.php";
         $test2 = "Logout";

} else {
		         $test = "login.php";
		         $test1 = "login.php";
		         $test2 = "Login";

}
if (isset($_GET['postid'])) {
        Post::likePost($_GET['postid'], $userid);
        
}
if (isset($_POST['searchbox'])) {
        $tosearch = explode(" ", $_POST['searchbox']);
        if (count($tosearch) == 1) {
                $tosearch = str_split($tosearch[0], 2);
        }
        $whereclause = "";
        $paramsarray = array(':username'=>'%'.$_POST['searchbox'].'%');
        for ($i = 0; $i < count($tosearch); $i++) {
                $whereclause .= " OR username LIKE :u$i ";
                $paramsarray[":u$i"] = $tosearch[$i];
        }
        $users = DB::query('SELECT users.username FROM users WHERE users.username LIKE :username '.$whereclause.'', $paramsarray);
        print_r($users);
        $whereclause = "";
        $paramsarray = array(':body'=>'%'.$_POST['searchbox'].'%');
        for ($i = 0; $i < count($tosearch); $i++) {
                if ($i % 2) {
                $whereclause .= " OR body LIKE :p$i ";
                $paramsarray[":p$i"] = $tosearch[$i];
                }
        }
        $posts = DB::query('SELECT posts.body FROM posts WHERE posts.body LIKE :body '.$whereclause.'', $paramsarray);
        echo '<pre>';
        print_r($posts);
        echo '</pre>';
}
$followingposts = DB::query('SELECT posts.id, posts.body, posts.uni_choice, users.`username` FROM users, posts
WHERE users.id = posts.user_id
ORDER BY posts.id DESC;');



?>
  <link rel="stylesheet" type="text/css" href="menu-style.css">

<body class="news">
  <header>
    <div class="nav">
      <ul>
        			<li class="feed"><a class="active" href="index.php">Feed</a></li>
                    <li class="profile"><a href="<?php echo $test ?>">Profile</a></li>
					  <li class="login"><a href="<?php echo $test1 ?>"><?php echo $test2 ?></a></li>

      </ul>
    </div>
    
  </header>
</body>



<?php
foreach ($followingposts as $posts) {
        echo '<a href="profile.php?username='.$posts['username'].'">'.$posts['username'].'</a>'."<br />".$posts['uni_choice']."<br />".($posts['body'])."<hr />";
        }
        ?>