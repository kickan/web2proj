// THIS CODE WAS CREATED BY KRISTINA ABRAHAMSSON IN MARCH 2022 FOR THE COURSE WEBUTVECKLING II
//-------------------------------------------------------------------------------------------- 

/*
*TABLE OF CONTENTS*

DEFAULT FUNCTIONS
- init
- runFunctions

ABOUT ME
 - getAbout
 - printAboutMe
 - updateAboutMe

 EXPERIENCE
 - createExp
 - getExp
 - printExp
 - deleteExp
 - getSingleExp
 - printExpForm
 - updateExp

 LANGUAGE
 - createLan
 - getLan
 - printLan
 - deleteLan
 - getSingleLan
 - printLanForm
 - UpdateLan

 POST
 - getPosts
 - printPosts
 - deletePost
 - addPost

 USER
 - addUser
 - getUsers

 WEBSITE
 - addWebsite
 - getAllWebsites
 - printWebs
 - deleteWeb

 OTHER
 - fixDate
 - CheckAndPrintResponse

 GRAPHICAL DESIGN
 - imgFunc
 - expandCard
*/

//========== DEFAULT FUNCTIONS ==========//

//Set default admin value
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
        case "blog":
            getPosts(0, "big");
            break;
        case "adminskills":
            admin = true;
            let aboutBtn = document.getElementById("about-btn");
            aboutBtn.addEventListener("click", updateAboutMe);

            let expBtn = document.getElementById("exp-Btn");
            expBtn.addEventListener("click", createExp);

            let lanBtn = document.getElementById("lan-Btn");
            lanBtn.addEventListener("click", createLan);
            getAbout();
            getExp();
            getLan();
            break;
    }
}

//======== ABOUT ME functions ============//

//Fetch about me information from API
function getAbout() {
    fetch("API/about.php")
        .then(response => response.json())
        .then(data => printAboutMe(data));
}

//Print about me information
function printAboutMe(data) {
    //Get element referenses
    let sloganEl = document.getElementById("slogan");
    let contentEl = document.getElementById("about-content");

    //Set values of elements
    sloganEl.value = data[0].slogan;
    contentEl.innerHTML = data[0].content;
}

//Update about me information
function updateAboutMe(event) {
    event.preventDefault();

    let formData = new FormData();

    //Get form elements
    let slogan = document.getElementById("slogan");
    let content = document.getElementById("about-content");

    //Append form values
    formData.append("slogan", slogan.value);
    formData.append("content", content.value);

    //POST data to API
    fetch("API/about.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => checkAndPrintResponse(data, "about-message", []));
}

//============ EXPERIENCE FUNCTIONS =============//

//Create new experience via API
function createExp() {
    event.preventDefault();
    let formData = new FormData();

    //Get form elements
    let type = document.getElementById("exp-type");
    let title = document.getElementById("title");
    let loc = document.getElementById("location");
    let sDate = document.getElementById("startdate");
    let eDate = document.getElementById("enddate");
    let content = document.getElementById("exp-content");

    //Append form values
    formData.append("type", type.value);
    formData.append("title", title.value);
    formData.append("location", loc.value);
    formData.append("startdate", sDate.value);
    formData.append("enddate", eDate.value);
    formData.append("content", content.value);

    //POST data to API
    fetch("API/exp.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => checkAndPrintResponse(data, "exp-message", ["title", "location", "startdate", "enddate", "exp-content"]));

    //Get and print experiences
    getExp();
}

//Fetch experiences from API
function getExp() {
    fetch("API/exp.php")
        .then(response => response.json())
        .then(data => printExp(data));
}

//Print experiences
function printExp(exp) {
    let containerEl = document.getElementById("exp-container");

    //Remove children
    containerEl.innerHTML = "";

    //Loop throgh array and create elems for each exp
    exp.forEach(e => {
        let article = document.createElement("article");
        article.classList.add("card--small");
        article.classList.add("card--green");
        article.addEventListener("click", expandCard);

        let title = document.createElement("h3");
        title.innerHTML = e.title;

        let div = document.createElement("div");
        div.classList.add("card--heading");
        div.appendChild(title);

        //create edit and delete btn if on Admin page
        if (admin) {
            let btnDiv = document.createElement("div");
            btnDiv.classList.add("btnDiv");

            let delBtn = document.createElement("button");
            delBtn.classList.add("btn");
            delBtn.classList.add("btn--green");
            delBtn.innerHTML = "Radera";
            delBtn.id = e.id;
            delBtn.addEventListener("click", deleteExp);

            let editBtn = document.createElement("button");
            editBtn.classList.add("btn");
            editBtn.classList.add("btn--white");
            editBtn.id = "e" + e.id;
            editBtn.addEventListener("click", getSingleExp)
            editBtn.innerHTML = "Redigera";

            btnDiv.appendChild(editBtn);
            btnDiv.appendChild(delBtn);

            div.appendChild(btnDiv);
        }

        let loc = document.createElement("p");
        loc.innerHTML = e.location;

        let p = document.createElement("p");
        p.classList.add("flexi-cont");
        let text = document.createTextNode(e.content);
        p.appendChild(text);

        //append elements
        article.appendChild(div);
        article.appendChild(loc);
        article.appendChild(p);

        containerEl.append(article);
    })
}

//Delete experience via API
function deleteExp() {
    event.preventDefault();
    let id = this.id;
    let url = "API/exp.php?delete=" + id;
    fetch(url)
        .then(response => response.json())
        .then(data => console.log(data))
    getExp();
}

//Get single experience through API
function getSingleExp() {
    let form = document.getElementById("exp-form");

    //Scroll to form 
    form.scrollIntoView();

    event.preventDefault();
    //Get ID from element
    let id = this.id;
    id = id[1];

    //send id to API with GET and recive data for single post
    let url = "API/exp.php?getSingle=" + id;
    fetch(url)
        .then(response => response.json())
        .then(data => printExpForm(data))
}

//Print experience data into experience form
function printExpForm(exp) {
    //Get element references
    let type = document.getElementById("exp-type");
    let title = document.getElementById("title");
    let loc = document.getElementById("location");
    let sDate = document.getElementById("startdate");
    let eDate = document.getElementById("enddate");
    let content = document.getElementById("exp-content");

    //Set values
    type.value = exp[0].type;
    title.value = exp[0].title;
    loc.value = exp[0].location;
    sDate.value = exp[0].startDate;
    eDate.value = exp[0].endDate;
    content.value = exp[0].content;

    //Add "save changes"-btn
    let btn = document.createElement("button");
    btn.classList.add("btn");
    btn.classList.add("btn--green");
    btn.innerHTML = "Spara ändringar";
    btn.id = exp[0].id;
    btn.addEventListener("click", updateExp);
    content.parentNode.appendChild(btn);

    //hide save-btn
    let saveBtn = document.getElementById("exp-Btn");
    saveBtn.style.display = "none";
}

//Update Experience with data from form via API
function updateExp() {
    event.preventDefault();
    //Get experience ID from element
    let id = this.id;

    //Create new form data
    let formData = new FormData();

    //Get form elements
    let type = document.getElementById("exp-type");
    let title = document.getElementById("title");
    let loc = document.getElementById("location");
    let sDate = document.getElementById("startdate");
    let eDate = document.getElementById("enddate");
    let content = document.getElementById("exp-content");
    console.log(title);

    //Append form values
    formData.append("update", id);
    formData.append("type", type.value);
    formData.append("title", title.value);
    formData.append("location", loc.value);
    formData.append("startDate", sDate.value);
    formData.append("endDate", eDate.value);
    formData.append("content", content.value);

    //POST data to API
    fetch("API/exp.php?update=", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => checkAndPrintResponse(data, "exp-message", ["title", "location", "startdate", "enddate", "exp-content"]));

    //Remove update btn
    title.parentNode.removeChild(title.parentNode.lastChild);

    //Make saveBtn visable
    let saveBtn = document.getElementById("exp-Btn");
    saveBtn.style.display = "block";

    //Get and print experiences
    getExp();
}

//============ LANGUAGE FUNCTIONS ============//

//Create new language via API
function createLan() {
    event.preventDefault();
    let formData = new FormData();

    //Get form elements
    let type = document.getElementById("lan-type");
    let name = document.getElementById("name");
    let level = document.getElementById("level");


    //Append form values
    formData.append("type", type.value);
    formData.append("name", name.value);
    formData.append("level", level.value);

    //POST data to API
    fetch("API/lan.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => checkAndPrintResponse(data, "lan-message", ["name", "level"]));

    //Get and print languages
    getLan();
}

//Get languages from API
function getLan() {
    fetch("API/lan.php")
        .then(response => response.json())
        .then(data => printLan(data));
}

//Print languages to page
function printLan(lan) {
    //Print experiences
    let containerEl = document.getElementById("lan-container");

    //Remove children
    containerEl.innerHTML = "";

    //Loop through list of languages and create elements
    lan.forEach(l => {
        let article = document.createElement("article");
        article.classList.add("card--small");
        article.classList.add("card--green");

        let title = document.createElement("h3");
        title.innerHTML = l.name;

        let div = document.createElement("div");
        div.classList.add("card--heading");
        div.appendChild(title);

        //create edit and delete btns if on admin page
        if (admin) {
            let btnDiv = document.createElement("div");
            btnDiv.classList.add("btnDiv");

            let delBtn = document.createElement("button");
            delBtn.classList.add("btn");
            delBtn.classList.add("btn--green");
            delBtn.innerHTML = "Radera";
            delBtn.id = l.id;
            delBtn.addEventListener("click", deleteLan);

            let editBtn = document.createElement("button");
            editBtn.classList.add("btn");
            editBtn.classList.add("btn--white");
            editBtn.id = "e" + l.id;
            editBtn.addEventListener("click", getSingleLan)
            editBtn.innerHTML = "Redigera";

            //Append elements
            btnDiv.appendChild(editBtn);
            btnDiv.appendChild(delBtn);
            div.appendChild(btnDiv);
        }
        //Append elements
        article.appendChild(div);
        containerEl.append(article);
    })
}

//Delete single Language via API
function deleteLan() {
    event.preventDefault();
    //Get lan ID from this element
    let id = this.id;
    let url = "API/lan.php?delete=" + id;
    fetch(url)
        .then(response => response.json())
        .then(data => console.log(data))
    //Get and print languages
    getLan();
}

//Get data for single language via API
function getSingleLan() {
    let form = document.getElementById("lan-form");

    //Scroll to form
    form.scrollIntoView();
    event.preventDefault();
    //Get id from element
    let id = this.id;
    id = id[1];
    let url = "API/lan.php?getSingle=" + id;
    fetch(url)
        .then(response => response.json())
        .then(data => printLanForm(data))
}

//Print language data into form
function printLanForm(lan) {
    //Get element references
    let type = document.getElementById("lan-type");
    let name = document.getElementById("name");
    let level = document.getElementById("level");

    //Set values
    type.value = lan[0].type;
    name.value = lan[0].name;
    level.value = lan[0].level;

    //Fix buttons
    let btn = document.createElement("button");
    btn.classList.add("btn");
    btn.classList.add("btn--green");
    btn.innerHTML = "Spara ändringar";
    btn.id = lan[0].id;
    btn.addEventListener("click", updateLan);
    name.parentNode.appendChild(btn);

    //hide save btn
    let saveBtn = document.getElementById("lan-Btn");
    saveBtn.style.display = "none";
}

//Updata single language via API
function updateLan() {
    event.preventDefault();
    //Get ID from element
    let id = this.id;
    let formData = new FormData();

    //Get form elements
    let type = document.getElementById("lan-type");
    let name = document.getElementById("name");
    let level = document.getElementById("level");

    //Append form values
    formData.append("update", id);
    formData.append("type", type.value);
    formData.append("name", name.value);
    formData.append("level", level.value);

    //POST data to API
    fetch("API/lan.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => checkAndPrintResponse(data, "lan-message", ["name", "level"]));

    //Remove update btn
    name.parentNode.removeChild(name.parentNode.lastChild);

    //Make saveBtn visable
    let saveBtn = document.getElementById("lan-Btn");
    saveBtn.style.display = "block";

    //Get and print languages
    getLan();
}

//===========POST FUNCTIONS ==============//

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

    //Check for type of card to be created
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
    //Get and print posts
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
        .then(data => checkAndPrintResponse(data, "post-message", ["title", "content", "file", "imgtext"]));

    //Update list of posts
    getPosts(0, "small");
}

//===========USER FUNCTIONS ============//

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
        .then(data => checkAndPrintResponse(data, "user-message", ["name", "username"]));

    //Empty password fields
    pass1Input.value = "";
    pass2Input.value = "";

    //Get and print users
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

//=========== WEBSITE FUNCTIONS ============//

//Add new website through API
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
        .then(data => checkAndPrintResponse(data, "web-message", ["title", "file", "content", "link"]));

    //Get and print websites
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
        img.alt = "";
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

function deleteWeb() {
    event.preventDefault();
    let id = this.id;
    let url = "API/web.php?delete=" + id;
    fetch(url)
        .then(response => response.json())
        .then(data => console.log(data))
    getAllWebsites();
}

//========= OTHER FUNCTIONS =========//

//Fix database date to another format
function fixDate(stringDate) {
    const d = new Date(stringDate);
    let returnDate = d.getDate() + "/" + d.getMonth() + "-" + d.getFullYear() + " kl. " + d.getHours() + ":" + d.getMinutes();

    return returnDate;
}

//Check and print response from API into message element (messEl).
//Empty elements in lst if ok response
function checkAndPrintResponse(data, messEl, lst) {
    //Get reference to messagebox
    let box = document.getElementById(messEl);

    //Empty box content
    box.innerHTML = "";

    let errorno = parseInt(data.error);

    //Check response
    if (errorno == 0) {
        //Print message
        let p = document.createElement("p");
        p.classList.add("ok-message");
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
            p.classList.add("error");
            p.innerHTML = messages[i];
            box.appendChild(p);
        }
    }
}

//================== Graphical design ===================//

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
        }
    })
}

//Expand blogposts card on click
function expandCard() {
    let elements = this.getElementsByClassName("flexi-cont");
    if (window.getComputedStyle(elements[0], null).display === "none") {
        for (let i = 0; i < elements.length; i++) {
            elements[i].style.display = "block";
        }
    } else {
        for (let i = 0; i < elements.length; i++) {
            elements[i].style.display = "none";
        }
    }
}