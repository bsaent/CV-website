

<?php
include('./classes/DB.php');
include('./classes/Login.php');
$username = "";
$verified = False;
$isFollowing = False;

if (isset($_GET['username'])) {
        if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))) {
                $username = DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['username'];
                $userid = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['id'];
                	$result = DB::query("SELECT * FROM posts WHERE user_id = $userid");
				$no = count($result);
				
                     if (isset($_POST['post'])) {
                        $postbody = $_POST['postbody'];
                        $unichoice = $_POST['uni'];
                        $loggedInUserId = Login::isLoggedIn();

                        if (strlen($postbody) > 160 || strlen($postbody) < 1) {
                                die('Incorrect length!');
                        }                        
					
							if ($no != 0) {
			
						die ("already submitted");			
										}
					
                        if ($loggedInUserId == $userid) {
                         DB::query('INSERT INTO posts VALUES (\'\', :postbody, :uni, NOW(), :userid)', array(':postbody'=>$postbody, ':uni'=>$unichoice, ':userid'=>$userid));
                       
                        } else {
                                                                 header("Location: login.php");
;
                        }
                }
              
                }
                ?>
                <link rel="stylesheet" type="text/css" href="menu-style.css">

<body class="news">
  <header>
    <div class="nav">
      <ul>
        <li class="tutorials"><a href="index.php">Feed</a></li>
         <li class="home"><a class="active" href="<?php echo $test ?>">Profile</a></li>
        <li class="login"><a href="logout.php">Logout</a></li>


      </ul>
    </div>
  </header>
</body>
                
               <?php
                $dbposts = DB::query('SELECT * FROM posts WHERE user_id=:userid ORDER BY id DESC', array(':userid'=>$userid));
                $posts = "";
                foreach($dbposts as $p) {
                
                           $posts .= htmlspecialchars($p['body']).("<hr /></br />").($p['uni_choice']).
                            "<hr /></br />";

                }
        } else {
						  header("Location: create-account.php");
        }
?>

<h1><?php echo $username; ?>'s Profile<?php if ($verified) { echo ' - Verified'; } ?></h1>

        

<div class="posts">
        <?php echo $posts; ?>
