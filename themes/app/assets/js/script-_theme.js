import User from "../../../_assets/js/User.js";

async function getLogged() {
    let user = new User();
    let data = await user.logged();
    if (!data.logged) {
        location.href = "http://localhost/beesmap/login/";
    }
}
getLogged();

const aLogOut = document.querySelector("#aLogOut");
aLogOut.addEventListener("click",() => {
    let user = new User();
    user.loginOut();
})  
