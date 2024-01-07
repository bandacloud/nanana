<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>TMS - LOGIN</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="../dashboard/img/logo-ico.png" />

	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">

	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">

	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">

	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">

	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">

	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">

	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">

	<meta name="robots" content="noindex, follow">
	<script nonce="89da6fd6-17f7-477d-b193-1f72a8d67a5e">
		(function(w, d) {
			! function(Z, _, ba, bb) {
				Z.zarazData = Z.zarazData || {};
				Z.zarazData.executed = [];
				Z.zaraz = {
					deferred: [],
					listeners: []
				};
				Z.zaraz.q = [];
				Z.zaraz._f = function(bc) {
					return function() {
						var bd = Array.prototype.slice.call(arguments);
						Z.zaraz.q.push({
							m: bc,
							a: bd
						})
					}
				};
				for (const be of ["track", "set", "debug"]) Z.zaraz[be] = Z.zaraz._f(be);
				Z.zaraz.init = () => {
					var bf = _.getElementsByTagName(bb)[0],
						bg = _.createElement(bb),
						bh = _.getElementsByTagName("title")[0];
					bh && (Z.zarazData.t = _.getElementsByTagName("title")[0].text);
					Z.zarazData.x = Math.random();
					Z.zarazData.w = Z.screen.width;
					Z.zarazData.h = Z.screen.height;
					Z.zarazData.j = Z.innerHeight;
					Z.zarazData.e = Z.innerWidth;
					Z.zarazData.l = Z.location.href;
					Z.zarazData.r = _.referrer;
					Z.zarazData.k = Z.screen.colorDepth;
					Z.zarazData.n = _.characterSet;
					Z.zarazData.o = (new Date).getTimezoneOffset();
					Z.zarazData.q = [];
					for (; Z.zaraz.q.length;) {
						const bl = Z.zaraz.q.shift();
						Z.zarazData.q.push(bl)
					}
					bg.defer = !0;
					for (const bm of [localStorage, sessionStorage]) Object.keys(bm || {}).filter((bo => bo.startsWith("_zaraz_"))).forEach((bn => {
						try {
							Z.zarazData["z_" + bn.slice(7)] = JSON.parse(bm.getItem(bn))
						} catch {
							Z.zarazData["z_" + bn.slice(7)] = bm.getItem(bn)
						}
					}));
					bg.referrerPolicy = "origin";
					bg.src = "../../../cdn-cgi/zaraz/sd0d9.js?z=" + btoa(encodeURIComponent(JSON.stringify(Z.zarazData)));
					bf.parentNode.insertBefore(bg, bf)
				};
				["complete", "interactive"].includes(_.readyState) ? zaraz.init() : Z.addEventListener("DOMContentLoaded", zaraz.init)
			}(w, d, 0, "script");
		})(window, document);
	</script>
</head>

<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<?php include '../php/login-form.php'; ?>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="login100-form validate-form">
					<span class="login100-form-title p-b-34">
						Account Login
					</span>
					<div class="wrap-input100 rs1-wrap-input100 validate-input m-b-20" data-validate="Type user name">
						<input id="first-name" class="input100" type="text" name="username" placeholder="User name" value="<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : '';?>">
						<span class="focus-input100"></span>
					</div>
					<div class="wrap-input100 rs2-wrap-input100 validate-input m-b-20" data-validate="Type password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" name="submit">
							Sign in
						</button>
					</div>
					<div class="w-full text-center p-t-27 p-b-239">
						<span class="txt1">
							Forgot
						</span>
						<a href="#" class="txt2">
							User name / password?
						</a>
					</div>
					<!-- <div class="w-full text-center">
						<a href="#" class="txt3">
							Sign Up
						</a>
					</div> -->
				</form>
				<div class="login100-more" style="background-image: url('images/bg-1.jpg');"></div>
			</div>
		</div>
	</div>
	<div id="dropDownSelect1"></div>

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>

	<script src="vendor/animsition/js/animsition.min.js"></script>

	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});
	</script>

	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>

	<script src="vendor/countdowntime/countdowntime.js"></script>

	<script src="js/main.js"></script>
	<script src="../js/sweetalert.min.js"></script>

	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'UA-23581568-13');
	</script>
	<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vaafb692b2aea4879b33c060e79fe94621666317369993" integrity="sha512-0ahDYl866UMhKuYcW078ScMalXqtFJggm7TmlUtp0UlD4eQk0Ixfnm5ykXKvGJNFjLMoortdseTfsRT8oCfgGA==" data-cf-beacon='{"rayId":"76315e6fdb219cc6","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2022.10.3","si":100}' crossorigin="anonymous"></script>
</body>

</html>