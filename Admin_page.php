<?php
    session_start();
    if(!isset($_SESSION['user_level']) or ($_SESSION['user_level'] != 1)) { //admin can only access
        header("Location: login.php");
        exit();
    }
?>

<!doctype HTML>
<html lang="en">
	<head>
		<title>Rivero Website</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="CSS_registerthanks.css">
	</head>
	<body>
		<div id="container">
			<?php include('header.php'); ?>
			<?php include('nav3.php'); ?> 	 

			<div id="admin-content">
				<center><h2 id="admin-welcome">Welcome Admin</h2></center>
				<h5 id="monado-description">
					The Monado is a powerful energy blade that can manipulate the ether around it, and by doing so, change the material and immaterial shape of the world. One's ability to control the Monado depends on the strength of will of its user; most Homs who try to use the sword cannot control it. At the beginning of the game, the Monado cannot harm any of the sentient beings (Homs, High Entia, and Nopon) of Bionis.

					The Monado grants its elected wielder the power of foresight. It is said that this is possible because all of the ether in the world is calculable in its changes. This allows the user to see where every ether particle is, was, and will be.

					According to Alvis, the Monado emits a particular ether wavelength in its ground state that attracts Telethia. Also, the Monado can be counteracted by opposing particles to that of the Monado.
				</h5>

</br>	<center><img id="monado-image" src="dashboard.png" width="500" height="300"></center>
			</div>

			<?php include('footer.php'); ?>
		</div>
	</body>
</html>
