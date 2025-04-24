class WindowInput {
	params = {};

	constructor(...forms) {
		this.forms = forms;
	}

	createWindow(text = "enviar") {
		return new Promise((resolve) => {
			const inputs = [];
			const div = document.createElement("div");
			div.id = "div-window-input";

			const btnExit = document.createElement("button");
			btnExit.innerHTML = "X";
			btnExit.addEventListener("click", () => {
				location.reload();
			});

			div.appendChild(btnExit);

			this.forms.forEach((e, index) => {
				const label = document.createElement("label");
				label.style.display = "block";
				label.style.marginBottom = "10px";

				const input = document.createElement("input");
				input.className = e;
				input.placeholder = `Digite ${e}`;
				input.tabIndex = index + 1; // Adiciona tabIndex para navegação

				const p = document.createElement("p");
				p.textContent = e;
				p.style.margin = "0";

				label.appendChild(p);
				label.appendChild(input);
				div.appendChild(label);
				inputs.push(input);

				// Adiciona o evento de keypress para submeter ao pressionar Enter
				input.addEventListener("keypress", (event) => {
					if (event.key === "Enter") {
						event.preventDefault(); // Previne o comportamento padrão

						// Se for o último input, clica no botão
						if (index === inputs.length - 1) {
							button.click();
						} else {
							// Foca no próximo input
							inputs[index + 1].focus();
						}
					}
				});
			});

			const button = document.createElement("button");
			button.textContent = text;
			button.style.marginTop = "10px";

			div.appendChild(button);
			document.body.appendChild(div);
			div.scrollIntoView({ behavior: "smooth" });

			button.addEventListener("click", () => {
				if (document.body.contains(div)) {
					document.body.removeChild(div);
				}

				inputs.forEach((input) => {
					this.params[input.className] = input.value;
				});

				resolve(this.params);
			});
		});
	}
}

export default WindowInput;
