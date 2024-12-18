import User from "../../../_assets/js/User.js";

async function getLogged() {
	const user = new User();
	const data = await user.logged();
	if (!data.logged) {
		location.href = "http://localhost/trabalho-de-PWII-bessmap-PHP/login/";
	}
}
getLogged();

const aLogOut = document.querySelector("#aLogOut");
aLogOut.addEventListener("click", () => {
	const user = new User();
	user.loginOut();
});
