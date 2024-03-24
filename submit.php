<!DOCTYPE html>
<html lang="en">
		<head>
				<meta charset="utf-8">
				<title>Amatl</title>
				<link rel="stylesheet" href="style.css">
		</head>
		<body>
				<header>
						<a href="index.php"><h2>Tny</h2></a>
						<nav>
								<ul class="menu">
										<li><a href="about.php">About</a></li>
										<li><a href="tutorial.php">Tutorial</a></li>
										<li><a href="reference.php">Reference</a></li>
										<li><a href="https://sr.ht/~m15o/Amatl/">Download</a></li>
										<li><a href="ide.html">Web IDE</a></li>
										<li><a href="launcher.php">Launcher</a></li>
										<li><a href="games.php">Games</a></li>
								</ul>
						</nav>
				</header>
				<main>

<h1>Submit a game</h1>
<form action="https://riku.miso.town/submit?user_id=1&label=Amatl" method="post">
    <div class="field">
        <label for="email">Email</label>
        <input type="email" name="email" required>
    </div>
		<div class="field">
				<label for="name">Name</label>
				<input type="name" name="name" required>
		</div>
    <div class="field">
        <label for="source">Source code</label><br>
        <textarea name="source" required rows="25" cols="60"></textarea>
    </div>
    <input type="submit" value="Submit">
</form>

        </main>
		</body>
</html>
