@props([
    'name' => 'telephone',
    'label' => __('phone.phone_number'),
    'old' => null,
    'codePhone' => null,
])

<div id="phone-component" class="space-y-4 relative">
    <label for="phone-input" class="block text-sm font-roboto-slab text-green-gs">
        {{ $label ?? 'Numéro de téléphone' }} <span class="text-red-500">*</span>
    </label>

    <div class="flex flex-col sm:flex-row items-center gap-3 mt-2 ">
        <div class="flex items-center gap-3 mt-2 cursor-pointer w-full sm:w-[30%] lg:w-[20%]" id="open-country-modal">
            <div class="w-8 h-6 overflow-hidden rounded border border-gray-300 bg-white">
                <img id="selected-flag" src="" alt="Drapeau sélectionné" class="w-full h-full object-cover" />
            </div>
            <span id="selected-country-label" class="text-sm text-gray-700 font-medium"></span>
        </div>

        <div class="relative w-full sm:w-[70%] lg:w-[80%]       ">
            <input 
                type="tel" 
                id="phone-input" 
                name="{{ $name }}"
                value="{{ old('telephone', $old) }}"
                maxlength="15"
                pattern="\d{6,15}"    
                title="{{ __('phone.validation.digits_between') }}"
                aria-describedby="phone-help"
                class="block w-full rounded-lg border font-roboto-slab bg-gray-50 p-2.5 text-sm text-green-gs focus:border-green-gs focus:ring-green-gs"
                required
            />
            <input type="hidden" id="code-phone" name="code_phone" value="{{ old('code_phone', $codePhone) }}"/>
        </div>
    </div>

    <p id="phone-error" class="mt-1 text-sm text-red-600 hidden"></p>
    <p id="phone-help" class="mt-1 text-xs text-gray-500">
        {{ __('phone.full_number') }}<span id="full-number"></span>
    </p>

    <div id="country-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-4 relative">
            <button id="close-country-modal" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl">&times;</button>
            <h2 class="text-lg font-semibold mb-2">{{ __('phone.search_country') }}</h2>
            <input type="text" id="country-search" placeholder="{{ __('phone.country_placeholder') }}"
                class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-green-500 focus:border-green-500 mb-3" />
            <div id="country-list" class="max-h-60 overflow-y-auto rounded-lg bg-white shadow-sm divide-y divide-gray-100">
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
            phoneError.textContent = `{{ __('phone.validation.digits_required', ['digits' => '${expectedLength}', 'code' => '${selectedCode}']) }}`;
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
                console.warn('{{ __("phone.location.unavailable") }}:', err);
            });
    }

    function renderCountryList(filter = '') {
        countryList.innerHTML = '';
        const filtered = countries.filter(c =>
            c.name.toLowerCase().includes(filter.toLowerCase())
        );

        if (filtered.length === 0) {
            countryList.innerHTML = '<div class="p-3 text-sm text-gray-500">{{ __("phone.no_country_found") }}</div>';
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
            countryList.innerHTML = '<div class="p-3 text-sm text-red-600">{{ __("phone.validation.loading_error") }}</div>';
            console.error('Erreur API pays :', err);
        });

        updateFullNumber(); 
});
</script>
@endpush
