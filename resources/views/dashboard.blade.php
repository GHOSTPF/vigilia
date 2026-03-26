<x-app-layout :title="__('Cadastro da Vigilia')">
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Faça o seu cadastro da Vigilia') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if ($jaRegistrado || session('success') === 'cadastro_concluido')
                <!-- Mensagem de Sucesso -->
                <div class="py-20 bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 min-h-screen flex items-center justify-center -mx-6 -my-12">
                    <div class="max-w-2xl text-center px-6">
                        
                        <!-- Círculo com checkmark animado -->
                        <div class="mb-8 flex justify-center">
                            <div class="relative w-32 h-32 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center shadow-2xl animate-pulse">
                                <svg class="w-16 h-16 text-white animate-bounce" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>

                        <!-- Mensagem Principal -->
                        <h1 class="text-5xl font-bold text-green-700 mb-4">
                            Parabéns! 🎉
                        </h1>
                        
                        <p class="text-3xl text-gray-800 font-semibold">
                            Seu cadastro na Vigília foi concluído com sucesso
                        </p>
                    </div>
                </div>
            @else
                <!-- Formulário de Cadastro -->
                <div x-data="{ idade: '{{ auth()->user()->idade }}', submetendo: false }">
                    <form action="{{ route('cadastro.salvar') }}" method="POST" enctype="multipart/form-data" @submit="submetendo = true" class="space-y-6">
                        @csrf

                        <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
                            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 font-semibold text-gray-700">
                                Informações Pessoais
                            </div>
                            
                            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="col-span-2 md:col-span-1">
                                    <x-input-label for="name" value="Nome Completo" />
                                    <x-text-input id="name" name="name" class="block mt-1 w-full bg-gray-50" type="text" value="{{ auth()->user()->name }}" required />
                                </div>

                                <div class="col-span-2 md:col-span-1">
                                    <x-input-label for="email" value="Seu Email" />
                                    <x-text-input id="email" name="email" class="block mt-1 w-full bg-gray-100 text-gray-500" type="email" value="{{ auth()->user()->email }}" readonly />
                                </div>

                                <div>
                                    <x-input-label for="cpf_rg" value="CPF ou RG" />
                                    <x-text-input id="cpf_rg" name="cpf_rg" class="block mt-1 w-full" type="text" placeholder="000.000.000-00" required />
                                </div>

                                <div>
                                    <x-input-label for="telefone" value="Contato (WhatsApp)" />
                                    <x-text-input id="telefone" name="telefone" class="block mt-1 w-full" type="text" placeholder="(00) 00000-0000" required />
                                </div>

                                <div>
                                    <x-input-label for="idade" value="Sua Idade" />
                                    <x-text-input id="idade" name="idade" x-model="idade" class="block mt-1 w-32" type="number" required />
                                </div>
                            </div>
                        </div>

                        <div x-show="idade !== '' && idade < 18" x-transition class="bg-orange-50 border border-orange-200 rounded-xl overflow-hidden shadow-sm">
                            <div class="px-6 py-4 bg-orange-100/50 border-b border-orange-200 flex items-center font-bold text-orange-800">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Dados do Responsável Requeridos
                            </div>

                            <div class="p-6 space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-input-label value="Nome do Responsável" />
                                        <x-text-input name="nome_responsavel" class="block mt-1 w-full border-orange-300" type="text" />
                                    </div>
                                    <div>
                                        <x-input-label value="Telefone do Responsável" />
                                        <x-text-input id="contato_responsavel" name="contato_responsavel" class="block mt-1 w-full border-orange-300" type="text" placeholder="(00) 00000-0000" />
                                    </div>
                                    <div>
                                        <x-input-label value="Grau de Parentesco" />
                                        <select name="parentesco" class="block mt-1 w-full border-orange-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                                            <option value="">Selecione...</option>
                                            <option value="Pai">Pai</option>
                                            <option value="Mãe">Mãe</option>
                                            <option value="Avô/Avó">Avô/Avó</option>
                                            <option value="Tio/Tia">Tio/Tia</option>
                                            <option value="Outro">Outro (Responsável Legal)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                                    <div class="border-2 border-dashed border-orange-300 rounded-lg p-4 bg-white/50">
                                        <span class="block text-sm font-semibold text-orange-800">Termo de Autorização</span>
                                        <input type="file" name="termo_autorizacao" class="mt-2 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-orange-200 file:text-orange-700 hover:file:bg-orange-300" />
                                    </div>
                                    <div class="border-2 border-dashed border-orange-300 rounded-lg p-4 bg-white/50">
                                        <span class="block text-sm font-semibold text-orange-800">Documento do Responsável</span>
                                        <input type="file" name="doc_responsavel" class="mt-2 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-orange-200 file:text-orange-700 hover:file:bg-orange-300" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6">
                            <label class="flex items-start cursor-pointer group">
                                <div class="flex items-center h-5">
                                    <input name="lgpd" type="checkbox" required class="focus:ring-indigo-500 h-5 w-5 text-indigo-600 border-gray-300 rounded transition cursor-pointer">
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="font-medium text-gray-700 group-hover:text-gray-900 transition italic" style="margin-left: 13px">Li e aceito os termos de consentimento para tratamento de dados pessoais (LGPD) e de responsabilidade.</span>
                                </div>
                            </label>

                            <div class="mt-8 flex justify-end">
                                <button type="submit" 
                                        class="inline-flex items-center justify-center space-x-2 px-10 py-4 bg-gradient-to-r from-indigo-600 via-purple-600 to-fuchsia-600 text-white font-bold uppercase tracking-widest rounded-xl shadow-2xl shadow-indigo-500/40 border border-transparent hover:from-indigo-500 hover:via-purple-500 hover:to-fuchsia-500 active:scale-95 transform transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-indigo-300 disabled:opacity-50 disabled:cursor-not-allowed"
                                        :disabled="submetendo">
                                    <span x-show="!submetendo" class="text-white">Finalizar e Salvar</span>
                                    <span x-show="submetendo" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        Enviando...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <script>
                    // Função para formatar CPF progressivamente
                    function formatCPF(value) {
                        value = value.replace(/\D/g, '').slice(0, 11);

                        if (value.length > 9) {
                            return value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
                        }
                        if (value.length > 6) {
                            return value.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
                        }
                        if (value.length > 3) {
                            return value.replace(/(\d{3})(\d{1,3})/, '$1.$2');
                        }
                        return value;
                    }

                    // Função para formatar telefone progressivamente
                    function formatTelefone(value) {
                        value = value.replace(/\D/g, '').slice(0, 11);

                        if (value.length > 10) {
                            return value.replace(/(\d{2})(\d{5})(\d{1,4})/, '($1) $2-$3');
                        }
                        if (value.length > 6) {
                            return value.replace(/(\d{2})(\d{4,5})(\d{0,4})/, '($1) $2-$3').replace(/-$/, '');
                        }
                        if (value.length > 2) {
                            return value.replace(/(\d{2})(\d{1,5})/, '($1) $2');
                        }
                        return value;
                    }

                    // Aplicar máscara ao CPF e telefone, só se os elementos existirem
                    const cpfInput = document.getElementById('cpf_rg');
                    const telefoneInput = document.getElementById('telefone');
                    const contatoResponsavelInput = document.getElementById('contato_responsavel');

                    if (cpfInput) {
                        cpfInput.addEventListener('input', function (e) {
                            e.target.value = formatCPF(e.target.value);
                        });
                    }

                    if (telefoneInput) {
                        telefoneInput.addEventListener('input', function (e) {
                            e.target.value = formatTelefone(e.target.value);
                        });
                    }

                    if (contatoResponsavelInput) {
                        contatoResponsavelInput.addEventListener('input', function (e) {
                            e.target.value = formatTelefone(e.target.value);
                        });
                    }
                </script>
            @endif

        </div>
    </div>
</x-app-layout>