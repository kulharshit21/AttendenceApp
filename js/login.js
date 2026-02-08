$(function() {
    // Capture the keyup event to enable/disable the login button
    $(document).on("keyup", "#email, #password", function(e) {
        $("#diverror").removeClass("applyerrordiv");
        // $("#errormessage").text("");

        let email = $("#email").val().trim();
        let password = $("#password").val().trim();

        if (email !== "" && password !== "") {
            $("#btnLogin").removeClass("inactivecolor").addClass("activecolor");
        } else {
            $("#btnLogin").removeClass("activecolor").addClass("inactivecolor");
        }
    });

    // Handle the click event for the login button
    $(document).on("click", "#btnLogin", function(e) {
        e.preventDefault(); // Prevent the default form submission
        tryLogin();
    });

    function tryLogin() {
        let email = $("#email").val().trim();
        let password = $("#password").val().trim();

        if (email !== "" && password !== "") {
            // Make an AJAX call
            $.ajax({
                url: "ajaxhandler/loginAjax.php", // Update the URL to your login handler
                type: "POST",
                dataType: "json",
                data: { user_name: email, password: password, action: "verifyUser" },
                beforeSend: function() {
                    // If you want to do something just before making the call
                    // alert("about to make an ajax call");
                    $("#diverror").removeClass("applyerrordiv");
                    $("#lockscreen").addClass("applylockscreen");
                    // $("#errormessage").text("");
                },
                success: function(rv) {
                    // If the AJAX call was successful, result will be in rv
                    // alert(JSON.stringify(rv));
                    $("#lockscreen").removeClass("applylockscreen");
                    if (rv['status'] === "ALL OK") {
                        document.location.replace("attendance.php");
                    } else {
                        // alert(rv['status']);
                        $("#diverror").addClass("applyerrordiv");
                        $("#errormessage").text(rv['status']);
                    }
                },
                error: function() {
                    // If for some reason the call was unsuccessful
                    alert("Oops, something went wrong");
                }
            });
        }
    }
});