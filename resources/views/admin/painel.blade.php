<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel Administrativo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-red-50 overflow-hidden shadow-sm sm:rounded-lg border border-red-200">
                <div class="p-6 text-red-900 font-bold">
                    {{ __("Bem-vindo, Administrador!") }}
                </div>
                <div class="p-6 text-gray-600">
                    Aqui você poderá gerenciar usuários, configurações e relatórios.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>