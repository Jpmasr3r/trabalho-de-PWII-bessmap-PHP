class Notification {
	message;
	type;

	constructor(message = "", type = "") {
		this.setMessage(message);
		this.setType(type.toUpperCase());
		this.instance();
	}

	//setters
	setMessage(message) {
		this.message = message;
	}

	setType(type) {
		this.type = type;
	}

	//getters
	getMessage() {
		return this.message;
	}

	getType() {
		return this.type;
	}

	//functions
	instance() {
		const div = document.createElement("div");
		div.className = "divNotification";
		const h1Type = document.createElement("h1");
		h1Type.innerHTML = this.getType();
		const h1Message = document.createElement("h1");
		h1Message.innerHTML = this.getMessage();
		div.appendChild(h1Type);
		div.appendChild(h1Message);
		document.body.appendChild(div);

		setTimeout(() => {
			div.style.left = "150%";
		}, 3000);

		setTimeout(() => {
			document.body.removeChild(div);
		}, 3500);
	}
}

export default Notification;
