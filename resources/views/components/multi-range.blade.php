<div class="flex justify-center items-center py-3 @if($class!= '') {{$class}} @endif">
    <div x-data="{{"range".$id."()"}}" x-init="mintrigger(); maxtrigger()" class="relative max-w-xl w-full">
        @if($label != '')<span for="{{$id}}" class="text-center">{{$label}}</span>@endif
      <div class="my-3">
        <input type="range"
               step="{{$step}}"
               x-bind:min="min" x-bind:max="max"
               x-on:input="mintrigger"
               x-model="minvalue"
               class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">
  
        <input type="range" 
               step="{{$step}}"
               x-bind:min="min" x-bind:max="max"
               x-on:input="maxtrigger"
               x-model="maxvalue"
               class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">
  
        <div class="relative z-10 h-2">
  
          <div class="absolute z-10 left-0 right-0 bottom-0 top-0 rounded-md bg-gray-200"></div>
  
          <div class="absolute z-20 top-0 bottom-0 rounded-md bg-green-gs" x-bind:style="'right:'+maxthumb+'%; left:'+minthumb+'%'"></div>
  
          <div class="absolute z-30 w-4 h-4 top-0 left-0 bg-green-gs rounded-full -translate-y-[30%]  -ml-1" x-bind:style="'left: '+minthumb+'%'"></div>
  
          <div class="absolute z-30 w-4 h-4 top-0 right-0 bg-green-gs rounded-full -translate-y-[30%]  -mr-3" x-bind:style="'right: '+maxthumb+'%'"></div>
   
        </div>
  
      </div>
      
      <div class="flex justify-between items-center">
        <div>
          <input type="text" maxlength="5" x-on:input="mintrigger" x-model="minvalue" class="px-3 py-2 border border-gray-200 rounded w-20 text-center">
        </div>
        <div>
          <input type="text" maxlength="5" x-on:input="maxtrigger" x-model="maxvalue" class="px-3 py-2 border border-gray-200 rounded w-20 text-center">
        </div>
      </div>
      
    </div>
  
  <script>
      function {{"range".$id}}() {
          return {
            minvalue: {{$minvalue}}, 
            maxvalue: {{$maxvalue}},
            min: {{$min}}, 
            max: {{$max}},
            minthumb: 0,
            maxthumb: 0, 
            
            mintrigger() {   
              this.minvalue = Math.min(this.minvalue, this.maxvalue - 2);      
              this.minthumb = ((this.minvalue - this.min) / (this.max - this.min)) * 100;
            },
             
            maxtrigger() {
              this.maxvalue = Math.max(this.maxvalue, this.minvalue + 2); 
              this.maxthumb = 100 - (((this.maxvalue - this.min) / (this.max - this.min)) * 100);    
            }, 
          }
      }
  </script>
  </div>