import Notification from "./Notification.js";

class Team {
	name;
	team_members;

	constructor(name = "") {
		this.setName(name);
	}

	//setter
	setName(name) {
		this.name = name;
	}

	setTeamMembers(team_members) {
		this.team_members = team_members;
	}

	//getter
	getName() {
		return this.name;
	}

	getTeam_members() {
		return this.team_members;
	}

	getFormData() {
		const formData = new FormData();
		formData.append("name", this.getName());
		formData.append("team_members", this.getTeam_members());
		return formData;
	}

	//functions
	async insert() {
		try {
			const data = await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/teams",
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

	async join() {
		try {
			const data = await fetch(
				`http://localhost/trabalho-de-PWII-bessmap-PHP/api/teams/join`,
				{
					method: "POST",
					body: this.getFormData(),
					headers: {
						token: localStorage.getItem("token"),
					},
				},
			).then((res) => res.json());

			new Notification(data.message, data.type);

			return data;
		} catch (error) {
			return {
				type: "error",
				message: error,
			};
		}
	}

	async update() {
		try {
			const data = await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/teams/update",
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
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/teams/delete",
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
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/teams/infs",
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

	async getAllTeamsByName(name = "") {
		try {
			const data = await fetch(
				`http://localhost/trabalho-de-PWII-bessmap-PHP/api/teams/select/${name}`,
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

	async exit() {
		try {
			const data = await fetch(
				`http://localhost/trabalho-de-PWII-bessmap-PHP/api/teams/exit`,
				{
					method: "POST",
					headers: {
						token: localStorage.getItem("token"),
					},
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
}

export default Team;
