class Area {
	constructor(
		options = {
			id: undefined,
			name: undefined,
			description: undefined,
			locate: undefined,
			weathered: undefined,
		},
	) {
		this.id = options.id;
		this.name = options.name;
		this.description = options.description;
		this.locate = options.locate;
		this.weathered = options.false;
	}

	getFormData() {
		const formData = new FormData();
		formData.append("id", this.id);
		formData.append("name", this.name);
		formData.append("description", this.description);
		formData.append("locate", this.locate);
		formData.append("weathered", this.weathered);
		return formData;
	}

	async insert() {
		try {
			const data = await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/areas",
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

	async list() {
		try {
			const data = await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/areas",
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

	async delete() {
		try {
			const data = await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/areas/delete",
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

	async update() {
		try {
			const data = await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/areas/update",
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
}

export default Area;
