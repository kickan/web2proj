
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
            getLatestPosts();
            break;
        case "adminuser":
            getUsers();
            const addUserBtn = document.getElementById("addUserBtn");
            addUserBtn.addEventListener("click", addUser);
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

        //Append elements to article
        cont.appendChild(h2);
        cont.appendChild(time);
        cont.appendChild(text);
        cont.appendChild(link);

        //Append article to container
        contEl.appendChild(cont);
    })
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

    //POST data to API
    fetch("API/user.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => checkAndPrintResponse(data));

    //Empty password fields
    pass1Input.value = "";
    pass2Input.value = "";

    getUsers();
}

//Get all users from DB using API
function getUsers() {
    fetch("API/user.php")
        .then(response => response.json())
        .then(data => writeUsers(data));
}

//List all users
function writeUsers(users) {
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


function checkAndPrintResponse(data) {
    //Get reference to messagebox
    let box = document.getElementById("message-box");

    //Get reference to form elements
    const nameInput = document.getElementById("name");
    const usernameInput = document.getElementById("username");

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
        nameInput.value = "";
        usernameInput.value = "";
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