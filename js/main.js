
function init() {
    runFunctions();
}
window.addEventListener("load", init);

function runFunctions() {
    let page = document.body.id;
    switch (page) {
        case "index":
            getLatestPosts();
            break;
        case "adminuser":
            getUsers();
            const addUserBtn = document.getElementById("addUserBtn");
            addUserBtn.addEventListener("click", addUser(event));
            break;
    }
}


//Fetch latest posts from post API
function getLatestPosts() {
    fetch("API/post.php")
        .then(response => response.json())
        .then(data => writePosts(data));
}

//Write posts to screen
function writePosts(posts) {
    const contEl = document.getElementById("post-container");

    contEl.innerHTML = ""; //Empty element

    posts.forEach(post => {
        //Create elements and add data from post
        let cont = document.createElement("article");
        cont.classList.add("card--green");
        cont.classList.add("card");

        let h2 = document.createElement("h2");
        let h2text = document.createTextNode(post.title);
        h2.appendChild(h2text);

        let time = document.createElement("p");
        let timeText = document.createTextNode(post.created);
        time.appendChild(timeText);

        let text = document.createElement("p");
        let textText = document.createTextNode(post.content);
        text.appendChild(textText);

        let link = document.createElement("a");
        link.href = "single.php?id=" + post.id;
        link.innerHTML = "Läs mer";

        cont.appendChild(h2);
        cont.appendChild(time);
        cont.appendChild(text);
        cont.appendChild(link);

        contEl.appendChild(cont);
    })
}

function addUser(e){
    e.preventDefault();
    let formData = new FormData();

    const nameInput = document.getElementById("name");
    const usernameInput = document.getElementById("username");
    const pass1Input = document.getElementById("password1");
    const pass2Input = document.getElementById("password2");

    let lst = [nameInput.value, usernameInput.value, pass1Input.value, pass2Input.value];
    console.log(lst);
    formData.append("name", nameInput.value);
    formData.append("username", usernameInput.value);
    formData.append("password1", pass1Input.value);
    formData.append("password2",pass2Input.value);

    fetch("API/user.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => console.log(data));

    getUsers();
}

function getUsers() {
    fetch("API/user.php")
        .then(response => response.json())
        .then(data => writeUsers(data));
}

function writeUsers(users) {
    const ulEl = document.getElementById("user-lst");

    //Clear list
    ulEl.innerHTML = "";

    users.forEach(user => {
        let liEl = document.createElement("li");
        let liText = document.createTextNode(user.name);

        liEl.appendChild(liText);
        ulEl.appendChild(liEl);
    })
}