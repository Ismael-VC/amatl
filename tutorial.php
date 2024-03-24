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

<h1>Tutorial</h1>

<p>Tny is a tiny virtual console. It can execute sequences of bytes that have a special meaning. These sequences are called "ROMs" and the bytes "machine code". To make writing ROMs easier for Humans, Tny also has an assembly language. The language exposes special words that translate directly to machine instructions. These are called mnemonics. In this book, we will learn about the mnemonics to build simple games with Tny.</p>

<h2>Getting started</h2>

<p>All Tny ROMs must start with `0 0` or other numbers.</p>

<p><pre>0 0 LIT 1 INC</pre></p>

<p>There is a lot going on in the above. Let's work through it. </p>

<p>First, LIT is an instruction that tells Tny to push the next number into the parameter stack (wstack). The parameter stack is a special part of memory in which we can push or pop values. It's used to pass parameters, thus its name.</p>

<p>Then, INC is another instruction that increases by one the top of the wstack.</p>

<p>If you haven't done so, execute the above program. You should see that the wstack now has 02 stored in it.</p>

<h3>Manipulating the stack</h3>

<p>Now that we've seen the stack, let's see how we can manipulate it.</p>

<p>LIT lets you push the next number to the stack.</p>

<p>You can read about the other instructions in the glossary below. Let's look at DUP. It says that the purpose is the "Duplicate the top of the stack". There's another column called "Effect" which says:</p>

<p><pre>n -- n n</pre></p>

<p>This is a way to indicate the effect of DUP on the stack. DUP requires a number to be on the stack. This number is the "n" represented on the left of "--". After its execution, the stack now has "n" twice.</p>

<p>Learning how to read stack effects is a great way to quickly see what parameters an instruction needs on the stack, and how it will modify the stack.</p>

<h3>Arithmetic</h3>

<p>All numbers are expressed in hexadecimal.</p>

<p><pre>LIT f \ push the decimal value 15 to the stack</pre></p>

<p>Let's add two numbers together:</p>

<p><pre>LIT 1 LIT 1 ADD</pre></p>

<p>Now, let's multiply the result by two:</p>

<p><pre>LIT 2 MUL</pre></p>

<p>How about we divide it by 4?</p>

<p><pre>LIT 4 DIV</pre></p>

<p>If you ever need a random number, you can use the RND instruction which will place on the stack a random number in the 0 255 range.</p>

<h3>Labels and addresses</h3>

<p>When your program gets assembled, every mnemonic gets mapped to a corresponding machine code value, which fits in a byte. Since every instruction fits in a single byte, we can refer to a particular place in your ROM by its offset. In Tny, this offset is called an address.</p>

<p>Imagine the following program:</p>

<p><pre>0 0 LIT 5 LIT 5 ADD</pre></p>

<p>The address of the first LIT instruction is 2. The address of the ADD instruction is 6. Let's now look at the following program:</p>

<p><pre>0 0 start: LIT 5 LIT 5 ADD</pre></p>

<p>In the above code, we added a label called start. It could have been called anything else. When Tny's preprocessor finds a label, it remembers its name and location, so that we can use this location later on.</p>

<h3>Jumping</h3>

<p>Let's look at the following program:</p>

<p><pre>0 0 LIT @start JMP
start: LIT 5 LIT 5 ADD BRK
LIT 2</pre></p>

<p>Let's try to understand what happens. When executed, the Instruction Pointer (IP) starts at address 2. It finds LIT, so it pushes the number that follows it into the stack. In this case, @start represents the memory address of the start label, which is 5. Our stack now has a 5 in it. Then it finds a JMP instruction. The JMP instruction tells the IP to take the value of the top of the stack, so 5, and to carry on. Our program then executes the LIT instructions, then the ADD one, and finally BRK. BRK is a special instruction that stops the execution of the program. Meaning that the remaining LIT 2 instruction won't be executed.</p>

<p>There are different ways to jump. For example, JSR will store the position of the next instruction in a special stack called the return stack. This allows to resume the execution with the JMPr instruction.</p>

<h3>Drawing on the screen</h3>

<p>The screen Amatl is 16x16, meaning that a screen position can be encoded in one byte. The address of the top left pixel is 00, and the address of the bottom right if ff. The high nibble represents the rows, and the low nibble the columns. For example, the pixel at the 4th row and 10th column is 4a.</p>

<p>A pixel can be either on or off.</p>

<p><pre>0 0 LIT 11 LIT 1 SET</pre></p>

<p>Here, we set the pixel at offset 11.</p>

<h3>Controller</h3>

<p>Like most consoles, 45M has a controller. A very basic one! It has your usual up left down right keys, as well as A and B which are mapped the the X and C key of the keyboard, respectively.</p>

<p>You can push to the stack the value of the current key being pressed with the KEY instruction. The value has the following format:</p>

<p><pre>0 0 0 B A R L D U</pre></p>

<p><pre>B: the B button</pre>
		A: the A button
		R: the right arrow
		L: the left arrow
		D: the down arrow
		U: the up arrow</pre>

		<h3>Vectors</h3>

		<p>Remember, each ROM starts with two values: 0 0. These values are actually memory addresses. Let's take the following example:</p>

		<p><pre>@frame 0 BRK
frame:  LIT 0 LIT 1 SET</pre></p>

		<p>Let's start with memory address 0. It's the screen vector. The value at this address will be called 60 times per second. In the example above, we have set it to the frame label.</p>

		<p>Now let's continue with memory address 1. The controller vector:</p>

		<p><pre>@frame @key BRK
frame: LIT 0 LIT 1 SET
key: KEY</pre></p>

		<p>The key vector will be executed anytime a key from the controller has been pressed.</p>

		<h3>Looping</h3>

		<p>It's possible to use use labels, jumps, and the return stack in order to create a loop. Here is a full example:</p>

		<pre>0 0 LIT 0 LIT 10 PSH PSH do:
  RSI LIT 1 SET
  PUL INC PSH
  RSI RSJ LTH LIT @do JCN
  PUL PUL POP POP</pre>

		<p>Let's unpack!</p>
		<p>We start by setting the screen and controller vectors to 0. Then we push 0 and 10 to the stack. They are the index and the limit respectively. The next two instructions, PSH and PSH, move the index and limit to the return stack. We use the return stack as a way to keep track of the current iteration. After that, we create a label called "do". That's the start of the loop.</p>

		<p>The first line of the loop turns on a pixel on the first line, based on the current index. It uses the RSI instruction, which copies the top of the return stack to the parameter stack.</p>

		<p>The next line increments the index by one by. To do that it pulls it from the return stack, increments it, and pushes it back.</p>

		<p>The next line is the test. We compare the top two values of the return stack by using RSI and RSJ with LTH. We then jump back to our "do" label when the comparaison is true.</p>

		<p>Finally, we pop the index and limit from the return stack.</p>

		<p>Now that we've seen an example, here is a template:</p>

		<pre>LIT index LIT limit PSH PSH do:
  # instructions go here
  PUL INC PSH
  RSI RSJ LTH LIT @do JCN
  PUL PUL POP POP</pre>

		<h3>Use FRM to control the screen vector's FPS</h3>
		<p>The screen vector is called 60 times per second, which might be too much for some programs. To change that, we can leverage the FRM and MOD instructions. Let's take an example:</p>

		<pre>2 0 CLS
FRM LIT 1e MOD LIT 0 NEQ LIT @end JCN
LIT 0 LIT 1 SET
end: BRK</pre>

		<p>This program starts by setting the screen vector to the address 2. 60 times per second, Tny's Instruction Pointer will be set to the address 2 and will start to execute each instruction sequentially. The first one, CLS, clears the screen. The following line will jump to the "end" label if the current frame should be skipped. To know how many frames should be skipped, we need to compute the following:</p>

		<pre>frame_skip = 60 / desired_fps</pre>

		<p>In our example, we want 2 frames per second, so the number of frames to skip is:</p>

		<pre>LIT 3c LIT 2 DIV</pre>

		<p>Which is equal to 30 (1e). That's why the 3rd line pushes the current frame as well as 1e to the stack and applies a modulo. We then push 0 and NEQ to make sure to jump our when the current frame isn't a multiple of 1e.</p>

		<p>Here's a snippet you can use to controle the FPS:</p>
		<pre>FRM LIT frame_skip MOD LIT 0 NEQ LIT @end JCN
# Perform computation
end: BRK</pre>

		<h3>Move a pixel around with the keyboard</h3>

		<p>Let's see how we can move a pixel around. For that, we will use the KEY instruction together with JCN. Here's an example:</p>

		<pre>@screen @ctrl
screen:
  CLS
  LIT pos: 0 LIT 1 SET
BRK
ctrl:
  KEY LIT 1 EQU LIT @up    JCN
  KEY LIT 2 EQU LIT @down  JCN
  KEY LIT 4 EQU LIT @left  JCN
  KEY LIT 8 EQU LIT @right JCN
BRK

up:    LIT @pos LDA LIT 10 SUB LIT @pos STA BRK
down:  LIT @pos LDA LIT 10 ADD LIT @pos STA BRK
left:  LIT @pos LDA DEC LIT @pos STA BRK
right: LIT @pos LDA INC LIT @pos STA BRK
BRK</pre>

		<p>As always, we start by setting the screen and controller vector. Any time an arrow key is pressed, the controller vector will get called. In there, we use KEY, which pushes the value of the controller to the stack. We then test its value and jump to the correct label based on it. Notice that we modify directly the value at the pos address.</p>

		</body>
</html>

        </main>
		</body>
</html>
