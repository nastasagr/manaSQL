<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="assets/favicon.svg" type="image/svg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>ManaSQL</title>

    <style>
        * {
            font-family: "Sora", sans-serif;
        }
    </style>
</head>

<body x-data="dbLogin()" x-init="checkSession()" class="flex items-center justify-center bg-gray-200">



    <template x-if="errorMessage">
        <div class="w-full h-2 absolute top-0 mx-auto">
            <div class="flex bg-red-600 p-2 mb-4 flex items-center justify-center text-sm text-white" role="alert">
                <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <span class="font-medium" x-text="errorMessage"></span>
                </div>
            </div>
        </div>
    </template>


    <!-- start login form  -->
    <template x-if="!loggedIn">
        <div class="w-screen h-screen flex justify-center items-center">
            <div x-show="!loggedIn && !loading" class="bg-white rounded-xl shadow-lg p-8">

                <div class="flex flex-col justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 26 26">
                        <g fill="none">
                            <defs>
                                <mask id="pepiconsPencilDatabaseCircleFilled0">
                                    <path fill="#fff" d="M0 0h26v26H0z" />
                                    <g fill="#000" fill-rule="evenodd" clip-rule="evenodd">
                                        <path d="M6.828 6.625c-.311.208-.328.337-.328.355s.017.146.328.354c.293.196.75.392 1.358.564c1.211.343 2.914.561 4.814.561s3.602-.218 4.814-.56c.609-.173 1.065-.369 1.358-.565c.311-.208.328-.337.328-.354c0-.018-.017-.147-.328-.355c-.293-.196-.75-.392-1.358-.564C16.602 5.718 14.9 5.5 13 5.5s-3.603.218-4.814.56c-.609.173-1.065.369-1.358.565M19.5 8.305V19h1V6.98c0-.53-.375-.921-.772-1.187c-.416-.278-.985-.508-1.642-.694C16.764 4.725 14.966 4.5 13 4.5s-3.763.225-5.086.599c-.658.186-1.226.416-1.642.694c-.397.266-.772.657-.772 1.187V19h1V8.305c.386.217.87.401 1.414.555c1.323.374 3.12.599 5.086.599s3.764-.225 5.086-.599c.544-.154 1.028-.338 1.414-.555" />
                                        <path d="M6 18.5a.5.5 0 0 1 .5.5c0 .022.02.155.33.364c.293.198.749.395 1.358.57c1.21.345 2.912.566 4.812.566s3.602-.22 4.812-.567c.61-.174 1.065-.371 1.358-.569c.31-.21.33-.342.33-.364a.5.5 0 0 1 1 0c0 .53-.372.924-.77 1.193c-.416.28-.985.514-1.643.702c-1.323.378-3.121.605-5.087.605s-3.764-.227-5.087-.605c-.658-.188-1.227-.421-1.643-.702c-.398-.27-.77-.663-.77-1.193a.5.5 0 0 1 .5-.5m0-6a.5.5 0 0 1 .5.5c0 .022.02.155.33.364c.293.198.749.395 1.358.57c1.21.345 2.912.566 4.812.566s3.602-.22 4.812-.566c.61-.175 1.065-.372 1.358-.57c.31-.21.33-.342.33-.364a.5.5 0 0 1 1 0c0 .53-.372.924-.77 1.193c-.416.28-.985.514-1.643.702c-1.323.378-3.121.605-5.087.605s-3.764-.227-5.087-.605c-.658-.188-1.227-.421-1.643-.702c-.398-.27-.77-.663-.77-1.193a.5.5 0 0 1 .5-.5" />
                                    </g>
                                </mask>
                            </defs>
                            <circle cx="13" cy="13" r="13" fill="#eead35" mask="url(#pepiconsPencilDatabaseCircleFilled0)" />
                        </g>
                    </svg>

                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">manaSQL</h2>
                </div>




                <form @submit.prevent="connect" class="space-y-4 text-center">
                    <div>

                        <input
                            type="text"
                            x-model="host"
                            class="w-full px-4 py-2 text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                            placeholder="Database Hostname" />
                    </div>

                    <div>

                        <input
                            type="text"
                            x-model="user"
                            class="w-full px-4 text-center py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                            placeholder="Database Username" />
                    </div>

                    <div>

                        <input
                            type="text"
                            x-model="database"
                            class="w-full px-4 py-2 text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                            placeholder="Database Name" />
                    </div>


                    <div>

                        <input
                            type="password"
                            x-model="pass"
                            class="w-full text-center px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                            placeholder="Database Password" />
                    </div>



                    <button type="submit" class="w-full bg-[#4b4b4b] hover:bg-[#eead35] text-white font-medium py-2.5 rounded-lg transition-colors">
                        Connect
                    </button>
                </form>


            </div>
        </div>

    </template>
    <!-- end login form -->

    <!-- start float buttons -->
    <template x-if="loggedIn">
        <div x-data="{ showModal: false }" class="flex flex-col gap-5 fixed top-10 right-5">

            <!-- modal overlay -->
            <div x-show="showModal" class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showModal = false">
                <div class="absolute inset-0 bg-red-400 opacity-75"></div>
            </div>


            <!-- drop entire database modal -->
            <div x-show="showModal" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="fixed z-10 inset-0 overflow-y-auto" x-cloak>
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Modal panel -->
                    <div class="w-full inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <!-- Modal content -->
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <!-- Heroicon name: outline/exclamation -->
                                    <svg width="64px" height="64px" class="h-6 w-6 text-red-600" stroke="currentColor" fill="none" viewBox="0 0 24.00 24.00" xmlns="http://www.w3.org/2000/svg" stroke="#ef4444" stroke-width="0.45600000000000007">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M12 7.25C12.4142 7.25 12.75 7.58579 12.75 8V13C12.75 13.4142 12.4142 13.75 12 13.75C11.5858 13.75 11.25 13.4142 11.25 13V8C11.25 7.58579 11.5858 7.25 12 7.25Z" fill="#ef4444"></path>
                                            <path d="M12 17C12.5523 17 13 16.5523 13 16C13 15.4477 12.5523 15 12 15C11.4477 15 11 15.4477 11 16C11 16.5523 11.4477 17 12 17Z" fill="#ef4444"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.2944 4.47643C9.36631 3.11493 10.5018 2.25 12 2.25C13.4981 2.25 14.6336 3.11493 15.7056 4.47643C16.7598 5.81544 17.8769 7.79622 19.3063 10.3305L19.7418 11.1027C20.9234 13.1976 21.8566 14.8523 22.3468 16.1804C22.8478 17.5376 22.9668 18.7699 22.209 19.8569C21.4736 20.9118 20.2466 21.3434 18.6991 21.5471C17.1576 21.75 15.0845 21.75 12.4248 21.75H11.5752C8.91552 21.75 6.84239 21.75 5.30082 21.5471C3.75331 21.3434 2.52637 20.9118 1.79099 19.8569C1.03318 18.7699 1.15218 17.5376 1.65314 16.1804C2.14334 14.8523 3.07658 13.1977 4.25818 11.1027L4.69361 10.3307C6.123 7.79629 7.24019 5.81547 8.2944 4.47643ZM9.47297 5.40432C8.49896 6.64148 7.43704 8.51988 5.96495 11.1299L5.60129 11.7747C4.37507 13.9488 3.50368 15.4986 3.06034 16.6998C2.6227 17.8855 2.68338 18.5141 3.02148 18.9991C3.38202 19.5163 4.05873 19.8706 5.49659 20.0599C6.92858 20.2484 8.9026 20.25 11.6363 20.25H12.3636C15.0974 20.25 17.0714 20.2484 18.5034 20.0599C19.9412 19.8706 20.6179 19.5163 20.9785 18.9991C21.3166 18.5141 21.3773 17.8855 20.9396 16.6998C20.4963 15.4986 19.6249 13.9488 18.3987 11.7747L18.035 11.1299C16.5629 8.51987 15.501 6.64148 14.527 5.40431C13.562 4.17865 12.8126 3.75 12 3.75C11.1874 3.75 10.4379 4.17865 9.47297 5.40432Z" fill="#ef4444"></path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-bold text-red-600" id="modal-headline"> WARNING...</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500"> Are you sure you want to drop entire <span class="font-bold">Database</span>? This action cannot be undone. </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button @click="dropDatabase()" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-500 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"> DROP </button>
                            <button @click="showModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"> Cancel </button>
                        </div>
                    </div>
                </div>
            </div>


            <div title="Export SQL" class="w-12 h-12 rounded-lg flex justify-center cursor-pointer items-center  bg-blue-500 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 512 512">
                    <path fill="currentColor" d="M216 0h80c13.3 0 24 10.7 24 24v168h87.7c17.8 0 26.7 21.5 14.1 34.1L269.7 378.3c-7.5 7.5-19.8 7.5-27.3 0L90.1 226.1c-12.6-12.6-3.7-34.1 14.1-34.1H192V24c0-13.3 10.7-24 24-24m296 376v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h146.7l49 49c20.1 20.1 52.5 20.1 72.6 0l49-49H488c13.3 0 24 10.7 24 24m-124 88c0-11-9-20-20-20s-20 9-20 20s9 20 20 20s20-9 20-20m64 0c0-11-9-20-20-20s-20 9-20 20s9 20 20 20s20-9 20-20" />
                </svg>
            </div>

            <div title="Dump Database" @click="showModal = true" class="w-12 h-12 rounded-lg flex justify-center cursor-pointer items-center  bg-red-500 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 20 20">
                    <path fill="currentColor" d="M3.389 7.113L4.49 18.021c.061.461 2.287 1.977 5.51 1.979c3.225-.002 5.451-1.518 5.511-1.979l1.102-10.908C14.929 8.055 12.412 8.5 10 8.5c-2.41 0-4.928-.445-6.611-1.387m9.779-5.603l-.859-.951C11.977.086 11.617 0 10.916 0H9.085c-.7 0-1.061.086-1.392.559l-.859.951C4.264 1.959 2.4 3.15 2.4 4.029v.17C2.4 5.746 5.803 7 10 7c4.198 0 7.601-1.254 7.601-2.801v-.17c0-.879-1.863-2.07-4.433-2.519M12.07 4.34L11 3H9L7.932 4.34h-1.7s1.862-2.221 2.111-2.522c.19-.23.384-.318.636-.318h2.043c.253 0 .447.088.637.318c.248.301 2.111 2.522 2.111 2.522z" />
                </svg>
            </div>

            <div title="Logout" class="w-12 h-12 rounded-lg flex justify-center cursor-pointer items-center  bg-yellow-400 text-black" @click="logout()">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4.001H5v14a2 2 0 0 0 2 2h8m1-5l3-3m0 0l-3-3m3 3H9" />
                </svg>
            </div>
        </div>

    </template>
    <!-- end float buttons -->


    <!-- statusbar -->
    <template x-if="loggedIn">
        <div x-show="loggedIn" class="w-full z-99 fixed h-10 bg-[#204e9a]  text-white absolute bottom-0 flex flex-row gap-4 justify-center items-center">
            <div class="flex flex-row gap-2 font-bold">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                        <path fill="currentColor" fill-rule="evenodd" d="M2 8a3 3 0 0 1 3-3h14a3 3 0 0 1 3 3v3H2zm0 5v3a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-3zm4-6a1 1 0 0 0 0 2h.01a1 1 0 0 0 0-2zm-1 9a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1m4-9a1 1 0 0 0 0 2h.01a1 1 0 0 0 0-2zm-1 9a1 1 0 0 1 1-1h.01a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1" clip-rule="evenodd" />
                    </svg>
                </div>
                <div x-text="session.host"></div>
            </div>

            <div class="flex flex-row gap-2 font-bold">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 16 16">
                        <path fill="currentColor" fill-rule="evenodd" d="M8 8.5c1.776 0 3.515-.263 4.87-.888A5.6 5.6 0 0 0 14 6.931V8c0 2-2.686 3-6 3s-6-1-6-3V6.93c.35.275.736.501 1.13.682C4.485 8.237 6.224 8.5 8 8.5M14 4c0 2-2.686 3-6 3S2 6 2 4c0-.336.076-.643.217-.923C2.92 1.692 5.242 1 8 1c.828 0 1.618.063 2.335.188C12.49 1.563 14 2.5 14 4M8 15c3.314 0 6-1 6-3v-1.07c-.35.275-.736.501-1.13.683c-1.355.624-3.094.887-4.87.887s-3.515-.264-4.87-.887A5.7 5.7 0 0 1 2 10.93V12c0 2 2.686 3 6 3" clip-rule="evenodd" />
                    </svg>
                </div>
                <div x-text="session.database"></div>
            </div>


            <div class="flex flex-row gap-2 font-bold">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 15 15">
                        <path fill="currentColor" fill-rule="evenodd" d="M8 2h4.5a.5.5 0 0 1 .5.5V5H8zM7 5V2H2.5a.5.5 0 0 0-.5.5V5zM2 6v3h5V6zm6 0h5v3H8zm0 4h5v2.5a.5.5 0 0 1-.5.5H8zm-6 2.5V10h5v3H2.5a.5.5 0 0 1-.5-.5m-1-10A1.5 1.5 0 0 1 2.5 1h10A1.5 1.5 0 0 1 14 2.5v10a1.5 1.5 0 0 1-1.5 1.5h-10A1.5 1.5 0 0 1 1 12.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div x-text="tables.length"></div>
            </div>
        </div>

    </template>


    <!-- database tables -->
    <template x-if="loggedIn">
        <div x-show="tables.length">
            <div class="mt-10 mb-20 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-5 xl:grid-cols-5 px-12 ">
                <template x-for="table in tables" :key="table">
                    <div class="flex items-start rounded-xl bg-white hover:opacity-80 cursor-pointer p-4 ">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full border border-blue-100 bg-blue-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-blue-400 w-6 h-6" viewBox="0 0 29 24">
                                <path fill="currentColor" d="M28 0H1.333C.596 0-.001.597-.001 1.334v21.333c0 .737.597 1.334 1.334 1.334H28c.737 0 1.334-.597 1.334-1.334V1.334C29.334.597 28.737 0 28 0M13.334 8.001v5.333H2.667V8.001zm2.666 0h10.667v5.333H16zM2.667 16h10.667v5.333H2.667zM16 21.333V16h10.667v5.333z" />
                            </svg>
                        </div>

                        <div class="ml-4">
                            <h2 class="font-semibold" x-text="table"></h2>

                        </div>
                    </div>
                </template>
            </div>

        </div>


    </template>





    <!-- Alpine Script -->
    <script src="requests.js"></script>

</body>

</html>