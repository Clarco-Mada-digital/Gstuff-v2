<div x-data="multiSelect({{ json_encode($options) }}, {{json_encode($value)}})" class="w-full">
  {{-- <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label> --}}
  <div class="relative mt-1">
      <!-- Input pour afficher les badges -->
      <div
          class="flex flex-wrap gap-2 px-2 border border-gray-300 rounded-md shadow-sm"
          @click="isOpen = true"
      >
          <template x-for="(option, index) in selectedOptions" :key="index">
              <span class="flex justify-center items-center my-1.5 font-medium p-0.5 text-sm text-white rounded-md bg-green-gs border border-green-gs">
                  <span x-text="option"></span>
                  <button type="button" class="ml-2 text-white" @click="removeOption(index)">×</button>
              </span>
          </template>
          <input
              type="text"
              placeholder="{{$label}}..."
              class="flex-1 border-none focus:ring-0 focus:outline-none"
              x-model="search"
              @input="filterOptions"
              @focus="isOpen = true"
              @blur="closeDropdown"
          />
      </div>

      <!-- Liste déroulante des options -->
      <div
          class="absolute z-10 w-full mt-1 bg-white border rounded-md shadow-lg"
          x-show="isOpen && filteredOptions.length > 0"
          @mousedown.away="isOpen = false"
      >
          <ul class="py-1 text-sm text-gray-700">
              <template x-for="(option, index) in filteredOptions" :key="index">
                  <li
                      class="px-4 py-2 cursor-pointer hover:bg-teal-100"
                      @click="selectOption(option)"
                      x-text="option"
                  ></li>
              </template>
          </ul>
      </div>
  </div>

  <!-- Champ caché pour envoyer les données au backend -->
  <input type="hidden" name="{{ $name }}" x-bind:value="selectedValues().join(',')" />
  {{-- <template x-for="option in selectedOptions" :key="option">
  </template> --}}
</div>

@section('specialScripts')
<script>
  function multiSelect(options, value) {
      return {
          options: options,
          selectedOptions: value ? value : [],
          search: '',
          filteredOptions: [],
          isOpen: false,

          init() {
              this.filteredOptions = this.options;
          },

          filterOptions() {
              this.filteredOptions = this.options.filter(option =>
                  option.toLowerCase().includes(this.search.toLowerCase())
              );
          },

          selectOption(option) {
              if (!this.selectedOptions.includes(option)) {
                  this.selectedOptions.push(option);
              }
              this.search = '';
              this.filterOptions();
              this.isOpen = false;
          },

          removeOption(index) {
              this.selectedOptions.splice(index, 1);
          },

          closeDropdown() {
              setTimeout(() => {
                  this.isOpen = false;
              }, 200);
          },
          selectedValues(){
            let val = [];
            this.selectedOptions.map((option)=>{
              val.push(option);
            })
            return val;
          }
      };
  }
</script>
@endsection
