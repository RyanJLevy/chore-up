let userInfo

function getUserInfo() {
    $.ajax({
        method: "GET",
        url: "./get-user-info.php",
        success: function (result) {
            // console.log(result)
            userInfo = JSON.parse(result)
            // console.log(userInfo)
            sessionStorage.setItem("userId", userInfo.id)
        }
    })
}

function handleTeamBtnClick(event) {
    // console.log(event)
    document.location.href = "team-info.php?team_id=" + event.srcElement.dataset.teamId
}

getUserInfo()