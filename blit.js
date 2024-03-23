const canvas = document.getElementById("screen");
const ctx = canvas.getContext("2d");
const imageData = ctx.createImageData(16, 16);

function blit() {
		for (let i = 0; i < msm.output().length; i++) {
				let p = msm.output()[i];
				/* red   */ imageData.data[i*4] = p ? 255 : 0;
				/* green */ imageData.data[i*4+1] = p ? 255 : 0;
		    /* blue  */ imageData.data[i*4+2] = p ? 255 : 0;
				/* alpha */ imageData.data[i*4+3] = 255;
		}
		ctx.putImageData(imageData, 0, 0);
}

function gameloop() {
		msm.exec_screen_vector();
		blit();
		new Promise(display_update);
		setTimeout(() => {
				requestAnimationFrame(gameloop);
		}, 1000 / 60);
}

function start_gameloop() {
		requestAnimationFrame(gameloop);
}

canvas.addEventListener("keyup", (event) => {
		switch(event.key) {
		case 'ArrowUp':
				msm.keyup(0b11111110);
				break;
		case 'ArrowDown':
				msm.keyup(0b11111101);
				break;
		case 'ArrowLeft':
				msm.keyup(0b11111011);
				break;
		case 'ArrowRight':
				msm.keyup(0b11110111);
				break
		case 'x':
				msm.keyup(0b11101111);
				break;
		case 'c':
				msm.keyup(0b11011111);
				break;
		default:
				msm.keyup(0);
		}
});

canvas.addEventListener("keydown", (event) => {
		switch(event.key) {
		case 'ArrowUp':
				msm.keydown(0b00000001);
				msm.exec_key_vector();
				break;
		case 'ArrowDown':
				msm.keydown(0b00000010);
				msm.exec_key_vector();
				break;
		case 'ArrowLeft':
				msm.keydown(0b00000100);
				msm.exec_key_vector();
				break;
		case 'ArrowRight':
				msm.keydown(0b00001000);
				msm.exec_key_vector();
				break;
		case 'x':
				msm.keydown(0b00010000);
				msm.exec_key_vector();
				break;
		case 'c':
				msm.keydown(0b00100000);
				msm.exec_key_vector();
				break;
		default:
				msm.keydown(0);
		}
});

start_gameloop();
msm.on_executed(blit);

blit();
