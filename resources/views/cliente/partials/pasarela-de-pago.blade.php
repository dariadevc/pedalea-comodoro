<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
    @if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif
    <div id="errorCarga" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2 invisible" role="alert">
        <span class="block sm:inline"></span>
    </div>
    <h2 class="text-2xl font-bold text-red-600 mb-4">Cargar Saldo</h2>
    <form id="paymentForm" action="{{ route('cargar-saldo.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="amount" class="block text-lg font-medium text-gray-700">Monto</label>
            <select id="amount" name="amount"
                class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-red-600">
                <option value="1000" {{ old('amount') == '1000' ? 'selected' : '' }}>$1,000.00</option>
                <option value="2500" {{ old('amount') == '2500' ? 'selected' : '' }}>$2,500.00</option>
                <option value="5000" {{ old('amount') == '5000' ? 'selected' : '' }}>$5,000.00</option>
                <option value="7500" {{ old('amount') == '7500' ? 'selected' : '' }}>$7,500.00</option>
                <option value="10000" {{ old('amount') == '10000' ? 'selected' : '' }}>$1,0000.00</option>
            </select>
            @error('amount')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="cardNumber" class="block text-lg font-medium text-gray-700">Número de Tarjeta</label>
            <input type="text" id="cardNumber" name="cardNumber"
                class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-red-600"
                placeholder="1234 5678 9012 3456" maxlength="19" value="{{ old('cardNumber') }}">
            @error('cardNumber')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="cardName" class="block text-lg font-medium text-gray-700">Nombre en la Tarjeta</label>
            <input type="text" id="cardName" name="cardName"
                class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-red-600"
                placeholder="Nombre Completo" value="{{ old('cardName') }}">
            @error('cardName')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <div class="flex space-x-4">
            <div class="w-1/2">
                <label for="expiryDate" class="block text-lg font-medium text-gray-700">Fecha de Expiración</label>
                <input type="text" id="expiryDate" name="expiryDate"
                    class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-red-600"
                    placeholder="MM/AA" maxlength="5" value="{{ old('expiryDate') }}">
                @error('expiryDate')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="w-1/2">
                <label for="cvv" class="block text-lg font-medium text-gray-700">CVV</label>
                <input type="password" id="cvv" name="cvv"
                    class="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-red-600"
                    placeholder="123" maxlength="3" value="{{ old('cvv') }}">
                @error('cvv')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit"
            class="w-full bg-red-600 text-white font-semibold py-2 rounded-md hover:bg-red-700 focus:ring-2 focus:ring-red-600">
            PAGAR
        </button>
    </form>
</div>
