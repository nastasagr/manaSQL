<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="assets/favicon.svg" type="image/svg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/manasql.css">
    <title>manaSQL - Auth</title>
</head>

<body x-data="dbLogin()" x-init="checkSession()">

    <template x-if="errorMessage">
        <!-- error message -->
        <div class="error" x-show="errorMessage">
            <div class="flex flex-row j-center i-center gap-2">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="M4 6c0 1.657 3.582 3 8 3s8-1.343 8-3s-3.582-3-8-3s-8 1.343-8 3" />
                            <path d="M4 6v6c0 1.657 3.582 3 8 3c1.118 0 2.182-.086 3.148-.241M20 12V6" />
                            <path d="M4 12v6c0 1.657 3.582 3 8 3c1.064 0 2.079-.078 3.007-.22M19 16v3m0 3v.01" />
                        </g>
                    </svg>
                </div>

                <div x-text="errorMessage">

                </div>
            </div>
        </div>
    </template>


    <template x-if="!loggedIn">
        <form x-show="!loggedIn && !loading" @submit.prevent="connect" class="form">

            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M21 9.5v3c0 2.485-4.03 4.5-9 4.5s-9-2.015-9-4.5v-3c0 2.485 4.03 4.5 9 4.5s9-2.015 9-4.5m-18 5c0 2.485 4.03 4.5 9 4.5s9-2.015 9-4.5v3c0 2.485-4.03 4.5-9 4.5s-9-2.015-9-4.5zm9-2.5c-4.97 0-9-2.015-9-4.5S7.03 3 12 3s9 2.015 9 4.5s-4.03 4.5-9 4.5" />
                </svg>
            </div>
            <div class="auth_title">manaSQL</div>
            <div class="auth_sub_title">Connect to your database</div>


            <div class="inputs">
                <div class="input_wrapper">
                    <input x-model="host" class="normal_input" placeholder="Database Host" type="text">
                </div>

                <div class="input_wrapper">
                    <input x-model="user" class="normal_input" placeholder="Database User" type="text">
                </div>

                <div class="input_wrapper">
                    <input x-model="database" class="normal_input" placeholder="Database Name" type="text">
                </div>

                <div class="input_wrapper">
                    <input x-model="pass" id="password-input" class="normal_input" placeholder="Database Password"
                        type="password">

                </div>
            </div>


            <button class="submit_btn">Connect</button>

        </form>
    </template>


    <template x-if="loggedIn">
        <div>
            <div>
                <div class="logout" @click="logout()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 21 21">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="m14.595 13.5l2.905-3l-2.905-3m2.905 3h-9m6-7l-8 .002c-1.104.001-2 .896-2 2v9.995a2 2 0 0 0 2 2h8.095" stroke-width="1" />
                    </svg>
                </div>
            </div>



            <div class="tables" x-show="tables.length">
                <template x-for="table in tables" :key="table">
                    <div class="table" :data-table="table"></div>
                </template>
            </div>


            <div class="statebar">
                <div class="ibox">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M11 13a1 1 0 1 0 1 1a1 1 0 0 0-1-1m-4 0a1 1 0 1 0 1 1a1 1 0 0 0-1-1m15-9a3 3 0 0 0-3-3H5a3 3 0 0 0-3 3v4a3 3 0 0 0 .78 2A3 3 0 0 0 2 12v4a3 3 0 0 0 3 3h6v2H3a1 1 0 0 0 0 2h18a1 1 0 0 0 0-2h-8v-2h6a3 3 0 0 0 3-3v-4a3 3 0 0 0-.78-2A3 3 0 0 0 22 8Zm-2 12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1Zm0-8a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1Zm-9-3a1 1 0 1 0 1 1a1 1 0 0 0-1-1M7 5a1 1 0 1 0 1 1a1 1 0 0 0-1-1" />
                        </svg>
                    </div>
                    <div class="value" x-text="session.host"></div>
                </div>

                <div class="ibox">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 16 16">
                            <path fill="currentColor" fill-rule="evenodd" d="M8 8.5c1.776 0 3.515-.263 4.87-.888A5.6 5.6 0 0 0 14 6.931V8c0 2-2.686 3-6 3s-6-1-6-3V6.93c.35.275.736.501 1.13.682C4.485 8.237 6.224 8.5 8 8.5M14 4c0 2-2.686 3-6 3S2 6 2 4c0-.336.076-.643.217-.923C2.92 1.692 5.242 1 8 1c.828 0 1.618.063 2.335.188C12.49 1.563 14 2.5 14 4M8 15c3.314 0 6-1 6-3v-1.07c-.35.275-.736.501-1.13.683c-1.355.624-3.094.887-4.87.887s-3.515-.264-4.87-.887A5.7 5.7 0 0 1 2 10.93V12c0 2 2.686 3 6 3" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="value" x-text="session.database"></div>
                </div>

                <div class="ibox">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M5 4h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2m0 4v4h6V8zm8 0v4h6V8zm-8 6v4h6v-4zm8 0v4h6v-4z" />
                        </svg>
                    </div>
                    <div class="value" x-text="tables.length"></div>
                </div>


            </div>

        </div>
    </template>















    <script src="manasql.js"></script>


</body>

</html>