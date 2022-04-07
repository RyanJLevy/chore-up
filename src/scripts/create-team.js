let addedUsers = []
let addedUsersContainer = document.querySelector("#added-user-container")
let userInfo

function getUserInfo() {
    $.ajax({
        method: "GET",
        url: "./get-user-info.php",
        success: function (result) {
            // console.log(result)
            userInfo = JSON.parse(result)
            // console.log(userInfo)
        }
    })
}

function fillPlayersContainer() {
    addedUsersContainer.innerHTML = ""
    for (var i = 0; i < addedUsers.length; i++) {
        let currUsername = addedUsers[i][0].username
        let currID = parseInt(addedUsers[i][0].id)
        let userString = `
        <div class="user-card">
            <p class="card-username">${currUsername}</p>
            <button class="primary-btn btn-remove" onclick='handleUserRemoveClick(event, ${currID})'>X</button>
        </div>
        `;
        addedUsersContainer.innerHTML += userString
    }
}

function handleUserRemoveClick(event, removeID) {
    event.preventDefault()
    if (confirm("are you sure you want to delete this user from your team?")) {
        // console.log(addedUsers)
        addedUsers = addedUsers.filter(users => {
            // console.log("addID: " + users[0].id + " Remove: " + removeID)
            return users[0].id !== removeID
        })
        // console.log(event.srcElement.parentElement)
        event.srcElement.parentElement.remove()
        // console.log(addedUsers)
    }
}

document.querySelector("#user-search-btn").onclick = function(event) {
    event.preventDefault()
    let searchValue = document.querySelector("#user-name-input").value.trim()


    // let urlString = "add-user.php?username=" + searchValue;
    let searchResults

    $.ajax({
        method : "GET",
        url : "./add-user.php",
        data : {
            username : searchValue
        },
        success: function(result) {
            if (result === "[]") {
                alert("user not found")
            }
            else if (result === "self") {
                console.log("SELF")
            }
            else {
                // console.log(result)
                searchResults = JSON.parse(result)
                addedUsers.push(searchResults)
                // console.log(addedUsers)
                fillPlayersContainer()
            }
            document.querySelector("#user-name-input").value = ""
        }
    })
    // ajaxGet(urlString, function(result) {
    //     console.log(result)
    // })
}

document.querySelector("#create-team-btn").onclick = function (event) {
    event.preventDefault()
    let teamName = document.querySelector("#team-name-input").value.trim()
    let playersIDs = []
    for (user in addedUsers) {
        // console.log(addedUsers[user])
        playersIDs.push(addedUsers[user][0].id)
    }
    if (teamName.trim().length === 0 || playersIDs.length === 0) {
        alert("all fields must be filled out!")
        return
    }
    // console.log(JSON.stringify(playersIDs))
    // let playersJSON = JSON.stringify(addedUsers)
    // console.log(playersJSON)
    $.ajax({
        method : "POST",
        url : "./create-team.php",
        data : {
            creatorID: userInfo.id,
            teamName: teamName,
            player_ids: playersIDs
        },
        success: function(result) {
            if (result === "success") {
                console.log(result)
                alert("team created sucessfully!")
                document.location.href = "home.php"
            }
            else {
                console.log(result)
                alert("team could not be created.")
            }
        }
    })
}

getUserInfo()