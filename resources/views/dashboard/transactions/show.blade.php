<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from html.hixstudio.net/ebazer/transaction.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 19 Apr 2025 11:45:35 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Braun - Transaction Details</title>
    <link rel="shortcut icon" href="assets/img/logo/favicon.png" type="image/x-icon">

    <!-- css links -->
    @include('dashboard.components.style')

</head>
<body>

    <div class="tp-main-wrapper bg-slate-100 h-screen" x-data="{ sideMenu: false }">
        @include('dashboard.components.sideleft')


        <div class="fixed top-0 left-0 w-full h-full z-40 bg-black/70 transition-all duration-300" :class="sideMenu ? 'visible opacity-1' : '  invisible opacity-0 '" x-on:click="sideMenu = ! sideMenu"> </div>

        <div class="tp-main-content lg:ml-[250px] xl:ml-[300px] w-[calc(100% - 300px)]"  x-data="{ searchOverlay: false }">

            @include('dashboard.components.header')

            <div class="body-content px-8 py-8 bg-slate-100">
                <div class="flex justify-between items-center mb-8">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <a href="{{ route('dashboard.home') }}" class="text-gray-500 hover:text-gray-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </a>
                            <span class="text-gray-400">/</span>
                            <a href="{{ route('dashboard.transactions.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors">Transactions</a>
                            <span class="text-gray-400">/</span>
                            <span class="text-gray-700 font-medium">Details</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <h1 class="text-2xl font-bold text-gray-900">Transaction #{{ $transaction->id }}</h1>
                            <div class="px-3 py-1 rounded-full text-sm font-medium
                                @if($transaction->status == 'success')
                                    bg-green-100 text-green-800
                                @elseif($transaction->status == 'pending')
                                    bg-yellow-100 text-yellow-800
                                @else
                                    bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($transaction->status) }}
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('dashboard.transactions.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Transactions
                        </a>
                        <button onclick="window.print()" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Print
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Transaction Details -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="p-6 border-b border-gray-100">
                                <h4 class="text-xl font-semibold text-gray-800">Transaction #{{ $transaction->id }}</h4>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Transaction Information -->
                                    <div>
                                        <h5 class="text-lg font-semibold text-gray-800 mb-4">Transaction Information</h5>
                                        <div class="space-y-4">
                                            <div>
                                                <p class="text-sm text-gray-600">Order Reference</p>
                                                <p class="text-base font-medium text-gray-900">{{ $transaction->red_order }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">Konnect Order ID</p>
                                                <p class="text-base font-medium text-gray-900">{{ $transaction->order_id }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">Amount</p>
                                                <p class="text-base font-medium text-gray-900">{{ number_format($transaction->amount, 3) }} TND</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">Status</p>
                                                <div class="mt-1">
                                                    @if($transaction->status == 'success')
                                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Successful</span>
                                                    @elseif($transaction->status == 'pending')
                                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                    @else
                                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Failed</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">Payment Method</p>
                                                <p class="text-base font-medium text-gray-900">{{ ucfirst($transaction->payment_method) }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">Created At</p>
                                                <p class="text-base font-medium text-gray-900">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</p>
                                            </div>
                                            @if($transaction->paid_at)
                                            <div>
                                                <p class="text-sm text-gray-600">Paid At</p>
                                                <p class="text-base font-medium text-gray-900">{{ $transaction->paid_at->format('d/m/Y H:i:s') }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Order Details -->
                                    <div>
                                        <h5 class="text-lg font-semibold text-gray-800 mb-4">Order Details</h5>
                                        @if($transaction->order)
                                            <div class="space-y-4">
                                                <div>
                                                    <p class="text-sm text-gray-600">Customer Name</p>
                                                    <p class="text-base font-medium text-gray-900">{{ $transaction->order->nom }} {{ $transaction->order->prenom }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600">Email</p>
                                                    <p class="text-base font-medium text-gray-900">{{ $transaction->order->email }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600">Phone</p>
                                                    <p class="text-base font-medium text-gray-900">{{ $transaction->order->telephone }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600">Address</p>
                                                    <p class="text-base font-medium text-gray-900">{{ $transaction->order->adress }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-600">Governorate</p>
                                                    <p class="text-base font-medium text-gray-900">{{ $transaction->order->gouvernorat }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                                <p class="text-yellow-800">Order details are not available.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Technical Details -->
                                <div class="mt-8">
                                    <h5 class="text-lg font-semibold text-gray-800 mb-4">Technical Details</h5>
                                    <div class="bg-gray-50 rounded-lg p-6">
                                        <div class="space-y-4">
                                            <div>
                                                <p class="text-sm font-medium text-gray-600 mb-1">Payment Reference</p>
                                                <div class="flex items-center space-x-2">
                                                    <code class="px-3 py-1 bg-gray-100 rounded text-sm font-mono text-gray-800">{{ $transaction->payment_details['paymentRef'] ?? 'N/A' }}</code>
                                                    <button onclick="copyToClipboard('{{ $transaction->payment_details['paymentRef'] ?? '' }}')" class="text-gray-500 hover:text-gray-700">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-600 mb-1">Payment URL</p>
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ $transaction->payment_details['payUrl'] ?? '#' }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm break-all">
                                                        {{ $transaction->payment_details['payUrl'] ?? 'N/A' }}
                                                    </a>
                                                    <button onclick="copyToClipboard('{{ $transaction->payment_details['payUrl'] ?? '' }}')" class="text-gray-500 hover:text-gray-700">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                            <h5 class="text-lg font-semibold text-gray-800 mb-6">Quick Actions</h5>
                            <div class="space-y-4">
                                <button onclick="window.print()" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                    </svg>
                                    Print Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.components.js')

    @push('scripts')
    <script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            // You could add a toast notification here
            alert('Copied to clipboard!');
        }).catch(err => {
            console.error('Failed to copy text: ', err);
        });
    }
    </script>
    @endpush

</body>

<!-- Mirrored from html.hixstudio.net/ebazer/transaction.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 19 Apr 2025 11:45:36 GMT -->
</html> 

