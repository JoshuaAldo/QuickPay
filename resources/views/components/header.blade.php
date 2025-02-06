<div class="flex flex-col lg:flex-row justify-end lg:justify-between items-end lg:items-center pl-4 pr-4 pt-4 space-x-4">
    <div class="flex items-center lg:order-2 space-x-4">
        @auth
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
                <div>
                    <div x-data="{ open: false }" class="font-zenMaruGothic flex justify-center items-center">
                        <div @click="open = !open" class="relative border-b-4 border-transparent py-3"
                            :class="{ 'border-indigo-700 transform transition duration-300 ': open }"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100">
                            <div class="flex justify-center items-center space-x-3 cursor-pointer ml-4">
                                <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-gray-900">
                                    <img src="image/logo.png" alt="" class="w-full h-full object-cover">
                                </div>
                                <div class="font-semibold text-gray-700 text-lg">
                                    <div class="cursor-pointer">{{ auth()->user()->name }}</div>
                                </div>
                                <div class="items-center align-middle">
                                    <svg fill="#000000" height="13px" width="13px" version="1.1" id="Layer_1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        viewBox="0 0 330 330" xml:space="preserve">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path id="XMLID_225_"
                                                d="M325.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001l-139.39,139.393L25.607,79.393 c-5.857-5.857-15.355-5.858-21.213,0.001c-5.858,5.858-5.858,15.355,0,21.213l150.004,150c2.813,2.813,6.628,4.393,10.606,4.393 s7.794-1.581,10.606-4.394l149.996-150C331.465,94.749,331.465,85.251,325.607,79.393z">
                                            </path>
                                        </g>
                                    </svg>
                                </div>

                            </div>
                            <div class="flex justify-end">
                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="relative lg:absolute z-50 w-52 px-5 py-2 rounded-lg shadow border mt-2 right-0 bg-white hover:bg-blueRevamp hover:text-white">
                                    <ul class="space-y-2" style="position: relative;">
                                        <li class="font-medium">
                                            <button
                                                class="flex items-center transform transition-colors duration-200 border-r-4 border-transparent rounded-md">
                                                <div class="mr-3 text-red-600">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                                        </path>
                                                    </svg>
                                                </div>
                                                Logout
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </form>
        @endauth
    </div>

    <div class="flex-grow lg:order-1">
        <div class="relative">
            @if ($redirect == 'order' || $redirect == 'draftOrder')
            @else
                <form action="{{ route('search') }}" method="GET">
                    <input type="hidden" name="redirect" value="{{ $redirect }}">
                    <input type="text" name="query" placeholder="Search"
                        class="w-64 ml-auto lg:w-full h-11 pr-12 pl-10 border border-gray-300 rounded-xl focus:outline-none focus:ring focus:ring-blueRevamp opacity-60 z-0 relative">
                </form>
                <div class="absolute left-3 top-3 z-0">
                    <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M8.9051 2.771C5.71837 2.771 3.13501 5.35435 3.13501 8.54111C3.13501 11.7278 5.71837 14.3112 8.9051 14.3112C12.0918 14.3112 14.6752 11.7278 14.6752 8.54111C14.6752 5.35435 12.0918 2.771 8.9051 2.771ZM1.94751 8.54111C1.94751 4.69852 5.06253 1.5835 8.9051 1.5835C12.7477 1.5835 15.8627 4.69852 15.8627 8.54111C15.8627 12.3837 12.7477 15.4987 8.9051 15.4987C5.06253 15.4987 1.94751 12.3837 1.94751 8.54111Z"
                            fill="#9A9A9A" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M13.2493 12.3878L17.6949 16.8219L16.8562 17.6626L12.4106 13.2286L13.2493 12.3878Z"
                            fill="#9A9A9A" />
                    </svg>
                </div>
            @endif
        </div>
    </div>

</div>
