<html>
	<head>
		<title>Captcha examples in English</title>
		<meta charset="UTF8">
	</head>
	<body>
<?php
include("../AccessibleCaptcha.php");

$c = new De\PassionForCode\AccessibleCaptcha('english');
if($_POST) {
	if($c->checkResult() ) {
		echo "<p>Correct!</p>";
	} else {
		echo "<p>Wrong!</p>";
	}
}
?>
		<form method='post'>
			<?php echo $c->getCaptcha(); ?>
			<p><input type='submit' value='Send'>
		</form>
	</body>
</html>