import Notification from "../../../_assets/js/Notification.js";
import User from "../../../_assets/js/User.js";

const profile = document.querySelector("#div-profile");
const profileInfo = document.querySelector("#div-profile-info");

const profileImage = profile.querySelector("img");
const profileName = profileInfo.querySelector("h1");
const profileTeamName = profileInfo.querySelector("p");

async function updateInfs() {
	const user = new User();
	const data = await user.getInfs();
	console.log(data);

	if (data.data.name) {
		profileName.innerHTML = `${data.data.name}`;
	}
	if (data.data.team_name) {
		profileTeamName.innerHTML = data.data.team_name;
	}
	if (data.data.image) {
		profileImage.src = data.data.image;
	}
}
updateInfs();

profileImage.addEventListener("click", () => {
	const label = document.createElement("label");
	label.id = "select_image";
	const p = document.createElement("p");
	p.innerHTML = "Imagem de perfil";
	const input = document.createElement("input");
	input.type = "file";
	input.accept = "image/*";
	const button = document.createElement("button");
	button.innerHTML = "Mudar imagem";

	label.appendChild(p);
	label.appendChild(input);
	label.appendChild(button);
	profile.appendChild(label);

	button.addEventListener("click", async () => {
		const response = await new User().changeProfileImage(input.files[0]);
		new Notification(response.message, response.type);
		if (response.type === "success") {
			setTimeout(() => {
				location.reload();
			}, 1000);
		}
	});
});
