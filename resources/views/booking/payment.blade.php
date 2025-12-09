<x-app-layout>
    <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 bg-gray-50">
        
        <div class="max-w-4xl w-full mb-8 flex justify-center space-x-6 text-sm font-medium text-gray-400">
            <span class="text-green-600 flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Trip</span>
            <span>/</span>
            <span class="text-green-600 flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Details</span>
            <span>/</span>
            <span class="text-green-600 flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Confirm</span>
            <span>/</span>
            <span class="text-[#001233] font-bold border-b-2 border-[#001233] pb-0.5">Payment</span>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden max-w-4xl w-full flex flex-col md:flex-row">
            
            <div class="w-full md:w-1/2 p-8 md:p-12 relative">
                
                <button onclick="history.back()" class="absolute top-6 left-6 text-gray-400 hover:text-[#001233] transition flex items-center gap-1 text-sm font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back
                </button>

                <div class="flex items-center gap-3 mb-8 mt-6">
                    <img src="{{ asset('images/logo.png') }}" class="h-8 w-auto">
                    <span class="font-bold text-[#001233] text-xl">SecurePay</span>
                </div>

                <h2 class="text-2xl font-bold text-[#001233] mb-6">Payment Details</h2>
                
                <form id="paymentForm" action="{{ route('booking.process') }}" method="POST">
                    @csrf
                    @foreach($data as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Cardholder Name</label>
                            <input type="text" placeholder="JOHN DOE" class="w-full rounded-lg border-gray-300 focus:border-[#001233] focus:ring-[#001233] uppercase" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Card Number</label>
                            <div class="relative">
                                <input type="text" placeholder="0000 0000 0000 0000" maxlength="19" class="w-full rounded-lg border-gray-300 focus:border-[#001233] focus:ring-[#001233] pl-12" required>
                                <svg class="w-6 h-6 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-1/2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Expiry</label>
                                <input type="text" placeholder="MM/YY" maxlength="5" class="w-full rounded-lg border-gray-300 focus:border-[#001233] focus:ring-[#001233]" required>
                            </div>
                            <div class="w-1/2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">CVC</label>
                                <input type="text" placeholder="123" maxlength="3" class="w-full rounded-lg border-gray-300 focus:border-[#001233] focus:ring-[#001233]" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-8 bg-[#001233] text-white font-bold py-4 rounded-xl shadow-lg hover:bg-blue-900 transition flex justify-center items-center gap-2">
                        <span>Pay PHP {{ number_format($totalPrice, 2) }}</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
                
                <div class="mt-6 text-center">
                    <a href="{{ route('dashboard') }}" class="text-xs text-red-400 hover:text-red-600 font-bold uppercase tracking-wide transition">
                        Cancel Payment & Return to Home
                    </a>
                </div>

                <p class="text-[10px] text-gray-400 mt-4 text-center">
                    <span class="font-bold text-green-600">Encrypted & Secure.</span> This is a payment simulation. No real money will be deducted.
                </p>
            </div>

            <div class="w-full md:w-1/2 bg-[#001233] p-8 md:p-12 text-white flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-bold mb-6 opacity-90 border-b border-blue-900 pb-4">Order Summary</h3>
                    
                    <div class="space-y-4 pb-6 mb-6">
                        <div class="flex justify-between">
                            <span class="text-blue-200 text-sm">Route</span>
                            <span class="font-bold text-right">{{ $schedule->route->origin }} <br>➝ {{ $schedule->route->destination }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-blue-200 text-sm">Date & Time</span>
                            <span class="font-bold text-right">
                                {{ \Carbon\Carbon::parse($schedule->departure_time)->format('M d, Y') }}<br>
                                {{ \Carbon\Carbon::parse($schedule->departure_time)->format('h:i A') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-blue-200 text-sm">Selected Seats</span>
                            <span class="font-bold text-right">{{ implode(', ', $seats) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-blue-200 text-sm">Passenger</span>
                            <span class="font-bold text-right">{{ $data['passenger_name'] }}</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-end border-t border-blue-900 pt-6">
                        <span class="text-blue-200 text-sm uppercase font-bold tracking-wider">Total Amount</span>
                        <span class="text-4xl font-bold">₱ {{ number_format($totalPrice, 2) }}</span>
                    </div>
                </div>

                <div class="mt-8 opacity-50 text-xs">
                    BusPH Inc.<br>
                    San Pablo City, Laguna
                </div>
            </div>

        </div>
    </div>
    
    <script>
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button');
            
            // Change button state
            btn.disabled = true;
            btn.innerHTML = `<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing Payment...`;
            btn.classList.add('bg-gray-800', 'cursor-not-allowed');

            // Wait 2 seconds then submit
            setTimeout(() => {
                this.submit();
            }, 2000);
        });
    </script>
</x-app-layout>