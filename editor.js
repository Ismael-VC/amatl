const editor = document.querySelector('.editor');
const preview = document.querySelector('.preview');
const source = document.getElementById("source");
const errors = document.getElementById("errors");
const resizer = document.querySelector('.resizer');

let isResizing = false;

resizer.addEventListener('mousedown', (e) => {
		isResizing = true;
});

document.addEventListener('mousemove', (e) => {
	if (!isResizing) return;
		currentX = e.clientX;

	editor.style.width = `${e.clientX}px`;
	resizer.style.left = `${e.clientX}px`
	preview.style.left = `${e.clientX}px`;
});

document.addEventListener('mouseup', (e) => {
	isResizing = false;
});

let rom = [];
function compile() {
		errors.innerHTML = '';
		try {
				rom = msm.assemble(source.value)
				msm.run(rom);
		} catch(e) {
				errors.innerHTML = e.toString()
		}
		source.focus();
		display_update();
		display_rom();
		display_share();
}

function to_hex(n) {
		return n.toString(16).padStart(2, 0);
}

function display_cells(id, cells) {
    var $target = document.getElementById(id);
    $target.innerHTML = cells.map(to_hex).join(" ");
}

function display_buffer() {
		display_cells("buffer", msm.buffer);
}

function display_ram() {
		display_cells("ram", msm.memory);
}

function display_rom() {
		display_cells("rom", rom);
		document.getElementById("rom").innerHTML += "<br><br>(" + rom.length + " bytes)";
}

function display_share() {
		document.getElementById("share").innerHTML = `<a href="/system.html?r=${btoa(rom.map(e => String.fromCharCode(e)).join(''))}">link<a>`;

		const bytes = new Uint8Array(rom);
		const blob = new Blob([bytes], { type: 'application/octet-stream' });
		
		document.getElementById("share").innerHTML += `&nbsp;<a href="${URL.createObjectURL(blob)}" download="game.rom">download<a>`;
}

function display_stack() {
		display_cells("pstack", msm.pstack);
		display_cells("rstack", msm.rstack);
}

function display_update() {
		display_buffer();
		display_ram();
		display_stack();
}

function toggle() {
		let body = document.querySelector('body');
		if (body.classList.contains('toggle')) {
				body.classList.remove('toggle');
		} else {
				body.classList.add('toggle');
		}
}
