import User from "../../../_assets/js/User.js";

const inpRegisterName = document.querySelector("#inp-register-name");
const inpRegisterEmail = document.querySelector("#inp-register-email");
const inpRegisterPassword = document.querySelector("#inp-register-password");
const inpRegisterConfirmPassword = document.querySelector(
	"#inp-register-confirm-password",
);

const btnCreate = document.querySelector("#btn-create");
btnCreate.addEventListener("click", async () => {
	const user = new User(
		inpRegisterEmail.value,
		inpRegisterPassword.value,
		inpRegisterConfirmPassword.value,
		inpRegisterName.value,
	);

	const userInsert = await user.insert();
	if (userInsert.type === "success") {
		setTimeout(() => {
			location.href = "http://localhost/trabalho-de-PWII-bessmap-PHP/login";
		}, 1500);
	}
});

const inpLoginEmail = document.querySelector("#inp-login-email");
const inpLoginPassword = document.querySelector("#inp-login-password");

const btnLogin = document.querySelector("#btn-login");
btnLogin.addEventListener("click", async () => {
	const user = new User(inpLoginEmail.value, inpLoginPassword.value);

	const userLogin = await user.login();
	if (userLogin.type === "success") {
		localStorage.setItem("token", userLogin.token);

		setTimeout(() => {
			location.href = "http://localhost/trabalho-de-PWII-bessmap-PHP/app";
		}, 1500);
	}
});
