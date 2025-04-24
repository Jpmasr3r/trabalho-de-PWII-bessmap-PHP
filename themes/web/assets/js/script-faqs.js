const lblFaqs = document.querySelectorAll(".lblFaq");

lblFaqs.forEach(e => {
    let clicked = false;
    e.querySelector("h3").style.display = "none";
    e.addEventListener("click",() => {
        if(clicked) {
            e.querySelector("h3").style.display = "none";
            e.querySelector("h1").querySelector("i").innerHTML = "▶";
        }else {
            e.querySelector("h3").style.display = "flex";
            e.querySelector("h1").querySelector("i").style.rotate = "0deg";
            e.querySelector("h1").querySelector("i").innerHTML = "🔽";
        }
        clicked = !clicked;
    })
})