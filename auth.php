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
        <div x-transition>
            <div>
                <div class="logout" @click="logout()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 21 21">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="m14.595 13.5l2.905-3l-2.905-3m2.905 3h-9m6-7l-8 .002c-1.104.001-2 .896-2 2v9.995a2 2 0 0 0 2 2h8.095" stroke-width="1" />
                    </svg>
                </div>
            </div>

            <div>
                <div class="statebar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512">
                        <path fill="currentColor" fill-rule="evenodd" d="M426.666 298.667v64C426.666 409.795 350.256 448 256 448c-92.162 0-167.262-36.526-170.554-82.205l-.113-3.128v-64l.113 3.128C88.738 347.475 163.838 384 256 384c94.256 0 170.666-38.205 170.666-85.333M85.446 195.128c3.292 45.68 78.392 82.205 170.554 82.205c94.256 0 170.666-38.205 170.666-85.333v64l-.023 1.411c-1.507 46.478-77.33 83.922-170.643 83.922c-92.162 0-167.262-36.526-170.554-82.205L85.333 256v-64ZM256 64c92.162 0 167.262 36.526 170.554 82.205l.112 3.128l-.023 1.411c-1.507 46.478-77.33 83.923-170.643 83.923c-92.162 0-167.262-36.526-170.554-82.205l-.113-3.129C85.333 102.205 161.743 64 256 64" />
                    </svg>
                </div>
            </div>
        </div>
    </template>





    <script>
        function dbLogin() {
            return {
                host: '',
                user: '',
                pass: '',
                database: '',
                loggedIn: false,
                session: {},
                errorMessage: '',
                loading: true,
                timeoutRef: null,

                async connect() {
                    try {
                        const res = await fetch('actions.php?method=connect', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                host: this.host,
                                user: this.user,
                                pass: this.pass,
                                database: this.database
                            })
                        });

                        const data = await res.json();

                        if (!res.ok || !data.success) {
                            this.showMessage(data.message || 'Σφάλμα σύνδεσης.');
                            return;
                        }

                        this.loggedIn = true;
                        this.session = data.session;
                    } catch (err) {
                        this.showMessage('Αδυναμία σύνδεσης.');
                    }
                },

                showMessage(msg) {
                    this.errorMessage = msg;


                    if (this.timeoutRef) {
                        clearTimeout(this.timeoutRef);
                    }

                    this.timeoutRef = setTimeout(() => {
                        this.errorMessage = '';
                        this.timeoutRef = null;
                    }, 3000);
                },


                async logout() {
                    const res = await fetch('actions.php?method=logout', {
                        method: 'POST'
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.loggedIn = false;
                        this.session = {};
                    }
                },

                async checkSession() {
                    try {
                        const res = await fetch('actions.php?method=sessionCheck');
                        const data = await res.json();
                        if (data.loggedIn) {
                            this.loggedIn = true;
                            this.session = data.session;
                        }
                    } catch (e) {

                    } finally {
                        this.loading = false;
                    }
                }
            };
        }
    </script>


</body>

</html>