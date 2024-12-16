<?php
	session_start();
	include "../config/config.php";
	include "./classes/Db.class.php";
	include ROOT."/include/function.php";
	

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$username = postIndex('username');
        $password = postIndex('password');

		if($username && $password) {
			$db = new Db();
			$sql = "SELECT * FROM admin WHERE ten_dang_nhap = :username AND mat_khau = :password";
			$user = $db->selectOne($sql, [
				':username' => $username,
				':password' => md5($password), 
			]);
			if ($user) {
				$_SESSION['admin_logged_in'] = true;
				$_SESSION['admin_username'] = $user['ten_dang_nhap'];
	
				header('Location: index.php');
				exit();
			} else {
				$error = 'Sai tên đăng nhập hoặc mật khẩu.';
			}
		}
		else {
			$error = 'Vui lòng nhập đầy đủ thông tin.';
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<title>Admin | Sign In</title>
		
	  
		<link rel="stylesheet" href="resources/css/reset.css" type="text/css" media="screen" />
	  
		<link rel="stylesheet" href="resources/css/style.css" type="text/css" media="screen" />
		
		<link rel="stylesheet" href="resources/css/invalid.css" type="text/css" media="screen" />	
	
	  
		
	
		
	</head>
  
	<body id="login">
		
		<div id="login-wrapper" class="png_bg">
			<div id="login-top">
				<img id="logo" src="../images/Logo.png" alt="logo" />  
			</div> 
			
			<div id="login-content">
				<h4 class="title-login">Admin - Sign In</h4>
				<form action="" method="post">
				
					<div class="notification information png_bg">
						<?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
					</div>
					
					<p>
						<label>Username: </label>
						<input class="text-input" type="text" name="username" />
					</p>
					<div class="clear"></div>
					<p>
						<label>Password: </label>
						<input class="text-input" type="password" name="password" />
					</p>
					<div class="clear"></div>
					
					<div class="clear"></div>
					<p>
						<input class="button" type="submit" value="Sign In" />
					</p>
					
				</form>
			</div> <!-- End #login-content -->
			
		</div> <!-- End #login-wrapper -->
		
  </body>
  </html>
