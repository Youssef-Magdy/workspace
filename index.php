<!DOCTYPE html>
<html lang="en-us" id="lock-page">
	<head>
		<meta charset="utf-8">
		<title> Work Space</title>
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		
		<!-- #CSS Links -->
		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/font-awesome.min.css">

		<!-- SmartAdmin Styles : Caution! DO NOT change the order -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production-plugins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-skins.min.css">

		<!-- SmartAdmin RTL Support -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-rtl.min.css"> 

		<!-- We recommend you use "your_style.css" to override SmartAdmin
		     specific styles this will also ensure you retrain your customization with each SmartAdmin update.
		<link rel="stylesheet" type="text/css" media="screen" href="css/your_style.css"> -->

		<!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/demo.min.css">

		<!-- page related CSS -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/lockscreen.min.css">

		<!-- #FAVICONS -->
		<link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
		<link rel="icon" href="img/favicon/favicon.ico" type="image/x-icon">

		<!-- #GOOGLE FONT -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

		<!-- #APP SCREEN / ICONS -->
		<!-- Specifying a Webpage Icon for Web Clip 
			 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
		<link rel="apple-touch-icon" href="img/splash/sptouch-icon-iphone.png">
		<link rel="apple-touch-icon" sizes="76x76" href="img/splash/touch-icon-ipad.png">
		<link rel="apple-touch-icon" sizes="120x120" href="img/splash/touch-icon-iphone-retina.png">
		<link rel="apple-touch-icon" sizes="152x152" href="img/splash/touch-icon-ipad-retina.png">
		
		<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		
		<!-- Startup image for web apps -->
		<link rel="apple-touch-startup-image" href="img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
		<link rel="apple-touch-startup-image" href="img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
		<link rel="apple-touch-startup-image" href="img/splash/iphone.png" media="screen and (max-device-width: 320px)">

	</head>
	
	<body>
<?php
ob_start();
session_start();
    include "connect.php";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['user'];
    $pass = $_POST['pass'];
    //check if user in database//
    $stmt = $con->prepare('SELECT * from admin WHERE username=? AND password=?');
    $stmt->execute(array($username, $pass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    //    ///// Include news records ////
    //    mysqli_select_db($website, $database_website);
    //    $query_news1 = "SELECT  employee_ID , empolyee_pass from employees WHERE employee_ID=$username AND empolyee_pass=$pass";
    //    $news1 = mysqli_query($website, $query_news1) or die(mysqli_error($news1));
    //    $row = mysqli_fetch_assoc($news1);
    ////// End of include the settings table ///

    if (!empty($row))  {
    $_SESSION['username'] = $username;
        echo "<script type='text/javascript'> window.location.href = 'member.php'</script>";
    } else {
    echo "<div class='alert alert-danger alert-dismissible ' style=' max-width: 320px ; text-align: center; margin: auto'>
        اسم مستخدم او كلمة السر غير صحيحة
    </div>";
        echo "<script type='text/javascript'> window.location.href = 'index.php'</script>";
    }
    }
    ?>


    <div id="main" role="main">

			<!-- MAIN CONTENT -->

			<form class="lockscreen animated flipInY" action="<?php $_SERVER['PHP_SELF'] ?> " method="POST">
				<div class="logo">
					<h1 class="semi-bold"><img src="img/logo-o.png" alt="" /> Work Space</h1>
				</div>
				<div>
					<img src="img/avatars/sunny-big.png" alt="" width="120" height="120" />
					<div>
						<h1><i class="fa fa-user fa-2x text-muted air air-top-right hidden-mobile"></i>John Doe <small><i class="fa fa-lock text-muted"></i> &nbsp;Locked</small></h1>

                        <div class="form-group" >
                            <input class="form-control" name="user" type="text" placeholder="username">
                        </div>

						<div class="input-group" >
                            <input class="form-control" type="password" name="pass" placeholder="Password">
							<div class="input-group-btn">
								<input class="btn btn-primary" type="submit">
									<i class="fa fa-key"></i>
								</input>
							</div>
						</div>
						<p class="no-margin margin-top-5">
							Logged as someone else? <a> Click here</a>
						</p>
					</div>

				</div>
				<p class="font-xs margin-top-5">
					Copyright SmartAdmin 2019-2020.

				</p>
			</form>

		</div>

		<!--================================================== -->	

		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
		<script src="js/plugin/pace/pace.min.js"></script>

	    <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
	    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script> if (!window.jQuery) { document.write('<script src="js/libs/jquery-2.1.1.min.js"><\/script>');} </script>

	    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<script> if (!window.jQuery.ui) { document.write('<script src="js/libs/jquery-ui-1.10.3.min.js"><\/script>');} </script>

		<!-- IMPORTANT: APP CONFIG -->
		<script src="js/app.config.js"></script>

		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events 		
		<script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> -->

		<!-- BOOTSTRAP JS -->		
		<script src="js/bootstrap/bootstrap.min.js"></script>

		<!-- JQUERY VALIDATE -->
		<script src="js/plugin/jquery-validate/jquery.validate.min.js"></script>
		
		<!-- JQUERY MASKED INPUT -->
		<script src="js/plugin/masked-input/jquery.maskedinput.min.js"></script>
		
		<!--[if IE 8]>
			
			<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
			
		<![endif]-->

		<!-- MAIN APP JS FILE -->
		<script src="js/app.min.js"></script>

	</body>
</html>