import Notification from "./Notification.js";

class User {
	name;
	email;
	password;
	confirmPassword;
	image;

	constructor(
		email = "",
		password = "",
		confirmPassword = "",
		name = "",
		image = "",
	) {
		this.name = name;
		this.email = email;
		this.password = password;
		this.confirmPassword = confirmPassword;
		this.image = image;
	}

	//functions
	getFormData() {
		const formData = new FormData();
		formData.append("name", this.name);
		formData.append("email", this.email);
		formData.append("password", this.password);
		formData.append("confirmPassword", this.confirmPassword);
		formData.append("image", this.image);
		return formData;
	}

	async insert() {
		try {
			const data = await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/users",
				{
					method: "POST",
					body: this.getFormData(),
				},
			).then((res) => res.json());

			new Notification(data.message, data.type);

			return data;
		} catch (error) {
			new Notification(error, "error");

			return {
				type: "error",
				message: error,
			};
		}
	}

	async login() {
		try {
			const data = await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/users/login",
				{
					method: "POST",
					body: this.getFormData(),
				},
			).then((res) => res.json());

			new Notification(data.message, data.type);

			return data;
		} catch (error) {
			new Notification(error, "error");

			return {
				type: "error",
				message: error,
			};
		}
	}

	loginOut() {
		try {
			localStorage.removeItem("token");

			new Notification("Deslogado com sucesso", "success");

			return {
				type: "sucess",
				message: "Deslogado com sucesso",
			};
		} catch (error) {
			new Notification(error, "error");

			return {
				type: "error",
				message: error,
			};
		}
	}

	async update() {
		try {
			const data = await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/users/update",
				{
					method: "POST",
					body: this.getFormData(),
					headers: {
						token: localStorage.getItem("token"),
					},
				},
			).then((res) => res.json());

			console.log(data);

			return data;
		} catch (error) {
			return {
				type: "error",
				message: error,
			};
		}
	}

	async updatePassword(newPassword = "", confirmNewPassword = "") {
		try {
			const formData = this.getFormData();
			formData.append("newPassword", newPassword);
			formData.append("confirmNewPassword", confirmNewPassword);
			const data = await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/users/updatePassword",
				{
					method: "POST",
					body: this.getFormData(),
					headers: {
						token: localStorage.getItem("token"),
					},
				},
			).then((res) => res.json());
			return data;
		} catch (error) {
			return {
				type: "error",
				message: error,
			};
		}
	}

	async delete() {
		try {
			const data = await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/users/delete",
				{
					method: "POST",
					body: this.getFormData(),
					headers: {
						token: localStorage.getItem("token"),
					},
				},
			).then((res) => res.json());
			return data;
		} catch (error) {
			return {
				type: "error",
				message: error,
			};
		}
	}

	async logged() {
		try {
			const data = await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/users/logged",
				{
					method: "GET",
					headers: {
						token: localStorage.getItem("token"),
					},
				},
			).then((res) => res.json());

			return data;
		} catch (error) {
			return {
				type: "error",
				message: error,
			};
		}
	}

	async exitTeam() {
		try {
			const data = await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/teams/exit",
				{
					method: "POST",
					headers: {
						token: localStorage.getItem("token"),
					},
				},
			).then((res) => res.json());

			return data;
		} catch (error) {
			return {
				type: "error",
				message: error,
			};
		}
	}

	async getInfs() {
		try {
			const data = await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/users/infs",
				{
					method: "GET",
					headers: {
						token: localStorage.getItem("token"),
					},
				},
			).then((res) => res.json());

			return data;
		} catch (error) {
			new Notification(error, "error");

			return {
				type: "error",
				message: error,
			};
		}
	}

	async changeProfileImage(image) {
		try {
			const formData = new FormData();
			formData.append("image", image);

			const data = await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/upload/image",
				{
					method: "POST",
					body: formData,
					headers: {
						token: localStorage.getItem("token"),
					},
				},
			).then((res) => res.json());

			this.image = data.path;

			await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/users/update",
				{
					method: "POST",
					body: this.getFormData(),
					headers: {
						token: localStorage.getItem("token"),
					},
				},
			).then((res) => res.json());

			return data;
		} catch (error) {
			new Notification(error, "error");

			return {
				type: "error",
				message: error,
			};
		}
	}
}

export default User;
