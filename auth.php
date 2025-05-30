<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="assets/favicon.svg" type="image/svg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/manasql.css">
    <title>manaSQL - Auth</title>
</head>

<body>


    <section class="form__section">


        <!-- login form -->
        <form class="form">

            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M21 9.5v3c0 2.485-4.03 4.5-9 4.5s-9-2.015-9-4.5v-3c0 2.485 4.03 4.5 9 4.5s9-2.015 9-4.5m-18 5c0 2.485 4.03 4.5 9 4.5s9-2.015 9-4.5v3c0 2.485-4.03 4.5-9 4.5s-9-2.015-9-4.5zm9-2.5c-4.97 0-9-2.015-9-4.5S7.03 3 12 3s9 2.015 9 4.5s-4.03 4.5-9 4.5" />
                </svg>
            </div>
            <div class="auth_title">manaSQL</div>
            <div class="auth_sub_title">Connect to your database</div>


            <div class="inputs">
                <div class="input_wrapper">
                    <input class="normal_input" placeholder="Database Host" type="text">
                </div>

                <div class="input_wrapper">
                    <input class="normal_input" placeholder="Database User" type="text">
                </div>

                <div class="input_wrapper">
                    <input class="normal_input" placeholder="Database Name" type="text">
                </div>

                <div class="input_wrapper">
                    <input id="password-input" class="normal_input" placeholder="Database Password"
                        type="password">

                </div>
            </div>


            <button class="submit_btn">Connect</button>

        </form>
        <!-- end login form -->
    </section>
</body>

</html>