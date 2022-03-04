let admin = false;


//Function to run when page is loaded
function init() {
    runFunctions();
}

window.addEventListener("load", init);

//Run different functions depending on which page is loaded
function runFunctions() {
    let page = document.body.id;
    switch (page) {
        case "index":
            imgFunc();
            getPosts(3, "big");
            break;
        case "adminuser":
            admin = true;
            getUsers();
            const addUserBtn = document.getElementById("addUserBtn");
            addUserBtn.addEventListener("click", addUser);
            break;
        case "adminblog":
            admin = true;
            const addPostBtn = document.getElementById("addPostBtn");
            addPostBtn.addEventListener("click", addPost);
            getPosts(0, "small");
            break;
        case "admin":
            admin = true;
            let webBtn = document.getElementById("webBtn");
            webBtn.addEventListener("click", addWebsite);
            getAllWebsites();
            break;
    }
}

//Img animation index page
function imgFunc() {
    let img1 = document.getElementById("img1");
    let img2 = document.getElementById("img2");
    let img3 = document.getElementById("img3");

    document.addEventListener("scroll", function () {
        let value = window.scrollY;
        if (value < 76) {
            img1.style.opacity = "1";
            img2.style.opacity = "0";
            img3.style.opacity = "0";

        }
        else if (value < 176 && value > 76) {
            img1.style.opacity = "0";
            img2.style.opacity = "1";
            img3.style.opacity = "0";
        }
        else {
            img1.style.opacity = "0";
            img2.style.opacity = "0";
            img3.style.opacity = "1";

            //window.setInterval(knitMove, timerStep);

        }
    })
}

//Fetch latest posts from post API
function getPosts(number, type) {
    let url = "API/post.php?number=" + number;

    fetch(url)
        .then(response => response.json())
        .then(data => printPosts(data, type));
}

//Print posts to on public pages
function printPosts(posts, type) {
    const contEl = document.getElementById("post-container");

    contEl.innerHTML = ""; //Empty element

    if (type == "big") {
        posts.forEach(post => {
            //Create elements and add data from post
            let cont = document.createElement("article");
            cont.id = post.id;
            cont.classList.add("card--green");
            cont.classList.add("card");

            let h2 = document.createElement("h2");
            let h2text = document.createTextNode(post.title);
            h2.appendChild(h2text);

            let time = document.createElement("p");
            let timeText = document.createTextNode(post.created);
            time.appendChild(timeText);

            let img = document.createElement("img");
            img.src = "img/" + post.img;
            img.alt = post.imgtext;

            let text = document.createElement("p");
            let content = post.content.split(" ", 50);
            content = content.join(" ") + "...";
            let textText = document.createTextNode(content);
            text.appendChild(textText);

            let link = document.createElement("a");
            link.href = "single.php?id=" + post.id;
            link.innerHTML = "Läs mer";

            //Append elements to article
            cont.appendChild(h2);
            cont.appendChild(time);
            cont.appendChild(img);
            cont.appendChild(text);
            cont.appendChild(link);

            //Append article to container
            contEl.appendChild(cont);
        })
    } else if (type == "small") {
        posts.forEach(post => {
            //Create elements and add data from post
            let cont = document.createElement("article");
            cont.classList.add("card--green");
            cont.classList.add("card--small");
            cont.addEventListener("click", expandCard);

            let div = document.createElement("div");
            div.classList.add("card--heading");


            let h2 = document.createElement("h3");
            let h2text = document.createTextNode(post.title);
            h2.appendChild(h2text);
            div.appendChild(h2);
            if (admin) {
                let btnDiv = document.createElement("div");
                btnDiv.classList.add("btnDiv");

                //create edit and delete btn
                let delBtn = document.createElement("button");
                delBtn.classList.add("btn");
                delBtn.classList.add("btn--green");
                delBtn.innerHTML = "Radera";
                delBtn.id = post.id;
                delBtn.addEventListener("click", deletePost);

                let editBtn = document.createElement("button");
                editBtn.classList.add("btn");
                editBtn.classList.add("btn--white");
                editBtn.addEventListener("click", function () {
                    window.location.href = "editpost.php?edit=" + post.id;
                })
                editBtn.innerHTML = "Redigera";

                btnDiv.appendChild(editBtn);
                btnDiv.appendChild(delBtn);

                div.appendChild(btnDiv);
            }
            cont.appendChild(div);

            let time = document.createElement("p");
            let timeText = document.createTextNode(post.created);
            time.appendChild(timeText);
            cont.appendChild(time);

            let img = document.createElement("img");
            img.classList.add("flexi-cont");
            img.src = "img/" + post.img;
            img.alt = post.imgtext;
            cont.appendChild(img);

            let text = document.createElement("p");
            text.classList.add("flexi-cont");
            let content = post.content.split(" ", 50);
            content = content.join(" ") + "...";
            let textText = document.createTextNode(content);
            text.appendChild(textText);
            cont.appendChild(text);

            let link = document.createElement("a");
            link.classList.add("flexi-cont");
            link.href = "single.php?id=" + post.id;
            link.innerHTML = "Läs mer";
            cont.appendChild(link);

            //Append article to container
            contEl.appendChild(cont);
        })
    }

}

//Delete post from DB via API
function deletePost() {
    event.preventDefault();
    let id = this.id;
    let url = "API/post.php?delete=" + id;
    fetch(url)
        .then(response => response.json())
        .then(data => console.log(data))
    getPosts(0, "small")
}

//Add post to db with API
function addPost(event) {
    event.preventDefault();
    let formData = new FormData();

    //Get form elements
    const titleInput = document.getElementById("title");
    const imgInput = document.getElementById("file");
    const imgText = document.getElementById("imgtext");
    const contentInput = document.getElementById("content");

    //Append form values
    formData.append("title", titleInput.value);
    formData.append("content", contentInput.value);
    formData.append("file", imgInput.files[0]);
    formData.append("imgtext", imgText.value);

    //POST data to API
    fetch("API/post.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => checkAndPrintResponse(data, ["title", "content", "file", "imgtext"]));

    //Update list of posts
    getPosts(0, "small");
}

//Add user from form to db using API
function addUser(event) {
    event.preventDefault(); //Prevent page from loading
    let formData = new FormData();

    //Get form elements
    const nameInput = document.getElementById("name");
    const usernameInput = document.getElementById("username");
    const pass1Input = document.getElementById("password1");
    const pass2Input = document.getElementById("password2");

    //Append form values
    formData.append("name", nameInput.value);
    formData.append("username", usernameInput.value);
    formData.append("password1", pass1Input.value);
    formData.append("password2", pass2Input.value);

    //POST users to API
    fetch("API/user.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => checkAndPrintResponse(data, ["name", "username"]));

    //Empty password fields
    pass1Input.value = "";
    pass2Input.value = "";

    getUsers();
}

//Get all users from DB using API
function getUsers() {
    fetch("API/user.php")
        .then(response => response.json())
        .then(data => printUsers(data));
}

//List all users
function printUsers(users) {
    const tableEl = document.getElementById("user-table");

    //Remove all child nodes exept headings
    while (tableEl.childNodes.length > 2) {
        tableEl.removeChild(tableEl.lastChild);
    }

    //List users
    users.forEach(user => {
        let td1 = document.createElement("td");
        let td2 = document.createElement("td");
        let td3 = document.createElement("td");

        let created = fixDate(user.created);

        td1.innerHTML = user.name;
        td2.innerHTML = user.username;
        td3.innerHTML = created;

        let trEl = document.createElement("tr");


        //Append elements
        trEl.appendChild(td1);
        trEl.appendChild(td2);
        trEl.appendChild(td3);

        tableEl.appendChild(trEl);
    })
}

//Fix database date to another format
function fixDate(stringDate) {
    const d = new Date(stringDate);
    let returnDate = d.getDate() + "/" + d.getMonth() + "-" + d.getFullYear() + " kl. " + d.getHours() + ":" + d.getMinutes();

    return returnDate;
}


function checkAndPrintResponse(data, lst) {
    //Get reference to messagebox
    let box = document.getElementById("message-box");

    //Empty box content
    box.innerHTML = "";

    let errorno = parseInt(data.error);

    //Check response
    if (errorno == 0) {
        //Print message
        let p = document.createElement("p");
        p.innerHTML = data.message;
        box.appendChild(p);
        //If user added, empty form
        for (let i = 0; i < lst.length; i++) {
            const inputField = document.getElementById(lst[i]);
            inputField.value = "";
        }

    } else {
        //Split messages into list if several error messages
        let m = data.message;
        let messages = m.split(". ");
        for (let i = 0; i < errorno; i++) {
            //Print error messages
            let p = document.createElement("p");
            p.innerHTML = messages[i];
            box.appendChild(p);
        }
    }
}

function addWebsite(event) {
    event.preventDefault(); //Prevent page from loading
    let formData = new FormData();

    //Get form elements
    const titleInput = document.getElementById("title");
    const imgInput = document.getElementById("file");
    const contentInput = document.getElementById("content");
    const linkInput = document.getElementById("link");

    //Append form values
    formData.append("title", titleInput.value);
    formData.append("content", contentInput.value);
    formData.append("file", imgInput.files[0]);
    formData.append("link", linkInput.value);

    //POST users to API
    fetch("API/web.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => checkAndPrintResponse(data, ["title", "file", "content", "link"]));

    getAllWebsites();
}

//Fetch latest websites from web API
function getAllWebsites() {
    fetch("API/web.php")
        .then(response => response.json())
        .then(data => printWebs(data));
}

//Print websites to portfolio
function printWebs(webs) {
    const contEl = document.getElementById("web-container");
    contEl.innerHTML = ""; //Empty element

    webs.forEach(web => {
        //Create elements and add data from post
        let cont = document.createElement("article");
        cont.classList.add("card--green");
        cont.classList.add("card--small");
        cont.addEventListener("click", expandCard);

        let div = document.createElement("div");
        div.classList.add("card--heading");

        let h3 = document.createElement("h3");
        let h3text = document.createTextNode(web.title);
        h3.appendChild(h3text);
        div.appendChild(h3);

        if (admin) {
            let btnDiv = document.createElement("div");
            btnDiv.classList.add("btnDiv");

            //create edit and delete btn
            let delBtn = document.createElement("button");
            delBtn.classList.add("btn");
            delBtn.classList.add("btn--green");
            delBtn.innerHTML = "Radera";
            delBtn.id = web.id;
            delBtn.addEventListener("click", deleteWeb);

            let editBtn = document.createElement("button");
            editBtn.classList.add("btn");
            editBtn.classList.add("btn--white");
            editBtn.addEventListener("click", function () {
                window.location.href = "edit.php?edit=" + web.id;
            })
            editBtn.innerHTML = "Redigera";

            btnDiv.appendChild(editBtn);
            btnDiv.appendChild(delBtn);

            div.appendChild(btnDiv);
        }
        cont.appendChild(div);

        let img = document.createElement("img");
        img.classList.add("flexi-cont");
        img.src = "img/" + web.img;
        img.alt ="";
        cont.appendChild(img);

        let text = document.createElement("p");
        text.classList.add("flexi-cont");
        let textText = document.createTextNode(web.content);
        text.appendChild(textText);
        cont.appendChild(text);

        let link = document.createElement("a");
        link.classList.add("flexi-cont");
        link.href = web.link;
        link.innerHTML = "Besök webbplats";
        cont.appendChild(link);

        //Append article to container
        contEl.appendChild(cont);
    })

}


//Expand blogposts card on click
function expandCard() {
    let elements = this.getElementsByClassName("flexi-cont");
    if (window.getComputedStyle(elements[1], null).display === "none") {
        for (let i = 0; i < elements.length; i++) {
            elements[i].style.display = "block";
        }
    } else {
        for (let i = 0; i < elements.length; i++) {
            elements[i].style.display = "none";
        }
    }
}

function deleteWeb(){
    event.preventDefault();
    let id = this.id;
    let url = "API/web.php?delete=" + id;
    fetch(url)
        .then(response => response.json())
        .then(data => console.log(data))
    getAllWebsites();
}
