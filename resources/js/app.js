import "./bootstrap";

window.initRichTextEditor = function (editor) {
	const content = editor.querySelector('[contenteditable="true"]');
	const input = editor.querySelector('input[type="hidden"]');

	if (!content || !input || editor.dataset.initialized === 'true') {
		return;
	}

	editor.dataset.initialized = 'true';
	let savedRange = null;

	const saveSelection = () => {
		const selection = window.getSelection();

		if (selection.rangeCount && content.contains(selection.anchorNode)) {
			savedRange = selection.getRangeAt(0).cloneRange();
		}
	};

	const restoreSelection = () => {
		if (!savedRange) {
			content.focus();
			return;
		}

		const selection = window.getSelection();
		selection.removeAllRanges();
		selection.addRange(savedRange);
		content.focus();
	};

	content.addEventListener('input', () => {
		input.value = content.innerHTML;
	});
	content.addEventListener('mouseup', saveSelection);
	content.addEventListener('keyup', saveSelection);
	content.addEventListener('blur', saveSelection);

	editor.querySelectorAll('[data-command]').forEach((control) => {
		if (control.tagName === 'BUTTON') {
			control.addEventListener('mousedown', (event) => {
				event.preventDefault();
			});
		} else {
			control.addEventListener('mousedown', saveSelection);
		}

		const applyCommand = () => {
			const command = control.dataset.command;
			const value = control.dataset.value || control.value || null;

			if (command === 'createLink') {
				const url = window.prompt('URL del enlace');

				if (!url) {
					return;
				}

				restoreSelection();
				document.execCommand(command, false, url);
			} else {
				restoreSelection();
				document.execCommand(command, false, value);
			}

			input.value = content.innerHTML;
		};

		control.addEventListener(control.tagName === 'BUTTON' ? 'click' : 'change', applyCommand);
	});
};

document.querySelectorAll('[data-carousel]').forEach((carousel) => {
	const track = carousel.querySelector('[data-carousel-track]');
	const slides = track?.querySelectorAll('[data-carousel-slide]');

	if (!track || !slides?.length) {
		return;
	}

	let currentIndex = 0;

	const goToSlide = (index) => {
		currentIndex = Math.max(0, Math.min(index, slides.length - 1));
		track.scrollTo({ left: slides[currentIndex].offsetLeft, behavior: 'smooth' });
	};

	carousel.querySelector('[data-carousel-prev]')?.addEventListener('click', () => {
		goToSlide(currentIndex - 1);
	});

	carousel.querySelector('[data-carousel-next]')?.addEventListener('click', () => {
		goToSlide(currentIndex + 1);
	});

	track.addEventListener('scrollend', () => {
		const nearestSlide = [...slides].reduce((nearest, slide, index) =>
			Math.abs(slide.offsetLeft - track.scrollLeft) < Math.abs(slides[nearest].offsetLeft - track.scrollLeft)
				? index
				: nearest, currentIndex);
		currentIndex = nearestSlide;
	});
});

window.Alpine.start();
