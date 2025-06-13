<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flowbite Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans">

    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                        </svg>
                    </button>
                    <a href="#" class="flex ms-2 md:me-24">
                        <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 me-3" alt="Flowbite Logo" />
                        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">Admin Dashboard</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900 dark:text-white" role="none">
                                    Neil Sims
                                </p>
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                    neil.sims@flowbite.com
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Dashboard</a>
                                </li>
                                <li>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Settings</a>
                                </li>
                                <li>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Earnings</a>
                                </li>
                                <li>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Sign out</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" fill="currentColor" viewBox="0 0 22 21" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.071 11.233A6.294 6.294 0 0 0 7.828 6.5V2.071a1.942 1.942 0 0 0-1.606-.791 1.97 1.97 0 0 0-1.85 1.054A6.29 6.29 0 0 0 2.071 11.233Zm1.848 1.488a6.3 6.3 0 0 0 5.625 4.708v-4.47a1.943 1.943 0 0 0-1.606-.791 1.97 1.97 0 0 0-1.85 1.054 6.29 6.29 0 0 0-2.169 2.5ZM17.929 11.233a6.294 6.294 0 0 1-5.757 4.708v-4.47a1.943 1.943 0 0 1 1.606-.791 1.97 1.97 0 0 1 1.85 1.054 6.29 6.29 0 0 1 2.3-.5ZM17.929 11.233A6.294 6.294 0 0 0 12.172 6.5V2.071a1.942 1.942 0 0 0 1.606-.791 1.97 1.97 0 0 0 1.85 1.054 6.29 6.29 0 0 0 2.3-.5ZM9.006 1.071C8.257.653 7.427.316 6.54.127A6.273 6.273 0 0 0 .1 6.5H6.5v4.5a6.294 6.294 0 0 0 1.606.791 1.97 1.97 0 0 0 1.85-1.054A6.29 6.29 0 0 0 9.006 1.071Zm0 18.071C9.757 19.347 10.573 19.684 11.46 19.873A6.273 6.273 0 0 0 19.9 13.5H13.5V9a6.294 6.294 0 0 0-1.606-.791 1.97 1.97 0 0 0-1.85 1.054A6.29 6.29 0 0 0 9.006 19.142Z" />
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 9.171a3 3 0 01-.879 2.121L4.121 11.5c-1.562 1.562-1.562 4.095 0 5.657l.707.707a4 4 0 005.657 0l.707-.707c1.562-1.562 1.562-4.095 0-5.657l-.707-.707A3 3 0 015 9.171zM11.879 4.879a3 3 0 01-.879 2.121l-.707-.707c-1.562-1.562-1.562-4.095 0-5.657l.707-.707a4 4 0 005.657 0l.707.707c1.562 1.562 1.562 4.095 0 5.657l-.707-.707a3 3 0 01-2.121-.879z"></path>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 2a6 6 0 00-6 6v3.133a4.852 4.852 0 00-1.78 3.085A1 1 0 012 16h16a1 1 0 01-.22-.782 4.852 4.852 0 00-1.78-3.085V8a6 6 0 00-6-6zM10 18a3 3 0 003-3H7a3 3 0 003 3z"></path>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Products</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 0a10 10 0 100 20 10 10 0 000-20zm0 18a8 8 0 110-16 8 8 0 010 16zm-1-12.75a1 1 0 00-2 0V9a1 1 0 002 0V5.25zm2 0a1 1 0 00-2 0V9a1 1 0 002 0V5.25zM10 15a1 1 0 000-2 1 1 0 000 2z"></path>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V4a1 1 0 00-1-1H3zm2 2h2v2H5V5zm4 0h2v2H9V5zm4 0h2v2h-2V5zM5 9h2v2H5V9zm4 0h2v2H9V9zm4 0h2v2h-2V9zm-8 4h2v2H5v-2zm4 0h2v2H9v-2zm4 0h2v2h-2v-2z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <div class="p-4 sm:ml-64 mt-14">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Dashboard Overview</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-md">
                    <h5 class="text-lg font-medium text-gray-900 dark:text-white">Total Users</h5>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">1,234</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Increased by 5% this month</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-md">
                    <h5 class="text-lg font-medium text-gray-900 dark:text-white">Total Sales</h5>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">$56,789</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Up 12% from last quarter</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-md">
                    <h5 class="text-lg font-medium text-gray-900 dark:text-white">New Orders</h5>
                    <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mt-2">456</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">30 new orders today</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-md">
                    <h5 class="text-lg font-medium text-gray-900 dark:text-white">Pending Issues</h5>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">12</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Action required</p>
                </div>
            </div>

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Recent Users</h2>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-6">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                User Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Role
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Alice Smith
                            </th>
                            <td class="px-6 py-4">
                                alice.smith@example.com
                            </td>
                            <td class="px-6 py-4">
                                Admin
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Active</span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            </td>
                        </tr>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Bob Johnson
                            </th>
                            <td class="px-6 py-4">
                                bob.j@example.com
                            </td>
                            <td class="px-6 py-4">
                                Editor
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Pending</span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            </td>
                        </tr>
                        <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Charlie Brown
                            </th>
                            <td class="px-6 py-4">
                                charlie.b@example.com
                            </td>
                            <td class="px-6 py-4">
                                User
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Active</span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Quick Stats</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-md">
                    <h5 class="text-lg font-medium text-gray-900 dark:text-white">Website Visitors</h5>
                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400 mt-2">15,000</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Last 7 days</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-md">
                    <h5 class="text-lg font-medium text-gray-900 dark:text-white">Revenue Growth</h5>
                    <p class="text-3xl font-bold text-teal-600 dark:text-teal-400 mt-2">8.5%</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Year-to-date</p>
                </div>
            </div>

        </div>
    </div>

    <script src="<?= base_url("flowbite.min.js") ?>"></script>
</body>
</html>