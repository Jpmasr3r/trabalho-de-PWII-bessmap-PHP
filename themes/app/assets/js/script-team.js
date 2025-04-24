import Area from "../../../_assets/js/Area.js";
import Box from "../../../_assets/js/Box.js";
import Notification from "../../../_assets/js/Notification.js";
import Team from "../../../_assets/js/Team.js";
import User from "../../../_assets/js/User.js";
import WindowInput from "../../../_assets/js/WindowInput.js";

const teamName = document.querySelector(".div-team-info h1");
const teamMembersArea = document.querySelector(".div-team-members");

async function update() {
	const userInfs = await new User().getInfs();
	if (!userInfs.data.team_name) {
		insertJoinTeam();
	} else {
		teamName.innerHTML = `${userInfs.data.team_name}✏️`;
		teamName.addEventListener("click", () => {
			editTeamName();
		});

		const team = await new Team().getInfs();

		team.data.members.forEach((member) => {
			insertMember(member.name, member.image);
		});
	}
}
update();

// Funções de equipe
async function editTeamName() {
	const params = await new WindowInput("Novo nome da area").createWindow(
		"Mudar nome da area",
	);

	const response = await new Team(params["Novo nome da area"]).update();
	new Notification(response.message, response.type);

	if (response.type === "success") {
		setTimeout(() => {
			location.reload();
		}, 1000);
	}
}

function insertTeam(team) {
	const div = document.createElement("div");
	const h1 = document.createElement("h1");
	h1.innerHTML = team.name;
	const button = document.createElement("button");
	button.innerHTML = "Juntar-se";
	div.appendChild(h1);
	div.appendChild(button);
	document.querySelector("#div-search").appendChild(div);

	button.addEventListener("click", async () => {
		const teamClass = new Team(team.name);
		const join = await teamClass.join();
		if (join.type === "success") {
			location.href =
				"http://localhost/trabalho-de-PWII-bessmap-PHP/app/equipe";
		}
	});
}

function insertMember(
	memberName = "",
	memberImage = "http://localhost/trabalho-de-PWII-bessmap-PHP/themes/_assets/imgs/bee-black.png",
) {
	const div = document.createElement("div");
	div.className = "team-member";
	const img = document.createElement("img");
	img.src = memberImage;
	const div2 = document.createElement("div");
	div2.className = "team-member-info";
	const h1 = document.createElement("h1");
	h1.innerHTML = memberName;

	div2.appendChild(h1);
	div.appendChild(img);
	div.appendChild(div2);
	teamMembersArea.appendChild(div);
}

function insertJoinTeam() {
	const divArea = document.querySelector("#div-area");
	divArea.removeChild(document.querySelector(".team-focus"));
	const h1 = document.createElement("h1");
	h1.innerHTML =
		"Você não pertence a nenhuma equipe. Deseja se juntar a alguma?";
	divArea.appendChild(h1);

	const div = document.createElement("div");
	const label = document.createElement("label");
	const p = document.createElement("p");
	p.innerHTML = "Nome da equipe";
	const input = document.createElement("input");
	input.type = "text";
	const button = document.createElement("button");
	button.innerHTML = "Pesquisar";
	const divSearch = document.createElement("div");
	divSearch.id = "div-search";

	label.appendChild(p);
	label.appendChild(input);
	div.appendChild(label);
	div.appendChild(button);
	divArea.appendChild(div);
	divArea.appendChild(divSearch);

	button.addEventListener("click", async () => {
		const team = new Team();
		const teamselect = await team.getAllTeamsByName(input.value);

		const btn_2 = document.createElement("button");
		btn_2.innerHTML = "Crie sua própria equipe";
		div.appendChild(btn_2);

		divSearch.innerHTML = "";
		if (teamselect.type === "success") {
			teamselect.data.forEach((e) => {
				insertTeam(e);
			});
		}

		btn_2.addEventListener("click", async () => {
			const newTeam = new Team(input.value);
			await newTeam.insert();
			location.reload();
		});
	});
}

const btnInsertArea = document.querySelector("#btn-insert-area");
btnInsertArea.addEventListener("click", insertArea);

// Funções de área
async function insertArea() {
	const windowInput = new WindowInput(
		"Nome da área",
		"Descrição da área",
		"Localização da área",
	);
	const params = await windowInput.createWindow("Criar área");

	const newArea = new Area({
		name: params["Nome da área"],
		description: params["Descrição da área"],
		locate: params["Localização da área"],
	});

	const data = await newArea.insert();

	new Notification(data.message, data.type);

	listAreas();
}

async function listAreas() {
	const divAreas = document.querySelector("#div-areas");
	divAreas.innerHTML = "<h1>Areas</h1>";
	const response = await new Area().list();

	response.data.forEach((area) => {
		const divArea = document.createElement("div");
		divArea.className = "area";

		const h1 = document.createElement("h1");
		h1.innerHTML = `${area["name"]}✏️`;
		h1.addEventListener("click", () => {
			editArea(area.id);
		});

		const h2 = document.createElement("h2");
		h2.innerHTML = `${area["locate"]}`;
		h2.addEventListener("click", () => {
			editArea(area.id);
		});

		const h3 = document.createElement("h3");
		h3.innerHTML = `${area["description"]}`;
		h3.addEventListener("click", () => {
			editArea(area.id);
		});

		const divBoxes = document.createElement("div");
		divBoxes.className = "div-boxes";

		const buttonBoxes = document.createElement("button");
		buttonBoxes.innerHTML = "Criar Caixa";
		buttonBoxes.addEventListener("click", async () => {
			await newBox(area["id"]);
		});

		const buttonDelete = document.createElement("button");
		buttonDelete.innerHTML = "Deletar";
		buttonDelete.addEventListener("click", () => {
			deleteArea(area.id);
		});

		divArea.appendChild(h1);
		divArea.appendChild(h2);
		divArea.appendChild(h3);
		divArea.appendChild(divBoxes);
		divArea.appendChild(buttonBoxes);
		divArea.appendChild(buttonDelete);

		divAreas.appendChild(divArea);

		listBoxesByArea(area["id"], divBoxes);
	});
}

async function editArea(id) {
	const params = await new WindowInput(
		"Novo nome da area",
		"Nova localização da area",
		"Nova descrição da area",
	).createWindow("Mudar informações da area");

	const response = await new Area({
		name: params["Novo nome da area"],
		locate: params["Nova localização da area"],
		description: params["Nova descrição da area"],
		id: id,
	}).update();

	console.log(response);

	new Notification(response.message, response.type);
	if (response.type === "success") {
		setTimeout(() => {
			location.reload();
		}, 1000);
	}
}

async function newBox(area_id) {
	const windowInput = new WindowInput("Indentificador da caixa");
	const params = await windowInput.createWindow("Criar Caixa");

	const box = new Box({
		identifier: params["Indentificador da caixa"],
		area_id: area_id,
	});

	const response = await box.insert();
	new Notification(response.message, response.type);
	if (response.type === "success") {
		setTimeout(() => {
			location.reload();
		}, 1000);
	}
}

async function listBoxesByArea(area_id, divBoxes) {
	const boxes = await new Box({
		area_id: area_id,
	}).list();

	boxes.data.forEach((box) => {
		const div = document.createElement("div");
		div.className = "box";

		const h1_identifier = document.createElement("h1");
		h1_identifier.innerHTML = `${box.identifier}✏️`;
		h1_identifier.addEventListener("click", () => {
			editBoxName(box.id);
		});

		div.appendChild(h1_identifier);

		const btnDelete = document.createElement("button");
		btnDelete.innerHTML = "Excluir Caixa";
		btnDelete.addEventListener("click", () => {
			deleteBox(box.id);
		});

		div.appendChild(btnDelete);

		divBoxes.appendChild(div);
	});
}

async function deleteBox(id) {
	const response = await new Box({
		id: id,
	}).delete();

	new Notification(response.message, response.type);
	if (response.type === "success") {
		setTimeout(() => {
			location.reload();
		}, 1000);
	}
}

async function deleteArea(id) {
	const response = await new Area({
		id: id,
	}).delete();

	new Notification(response.message, response.type);
	if (response.type === "success") {
		setTimeout(() => {
			location.reload();
		}, 1000);
	}
}

async function editBoxName(id) {
	const params = await new WindowInput(
		"Novo indentificador da caixa",
	).createWindow("Mudar informações da caixa");

	const response = await new Box({
		id: id,
		identifier: params["Novo indentificador da caixa"],
	}).update();

	new Notification(response.message, response.type);
	if (response.type === "success") {
		setTimeout(() => {
			location.reload();
		}, 1000);
	}
}

const btnExit = document.querySelector("#btn-exit-team");
btnExit.addEventListener("click", async () => {
	const team = await new Team().exit();
	if (team.type === "success") {
		location.reload();
	}
});

const btnDelete = document.querySelector("#btn-delete-team");
btnDelete.addEventListener("click", async () => {
	const team = await new Team().delete();

	if (team.type === "success") {
		location.reload();
	}
});

listAreas();
