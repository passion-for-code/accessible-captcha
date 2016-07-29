<html>
	<head>
		<title>Captcha-Beispiele auf deutsch </title>
		<meta charset="UTF8">
	</head>
	<body>
<?php
include("../AccessibleCaptcha.php");

$c = new De\PassionForCode\AccessibleCaptcha('german');
if($_POST) {
	if($c->checkResult() ) {
		echo "<p>Richtig!</p>";
	} else {
		echo "<p>Falsch!</p>";
	}
}
?>
		<form method='post'>
			<?php echo $c->getCaptcha(); ?>
			<p><input type='submit' value='Absenden'>
		</form>
	</body>
</html>