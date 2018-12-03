<?php
include('classes/DB.php');
if (isset($_POST['createaccount'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        if (!DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {
                if (strlen($username) >= 3 && strlen($username) <= 32) {
                        if (preg_match('/[a-zA-Z0-9_]+/', $username)) {
                                if (strlen($password) >= 6 && strlen($password) <= 60) {
                                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                if (!DB::query('SELECT email FROM users WHERE email=:email', array(':email'=>$email))) {
                                        DB::query('INSERT INTO users VALUES (\'\', :username, :password, :email)', array(':username'=>$username, ':password'=>password_hash($password, PASSWORD_BCRYPT), ':email'=>$email));
                                if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {
                if (password_verify($password, DB::query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password'])) {
                        echo 'Logged in!';
                        $cstrong = True;
                        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                        $user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];
                        DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
                        setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                        setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);     
                        }}   
						  header("Location: add-doc.php?username=$username");
;
                                } else {
                                        echo 'Email in use!';
                                }
                        } else {
                                        echo 'Invalid email!';
                                }
                        } else {
                                echo 'Invalid password!';
                        }
                        } else {
                                echo 'Invalid username';
                        }
                } else {
                        echo 'Invalid username';
                }
        } else {
                echo 'User already exists!';
        }
}
?>




<html >
<head>
  <meta charset="UTF-8">
  <title>Signup Form</title>
  
  
  
      <link rel="stylesheet" href="style.css">

  
</head>

<body>
  <link href='https://fonts.googleapis.com/css?family=Montserrat:700' rel='stylesheet' type='text/css'>

<main>
  <figure>
    <picture>
      <source  media="(min-width: 768px)"
              srcset="//assets.petermueller.io/codepen/dailyui-001/img.png     340w,
                      //assets.petermueller.io/codepen/dailyui-001/img@2x.png  680w,
                      //assets.petermueller.io/codepen/dailyui-001/img@3x.png 1020w"
               sizes="360px" />
      <source srcset="//assets.petermueller.io/codepen/dailyui-001/img-small.png     340w,
                      //assets.petermueller.io/codepen/dailyui-001/img-small@2x.png  680w,
                      //assets.petermueller.io/codepen/dailyui-001/img-small@3x.png 1020w"
               sizes="(min-width: 320px) 290px,
                      (min-width: 480px) 435px
                      (min-width: 640px) 580px" />
      <img       src="//assets.petermueller.io/codepen/dailyui-001/img.png"
                 alt="Citymap illustration" />
    </picture>
  </figure>
  <div class="headline">
    <h2 class="text-headline">Website Test</h2>
    <h3 class="text-subheadline"> The Webby Website Web Website</h2>
  </div>
<form action="create-account.php" method="post">

    <span>
          <label for="username" class="text-small-uppercase">Username</label>
<input class="text-body" type="text" name="username" value="" ><p />
    </span>
    
    
    <span>
      <label for="email" class="text-small-uppercase">Email</label>
<input class="text-body" type="email" name="email" value="" ><p />
    </span>
    
    
    <span>
      <label for="password" class="text-small-uppercase">Password</label>
    
<input class="text-body" type="text" name="password" value="" ><p />

    </span>
    
    
    <input class="text-small-uppercase" type="submit" name="createaccount" value="Create Account">

  </form>
</main>
  
    <script src="index.js"></script>

</body>
</html>
