<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
       

    </script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom JS -->
    <script src="js/login.js"></script>
    <style>
        /* Custom styles for error message */
        .applyerrordiv {
            display: block;
        }
        .applylockscreen {
            display: block;
        }
        .inactivecolor {
            opacity: 0.5;
            pointer-events: none;
        }
        .activecolor {
            opacity: 1;
            pointer-events: auto;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 flex items-center justify-center min-h-screen">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800 dark:text-white">Sign In</h2>
        <form id="loginForm" class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email address</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-white dark:bg-gray-700 dark:text-white" required>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-white dark:bg-gray-700 dark:text-white" required>
            </div>
            <div>
                <button id="btnLogin" type="button" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ">
                    Sign in
                </button>
            </div>
            <div id="diverror" class="hidden mt-2 text-sm text-red-600 dark:text-red-400">
                <span id="errormessage"></span>
            </div>
        </form>
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">Or continue with</p>
            <div class="mt-2">
                <button id="googleSignIn" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-sm font-medium text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="Google Logo" class="h-5 mr-2">
                    Sign in with Google
                </button>
            </div>
        
        <!-- Lock Screen Overlay -->
        <div id="lockscreen" class="hidden fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center z-50">
            <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-blue-500"></div>
        </div>
    </div>

    <!-- Google Sign-In Script -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        function handleCredentialResponse(response) {
            // Decode the JWT token to get user information
            const jwtToken = response.credential;
            const decodedJwt = parseJwt(jwtToken);

            // Check if the domain is srmist.edu.in
            if (decodedJwt.email.endsWith('@srmist.edu.in')) {
                // Send the token to the server for verification
                $.ajax({
                    url: "ajaxhandler/loginAjax.php",
                    type: "POST",
                    dataType: "json",
                    data: { google_token: jwtToken, action: "verifyGoogleUser" },
                    beforeSend: function() {
                        $("#diverror").removeClass("applyerrordiv");
                        $("#lockscreen").addClass("applylockscreen");
                    },
                    success: function(rv) {
                        $("#lockscreen").removeClass("applylockscreen");
                        if (rv['status'] === "ALL OK") {
                            document.location.replace("attendance.php");
                        } else {
                            $("#diverror").addClass("applyerrordiv");
                            $("#errormessage").text(rv['status']);
                        }
                    },
                    error: function() {
                        alert("Oops, something went wrong");
                    }
                });
            } else {
                $("#diverror").addClass("applyerrordiv");
                $("#errormessage").text("Only SRMIST.edu.in accounts are allowed.");
            }
        }

        function parseJwt(token) {
            const base64Url = token.split('.')[1];
            const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            const jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));

            return JSON.parse(jsonPayload);
        }

        window.onload = function () {
            google.accounts.id.initialize({
                client_id: "518391315871-aqe05tvs5mi500ccub95o99ll5mjg6uv.apps.googleusercontent.com", // Replace with your Client ID
                callback: handleCredentialResponse
            });
            google.accounts.id.renderButton(
                document.getElementById("googleSignIn"),
                { theme: "outline", size: "large" }  // customization attributes
            );
            google.accounts.id.prompt(); // also display the One Tap dialog
        };
    </script>
</body>
</html>