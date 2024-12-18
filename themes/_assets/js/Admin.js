export default class Admin {
	async getUsers() {
		try {
			const data = await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/users",
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

	async getTeams() {
		try {
			const data = await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/teams",
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
}
