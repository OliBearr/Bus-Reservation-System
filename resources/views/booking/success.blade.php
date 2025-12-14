<x-app-layout>
    <div class="flex flex-col min-h-screen">
        
        <div class="flex-grow flex flex-col justify-center items-center py-12 bg-green-50 px-4">
            
            <div class="bg-white p-10 rounded-2xl shadow-xl text-center max-w-md w-full border border-gray-100">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                
                <h1 class="text-3xl font-black text-[#001233] mb-2">Payment Successful!</h1>
                <p class="text-gray-500 mb-8">Your booking has been confirmed.</p>
                
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-8 text-left relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-green-500"></div>
                    
                    <p class="text-xs text-gray-400 uppercase font-bold mb-1">Transaction ID</p>
                    <p class="text-lg font-mono font-bold text-[#001233] tracking-widest">{{ $id }}</p>
                </div>

                <a href="{{ route('home') }}" class="block w-full py-4 bg-[#001233] text-white font-bold rounded-xl shadow-lg hover:bg-blue-900 transition transform hover:-translate-y-1">
                    Return to Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>