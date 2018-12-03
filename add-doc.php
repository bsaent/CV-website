<?php
include('./classes/DB.php');
include('./classes/Login.php');
$username = "";


if (isset($_GET['username'])) {
        if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))) {
                $username = DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['username'];
                $userid = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['id'];
				$result = DB::query("SELECT * FROM posts WHERE user_id = $userid");
				$no = count($result);
				
				if ($no != 0) {
			
						die ("already submitted");			
										}
			  
						
	
                if (isset($_POST['post'])) {
                        $postbody = $_POST['postbody'];
                        $unichoice = $_POST['uni'];
                        $loggedInUserId = Login::isLoggedIn();

                        if (strlen($postbody) > 160 || strlen($postbody) < 1) {
                                 die ("Incorect Length");
                        }                        
						if ($no = 0) {
							
							
                        if ($loggedInUserId == $userid) {
                                DB::query('INSERT INTO posts VALUES (\'\', :postbody, :uni, NOW(), :userid)', array(':postbody'=>$postbody, ':uni'=>$unichoice, ':userid'=>$userid));
                        } else {
                                 header("Location: login.php");
;
                        }
                }
              
                }
                }
          
}
?>

<h1><?php echo $username; ?>'s Profile</h1>

        
<form action="profile.php?username=<?php echo $username; ?>" method="post">
        <textarea name="postbody" rows="8" cols="80"></textarea>
                <hr />

  <select name="uni">
    <option value="volvo">Volvo XC90</option>
    <option value="saab">Saab 95</option>
    <option value="mercedes">Mercedes SLK</option>
    <option value="audi">Audi TT</option>
  </select>

                          <hr />

            <input type="submit" name="post" value="Post">

</form>
