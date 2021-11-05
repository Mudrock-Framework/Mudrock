<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASE_URL.'/css/messages.css' ?>">
</head>
<body>
    <div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h1><?php echo $code ?></h1>
			</div>
			<h2><?php echo $message ?></h2>
			<p class="description"><?php echo $description ?></p>
		</div>
	</div>
</body>
</html>