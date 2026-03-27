<x-app-layout :title="__('Cadastro da Vigilia')">
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Faça o seu cadastro da Vigilia') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if ($jaRegistrado || session('success') === 'cadastro_concluido')
                <div class="flex items-center justify-center" style="background-color: #d1fae5; font-family: 'Nunito', sans-serif; padding: 48px 80px; border-radius: 12px; margin-top: 16px; max-width: 600px; margin-left: auto; margin-right: auto;">
                    <div class="flex flex-col items-center text-center gap-5">

                        {{-- Círculo com check --}}
                        <div class="flex items-center justify-center rounded-full" style="width:100px; height:100px; background-color:#34d399; box-shadow: 0 8px 32px rgba(16,185,129,0.35); animation: popIn .6s cubic-bezier(.175,.885,.32,1.275) both;">
                            <svg viewBox="0 0 52 52" style="width:48px;height:48px;stroke:#fff;stroke-width:3;fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-dasharray:60;stroke-dashoffset:60;animation:drawCheck .5s ease .5s forwards;">
                                <polyline points="14,27 23,36 38,18"/>
                            </svg>
                        </div>

                        <h1 style="font-size:1.75rem; font-weight:800; color:#065f46; margin:0; animation:fadeUp .5s ease .7s both;">
                            Parabéns! 🎉
                        </h1>

                        <p style="font-size:1rem; font-weight:600; color:#1f7a55; margin:0; max-width:300px; line-height:1.6; animation:fadeUp .5s ease .85s both;">
                            Seu cadastro na Vigília foi concluído com sucesso
                        </p>

                    </div>
                </div>

            @else
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

                        <div x-show="idade !== '' && idade < 18" x-transition id="responsavel-section" class="rounded-2xl overflow-hidden shadow-md transition-all duration-500" style="border: 1.5px solid #fcd34d; background: #fffbeb;">

                            <div id="responsavel-header" class="px-6 py-4 border-b flex items-center justify-between" style="background: #fef3c7; border-color: #fcd34d;">
                                <div class="flex items-center gap-3">
                                    <div id="responsavel-icon" class="flex items-center justify-center" style="background: #f59e0b;width: 30px;height: 30px;border-radius: 50%;">
                                        <svg id="icon-alert" class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        <svg id="icon-check" class="w-5 h-5 text-white hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm" id="responsavel-title" style="color: #92400e;">Dados do Responsável</p>
                                        <p class="text-xs" id="responsavel-subtitle" style="color: #b45309;">Preencha os campos abaixo para continuar</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 space-y-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                    <div class="space-y-1">
                                        <label class="text-xs font-semibold uppercase tracking-wide" style="color:#6b7280;">Nome do Responsável</label>
                                        <input id="campo-nome" name="nome_responsavel" type="text"
                                            class="resp-input w-full px-4 py-2.5 rounded-xl bg-white text-sm text-gray-800 placeholder-gray-400 outline-none transition-all duration-300"
                                            style="border: 1.5px solid #fcd34d;border-radius: 10px;"
                                            placeholder="Nome completo"
                                            oninput="atualizarProgresso()" />
                                    </div>

                                    <div class="space-y-1">
                                        <label class="text-xs font-semibold uppercase tracking-wide" style="color:#6b7280;">Telefone do Responsável</label>
                                        <input id="campo-tel" name="contato_responsavel" type="text"
                                            class="resp-input w-full px-4 py-2.5 rounded-xl bg-white text-sm text-gray-800 placeholder-gray-400 outline-none transition-all duration-300"
                                            style="border: 1.5px solid #fcd34d;border-radius: 10px;"
                                            placeholder="(00) 00000-0000"
                                            oninput="atualizarProgresso()" />
                                    </div>

                                    <div class="space-y-1 md:col-span-2">
                                        <label class="text-xs font-semibold uppercase tracking-wide" style="color:#6b7280;">Grau de Parentesco</label>
                                        <select id="campo-parentesco" name="parentesco"
                                                class="resp-input w-full px-4 py-2.5 rounded-xl bg-white text-sm text-gray-800 outline-none transition-all duration-300 appearance-none"
                                                style="border: 1.5px solid #fcd34d;border-radius: 10px;"
                                                onchange="atualizarProgresso()">
                                            <option value="">Selecione o parentesco...</option>
                                            <option value="Pai">Pai</option>
                                            <option value="Mãe">Mãe</option>
                                            <option value="Avô/Avó">Avô/Avó</option>
                                            <option value="Tio/Tia">Tio/Tia</option>
                                            <option value="Outro">Outro (Responsável Legal)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">

                                    <div id="box-termo" class="rounded-xl p-4 bg-white/60 space-y-2 transition-all duration-300" style="border: 2px dashed #fcd34d;margin-bottom: 5px;">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span class="text-sm font-semibold text-gray-700">Termo de Autorização</span>
                                        </div>
                                        <input type="file" name="termo_autorizacao" id="campo-termo"
                                            onchange="atualizarProgresso()"
                                            class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-100 file:text-amber-700 hover:file:bg-amber-200" />
                                        <p id="label-termo" class="text-xs font-medium hidden" style="color:#059669;"></p>
                                    </div>

                                    <div id="box-doc" class="rounded-xl p-4 bg-white/60 space-y-2 transition-all duration-300" style="border: 2px dashed #fcd34d;">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c2.21 0 4 1.343 4 3H3c0-1.657 1.79-3 4-3z"/>
                                            </svg>
                                            <span class="text-sm font-semibold text-gray-700">Documento do Responsável</span>
                                        </div>
                                        <input type="file" name="doc_responsavel" id="campo-doc"
                                            onchange="atualizarProgresso()"
                                            class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-100 file:text-amber-700 hover:file:bg-amber-200" />
                                        <p id="label-doc" class="text-xs font-medium hidden" style="color:#059669;"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6">
                            <label class="flex items-start cursor-pointer group">
                                <div class="flex items-center h-5">
                                    <input name="lgpd" type="checkbox" required 
                                        class="focus:ring-emerald-500 h-5 w-5 text-emerald-600 border-gray-300 rounded transition cursor-pointer">
                                </div>
                                <div class="ml-4 text-sm">
                                    <span class="text-gray-600 italic" style="margin-left: 10px;">
                                        Li e aceito os termos de consentimento para tratamento de dados pessoais (LGPD) e de responsabilidade.
                                    </span>
                                </div>
                            </label>

                            <div class="mt-6 flex justify-end">
                                <button type="submit"
                                        class="group relative inline-flex items-center justify-center gap-2 px-8 py-3 rounded-xl font-semibold text-white text-sm tracking-wide transition-all duration-200 active:scale-95 focus:outline-none focus:ring-4 focus:ring-emerald-300 disabled:opacity-50 disabled:cursor-not-allowed overflow-hidden"
                                        style="background-color: #059669;padding: 10px;border-radius: 10px;"
                                        onmouseover="this.style.backgroundColor='#047857'"
                                        onmouseout="this.style.backgroundColor='#059669'"
                                        :disabled="submetendo">

                                    {{-- Ícone check --}}
                                    <svg x-show="!submetendo" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>

                                    <span x-show="!submetendo">Finalizar e Salvar</span>

                                    <span x-show="submetendo" class="flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                                        </svg>
                                        Enviando...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <script>
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

                    const cpfInput = document.getElementById('cpf_rg');
                    const telefoneInput = document.getElementById('telefone');
                    const contatoResponsavelInput = document.getElementById('campo-tel');

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
                    function atualizarProgresso() {
                        const campos = [
                            { id: 'campo-nome',       dot: 'dot-1', tipo: 'text' },
                            { id: 'campo-tel',        dot: 'dot-2', tipo: 'text' },
                            { id: 'campo-parentesco', dot: 'dot-3', tipo: 'select' },
                            { id: 'campo-termo',      dot: 'dot-4', tipo: 'file', label: 'label-termo', box: 'box-termo' },
                            { id: 'campo-doc',        dot: 'dot-5', tipo: 'file', label: 'label-doc',   box: 'box-doc' },
                        ];

                        let preenchidos = 0;

                        campos.forEach(c => {
                            const el = document.getElementById(c.id);
                            const dot = document.getElementById(c.dot);
                            let ok = false;

                            if (c.tipo === 'file') {
                                ok = el.files && el.files.length > 0;
                                if (ok) {
                                    const lbl = document.getElementById(c.label);
                                    lbl.textContent = '✓ ' + el.files[0].name;
                                    lbl.classList.remove('hidden');
                                }
                                const box = document.getElementById(c.box);
                                box.style.borderColor = ok ? '#34d399' : '#fcd34d';
                            } else {
                                ok = el.value.trim() !== '';
                                el.style.borderColor = ok ? '#34d399' : '#fcd34d';
                            }

                            if (dot) {
                                dot.style.background = ok ? '#10b981' : '#d1d5db';
                            }
                            if (ok) preenchidos++;
                        });

                        const secao  = document.getElementById('responsavel-section');
                        const header = document.getElementById('responsavel-header');
                        const icon   = document.getElementById('responsavel-icon');
                        const alert  = document.getElementById('icon-alert');
                        const check  = document.getElementById('icon-check');
                        const title  = document.getElementById('responsavel-title');
                        const sub    = document.getElementById('responsavel-subtitle');
                        const tudo   = preenchidos === campos.length;

                        secao.style.borderColor  = tudo ? '#6ee7b7' : '#fcd34d';
                        secao.style.background   = tudo ? '#ecfdf5'  : '#fffbeb';
                        header.style.background  = tudo ? '#d1fae5'  : '#fef3c7';
                        header.style.borderColor = tudo ? '#6ee7b7'  : '#fcd34d';
                        icon.style.background    = tudo ? '#10b981'  : '#f59e0b';
                        alert.classList.toggle('hidden', tudo);
                        check.classList.toggle('hidden', !tudo);
                        title.style.color        = tudo ? '#065f46'  : '#92400e';
                        sub.style.color          = tudo ? '#059669'  : '#b45309';
                        sub.textContent          = tudo ? 'Tudo preenchido! ✓' : 'Preencha os campos abaixo para continuar';
                    }
                </script>
            @endif

        </div>
    </div>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@700;800&display=swap');
    @keyframes popIn    { from{transform:scale(.3);opacity:0} to{transform:scale(1);opacity:1} }
    @keyframes drawCheck{ to{stroke-dashoffset:0} }
    @keyframes fadeUp   { from{transform:translateY(14px);opacity:0} to{transform:translateY(0);opacity:1} }
    </style>
</x-app-layout>