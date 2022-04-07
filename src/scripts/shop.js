let userID 
if (sessionStorage.getItem("userId")) {
    userID = sessionStorage.getItem("userId")
}

document.querySelector("#buy-pass-btn").onclick = function() {
    $.ajax({
        method: "GET",
        url: "./purchase-pass.php",
        data: {
            user_id: userID
        },
        success: function(result) {
            if (result === "success") {
                alert("successfully purchased a pass!")
                document.location.href = "./home.php"
            }
            else {
                alert("could not purchase pass!")
                // console.log(result)
            }
        }
    })
}