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
	const track = carousel.firstElementChild;
	const slides = track?.querySelectorAll(':scope > article');

	if (!track || !slides?.length) {
		return;
	}

	const scrollAmount = () => slides[0].getBoundingClientRect().width + 24;

	carousel.querySelector('[data-carousel-prev]')?.addEventListener('click', () => {
		track.scrollBy({ left: -scrollAmount(), behavior: 'smooth' });
	});

	carousel.querySelector('[data-carousel-next]')?.addEventListener('click', () => {
		track.scrollBy({ left: scrollAmount(), behavior: 'smooth' });
	});
});

window.Alpine.start();
