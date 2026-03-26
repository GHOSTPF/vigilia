<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Cadastro Concluído') }}
        </h2>
    </x-slot>

    <div class="py-20 bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 min-h-screen flex items-center justify-center">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 text-center">
            
            <!-- Círculo com checkmark animado -->
            <div class="mb-8 flex justify-center">
                <div class="relative w-32 h-32 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center shadow-2xl animate-pulse">
                    <svg class="w-16 h-16 text-white animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            <!-- Mensagem Principal -->
            <div class="bg-white rounded-2xl shadow-2xl p-12 border-t-4 border-green-500">
                <h1 class="text-4xl font-bold text-green-700 mb-4">
                    Parabéns! 🎉
                </h1>
                
                <p class="text-2xl text-gray-800 mb-2 font-semibold">
                    Seu cadastro na Vigília foi concluído
                </p>

                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    Você realizou o seu cadastro com sucesso! Agora você está totalmente registrado na plataforma Vigília e pode acessar todos os recursos disponíveis.
                </p>

                <!-- Dados do Cadastro em um resumo compacto -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-6 mb-8 border border-green-200">
                    <p class="text-sm text-gray-600 mb-3 font-medium">DADOS REGISTRADOS</p>
                    <div class="grid grid-cols-2 gap-4 text-left">
                        <div>
                            <span class="text-xs text-gray-500 uppercase">Nome</span>
                            <p class="font-semibold text-gray-800">{{ $registro->user->name }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 uppercase">Email</span>
                            <p class="font-semibold text-gray-800">{{ $registro->user->email }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 uppercase">Idade</span>
                            <p class="font-semibold text-gray-800">{{ $registro->idade }} anos</p>
                        </div>
                        <div>
                            <span class="text-xs text-gray-500 uppercase">Telefone</span>
                            <p class="font-semibold text-gray-800">{{ $registro->telefone }}</p>
                        </div>
                    </div>
                </div>

                <!-- Aviso importante -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded mb-8 text-left">
                    <p class="text-sm text-yellow-800">
                        <span class="font-semibold">⚠️ Importante:</span> Seu cadastro é permanente. Para alterar informações, entre em contato com nosso suporte.
                    </p>
                </div>

                <!-- Botão de ação -->
                <a href="{{ route('dashboard.user') }}" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-indigo-600 via-purple-600 to-fuchsia-600 text-white font-bold rounded-lg shadow-lg hover:from-indigo-500 hover:via-purple-500 hover:to-fuchsia-500 transition-all duration-200 transform hover:scale-105">
                    ← Voltar para Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
