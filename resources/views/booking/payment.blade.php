<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- PROGRESS BAR --}}
            <div class="mb-8">
                <div class="flex items-center justify-center space-x-4">
                    <div class="flex items-center text-[#001233]">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#001233] text-white font-bold text-sm">1</span>
                    </div>
                    <div class="w-16 h-0.5 bg-[#001233]"></div>
                    <div class="flex items-center text-[#001233]">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#001233] text-white font-bold text-sm">2</span>
                    </div>
                    <div class="w-16 h-0.5 bg-[#001233]"></div>
                    <div class="flex items-center text-[#001233]">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#001233] text-white font-bold text-sm">3</span>
                        <span class="ml-2 font-bold text-sm">Payment</span>
                    </div>
                </div>
            </div>

            {{-- FORM START --}}
            <form action="{{ route('booking.process') }}" method="POST" id="paymentForm">
                @csrf
                
                {{-- HIDDEN DATA --}}
                <input type="hidden" name="schedule_id" value="{{ $data['schedule_id'] }}">
                <input type="hidden" name="seats" value="{{ $data['seats'] }}">
                <input type="hidden" name="contact_phone" value="{{ $data['contact_phone'] }}">
                <input type="hidden" name="contact_email" value="{{ $data['contact_email'] }}">
                @if(isset($data['passengers']) && is_array($data['passengers']))
                    @foreach($data['passengers'] as $index => $passenger)
                        <input type="hidden" name="passengers[{{ $index }}][first_name]" value="{{ $passenger['first_name'] }}">
                        <input type="hidden" name="passengers[{{ $index }}][surname]" value="{{ $passenger['surname'] }}">
                        <input type="hidden" name="passengers[{{ $index }}][discount_id]" value="{{ $passenger['discount_id'] ?? '' }}">
                    @endforeach
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- LEFT: PAYMENT DETAILS (Interactive) --}}
                    <div class="lg:col-span-2 space-y-6" x-data="{ method: 'card' }">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <h2 class="text-xl font-bold text-[#001233] mb-6">Payment Method</h2>
                            
                            {{-- OPTION 1: CREDIT CARD --}}
                            <div class="border rounded-lg mb-4 overflow-hidden transition-all duration-200"
                                 :class="method === 'card' ? 'border-[#001233] ring-1 ring-[#001233] bg-blue-50/10' : 'border-gray-200 hover:bg-gray-50'">
                                <label class="flex items-center p-4 cursor-pointer">
                                    <input type="radio" name="payment_method" value="card" x-model="method" class="text-[#001233] focus:ring-[#001233]">
                                    <div class="ml-3 flex items-center gap-3">
                                        <span class="font-bold text-gray-800">Credit / Debit Card</span>
                                        <div class="flex gap-1">
                                            {{-- Generic Card Icons --}}
                                            <div class="bg-gray-200 h-5 w-8 rounded"></div>
                                            <div class="bg-gray-200 h-5 w-8 rounded"></div>
                                        </div>
                                    </div>
                                </label>
                                
                                {{-- Card Inputs (Only show if 'card' is selected) --}}
                                <div x-show="method === 'card'" x-transition class="p-4 border-t border-gray-200 bg-gray-50/50">
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Card Number</label>
                                            <input type="text" placeholder="0000 0000 0000 0000" class="w-full rounded-lg border-gray-300 focus:ring-[#001233] focus:border-[#001233]">
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Expiration</label>
                                                <input type="text" placeholder="MM / YY" class="w-full rounded-lg border-gray-300 focus:ring-[#001233] focus:border-[#001233]">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">CVC / CVV</label>
                                                <input type="text" placeholder="123" class="w-full rounded-lg border-gray-300 focus:ring-[#001233] focus:border-[#001233]">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Cardholder Name</label>
                                            <input type="text" placeholder="JUAN DELA CRUZ" class="w-full rounded-lg border-gray-300 focus:ring-[#001233] focus:border-[#001233]">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- OPTION 2: GCASH --}}
                            <div class="border rounded-lg mb-4 overflow-hidden transition-all duration-200"
                                 :class="method === 'gcash' ? 'border-blue-500 ring-1 ring-blue-500 bg-blue-50/10' : 'border-gray-200 hover:bg-gray-50'">
                                <label class="flex items-center p-4 cursor-pointer">
                                    <input type="radio" name="payment_method" value="gcash" x-model="method" class="text-blue-500 focus:ring-blue-500">
                                    <div class="ml-3 flex items-center gap-3">
                                        <span class="font-bold text-gray-800">GCash</span>
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded-full font-bold">E-Wallet</span>
                                    </div>
                                </label>
                                
                                <div x-show="method === 'gcash'" x-transition class="p-4 border-t border-gray-200 bg-gray-50/50">
                                    <p class="text-sm text-gray-600 mb-3">You will be redirected to GCash to complete your payment securely.</p>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">GCash Mobile Number</label>
                                        <input type="text" placeholder="0917 123 4567" class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>

                            {{-- OPTION 3: MAYA --}}
                            <div class="border rounded-lg mb-4 overflow-hidden transition-all duration-200"
                                 :class="method === 'maya' ? 'border-green-500 ring-1 ring-green-500 bg-green-50/10' : 'border-gray-200 hover:bg-gray-50'">
                                <label class="flex items-center p-4 cursor-pointer">
                                    <input type="radio" name="payment_method" value="maya" x-model="method" class="text-green-500 focus:ring-green-500">
                                    <div class="ml-3 flex items-center gap-3">
                                        <span class="font-bold text-gray-800">Maya</span>
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full font-bold">E-Wallet</span>
                                    </div>
                                </label>
                                
                                <div x-show="method === 'maya'" x-transition class="p-4 border-t border-gray-200 bg-gray-50/50">
                                    <p class="text-sm text-gray-600 mb-3">Scan QR code or login to Maya to pay.</p>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Maya Account Number</label>
                                        <input type="text" placeholder="0918 123 4567" class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- RIGHT: SUMMARY --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 sticky top-4">
                            <h3 class="text-xl font-bold text-[#001233] mb-6 border-b pb-4">Order Summary</h3>

                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Route</span>
                                    <span class="font-bold text-gray-900">{{ $schedule->route->origin }} → {{ $schedule->route->destination }}</span>
                                </div>
                                
                                {{-- DETAILED FARE BREAKDOWN --}}
                                <div class="border-t border-dashed border-gray-200 pt-4 mt-4">
                                    <p class="text-xs font-bold text-gray-500 uppercase mb-3">Fare Breakdown</p>
                                    
                                    @foreach($priceBreakdown as $item)
                                        <div class="flex justify-between items-start mb-3 text-sm">
                                            <div>
                                                <span class="block font-medium text-gray-800">
                                                    {{ $item['name'] }} 
                                                    <span class="text-xs text-gray-400">(Seat {{ $item['seat'] }})</span>
                                                </span>
                                                @if($item['is_discounted'])
                                                    <span class="bg-green-100 text-green-700 text-[10px] px-1.5 py-0.5 rounded font-bold">
                                                        20% DISCOUNT APPLIED
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                @if($item['is_discounted'])
                                                    <span class="block text-xs text-gray-400 line-through">₱ {{ number_format($item['original_price'], 2) }}</span>
                                                    <span class="block font-bold text-green-600">₱ {{ number_format($item['final_price'], 2) }}</span>
                                                @else
                                                    <span class="font-bold text-gray-900">₱ {{ number_format($item['final_price'], 2) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="border-t pt-4">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-gray-600 font-bold">Total Amount</span>
                                    <span class="text-3xl font-black text-[#001233]">₱ {{ number_format($totalPrice, 2) }}</span>
                                </div>

                                {{-- ACTION BUTTONS --}}
                                <div class="space-y-3">
                                    <button type="submit" class="w-full bg-green-600 text-white py-4 rounded-lg font-bold hover:bg-green-700 transition shadow-lg text-lg flex justify-center items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Pay ₱ {{ number_format($totalPrice, 2) }}
                                    </button>

                                    <a href="{{ route('home') }}" class="block w-full bg-gray-100 text-gray-600 py-3 rounded-lg font-bold hover:bg-gray-200 transition text-center border border-gray-200">
                                        Cancel Transaction
                                    </a>
                                </div>
                                
                                <p class="text-xs text-center text-gray-400 mt-4">
                                    Secured by PayMongo. Your data is encrypted.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

{{-- IMPORTANT!!! --}}
{{-- Remove this part when integrating a real payment gateway --}}
<script>
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('button');
        btn.disabled = true;
        btn.innerHTML = `<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing Payment...`;
        btn.classList.add('bg-gray-800', 'cursor-not-allowed');
        setTimeout(() => {
            this.submit();
        }, 2000);
    });
</script>