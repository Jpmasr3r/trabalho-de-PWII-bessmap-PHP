class Box {
	constructor(
		options = {
			id: "",
			area_id: "",
			identifier: "",
			collect_status: "",
		},
	) {
		this.id = options.id;
		this.area_id = options.area_id;
		this.identifier = options.identifier;
		this.collect_status = options.collect_status;
	}

	// Method to get data as FormData
	getFormData() {
		const formData = new FormData();
		formData.append("identifier", this.identifier);
		formData.append("collect_status", this.collect_status);
		formData.append("area_id", this.area_id);
		formData.append("id", this.id);
		return formData;
	}

	async insert() {
		try {
			const data = await fetch(
				"http://localhost/trabalho-de-PWII-bessmap-PHP/api/boxes",
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
				`http://localhost/trabalho-de-PWII-bessmap-PHP/api/boxes/${this.area_id}`,
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
				`http://localhost/trabalho-de-PWII-bessmap-PHP/api/boxes/delete`,
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
				`http://localhost/trabalho-de-PWII-bessmap-PHP/api/boxes/update`,
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

export default Box;
