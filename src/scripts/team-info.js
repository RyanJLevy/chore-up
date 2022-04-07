let userID = sessionStorage.getItem("userId")

let addChorePopupWindow = document.querySelector("#add-chore-popup")
let popupOverlay = document.querySelector("#popup-overlay")

let teamID = document.querySelector("#team-info-container").dataset.teamId
let teamPlayers

// Favorite Handling
let favoritesList = []
if (localStorage.getItem("favorite")) {
    favoritesList = JSON.parse(localStorage.getItem("favorite"))
}

let favoriteBtn = document.querySelector("#btn-favorite")
let isFavorite = false
if (favoritesList.includes(teamID)) {
    isFavorite = true
    favoriteBtn.innerHTML = `<i class="fas fa-star"></i>`
    favoriteBtn.style.color = "var(--primary-color)"
}

document.querySelector("#btn-favorite").onclick = function() {
    if (!isFavorite) {
        alert("added team to favorites!")
        favoritesList.push(teamID)
        localStorage.setItem("favorite", JSON.stringify(favoritesList))
        favoriteBtn.innerHTML = `<i class="fas fa-star"></i>`
        favoriteBtn.style.color = "var(--primary-color)"
        isFavorite = true
    }
    else {
        let index = favoritesList.indexOf(teamID)
        favoritesList.splice(index, 1)
        localStorage.setItem("favorite", JSON.stringify(favoritesList))
        favoriteBtn.innerHTML = `<i class="far fa-star"></i>`
        favoriteBtn.style.color = "var(--secondary-color)"
        isFavorite = false
    }
}

function handlePopupExit(popupName) {
    document.querySelector("#"+popupName).style.display = "none"
    popupOverlay.style.display = "none"
}

// Team Info View More
let moreInfoContainer = document.querySelector("#team-info-more")
let teamInfoContainer = document.querySelector(".team-info")
document.querySelector("#btn-team-info-view").onclick = function(event) {
    if (moreInfoContainer.style.display !== "flex") {
        teamInfoContainer.style.width = "auto"
        moreInfoContainer.style.display = "flex"
    }
    else {
        teamInfoContainer.style.width = "40%"
        moreInfoContainer.style.display = "none"
    }
}

document.querySelector("#add-chore-btn").onclick = function () {
    addChorePopupWindow.style.display = "flex"
    document.querySelector("#chore-name").value = ""
    document.querySelector("#chore-user").value = "-1"
    popupOverlay.style.display = "block"
}

document.querySelector("#create-chore-btn").onclick = function() {
    let choreUser = document.querySelector("#chore-user")
    let choreName = document.querySelector("#chore-name")

    if (choreName.value.trim().length === 0 || choreUser.value === "-1") {
        alert("must fill out all fields!")
        // console.log("Invalid")
    }
    else {
        let user = choreUser.value
        let name = choreName.value.trim()
        // console.log(teamID + " " + user + " " + name)
        $.ajax({
            method: "POST",
            url : "./add-chore.php",
            data: {
                chore_title: name,
                team_id: teamID,
                user_id: user
            },
            success: function(result) {
                if (result === "success") {
                    handlePopupExit("add-chore-popup")
                    getAllChores()
                }
                else {
                    console.log(result)
                }
            }
        })
    }

}

let todoContainer = document.querySelector("#todo-card-container")
let completedContainer = document.querySelector("#completed-card-container")

function displayChores(choresList) {
    // console.log(choresList)
    todoContainer.innerHTML = ""
    completedContainer.innerHTML = ""
    choresList.forEach(chore => {
        let choreData = JSON.stringify(chore)
        let choreString
        let complete = parseInt(chore.is_complete)
        if (complete) {
            choreString = `
            <div data-chore-info='${choreData}' class="chore-card">
                <h1>${chore.chore_name}</h1>
                <div>
                    <button class="view-more-btn" onclick="handleViewChoreClick(event)"><i class="fas fa-ellipsis-h"></i></button>
                </div>
            </div>
            `;
            completedContainer.innerHTML += choreString
        }
        else {
            choreString = `
            <div data-chore-info='${choreData}' class="chore-card">
                <h1>${chore.chore_name}</h1>
                <div class="chore-card-btn-container">
                    <button class="view-more-btn" onclick="handleViewChoreClick(event)"><i class="fas fa-ellipsis-h"></i></button>
                    <button class="delete-chore-btn" onclick="handleDeleteChoreClick(event)"><i class="fas fa-trash"></i></button>
                </div>
            </div>
            `;
            todoContainer.innerHTML += choreString
        }
    });
}

function getPlayerInfo(id) {
    $.ajax({
        method: "GET",
        url: "./get-users-in-team.php",
        data: {
            team_id: teamID
        },
        success: function(result) {
            // console.log(result)
            teamPlayers = JSON.parse(result)
        }
    })
}

// VIEW CHORE CLICK
let choreInfoPopup = document.querySelector("#chore-info-popup")
let choreInfoContainer = document.querySelector("#chore-info-container")
async function handleViewChoreClick(event) {
    choreInfoContainer.innerHTML = ""
    let choreInfo
    if (event.srcElement.className === "view-more-btn") {
        console.log(event.srcElement.parentElement.parentElement)
        choreInfo = event.srcElement.parentElement.parentElement.dataset.choreInfo
    }
    else {
        choreInfo = event.srcElement.parentElement.parentElement.parentElement.dataset.choreInfo
    }

    choreInfo = JSON.parse(choreInfo)
    // console.log(choreInfo)
    let choreInfoString
    if (userID === choreInfo.user_id) {
        if (choreInfo.is_complete === "1") {
            choreInfoString = `
            <h1>${choreInfo.chore_name}</h1>
            <p class="chore-info-header">assigned player</p>
            <p class="card-player-name"><i class="fas fa-crown"></i> you</p>
            `;             
        }
        else {
            let choreID = choreInfo.id
            let choreUserID = choreInfo.user_id
            choreInfoString = `
            <h1>${choreInfo.chore_name}</h1>
            <p class="chore-info-header">assigned player</p>
            <p class="card-player-name"><i class="fas fa-crown"></i> you</p>
            <div class="chore-info-btns">
                <button class="primary-btn btn-mark-done" onclick="handleMarkDoneClick('${choreInfo.id}')">mark as done</button>
                <button class="secondary-btn btn-use-pass" onclick="handleUsePassClick('${choreID}', '${choreUserID}')">use pass</button>
            </div>
            `;
        }
    }
    else {
        let playerName = ""
        teamPlayers.forEach(player => {
            if (player.id === choreInfo.user_id) {
                playerName = player.username
            }
        })
        choreInfoString = `
        <h1>${choreInfo.chore_name}</h1>
        <p class="chore-info-header">assigned player</p>
        <p class="card-player-name"><i class="fas fa-user"></i> ${playerName}</p>
        `;        
    }
    choreInfoContainer.innerHTML = choreInfoString
    choreInfoPopup.style.display = "flex"
    popupOverlay.style.display = "block"
}   

// DELETE CHORE CLICK
function handleDeleteChoreClick(event) {
    if (confirm("are you sure you want to delete this chore, doing so will delete it for other players?")) {
        let choreInfo
        if (event.srcElement.className === "delete-chore-btn") {
            // console.log(event.srcElement.parentElement.parentElement)
            choreInfo = event.srcElement.parentElement.parentElement.dataset.choreInfo
        }
        else {
            choreInfo = event.srcElement.parentElement.parentElement.parentElement.dataset.choreInfo
        }
        choreInfo = JSON.parse(choreInfo)
        console.log(choreInfo)

        $.ajax({
            method: "POST",
            url: "./remove-chore.php",
            data: {
                chore_id: choreInfo.id
            },
            success: function(result) {
                if (result === "success") {
                    getAllChores()
                }
                else {
                    console.log(result)
                }
            }
        })
    }
}

// MARK CHORE DONE
function handleMarkDoneClick(id) {
    $.ajax({
        method: "POST",
        url: "./mark-chore-done.php",
        data: {
            chore_id: id,
            user_id: userID
        },
        success: function(result) {
            if (result === "success") {
                handlePopupExit("chore-info-popup")
                getAllChores()
            }
            else {
                console.log(result)
            }
        }
    })
}

// USE PASS ON CHORE
function handleUsePassClick(choreID, userID) {
    // console.log(choreID)
    // console.log(userID)
    $.ajax({
        method: "GET",
        url: "./use-pass.php",
        data: {
            chore_id: choreID,
            user_id: userID
        },
        success: function(result) {
            if (result === "success") {
                handlePopupExit("chore-info-popup")
                getAllChores()
            }
            else {
                console.log(result)
                alert("sorry, you don't have any passes!")
            }
        }
    })
}

function getAllChores() {
    console.log(teamID)
    $.ajax({
        method: "GET",
        url: "./get-all-chores.php",
        data: {
            team_id: teamID
        },
        success: function(result) {
            console.log(result)
            displayChores(JSON.parse(result))
        }
    })
}

window.onload = function() {
    getPlayerInfo()
    getAllChores()  
}
