<x-app-layout :title="__('Dashboard Administrativo')">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Painel Administrativo') }}
                </h2>
                <p class="text-sm text-gray-500">Bem-vindo, {{ Auth::user()->name }}</p>
            </div>
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                + Novo Registro
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="max-w-sm bg-white rounded-lg shadow-md p-6 mb-4">
                    <h2 class="text-xl font-bold mb-2">Total de Inscrições</h2>
                    <p class="text-gray-600">Número total de inscrições registradas.</p>
                    <div class="mt-4">
                        <span class="text-3xl font-bold text-indigo-600">{{ $totalRegistros }}</span>
                    </div>
                </div>
                <div class="max-w-sm bg-white rounded-lg shadow-md p-6 mb-4">
                    <h2 class="text-xl font-bold mb-2">Menores de Idade</h2>
                    <p class="text-gray-600">Inscritos com menos de 18 anos.</p>
                    <div class="mt-4">
                        <span class="text-3xl font-bold text-red-500">{{ $menores }}</span>
                    </div>
                </div>

                <div class="max-w-sm bg-white rounded-lg shadow-md p-6 mb-4">
                    <h2 class="text-xl font-bold mb-2">Maiores de Idade</h2>
                    <p class="text-gray-600">Inscritos com 18 anos ou mais.</p>
                    <div class="mt-4">
                        <span class="text-3xl font-bold text-green-600">{{ $maiores }}</span>
                    </div>
                </div>
            </div>
            <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-6">
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Registros da Vigília</h3>
                    
                    <form method="GET" action="{{ route('seu-dashboard.index') }}" class="flex flex-wrap items-center gap-3">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nome..." 
                                class="pl-10 pr-4 py-2 border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl text-sm w-full md:w-64">
                        </div>

                        <select name="ordem" class="border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl text-sm">
                            <option value="recentes">Mais recentes</option>
                            <option value="antigos">Mais antigos</option>
                            <option value="nome">Nome (A-Z)</option>
                        </select>

                        <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold transition">
                            Filtrar
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto border border-gray-100 rounded-xl">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Usuário</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Idade</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Documentos</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Contato</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Responsável</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Anexos</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($registros as $registro)
                                <tr class="hover:bg-blue-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-now3rap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs mr-3">
                                                {{ substr($registro->user->name ?? '?', 0, 1) }}
                                            </div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $registro->user->name ?? '-' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            @if ($registro->idade >= 18)
                                                {{ $registro->idade }} anos
                                            @else
                                                {{ $registro->idade }} ano
                                            @endif
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-gray-900">
                                                @php
                                                    $valor = preg_replace("/[^0-9]/", "", $registro->cpf_rg);
                                                    if (strlen($valor) === 11) {
                                                        $formatado = vsprintf('%s%s%s.%s%s%s.%s%s%s-%s%s', str_split($valor));
                                                    } else {
                                                        $formatado = $registro->cpf_rg; // Caso não seja CPF, mantém como está
                                                    }
                                                @endphp

                                                {{ $formatado }}
                                            <span class="text-xs text-gray-400 uppercase tracking-tighter ml-2">CPF/RG</span></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        @php
                                            $tel = preg_replace('/[^0-9]/', '', $registro->telefone);
                                            
                                            if (strlen($tel) === 11) {
                                                $telFormatado = preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $tel);
                                            } elseif (strlen($tel) === 10) {
                                                $telFormatado = preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $tel);
                                            } else {
                                                $telFormatado = $registro->telefone; 
                                            }
                                        @endphp

                                        {{ $telFormatado }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $registro->nome_responsavel ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex justify-center items-center gap-3" x-data="{ open: false }">
                                            
                                            <button 
                                                @click="$dispatch('open-modal', 'modal-docs-{{ $registro->id }}')"
                                                class="flex items-center gap-1 text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-2 py-1 rounded-md transition"
                                                title="Ver Documentos"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <span class="text-xs font-bold">Anexado</span>
                                            </button>

                                            <button class="text-red-400 hover:text-red-600 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>

                                            <x-modal name="modal-docs-{{ $registro->id }}" focusable>
                                                <div class="p-6">
                                                    <h2 class="text-lg font-bold text-gray-900 mb-4">
                                                        Documentos de: {{ $registro->user->name }}
                                                    </h2>

                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div class="border rounded-xl p-4 flex flex-col items-center">
                                                            <p class="text-sm font-semibold mb-2">Termo de Autorização</p>
                                                            @if($registro->termo_autorizacao_path)
                                                                <iframe src="{{ asset('storage/' . $registro->termo_autorizacao_path) }}" class="w-full h-64 rounded border mb-2"></iframe>
                                                                <a href="{{ asset('storage/' . $registro->termo_autorizacao_path) }}" target="_blank" class="text-blue-600 text-xs underline">Abrir em nova aba</a>
                                                            @else
                                                                <p class="text-xs text-gray-400">Não enviado</p>
                                                            @endif
                                                        </div>

                                                        <div class="border rounded-xl p-4 flex flex-col items-center">
                                                            <p class="text-sm font-semibold mb-2">Doc. Responsável</p>
                                                            @if($registro->doc_responsavel_path)
                                                                <iframe src="{{ asset('storage/' . $registro->doc_responsavel_path) }}" class="w-full h-64 rounded border mb-2"></iframe>
                                                                <a href="{{ asset('storage/' . $registro->doc_responsavel_path) }}" target="_blank" class="text-blue-600 text-xs underline">Abrir em nova aba</a>
                                                            @else
                                                                <p class="text-xs text-gray-400">Não enviado</p>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="mt-6 flex justify-end">
                                                        <x-secondary-button x-on:click="$dispatch('close')">
                                                            Fechar
                                                        </x-secondary-button>
                                                    </div>
                                                </div>
                                            </x-modal>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900 p-1 rounded-md hover:bg-indigo-50">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <a href="#" class="text-red-600 hover:text-red-900 p-1 rounded-md hover:bg-red-50">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <p class="text-gray-500 font-medium">Nenhum registro encontrado.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $registros->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>