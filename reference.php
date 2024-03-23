<!DOCTYPE html>
<html lang="en">
		<head>
				<meta charset="utf-8">
				<title>tny</title>
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
										<li><a href="https://sr.ht/~m15o/tny/">Download</a></li>
										<li><a href="ide.html">Web IDE</a></li>
										<li><a href="launcher.php">Launcher</a></li>
										<li><a href="games.php">Games</a></li>
								</ul>
						</nav>
				</header>
				<main>

<h1>Tny Reference</h1>

<h2>Memory map</h2>
<ul>
		<li>256 bytes of RAM</li>
		<li>A 256 bytes general purpose buffer</li>
		<li>Two 256 bytes stacks: pstack and rstack</li>
		<li>A 16x16 pixels (32 bytes) screen</li>
		<li>3 bytes that store the state:</li>
		<ul>
				<li>1 byte Instruction Pointer (IP) that points to the next instruction</li>
				<li>1 byte Controller that encodes the key pressed</li>
				<li>1 byte that stores the current frame</li>
		</ul>
</ul>

<h2>Screen</h2>
<table>
<tr><td>00</td><td>01</td><td>02</td><td>03</td><td>04</td><td>05</td><td>06</td><td>07</td><td>08</td><td>09</td><td>0a</td><td>0b</td><td>0c</td><td>0d</td><td>0e</td><td>0f</td></tr><tr><td>10</td><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td><td>17</td><td>18</td><td>19</td><td>1a</td><td>1b</td><td>1c</td><td>1d</td><td>1e</td><td>1f</td></tr><tr><td>20</td><td>21</td><td>22</td><td>23</td><td>24</td><td>25</td><td>26</td><td>27</td><td>28</td><td>29</td><td>2a</td><td>2b</td><td>2c</td><td>2d</td><td>2e</td><td>2f</td></tr><tr><td>30</td><td>31</td><td>32</td><td>33</td><td>34</td><td>35</td><td>36</td><td>37</td><td>38</td><td>39</td><td>3a</td><td>3b</td><td>3c</td><td>3d</td><td>3e</td><td>3f</td></tr><tr><td>40</td><td>41</td><td>42</td><td>43</td><td>44</td><td>45</td><td>46</td><td>47</td><td>48</td><td>49</td><td>4a</td><td>4b</td><td>4c</td><td>4d</td><td>4e</td><td>4f</td></tr><tr><td>50</td><td>51</td><td>52</td><td>53</td><td>54</td><td>55</td><td>56</td><td>57</td><td>58</td><td>59</td><td>5a</td><td>5b</td><td>5c</td><td>5d</td><td>5e</td><td>5f</td></tr><tr><td>60</td><td>61</td><td>62</td><td>63</td><td>64</td><td>65</td><td>66</td><td>67</td><td>68</td><td>69</td><td>6a</td><td>6b</td><td>6c</td><td>6d</td><td>6e</td><td>6f</td></tr><tr><td>70</td><td>71</td><td>72</td><td>73</td><td>74</td><td>75</td><td>76</td><td>77</td><td>78</td><td>79</td><td>7a</td><td>7b</td><td>7c</td><td>7d</td><td>7e</td><td>7f</td></tr><tr><td>80</td><td>81</td><td>82</td><td>83</td><td>84</td><td>85</td><td>86</td><td>87</td><td>88</td><td>89</td><td>8a</td><td>8b</td><td>8c</td><td>8d</td><td>8e</td><td>8f</td></tr><tr><td>90</td><td>91</td><td>92</td><td>93</td><td>94</td><td>95</td><td>96</td><td>97</td><td>98</td><td>99</td><td>9a</td><td>9b</td><td>9c</td><td>9d</td><td>9e</td><td>9f</td></tr><tr><td>a0</td><td>a1</td><td>a2</td><td>a3</td><td>a4</td><td>a5</td><td>a6</td><td>a7</td><td>a8</td><td>a9</td><td>aa</td><td>ab</td><td>ac</td><td>ad</td><td>ae</td><td>af</td></tr><tr><td>b0</td><td>b1</td><td>b2</td><td>b3</td><td>b4</td><td>b5</td><td>b6</td><td>b7</td><td>b8</td><td>b9</td><td>ba</td><td>bb</td><td>bc</td><td>bd</td><td>be</td><td>bf</td></tr><tr><td>c0</td><td>c1</td><td>c2</td><td>c3</td><td>c4</td><td>c5</td><td>c6</td><td>c7</td><td>c8</td><td>c9</td><td>ca</td><td>cb</td><td>cc</td><td>cd</td><td>ce</td><td>cf</td></tr><tr><td>d0</td><td>d1</td><td>d2</td><td>d3</td><td>d4</td><td>d5</td><td>d6</td><td>d7</td><td>d8</td><td>d9</td><td>da</td><td>db</td><td>dc</td><td>dd</td><td>de</td><td>df</td></tr><tr><td>e0</td><td>e1</td><td>e2</td><td>e3</td><td>e4</td><td>e5</td><td>e6</td><td>e7</td><td>e8</td><td>e9</td><td>ea</td><td>eb</td><td>ec</td><td>ed</td><td>ee</td><td>ef</td></tr><tr><td>f0</td><td>f1</td><td>f2</td><td>f3</td><td>f4</td><td>f5</td><td>f6</td><td>f7</td><td>f8</td><td>f9</td><td>fa</td><td>fb</td><td>fc</td><td>fd</td><td>fe</td><td>ff</td></tr></table>

<h2>Execution</h2>

<ol>
		<li>The ROM gets loaded in the RAM</li>
		<li>The IP (Instruction Pointer) starts at position 2</li>
		<li>Every instruction is executed</li>
		<li>A BRK instruction will stop execution of current vector</li>
		<li>The address stored at memory position 0 is the screen vector, executed 60 times per second</li>
		<li>The address stored at memory position 1 is the key vector, executed when a key is pressed</li>
</ol>

<h2 id="instructions">Instructions</h2>
<table>
		<tr>
				<th>Code</th>
				<th>Mnemonic</th>
				<th>Effect</th>
				<th>Purpose</th>
		</tr>
						<tr>
						<td>0x00</td>
						<td>BRK</td>
						<td></td>
						<td>Stop evaluation</td>
				</tr>
						<tr>
						<td>0x01</td>
						<td>RET</td>
						<td></td>
						<td>Pop rstack into IP</td>
				</tr>
						<tr>
						<td>0x02</td>
						<td>JMP</td>
						<td>a</td>
						<td>Set the IP to a</td>
				</tr>
						<tr>
						<td>0x03</td>
						<td>JMR</td>
						<td>a</td>
						<td>Push IP+1 to rstack, then JMP</td>
				</tr>
						<tr>
						<td>0x04</td>
						<td>JCN</td>
						<td>f a</td>
						<td>Set IP to a if f is not 0</td>
				</tr>
						<tr>
						<td>0x05</td>
						<td>JCR</td>
						<td>f a</td>
						<td>Push IP+1 to rstack, then JCN</td>
				</tr>
						<tr>
						<td>0x06</td>
						<td>LIT</td>
						<td></td>
						<td>Push following number to the stack, increase IP by 2</td>
				</tr>
						<tr>
						<td>0x07</td>
						<td>POP</td>
						<td>n</td>
						<td>Pop top of the stack</td>
				</tr>
						<tr>
						<td>0x08</td>
						<td>DUP</td>
						<td>n -- n n</td>
						<td>Duplicate top of the stack</td>
				</tr>
						<tr>
						<td>0x09</td>
						<td>SWP</td>
						<td>n1 n2 -- n2 n1</td>
						<td>Swap top of the stack</td>
				</tr>
						<tr>
						<td>0x0a</td>
						<td>ROT</td>
						<td>n1 n2 n3 -- n2 n3 n1</td>
						<td>Rotate top of the stack</td>
				</tr>
						<tr>
						<td>0x0b</td>
						<td>OVR</td>
						<td>n1 n2 -- n1 n2 n1</td>
						<td>Copy n1 to top of the stack</td>
				</tr>
						<tr>
						<td>0x0c</td>
						<td>PSH</td>
						<td>n --</td>
						<td>Take value off pstack and push it to rstack</td>
				</tr>
						<tr>
						<td>0x0d</td>
						<td>PUL</td>
						<td>-- n</td>
						<td>Pull value off rstack and push it to pstack</td>
				</tr>
						<tr>
						<td>0x0e</td>
						<td>RSI</td>
						<td>-- n</td>
						<td>Copy top of rstack without affecting it</td>
				</tr>
						<tr>
						<td>0x0f</td>
						<td>RSJ</td>
						<td>-- n</td>
						<td>Copy second item of rstack without affecting it</td>
				</tr>
						<tr>
						<td>0x10</td>
						<td>STA</td>
						<td>n a</td>
						<td>Store n to address</td>
				</tr>
						<tr>
						<td>0x11</td>
						<td>LDA</td>
						<td>a -- n</td>
						<td>Load from address</td>
				</tr>
						<tr>
						<td>0x12</td>
						<td>STB</td>
						<td>n a</td>
						<td>Store n in buffer at address a</td>
				</tr>
						<tr>
						<td>0x13</td>
						<td>LDB</td>
						<td>a -- n</td>
						<td>Load from buffer address a</td>
				</tr>
						<tr>
						<td>0x14</td>
						<td>ADD</td>
						<td>n1 n2 -- n1+n2</td>
						<td>Add top two stack values</td>
				</tr>
						<tr>
						<td>0x15</td>
						<td>SUB</td>
						<td>n1 n2 -- n1-n2</td>
						<td>Subtract top stack value from second</td>
				</tr>
						<tr>
						<td>0x16</td>
						<td>INC</td>
						<td>n -- n+1</td>
						<td>Increment top of the stack</td>
				</tr>
						<tr>
						<td>0x17</td>
						<td>DEC</td>
						<td>n -- n-1</td>
						<td>Decrement top of the stack</td>
				</tr>
						<tr>
						<td>0x18</td>
						<td>MUL</td>
						<td>n1 n2 -- n1*n2</td>
						<td>Multiply top two stack values</td>
				</tr>
						<tr>
						<td>0x19</td>
						<td>DIV</td>
						<td>n1 n2 -- n1/n2</td>
						<td>Divide top two stack values</td>
				</tr>
						<tr>
						<td>0x1a</td>
						<td>MOD</td>
						<td>n1 n2 -- n1%n2</td>
						<td>Divide n1 by n2 and push remainder</td>
				</tr>
						<tr>
						<td>0x1b</td>
						<td>RND</td>
						<td>-- n</td>
						<td>Push random number</td>
				</tr>
						<tr>
						<td>0x1c</td>
						<td>EQU</td>
						<td>n1 n2 -- f</td>
						<td>Check if n1 and n2 are equal</td>
				</tr>
						<tr>
						<td>0x1d</td>
						<td>NEQ</td>
						<td>n1 n2 -- f</td>
						<td>Check if n1 and n2 are different</td>
				</tr>
						<tr>
						<td>0x1e</td>
						<td>GTH</td>
						<td>n1 n2 -- f</td>
						<td>Check if n1 > n2</td>
				</tr>
						<tr>
						<td>0x1f</td>
						<td>LTH</td>
						<td>n1 n2 -- f</td>
						<td>Check if n1 < n2</td>
				</tr>
						<tr>
						<td>0x20</td>
						<td>AND</td>
						<td>n1 n2 -- n1&n2</td>
						<td>Push n1 & n2 to the stack</td>
				</tr>
						<tr>
						<td>0x21</td>
						<td>ORR</td>
						<td>n1 n2 -- n1|n2</td>
						<td>Push the binary OR operation n1|n2 to the stack</td>
				</tr>
						<tr>
						<td>0x22</td>
						<td>XOR</td>
						<td>n1 n2 -- n1^n2</td>
						<td>Push the binary XOR operation n1^n2 to the stack</td>
				</tr>
						<tr>
						<td>0x23</td>
						<td>SFT</td>
						<td>n ctl -- v</td>
						<td>Shift n left based on ctl high nibble, right based on ctl low nibble.</td>
				</tr>
						<tr>
						<td>0x24</td>
						<td>CLS</td>
						<td></td>
						<td>Clear screen</td>
				</tr>
						<tr>
						<td>0x25</td>
						<td>SET</td>
						<td>a f</td>
						<td>Set pixel at a when f is 1.</td>
				</tr>
						<tr>
						<td>0x26</td>
						<td>GET</td>
						<td>a -- f</td>
						<td>Get state of pixel at adr. 1 if on, 0 otherwise.</td>
				</tr>
						<tr>
						<td>0x27</td>
						<td>KEY</td>
						<td>k</td>
						<td>Push the value of the controller to the pstack</td>
				</tr>
						<tr>
						<td>0x28</td>
						<td>FRM</td>
						<td>f</td>
						<td>Push the value of the current frame to the pstack</td>
				</tr>
		</table>

        </main>
		</body>
</html>
