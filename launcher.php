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

<h1>Launcher</h1>

<form>
    <label for="file-upload">Select a ROM:</label>
    <input type="file" id="file-upload" name="file-upload" accept=".rom" />
    <button type="button" onclick="handleFileUpload()">Launch</button>
</form>

<script>
 function handleFileUpload() {
     const fileInput = document.getElementById('file-upload');
     const file = fileInput.files[0];

     if (!file) {
         alert('Please select a file to upload');
         return;
     }

		 const fileReader = new FileReader();
     fileReader.onload = function(event) {
         const fileContent = event.target.result;
				 window.location.href = "emulator.php?r=" + btoa(fileContent);
     };

     // Read the file as a binary string
     fileReader.readAsBinaryString(file);
 }
</script>

        </main>
		</body>
</html>
