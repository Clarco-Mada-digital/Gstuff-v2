@props([
    'name' => 'telephone',
    'label' => __('phone.phone_number'),
    'old' => null,
    'codePhone' => null,
])

<div id="phone-component" class="relative space-y-4">
    <label for="phone-input" class="font-roboto-slab text-green-gs block text-sm">
        {{ $label ?? 'Numéro de téléphone' }} <span class="text-red-500">*</span>
    </label>

    <div class="mt-2 flex flex-col items-center gap-3 sm:flex-row">
        <div class="mt-2 flex w-full cursor-pointer items-center gap-3 sm:w-[30%] lg:w-[20%]" id="open-country-modal">
            <div class="h-6 w-8 overflow-hidden rounded border border-gray-300 bg-white">
                <img id="selected-flag" src="" alt="Drapeau sélectionné" class="h-full w-full object-cover" />
            </div>
            <span id="selected-country-label" class="text-sm font-medium text-gray-700"></span>
        </div>

        <div class="relative w-full sm:w-[70%] lg:w-[80%]">
            <input type="tel" id="phone-input" name="{{ $name }}" value="{{ old('telephone', $old) }}"
                maxlength="15" pattern="\d{6,15}" title="{{ __('phone.validation.digits_between') }}"
                aria-describedby="phone-help"
                class="font-roboto-slab text-green-gs focus:border-green-gs focus:ring-green-gs block w-full rounded-lg border bg-gray-50 p-2.5 text-sm"
                required />
            <input type="hidden" id="code-phone" name="code_phone" value="{{ old('code_phone', $codePhone) }}" />
        </div>
    </div>

    <p id="phone-error" class="mt-1 hidden text-sm text-red-600"></p>
    <p id="phone-help" class="mt-1 text-xs text-gray-500">
        {{ __('phone.full_number') }}<span id="full-number"></span>
    </p>

    <div id="country-modal" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black/50">
        <div class="relative w-full max-w-md rounded-lg bg-white p-4 shadow-lg">
            <button id="close-country-modal"
                class="absolute right-2 top-2 text-xl text-gray-500 hover:text-red-500">&times;</button>
            <h2 class="mb-2 text-lg font-semibold">{{ __('phone.search_country') }}</h2>
            <input type="text" id="country-search" placeholder="{{ __('phone.country_placeholder') }}"
                class="mb-3 w-full rounded-lg border px-3 py-2 text-sm focus:border-green-500 focus:ring-green-500" />
            <div id="country-list"
                class="max-h-60 divide-y divide-gray-100 overflow-y-auto rounded-lg bg-white shadow-sm">
                <!-- Pays générés dynamiquement -->
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const phoneInput = document.getElementById('phone-input');
            const phoneError = document.getElementById('phone-error');
            const fullNumber = document.getElementById('full-number');
            const flagDisplay = document.getElementById('selected-flag');
            const countryLabel = document.getElementById('selected-country-label');
            const codePhoneInput = document.getElementById('code-phone');

            const modal = document.getElementById('country-modal');
            const openModalBtn = document.getElementById('open-country-modal');
            const closeModalBtn = document.getElementById('close-country-modal');
            const countrySearch = document.getElementById('country-search');
            const countryList = document.getElementById('country-list');

            let selectedCode = "{{ old('code_phone', $codePhone) }}";
            let countries = [];
            const phoneLengths = @json($countryData); // Ex: { "+261": 9, "+33": 9 }

            function updateFullNumber() {
                const raw = phoneInput.value.replace(/\D/g, '');
                const expectedLength = phoneLengths[selectedCode] || 15;
                const trimmed = raw.slice(0, expectedLength);
                phoneInput.value = trimmed;

                codePhoneInput.value = selectedCode;

                if (trimmed.length !== expectedLength) {
                    phoneError.textContent =
                        `{{ __('phone.validation.digits_required', ['digits' => '${expectedLength}', 'code' => '${selectedCode}']) }}`;
                    phoneError.classList.remove('hidden');
                    phoneInput.classList.add('border-red-500');
                } else {
                    phoneError.textContent = '';
                    phoneError.classList.add('hidden');
                    phoneInput.classList.remove('border-red-500');
                }

                fullNumber.textContent = `${selectedCode}${trimmed}`;
            }

            function detectLocationAndSetDefaultCode() {
                const storedCode = localStorage.getItem('default_code_phone');
                if (selectedCode || storedCode) {
                    selectedCode = selectedCode || storedCode;
                    return;
                }

                fetch('https://ipapi.co/json/')
                    .then(res => res.json())
                    .then(data => {
                        const countryCallingCode = `+${data.country_calling_code.replace('+', '')}`;
                        selectedCode = countryCallingCode;
                        localStorage.setItem('default_code_phone', selectedCode);

                        const matchedCountry = countries.find(c => c.code === selectedCode);
                        if (matchedCountry) {
                            flagDisplay.src = matchedCountry.flagUrl;
                            countryLabel.textContent = `${matchedCountry.name} (${matchedCountry.code})`;
                        }

                        updateFullNumber();
                    })
                    .catch(err => {
                        console.warn('{{ __('phone.location.unavailable') }}:', err);
                    });
            }

            function renderCountryList(filter = '') {
                countryList.innerHTML = '';
                const filtered = countries.filter(c =>
                    c.name.toLowerCase().includes(filter.toLowerCase())
                );

                if (filtered.length === 0) {
                    countryList.innerHTML =
                        '<div class="p-3 text-sm text-gray-500">{{ __('phone.no_country_found') }}</div>';
                    return;
                }

                filtered.forEach(country => {
                    const item = document.createElement('div');
                    item.className = 'flex items-center gap-2 px-3 py-2 cursor-pointer hover:bg-gray-100';
                    item.innerHTML = `
                <img src="${country.flagUrl}" alt="${country.name}" class="w-5 h-4 rounded border" />
                <span class="text-sm text-gray-700">${country.name} (${country.code})</span>
            `;
                    item.addEventListener('click', () => {
                        selectedCode = country.code;
                        flagDisplay.src = country.flagUrl;
                        countryLabel.textContent = `${country.name} (${country.code})`;
                        modal.classList.add('hidden');
                        countrySearch.value = '';
                        updateFullNumber();
                    });
                    countryList.appendChild(item);
                });
            }

            countrySearch.addEventListener('input', (e) => {
                const query = e.target.value.trim();
                renderCountryList(query);
            });

            openModalBtn.addEventListener('click', () => {
                modal.classList.remove('hidden');
                countrySearch.focus();
                renderCountryList('');
            });

            closeModalBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
                countrySearch.value = '';
            });

            phoneInput.addEventListener('input', updateFullNumber);

            phoneInput.addEventListener('keydown', (e) => {
                const expectedLength = phoneLengths[selectedCode] || 6;
                const raw = phoneInput.value.replace(/\D/g, '');

                const allowedKeys = ['Backspace', 'ArrowLeft', 'ArrowRight', 'Tab', 'Delete'];
                if (allowedKeys.includes(e.key)) return;

                if (!/^\d$/.test(e.key)) {
                    e.preventDefault();
                    return;
                }

                if (raw.length >= expectedLength) {
                    e.preventDefault();
                }
            });

            fetch('https://restcountries.com/v3.1/all?fields=name,idd,flags')
                .then(res => res.json())
                .then(data => {
                    countries = data
                        .filter(c => c.idd?.root && c.flags?.svg)
                        .map(c => ({
                            name: c.name.common,
                            code: `${c.idd.root}${(c.idd.suffixes?.[0] || '')}`,
                            flagUrl: c.flags.svg
                        }))
                        .sort((a, b) => a.name.localeCompare(b.name));

                    detectLocationAndSetDefaultCode();

                    let defaultCountry = countries.find(c => c.code === selectedCode);
                    if (!defaultCountry) {
                        defaultCountry = countries[0];
                        selectedCode = defaultCountry.code;
                    }

                    flagDisplay.src = defaultCountry.flagUrl;
                    countryLabel.textContent = `${defaultCountry.name} (${defaultCountry.code})`;

                    updateFullNumber();
                })
                .catch(err => {
                    countryList.innerHTML =
                        '<div class="p-3 text-sm text-red-600">{{ __('phone.validation.loading_error') }}</div>';
                    console.error('Erreur API pays :', err);
                });

            updateFullNumber();
        });
    </script>
@endpush
