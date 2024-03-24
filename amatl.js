(function () {
		let on_executed;
		let screen_ready;
		let controller_ready;
		let frame = 0;
		let keyp = 0;

		const mn = {
				BRK: 0,
				LIT: 6,
				POP: 7,
				DUP: 8,
				SWP: 9,
				ROT: 10,
				OVR: 11,
				STA: 16,
				LDA: 17,
				ADD: 20,
				SUB: 21,
				INC: 22,
				DEC: 23,
				MUL: 24,
				DIV: 25,
				MOD: 26,
				AND: 32,
				JMP: 2,
				JCN: 4,
				JCR: 5,
				CLS: 36,
				SET: 37,
				EQU: 28,
				JMPr: 1,
				JSR: 3,
				RND: 27,
				NEQ: 29,
				GET: 38,
				PSH: 12,
				PUL: 13,
				RSI: 14,
				RSJ: 15,
				STB: 18,
				LDB: 19,
				LTH: 31,
				GTH: 30,
				ORR: 33,
				XOR: 34,
				SFT: 35,
				KEY: 39,
				FRM: 40
		}

		// screen pixels (16x16)
		const screen = new Array(256).fill(0);

		// 256 values (1 byte)
		const memory = new Array(256).fill(0);

		// 256 values (1 byte)
		const buffer = new Array(256).fill(0);

		// each sprite is 2 bytes
		const sprites = new Array(10*2).fill(0);

		// controller
		let btn = 0;

		// parameter stack
		const wstack = [];

		// return stack
		const rstack = [];

		// instruction pointer // TODO: call it ip (instruction pointer)
		let h;

		// exit flag to stop execution
		let exit;

		function load(rom) {
				if (rom.length > 256)
						throw new Error('ROM > 256 bytes');
				for (let i = 0; i < rom.length; i++) {
						memory[i] = rom[i];
				}
				console.log("loaded rom: ", rom.length, "bytes");
		}

		function push(s, n) {
				if (s.length > 256)
						throw new Error('stack overflow');
				s.push(n);
		}

		function pop(s) {
				if (s.length === 0)
						throw new Error('stack underflow');
				return s.pop()
		}

		// execute the current instruction
		function exec() {
				let adr, n, n2, n3, c;
				switch(memory[h]) {
				case mn.BRK:
						exit = 1;
						break;
				case mn.LIT:
						push(wstack, memory[++h])
						h++;
						break;
				case mn.JMP:
						h = pop(wstack)
						break;
				case mn.JSR:
						push(rstack, h+1);
						h = pop(wstack)
						break;
				case mn.JMPr:
						h = pop(rstack)
						break;
				case mn.NOT:
						n = pop(wstack);
						push(wstack, n? 0 : 1);
						h++;
						break;
				case mn.SET:
						n = pop(wstack);
						n2 = pop(wstack);
						screen[n2] = n == 0 ? 0 : 1;
						h++;
						break;
				case mn.KEY:
						push(wstack, keyp);
						h++;
						break;
				case mn.FRM:
						push(wstack, frame);
						h++;
						break;
				case mn.LDA:
						adr = pop(wstack);
						push(wstack, memory[adr]);
						h++;
						break;
				case mn.LDB:
						adr = pop(wstack);
						push(wstack, buffer[adr]);
						h++;
						break;
				case mn.GET:
						adr = pop(wstack);
						push(wstack, screen[adr]);
						h++;
						break;
				case mn.STA:
						adr = pop(wstack);
						n = pop(wstack);
						memory[adr] = n;
						h++;
						break;
				case mn.STB:
						adr = pop(wstack);
						n = pop(wstack);
						buffer[adr] = n;
						h++;
						break;
				case mn.CLS:
						screen.fill(0);
						h++;
						break;
				case mn.RND:
						push(wstack, Math.floor(Math.random() * 256));
						h++
						break;
				case mn.POP:
						pop(wstack);
						h++;
						break;
				case mn.JCN:
						adr = pop(wstack);
						n = pop(wstack);
						if (n) {
								h = adr;
						} else {
								h++;
						}
						break;
				case mn.MOD:
						n2 = pop(wstack);
						n  = pop(wstack);
						push(wstack, n%n2)
						h++;
						break;
				case mn.ADD:
						n2 = pop(wstack);
						n  = pop(wstack);
						push(wstack, (n+n2)&0xFF);
						h++;
						break;
				case mn.SUB:
						n2 = pop(wstack);
						n  = pop(wstack);
						push(wstack, (n-n2)&0xFF);
						h++;
						break;
				case mn.INC:
						n  = pop(wstack);
						push(wstack, (n+1)&0xFF)
						h++;
						break;
				case mn.DEC:
						n  = pop(wstack);
						push(wstack, (n-1)&0xFF);
						h++;
						break;
				case mn.DIV:
						n2 = pop(wstack);
						n  = pop(wstack);
						push(wstack, Math.floor(n/n2))
						h++;
						break;
				case mn.MUL:
						n2 = pop(wstack);
						n  = pop(wstack);
						push(wstack, n*n2)
						h++;
						break;
				case mn.JCR:
						adr = pop(wstack);
						n = pop(wstack);
						if (n) {
								push(rstack, h+1)
								h = adr;
						} else {
								h++;
						}
						break;
				case mn.DUP:
						n = pop(wstack);
						push(wstack, n);
						push(wstack, n);
						h++;
						break;
				case mn.AND:
						n = pop(wstack);
						n2 = pop(wstack);
						push(wstack, n2 & n);
						h++;
						break;
				case mn.ORR:
						n = pop(wstack);
						n2 = pop(wstack);
						push(wstack, n2 | n);
						h++;
						break;
				case mn.SFT:
						n = pop(wstack);
						n2 = pop(wstack);
						n3 = n2 >> (n&0x0f)
						n3 = n3 << ((n&0xf0) >> 4)
						push(wstack, n3);
						h++;
						break;
				case mn.XOR:
						n = pop(wstack);
						n2 = pop(wstack);
						push(wstack, n2 ^ n);
						h++;
						break;
				case mn.EQU:
						n = pop(wstack);
						n2 = pop(wstack);
						push(wstack, n === n2 ? 1 : 0);
						h++;
						break;
				case mn.GTH:
						n2 = pop(wstack);
						n = pop(wstack);
						push(wstack, n > n2 ? 1 : 0);
						h++;
						break;
				case mn.LTH:
						n2 = pop(wstack);
						n = pop(wstack);
						push(wstack, n < n2 ? 1 : 0);
						h++;
						break;
				case mn.NEQ:
						n = pop(wstack);
						n2 = pop(wstack);
						push(wstack, n !== n2 ? 1 : 0);
						h++;
						break;
				case mn.SWP:
						n2 = pop(wstack);
						n = pop(wstack);
						push(wstack, n2);
						push(wstack, n);
						h++;
						break;
				case mn.ROT:
						n3 = pop(wstack);
						n2 = pop(wstack);
						n = pop(wstack);
						push(wstack, n2);
						push(wstack, n3);
						push(wstack, n);
						h++
						break;
				case mn.OVR:
						n2 = pop(wstack);
						n = pop(wstack);
						push(wstack, n);
						push(wstack, n2);
						push(wstack, n);
						h++
						break;
				case mn.PSH:
						n = pop(wstack);
						push(rstack, n);
						h++
						break;
				case mn.PUL:
						n = pop(rstack);
						push(wstack, n);
						h++
						break;
				case mn.RSI:
						n = pop(rstack);
						push(rstack, n);
						push(wstack, n);
						h++
						break;
				case mn.RSJ:
						n2 = pop(rstack);
						n = pop(rstack);
						push(rstack, n);
						push(rstack, n2);
						push(wstack, n);
						h++
						break;
				default:
						throw new Error("Unknown instruction: " + memory[h]);
						break;
				}
		}

		// reset "pin"
		function reset() {
				memory.fill(0);
				buffer.fill(0);
				screen.fill(0);

				// reset exit flag
				exit = 0;

				// reset memory pointer
				h = 2;

				frame = 0;

				// reset stacks
				wstack.length = 0;
				rstack.length = 0;
		}

		// run machine code
		function run(rom) {
				reset();

				// load rom into memory
				load(rom);

				while (!exit) {
						exec()
				}

				if (on_executed) {
						on_executed();
				}
		}

		function output() {
				return screen;
		}

		function exec_screen_vector() {
				exit = 0;
				h = memory[0];
				if (!h) return;
				// push(wstack, frame);
				while (!exit) {
						exec();
				}
				frame = (frame+1) % 60; // TODO: FPS
		}

		function exec_key_vector() {
				exit = 0;
				h = memory[1];
				if (!h) return;
				// push(wstack, keyp);
				while (!exit) {
						exec();
				}
		}

		function preprocess(tokens) {
				let labels = {}
				let j = 0;

				// capture labels
				for (let i = 0; i < tokens.length; i++) {
						if (tokens[i].startsWith('@')) {
								labels[tokens[i].split('@')[1]] = j;
								tokens[i] = ''; // consume
						} else {
								j++;
						}
				}

				let i;
				try {
						// substitute them
						for (i = 0; i < tokens.length; i++) {
								if (tokens[i].startsWith(',')) {
										tokens[i] = (labels[tokens[i].slice(1)]).toString(16);
								}
						}
				} catch(e) {
						throw new Error("Unknown label " + tokens[i]);
				}

				return tokens.filter(Boolean);
		}

		function keydown(key) {
				keyp |= key;
		}

		function keyup(key) {
				keyp &= key;
		}

		function assemble(str) {
				let tokens = str
				        .replace(/#(0*[0-9a-f]+)/g, 'LIT $1')
				        .replace(/[\[\]]/g, '')
                        .replace(/,(?!:)(\w+)/g, 'LIT ,$1')
						.replace(/\\.*/mg, '')
				        .replace(/\(\s*[^)]*\s*\)/mg, '')
						.split(/\s+/)
						.filter(Boolean);
				tokens = preprocess(tokens);

				console.log(`Used: ${(tokens.length/256*100).toFixed(2)}%`);

				return tokens.map(m => {
						if (mn[m] !== undefined) return mn[m];
						let hex = /^[0-9a-f]{2}$/g;
						if (hex.test(m)) {
							let n = parseInt(m, 16);
							if (isNaN(n)) {
									throw new Error("Not a valid hex literal: " + m);
							}
						return n;
						}
				});
		}

		window.msm = {
				assemble,
				keydown,
				buffer,
				keyup,
				run,
				screen,
				output,
				memory,
				exec_screen_vector,
				exec_key_vector,
				wstack,
				rstack,
				on_executed: f => on_executed = f,
				screen_ready: f => screen_ready = f,
				controller_ready: f => controller_ready = f
		};
})()
