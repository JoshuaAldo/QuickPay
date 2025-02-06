<div x-data="{ open: false }" class="relative">
    <!-- Tombol Hamburger (Muncul di Mobile) -->
    <button @click="open = !open"
        class="lg:hidden fixed top-3 left-3 z-50 p-2 bg-blueRevamp rounded-md text-white focus:outline-none">
        <!-- Ikon Hamburger -->
        <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>

        <!-- Ikon Close -->
        <svg x-show="open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <aside
        class="inset-y-0 left-0 w-52 lg:w-64 h-full px-5 py-8 bg-blueRevamp border-r rounded-tr-lg rounded-br-lg shadow-2xl transition-transform transform flex-col
        lg:flex lg:relative fixed -translate-x-full lg:translate-x-0 z-40 overflow-y-auto"
        x-bind:class="{ '-translate-x-full': !open, 'translate-x-0': open }">
        <p class="font-zenOldMincho text-white text-2xl text-center m-auto p-2">QuickPay</p>

        <div class="flex flex-col justify-between flex-1 mt-6">
            <nav class="-mx-3 space-y-1">
                <div class="space-y-1">

                    <div class="flex items-center px-3 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#A1E3F9">
                            <path
                                d="M480-120q-151 0-255.5-46.5T120-280v-400q0-66 105.5-113T480-840q149 0 254.5 47T840-680v400q0 67-104.5 113.5T480-120Zm0-479q89 0 179-25.5T760-679q-11-29-100.5-55T480-760q-91 0-178.5 25.5T200-679q14 30 101.5 55T480-599Zm0 199q42 0 81-4t74.5-11.5q35.5-7.5 67-18.5t57.5-25v-120q-26 14-57.5 25t-67 18.5Q600-528 561-524t-81 4q-42 0-82-4t-75.5-11.5Q287-543 256-554t-56-25v120q25 14 56 25t66.5 18.5Q358-408 398-404t82 4Zm0 200q46 0 93.5-7t87.5-18.5q40-11.5 67-26t32-29.5v-98q-26 14-57.5 25t-67 18.5Q600-328 561-324t-81 4q-42 0-82-4t-75.5-11.5Q287-343 256-354t-56-25v99q5 15 31.5 29t66.5 25.5q40 11.5 88 18.5t94 7Z" />
                        </svg>
                        <label class="px-3 text-md text-white font-zenMaruGothic font-bold uppercase">Management
                            Menu</label>
                    </div>

                    <a class="{{ request()->is('product') ? 'bg-blueRevamp3 rounded-lg text-white font-bold' : 'bg-none transition-colors duration-300 transform rounded-lg hover:bg-blueRevamp3 hover:text-gray-200' }} flex items-center px-3 py-2 ml-8 mr-8 text-white"
                        href="/product">
                        <span class="mx-2 text-sm font-semibold font-zenMaruGothic">Product</span>
                    </a>

                    <a class="flex items-center px-3 py-2 ml-8 mr-8 text-white {{ request()->is('product_category') ? 'bg-blueRevamp3 rounded-lg text-white font-bold' : 'bg-none transition-colors duration-300 transform rounded-lg hover:bg-blueRevamp3  hover:text-gray-200' }}"
                        href="/product_category">
                        <span class="mx-2 text-sm font-semibold font-zenMaruGothic">Product Category</span>
                    </a>
                </div>

                <div class="space-y-1 ">

                    <div class="flex items-center px-3 py-2">
                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5.7017 19C5.17904 19 4.73177 18.8141 4.3599 18.4424C3.98739 18.07 3.80113 17.6225 3.80113 17.1C3.80113 16.5775 3.98739 16.13 4.3599 15.7576C4.73177 15.3859 5.17904 15.2 5.7017 15.2C6.22435 15.2 6.67162 15.3859 7.0435 15.7576C7.41601 16.13 7.60226 16.5775 7.60226 17.1C7.60226 17.6225 7.41601 18.07 7.0435 18.4424C6.67162 18.8141 6.22435 19 5.7017 19ZM15.2045 19C14.6819 19 14.2346 18.8141 13.8627 18.4424C13.4902 18.07 13.304 17.6225 13.304 17.1C13.304 16.5775 13.4902 16.13 13.8627 15.7576C14.2346 15.3859 14.6819 15.2 15.2045 15.2C15.7272 15.2 16.1748 15.3859 16.5473 15.7576C16.9192 16.13 17.1051 16.5775 17.1051 17.1C17.1051 17.6225 16.9192 18.07 16.5473 18.4424C16.1748 18.8141 15.7272 19 15.2045 19ZM5.7017 14.25C4.98899 14.25 4.45049 13.9371 4.08622 13.3114C3.72194 12.6863 3.7061 12.065 4.0387 11.4475L5.32158 9.12L1.90057 1.9H0.926526C0.657279 1.9 0.435546 1.8088 0.261328 1.6264C0.0871092 1.44463 0 1.21917 0 0.95C0 0.680833 0.0912271 0.45505 0.273681 0.27265C0.455502 0.0908833 0.681036 0 0.950283 0H2.49449C2.66871 0 2.83501 0.0475001 2.99339 0.1425C3.15177 0.2375 3.27056 0.372083 3.34975 0.54625L3.99119 1.9H18.0079C18.4355 1.9 18.7285 2.05833 18.8869 2.375C19.0453 2.69167 19.0373 3.02417 18.8631 3.3725L15.4896 9.4525C15.3154 9.76917 15.0857 10.0146 14.8007 10.1888C14.5156 10.3629 14.1909 10.45 13.8266 10.45H6.74701L5.7017 12.35H16.1786C16.4478 12.35 16.6695 12.4409 16.8438 12.6226C17.018 12.805 17.1051 13.0308 17.1051 13.3C17.1051 13.5692 17.0139 13.7946 16.8314 13.9764C16.6496 14.1588 16.4241 14.25 16.1548 14.25H5.7017Z"
                                fill="#A1E3F9" />
                        </svg>

                        <label class="px-3 text-md text-white font-zenMaruGothic font-bold uppercase">Sales
                            Transaction</label>
                    </div>

                    <a class="flex items-center px-3 py-2 ml-8 mr-8 text-white {{ request()->is('order') ? 'bg-blueRevamp3 rounded-lg text-white font-bold' : 'bg-none transition-colors duration-300 transform rounded-lg hover:bg-blueRevamp3 hover:text-gray-200' }}"
                        href="/order">
                        <span class="mx-2 text-sm font-semibold font-zenMaruGothic">Order</span>
                    </a>

                    <a class="flex items-center px-3 py-2 ml-8 mr-8 text-white {{ request()->is('draftOrder') ? 'bg-blueRevamp3 rounded-lg text-white font-bold' : 'bg-none transition-colors duration-300 transform rounded-lg hover:bg-blueRevamp3 hover:text-gray-200' }}"
                        href="/draftOrder">
                        <span class="mx-2 text-sm font-semibold font-zenMaruGothic">Draft Order</span>
                    </a>
                </div>

                <div class="space-y-1 ">

                    <div class="flex items-center px-3 py-2">
                        <svg width="24" height="24" viewBox="0 0 19 19" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M1.9 3.8H0V17.1C0 18.145 0.855 19 1.9 19H15.2V17.1H1.9V3.8ZM17.1 0H5.7C4.655 0 3.8 0.855 3.8 1.9V13.3C3.8 14.345 4.655 15.2 5.7 15.2H17.1C18.145 15.2 19 14.345 19 13.3V1.9C19 0.855 18.145 0 17.1 0ZM16.15 8.55H6.65V6.65H16.15V8.55ZM12.35 12.35H6.65V10.45H12.35V12.35ZM16.15 4.75H6.65V2.85H16.15V4.75Z"
                                fill="#A1E3F9" />
                        </svg>
                        <label class="px-3 text-md text-white font-zenMaruGothic font-bold uppercase">Sales
                            Transaction Report</label>
                    </div>

                    <a class="flex items-center px-3 py-2 ml-8 mr-8 text-white {{ request()->is('sales-report') ? 'bg-blueRevamp3 rounded-lg text-white font-bold' : 'bg-none transition-colors duration-300 transform rounded-lg hover:bg-blueRevamp3 hover:text-gray-200' }}"
                        href="/sales-report">
                        <span class="mx-2 text-sm font-semibold font-zenMaruGothic">Sales Report</span>
                    </a>
                </div>
                <div class="space-y-1 ">

                    <div class="flex items-center px-3 py-2">
                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M18 15.8333V16.8889C18 18.05 17.1 19 16 19H2C0.89 19 0 18.05 0 16.8889V2.11111C0 0.95 0.89 0 2 0H16C17.1 0 18 0.95 18 2.11111V3.16667H9C7.89 3.16667 7 4.11667 7 5.27778V13.7222C7 14.8833 7.89 15.8333 9 15.8333H18ZM9 13.7222H19V5.27778H9V13.7222ZM13 11.0833C12.17 11.0833 11.5 10.3761 11.5 9.5C11.5 8.62389 12.17 7.91667 13 7.91667C13.83 7.91667 14.5 8.62389 14.5 9.5C14.5 10.3761 13.83 11.0833 13 11.0833Z"
                                fill="#A1E3F9" />
                        </svg>

                        <label class="px-3 text-md text-white font-zenMaruGothic font-bold uppercase">Purchase</label>
                    </div>

                    <a class="flex items-center px-3 py-2 ml-8 mr-8 text-white {{ request()->is('purchase-of-goods') ? 'bg-blueRevamp3 rounded-lg text-white font-bold' : 'bg-none transition-colors duration-300 transform rounded-lg hover:bg-blueRevamp3 hover:text-gray-200' }}"
                        href="/purchase-of-goods">
                        <span class="mx-2 text-sm font-semibold font-zenMaruGothic">Purchase of Goods</span>
                    </a>
                </div>
            </nav>
        </div>
    </aside>

</div>
