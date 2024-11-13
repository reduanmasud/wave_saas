<?php
    use function Laravel\Folio\{middleware, name};

    middleware('auth');
    name('products');
?>
<x-layouts.app>
    <x-app.container 
    x-data="{ 
        days: 1, 
        basePrice: {{$server['provider_price']}}, 
        serviceCharge: 5, 
        trnxId: '' ,
        {{-- submitForm() {
            // Send the form data using Inertia.js
            console.log('submitting')
            Inertia.post('/product', {
                days: this.days,
                trnxId: this.trnxId,
            });
        } --}}
        
    }" x-cloak>
        <form action="{{ route('product.store') }}" method="POST">
            @csrf
        <input type="hidden" name="server" value="{{$server['id']}}">
        <x-app.heading
            title="Confirm Your Server Order"
            description="Review your server selection and complete your order details."
            :border="false"
        />

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">

            <!-- Left Side: Server Details -->
            <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-lg border border-slate-200 dark:border-zinc-700">
                <!-- Server SVG Icon (instead of placeholder image) -->
                <div class="w-full h-48 mb-6 flex justify-center items-center">
                    
                    <svg class="w-24 h-24 text-blue-600 dark:text-blue-400" viewBox="0 -1 149 149" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.6802 54.2336C19.6802 51.6956 19.5778 49.8362 19.7091 47.9984C19.8357 46.2263 18.9694 45.7702 17.4119 45.6021C14.2556 45.3458 11.1174 44.902 8.0138 44.273C3.43847 43.2131 1.0461 40.6317 1.00672 36.0032C0.935179 27.6021 1.30141 19.195 1.56067 10.7926C1.63286 8.43765 2.77356 6.44505 4.95917 5.56752C7.85427 4.40515 10.8734 2.94218 13.8946 2.80172C36.7167 1.74108 59.5468 0.767023 82.3854 0.18879C97.0217 -0.181385 111.68 0.0766199 126.327 0.254487C130.37 0.348166 134.398 0.790578 138.366 1.57694C143.844 2.60476 146.091 5.09032 146.837 10.557C147.876 18.1633 148.306 25.807 146.938 33.4192C145.622 40.7478 142.006 44.0085 134.588 44.7338C132.306 44.957 130.005 44.9734 127.712 45.0843C124.452 45.2425 124.358 45.3718 125.005 49.1287C126.006 49.2107 127.072 49.3098 128.139 49.3826C130.429 49.5389 132.729 49.6006 135.01 49.8421C144.154 50.8161 146.745 53.1028 147.554 62.1983C148.165 68.4995 148.26 74.8401 147.836 81.1566C147.219 89.2985 143.381 92.7876 135.314 93.671C131.089 94.1344 126.837 94.351 122.319 94.7008C122.423 96.6652 122.516 98.4597 122.63 100.593C123.746 100.703 124.796 100.79 125.846 100.911C130.075 101.41 134.339 101.721 138.521 102.486C142.509 103.214 145.272 105.666 145.949 109.822C147.293 118.062 147.768 126.352 146.219 134.617C144.927 141.519 141.227 145.001 134.146 145.381C125.089 145.867 116.014 145.961 106.944 146.078C82.0211 146.398 57.0967 146.718 32.1723 146.865C25.7336 146.903 19.289 146.34 12.851 145.982C11.3243 145.872 9.80951 145.634 8.32226 145.272C2.73617 144.01 0.345817 141.511 0.297904 135.745C0.23227 127.778 0.634621 119.806 0.888624 111.839C0.972635 109.22 2.18486 107.064 4.62972 106.129C8.23367 104.745 11.9748 103.718 16.3395 102.322C16.4832 101.285 16.7431 99.4081 17.0339 97.3039C14.3915 96.895 12.0254 96.6305 9.7052 96.1481C4.47681 95.0612 1.97942 92.5067 1.83371 87.1844C1.61318 79.1115 1.79958 71.0241 1.87834 62.9433C1.90394 60.331 3.07488 58.1428 5.51383 57.1674C8.52894 55.998 11.621 55.0377 14.7682 54.2934C16.1813 53.9449 17.7526 54.2336 19.6802 54.2336ZM74.6111 87.424C74.6111 87.2756 74.6111 87.1267 74.6111 86.9783C78.322 86.9783 82.0356 87.0682 85.7439 86.9626C101.359 86.5184 116.974 86.0372 132.586 85.5186C137.339 85.3592 138.518 84.4377 138.683 79.716C138.893 73.7335 138.591 67.7319 138.487 61.7395C138.45 59.6924 137.522 58.5149 135.314 58.4256C133.245 58.3423 131.187 57.9603 129.118 57.8836C103.202 56.9194 77.3546 58.3554 51.5126 60.0763C37.7846 60.9908 24.0504 61.8104 10.3097 62.535C8.1195 62.6538 7.79331 63.7696 7.90291 65.5056C8.32756 72.2659 8.76922 79.0183 9.14989 85.7773C9.28116 88.1171 10.5788 89.059 12.7513 89.0826C22.4651 89.1876 32.1874 89.5768 41.8927 89.3004C52.8076 88.9861 63.7054 88.0751 74.6111 87.424ZM69.8612 108.657L69.8474 109.092C62.4308 109.485 55.0141 109.945 47.5896 110.253C34.9302 110.778 22.2679 111.238 9.60281 111.632C7.32728 111.697 6.79698 112.757 6.87771 114.695C7.14024 121.025 7.35021 127.356 7.62194 133.685C7.78405 137.467 8.10171 138.07 12.0456 138.26C21.4227 138.714 30.8169 139.187 40.2026 139.063C58.8832 138.815 77.5574 138.116 96.2361 137.711C107.925 137.457 119.62 137.443 131.31 137.233C135.69 137.155 136.974 136.201 137.227 131.945C137.587 125.86 137.446 119.744 137.486 113.641C137.5 111.59 136.542 110.398 134.373 110.224C131.979 110.032 129.6 109.507 127.208 109.467C108.092 109.149 88.9763 108.915 69.8605 108.657H69.8612ZM69.9084 7.89491L69.8966 8.40423C63.5676 8.71993 57.2398 9.07957 50.9081 9.34211C37.4827 9.89934 24.0574 10.4625 10.6274 10.8773C8.37876 10.9468 7.3962 11.5691 7.50055 13.8604C7.78278 20.0792 7.98101 26.3025 8.23829 32.5226C8.41485 36.8052 8.66555 37.3599 12.9088 37.564C22.1795 38.011 31.4694 38.4507 40.7434 38.3246C58.8794 38.0779 77.008 37.3828 95.142 36.9877C107.378 36.7206 119.619 36.6819 131.856 36.4745C136.395 36.3977 137.587 35.5077 137.885 30.954C138.261 25.1959 138.244 19.4024 138.14 13.6267C138.074 10.133 137.686 9.92096 134.101 9.36438C132.38 9.05685 130.64 8.86717 128.893 8.79665C109.232 8.4698 89.571 8.16926 69.9084 7.89491ZM113.013 94.5879L25.223 97.615C25.5367 99.5459 25.8071 101.212 26.0861 102.927L112.685 99.9955C112.773 98.5443 112.87 96.9383 113.013 94.5879ZM28.6438 53.3659L114.434 48.6358C114.583 48.223 114.69 47.7961 114.754 47.3618C114.741 46.6218 114.677 45.8836 114.561 45.1526L27.662 46.2217C27.8989 48.5845 28.0735 50.4223 28.2782 52.2601C28.3654 52.6391 28.4874 53.0093 28.6425 53.3659H28.6438Z" fill="#000000"/>
                        <path d="M47.3345 76.9847C41.1886 77.2748 33.2265 77.6653 25.2619 78.0145C23.8494 78.0762 22.2801 78.3289 21.0567 77.8281C19.954 77.3759 18.6853 76.1013 18.5055 75.0203C18.3637 74.1671 19.5779 72.5223 20.5303 72.1829C22.5987 71.4869 24.7598 71.1051 26.9414 71.0501C42.7649 70.4319 58.5909 69.8763 74.4196 69.3837C75.9475 69.3531 77.4751 69.4559 78.9851 69.6908C80.769 69.9481 82.125 70.9379 82.2051 72.8459C82.2852 74.7538 80.9665 75.9306 79.2443 76.2542C76.996 76.6862 74.7142 76.92 72.425 76.9532C64.6697 77.0352 56.9138 76.9847 47.3345 76.9847Z" fill="#000000"/>
                        <path d="M128.836 75.8273C127.736 75.8009 126.691 75.3444 125.925 74.556C125.158 73.7675 124.732 72.7099 124.736 71.6103C124.829 69.0985 126.536 67.2372 128.71 67.2785C129.858 67.3427 130.941 67.8358 131.743 68.6603C132.545 69.4848 133.009 70.5806 133.041 71.7305C133.024 72.8306 132.572 73.8791 131.784 74.6468C130.996 75.4145 129.936 75.8389 128.836 75.8273Z" fill="#000000"/>
                        <path d="M114.823 76.271C113.722 76.2679 112.666 75.8339 111.881 75.0618C111.095 74.2897 110.644 73.2409 110.622 72.1399C110.599 69.8257 112.075 68.4953 114.647 68.5124C117.304 68.5294 118.972 70.0508 118.888 72.3848C118.837 73.4297 118.386 74.415 117.63 75.1379C116.874 75.8608 115.869 76.2664 114.823 76.271Z" fill="#000000"/>
                        <path d="M98.2951 69.0669C99.2761 69.1015 100.211 69.4929 100.924 70.1676C101.637 70.8422 102.079 71.7537 102.168 72.7312C102.173 73.221 102.076 73.7064 101.883 74.1566C101.69 74.6067 101.405 75.0117 101.047 75.3458C100.689 75.6798 100.265 75.9356 99.8025 76.0966C99.34 76.2577 98.849 76.3206 98.3608 76.2814C97.4292 76.2346 96.551 75.832 95.9077 75.1566C95.2643 74.4812 94.9047 73.5846 94.9032 72.6518C94.8782 72.1907 94.9473 71.7293 95.1064 71.2958C95.2655 70.8623 95.5112 70.4658 95.8286 70.1303C96.146 69.7949 96.5284 69.5276 96.9525 69.3447C97.3765 69.1619 97.8333 69.0674 98.2951 69.0669Z" fill="#000000"/>
                        <path d="M48.1842 127.455C40.2207 127.455 32.2585 127.455 24.2975 127.455C22.9889 127.497 21.6789 127.468 20.3733 127.371C18.5808 127.178 17.2057 126.308 17.1243 124.327C17.0489 122.493 18.2966 121.517 19.9059 121.193C21.8246 120.768 23.7782 120.521 25.7421 120.454C41.7808 120.212 57.8204 120.02 73.8608 119.879C75.268 119.865 76.857 119.8 78.0351 120.399C79.2231 121.003 80.7366 122.39 80.7589 123.462C80.7819 124.546 79.3517 126.018 78.1926 126.672C77.0493 127.316 75.4492 127.301 74.0479 127.31C65.4269 127.36 56.8059 127.335 48.1881 127.335L48.1842 127.455Z" fill="#000000"/>
                        <path d="M127.328 118.967C128.487 118.978 129.597 119.435 130.428 120.243C131.259 121.051 131.747 122.148 131.791 123.306C131.793 124.356 131.397 125.369 130.684 126.141C129.971 126.913 128.993 127.387 127.946 127.468C126.841 127.525 125.758 127.141 124.936 126.4C124.115 125.659 123.62 124.623 123.562 123.518C123.487 121.072 125.181 119.028 127.328 118.967Z" fill="#000000"/>
                        <path d="M109.406 123.497C109.374 121.209 110.906 119.794 113.386 119.821C116.011 119.853 117.694 121.39 117.626 123.705C117.583 124.745 117.141 125.729 116.392 126.453C115.643 127.177 114.644 127.584 113.603 127.592C112.507 127.593 111.454 127.165 110.669 126.4C109.885 125.634 109.432 124.592 109.406 123.497Z" fill="#000000"/>
                        <path d="M97.3846 127.224C96.8982 127.24 96.4137 127.157 95.9605 126.979C95.5073 126.802 95.0948 126.534 94.748 126.193C94.4013 125.851 94.1275 125.443 93.9433 124.993C93.7591 124.542 93.6682 124.059 93.6763 123.573C93.6653 123.114 93.7457 122.657 93.9128 122.23C94.0799 121.802 94.3304 121.412 94.6497 121.082C94.9689 120.752 95.3506 120.489 95.7724 120.308C96.1943 120.127 96.6479 120.032 97.107 120.028C98.0805 120.094 98.9981 120.508 99.6928 121.193C100.388 121.878 100.814 122.79 100.893 123.762C100.897 124.222 100.808 124.678 100.633 125.102C100.457 125.527 100.198 125.912 99.871 126.235C99.5438 126.558 99.1552 126.812 98.7281 126.982C98.301 127.152 97.8442 127.234 97.3846 127.224Z" fill="#000000"/>
                        <path d="M49.0389 26.6669H25.4763C24.1637 26.6669 22.8556 26.7174 21.5482 26.6669C19.6402 26.5933 17.9797 25.9324 17.7756 23.8026C17.5485 21.426 19.3167 20.5865 21.2633 20.2583C23.1977 19.9118 25.1554 19.7111 27.1198 19.6579C42.1767 19.4238 57.2346 19.2316 72.2936 19.0816C74.3585 19.0612 76.5237 19.0271 78.4573 19.6125C79.1343 19.8575 79.7514 20.2439 80.2673 20.746C80.7833 21.2482 81.1863 21.8545 81.4495 22.5247C81.9746 24.3263 80.4913 25.5635 78.7651 26.0151C77.3964 26.3718 75.9888 26.5576 74.5744 26.5684C66.0623 26.6176 57.5503 26.5933 49.0389 26.5933V26.6669Z" fill="#000000"/>
                        <path d="M128.45 26.7028C127.902 26.7236 127.355 26.6342 126.841 26.4403C126.328 26.2464 125.859 25.9517 125.461 25.5736C125.064 25.1954 124.746 24.7415 124.526 24.2386C124.307 23.7357 124.19 23.194 124.184 22.6454C124.178 20.1821 125.922 18.1881 128.072 18.1973C129.173 18.2532 130.217 18.704 131.013 19.467C131.808 20.2301 132.302 21.2543 132.404 22.352C132.438 22.899 132.361 23.4472 132.179 23.9641C131.997 24.4811 131.714 24.9564 131.345 25.362C130.977 25.7675 130.53 26.0951 130.033 26.3254C129.536 26.5557 128.998 26.6841 128.45 26.7028Z" fill="#000000"/>
                        <path d="M114.29 26.8235C113.748 26.8397 113.208 26.7489 112.7 26.5562C112.193 26.3636 111.729 26.073 111.334 25.7009C110.939 25.3288 110.621 24.8825 110.399 24.3876C110.177 23.8927 110.054 23.3589 110.038 22.8166C109.973 20.4971 111.457 19.0794 113.946 19.0899C116.589 19.1011 118.281 20.5995 118.252 22.9025C118.233 23.9434 117.807 24.9354 117.067 25.6677C116.327 26.4 115.331 26.8146 114.29 26.8235Z" fill="#000000"/>
                        <path d="M97.6531 26.4956C97.1666 26.4644 96.6917 26.334 96.2576 26.1122C95.8235 25.8905 95.4393 25.5822 95.1289 25.2063C94.8185 24.8305 94.5883 24.3951 94.4526 23.9269C94.3169 23.4587 94.2786 22.9676 94.3399 22.484C94.6162 20.5537 95.6847 19.2969 97.7745 19.3297C98.8083 19.3753 99.7819 19.8286 100.482 20.5906C101.182 21.3527 101.552 22.3611 101.51 23.3951C101.408 24.3172 100.946 25.1615 100.223 25.7428C99.4995 26.3241 98.5755 26.5948 97.6531 26.4956Z" fill="#000000"/>
                    </svg>
                </div>

                <!-- Server Name with Styling -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-500 text-white p-4 rounded-lg mb-6">
                    <h3 class="text-3xl font-bold">{{$server['server_name']}}</h3>
                </div>

                <!-- Server Specifications -->
                <div class="space-y-8"> <!-- Increased space between specs -->
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-white mb-3 border-b-2 border-blue-600 pb-2">Server Specifications</h4>
                    <ul class="text-gray-700 dark:text-gray-300">
                        <li class="flex items-center p-3 space-x-3 border-b border-gray-200 dark:border-zinc-600">
                            <!-- vCPU Icon -->
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="48" height="48" fill="white" fill-opacity="0.01"/>
                                <path d="M38 8H10C8.89543 8 8 8.89543 8 10V38C8 39.1046 8.89543 40 10 40H38C39.1046 40 40 39.1046 40 38V10C40 8.89543 39.1046 8 38 8Z" fill="#2F88FF" stroke="#2F88FF" stroke-width="4" stroke-linejoin="round"/>
                                <path d="M30 18H18V30H30V18Z" fill="#43CCF8" stroke="white" stroke-width="4" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.9092 2V8V2Z" fill="#2F88FF"/>
                                <path d="M14.9092 2V8" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.9092 40V46V40Z" fill="#2F88FF"/>
                                <path d="M14.9092 40V46" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M24 2V8V2Z" fill="#2F88FF"/>
                                <path d="M24 2V8" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M24 40V46V40Z" fill="#2F88FF"/>
                                <path d="M24 40V46" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M33.0908 2V8V2Z" fill="#2F88FF"/>
                                <path d="M33.0908 2V8" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M33.0908 40V46V40Z" fill="#2F88FF"/>
                                <path d="M33.0908 40V46" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2 14.9091H8H2Z" fill="#2F88FF"/>
                                <path d="M2 14.9091H8" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M40 14.9091H46H40Z" fill="#2F88FF"/>
                                <path d="M40 14.9091H46" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2 24H8H2Z" fill="#2F88FF"/>
                                <path d="M2 24H8" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M40 24H46H40Z" fill="#2F88FF"/>
                                <path d="M40 24H46" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2 33.0909H8H2Z" fill="#2F88FF"/>
                                <path d="M2 33.0909H8" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M40 33.0909H46H40Z" fill="#2F88FF"/>
                                <path d="M40 33.0909H46" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            
                            
                            <span class="font-medium">vCPU:</span> 
                            <span class="text-gray-900 dark:text-white font-semibold">{{$server['vcpu']}}</span>
                        </li>
                        <li class="flex items-center p-3 space-x-3 border-b border-gray-200 dark:border-zinc-600">
                            <!-- RAM Icon -->
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 4H19C20.1 4 21 4.9 21 6V18C21 19.1 20.1 20 19 20H5C3.9 20 3 19.1 3 18V6C3 4.9 3.9 4 5 4Z"/>
                                <path d="M9 10H15M9 14H15"/>
                            </svg>
                            <span class="font-medium">RAM:</span> 
                            <span class="text-gray-900 dark:text-white font-semibold">{{$server['ram']}} GB</span>
                        </li>
                        <li class="flex items-center p-3 space-x-3 border-b border-gray-200 dark:border-zinc-600">
                            <!-- Disk Storage Icon -->
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="16" rx="2" ry="2"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <span class="font-medium">Disk Storage:</span> 
                            <span class="text-gray-900 dark:text-white font-semibold">{{$server['disk_storage']}} GB</span>
                        </li>
                        <li class="flex items-center p-3 space-x-3">
                            <!-- Daily Rate Icon -->
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 8V16M12 12H16M4 4L20 20"/>
                            </svg>
                            <span class="font-medium">Daily Rate:</span> 
                            <span class="text-gray-900 dark:text-white font-semibold">{{$server['provider_price']}} BDT</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Side: Order Form -->
            <div class="flex flex-col bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-lg border border-slate-200 dark:border-zinc-700">
                <h2 class="text-xl font-semibold mb-4 text-center">bKash Payment</h2>
            
                <p class="text-sm text-gray-600 mb-4">Please follow the steps below to complete your payment:</p>
            
                <!-- Step 1: Enter Number of Days -->
                <div class="mb-4">
                    <label for="days" class="block text-sm font-medium text-gray-700 mb-2">Enter Number of Days</label>
                    <input type="number" x-model.number="days" min="1" name="days" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="e.g., 30">
                    <p class="text-xs text-gray-500 mt-1">Specify how many days you want to purchase.</p>
                </div>
            
                <!-- Step 2: Amount Information -->
                <div class="mb-4">
                    <p class="text-sm text-gray-700">Total Amount: <span id="total-amount" class="font-semibold text-lg"><span x-text="((basePrice * days) + serviceCharge).toFixed(2)"></span> BDT</span></p>
                    <p class="text-xs text-gray-500 mt-1">The total amount will be calculated based on the number of days you enter.</p>
                </div>
            
                <!-- Step 3: Payment Instructions -->
                <div class="mb-4">
                    <p class="text-sm text-gray-700">Please send the total amount to bKash:</p>
                    <p class="text-sm text-blue-500 font-medium">01728283349</p>
                    <p class="text-xs text-gray-500 mt-1">Use the above number to send the payment via bKash.</p>
                </div>
            
                <!-- Step 4: Enter Transaction ID -->
                <div class="mb-4">
                    <label for="trxID" class="block text-sm font-medium text-gray-700 mb-2">Transaction ID (trxID)</label>
                    <input type="text" id="trxID" name="trxID" class="w-full px-4 py-2 border border-gray-300 rounded-md" placeholder="Enter your transaction ID">
                    <p class="text-xs text-gray-500 mt-1">Enter the transaction ID provided by bKash after completing the payment.</p>
                </div>
            
                <!-- Submit Button -->
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">Submit Payment</button>

                <!-- Display all errors together -->
            @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-4 rounded-md mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            </div>
            
        </div>
        </form>
    </x-app.container>

    <script>
        function confirmOrder() {
            const trnxId = this.trnxId;
            const days = this.days;
            if (trnxId && days > 0) {
                alert(`Order confirmed for ${days} days. Transaction ID: ${trnxId}. Thank you for your purchase!`);
            } else {
                alert('Please enter a valid transaction ID and number of days.');
            }
        }
    </script>
</x-layouts.app>
