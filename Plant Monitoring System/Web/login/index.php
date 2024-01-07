<?php
session_start();
setcookie('uid', 0, time(), '/');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Plant Monitoring ~ Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />

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
	<script src="../js/sweetalert.min.js"></script>

	<meta name="robots" content="noindex, follow">
	<script nonce="b076cf1a-bf92-4313-b747-09e12026308b">
		(function(w, d) {
			! function(bb, bc, bd, be) {
				bb[bd] = bb[bd] || {};
				bb[bd].executed = [];
				bb.zaraz = {
					deferred: [],
					listeners: []
				};
				bb.zaraz.q = [];
				bb.zaraz._f = function(bf) {
					return async function() {
						var bg = Array.prototype.slice.call(arguments);
						bb.zaraz.q.push({
							m: bf,
							a: bg
						})
					}
				};
				for (const bh of ["track", "set", "debug"]) bb.zaraz[bh] = bb.zaraz._f(bh);
				bb.zaraz.init = () => {
					var bi = bc.getElementsByTagName(be)[0],
						bj = bc.createElement(be),
						bk = bc.getElementsByTagName("title")[0];
					bk && (bb[bd].t = bc.getElementsByTagName("title")[0].text);
					bb[bd].x = Math.random();
					bb[bd].w = bb.screen.width;
					bb[bd].h = bb.screen.height;
					bb[bd].j = bb.innerHeight;
					bb[bd].e = bb.innerWidth;
					bb[bd].l = bb.location.href;
					bb[bd].r = bc.referrer;
					bb[bd].k = bb.screen.colorDepth;
					bb[bd].n = bc.characterSet;
					bb[bd].o = (new Date).getTimezoneOffset();
					if (bb.dataLayer)
						for (const bo of Object.entries(Object.entries(dataLayer).reduce(((bp, bq) => ({
								...bp[1],
								...bq[1]
							})), {}))) zaraz.set(bo[0], bo[1], {
							scope: "page"
						});
					bb[bd].q = [];
					for (; bb.zaraz.q.length;) {
						const br = bb.zaraz.q.shift();
						bb[bd].q.push(br)
					}
					bj.defer = !0;
					for (const bs of [localStorage, sessionStorage]) Object.keys(bs || {}).filter((bu => bu.startsWith("_zaraz_"))).forEach((bt => {
						try {
							bb[bd]["z_" + bt.slice(7)] = JSON.parse(bs.getItem(bt))
						} catch {
							bb[bd]["z_" + bt.slice(7)] = bs.getItem(bt)
						}
					}));
					bj.referrerPolicy = "origin";
					bj.src = "../../../cdn-cgi/zaraz/sd0d9.js?z=" + btoa(encodeURIComponent(JSON.stringify(bb[bd])));
					bi.parentNode.insertBefore(bj, bi)
				};
				["complete", "interactive"].includes(bc.readyState) ? zaraz.init() : bb.addEventListener("DOMContentLoaded", zaraz.init)
			}(w, d, "zarazData", "script");
		})(window, document);
	</script>
</head>

<body>
	<?php
	include '../php/connect.php';
	if (isset($_POST['submit'])) {
		$email = mysqli_real_escape_string($conn, htmlentities($_POST['email']));
		$password = mysqli_real_escape_string($conn, htmlentities($_POST['password']));
		$pwd_hash = md5($password);

		$_SESSION['email'] = $email;

		$query = "SELECT `password`,`uid` FROM `users` WHERE `email`='$email'";
		if ($query_run = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($query_run) == 0) {
				unset($_SESSION['email']);
				?>
				<script type="text/javascript">
					document.addEventListener("DOMContentLoaded", function(event) {
						swal("", "Incorrect Email", "error");
					})
				</script>
				<?php
			} else if (mysqli_num_rows($query_run) == 1) {
				$row = mysqli_fetch_array($query_run);
				if ($pwd_hash == $row['password']) {
					// $_SESSION['uid'] = $row['uid'];
					setcookie('uid', $row['uid'], time() + (86400 * 30), '/');
					unset($_SESSION['email']);

				?>
					<script type="text/javascript">
						document.addEventListener("DOMContentLoaded", function(event) {
							swal("LOGIN SUCCESS", "Please Wait...", "success");
							setTimeout(function() {
								window.location = "../dashboard.php";
							}, 2000);
						});
					</script>
				<?php
				} else {
				?>
					<script type="text/javascript">
						swal("", "Incorrect Password", "error");
					</script>
	<?php
				}
			}
		} else {
			die(mysqli_error($conn));
		}
	}
	?>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-90 p-b-30">
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="login100-form validate-form">
					<span class="login100-form-title p-b-40">
						Login
					</span>
					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter email: ex@abc.xyz">
						<input class="input100" type="email" name="email" placeholder="Email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>">
						<span class="focus-input100"></span>
					</div>
					<div class="wrap-input100 validate-input m-b-20" data-validate="Please enter password">
						<span class="btn-show-pass">
							<i class="fa fa fa-eye"></i>
						</span>
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" name="submit">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>

	<script src="vendor/animsition/js/animsition.min.js"></script>

	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>

	<script src="vendor/select2/select2.min.js"></script>

	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>

	<script src="vendor/countdowntime/countdowntime.js"></script>

	<script src="js/main.js"></script>

	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'UA-23581568-13');
	</script>
	<script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317" integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA==" data-cf-beacon='{"rayId":"82438aed0b6063cc","b":1,"version":"2023.10.0","token":"cd0b4b3a733644fc843ef0b185f98241"}' crossorigin="anonymous"></script>
</body>

</html>