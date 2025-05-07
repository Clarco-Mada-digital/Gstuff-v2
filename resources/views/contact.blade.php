@extends('layouts.base')

@section('pageTitle', __('contact.page_title'))

@section('content')
<div class="relative w-full py-50" style="background: url('images/girl_deco_image.jpg') center center /cover">
    <div class="absolute flex items-center justify-center top-0 left-0 bg-black/30 w-full h-full z-0">
        <h2 class="font-dm-serif text-5xl text-amber-400 font-bold text-center z-10">{{__('contact.contact_us')}}</h2>
    </div>
</div>

<div class="flex items-center w-full gap-5 py-5">
    <div class="w-full lg:w-1/2 flex flex-col h-[80vh] items-center gap-5 px-1 xl:px-10 text-sm xl:text-base">
        <div class="w-full flex h-auto items-center justify-around mb-2">


           

            @if(auth()->user())
            <div id="info" class="w-[36%] p-2 h-full  m-auto flex flex-col items-center ">

              <div class="bg-gray-100 p-4 mb-2 rounded-lg">
                  <svg height="100px" width="100px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                      <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                      <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                      <g id="SVGRepo_iconCarrier">
                          <path style="fill:#EBB700;" d="M405.75,286.71l-22.028-38.16h-13.467c-8.947,0-16.2-7.253-16.2-16.2V90.477 c0-0.213-0.179-0.393-0.393-0.393h-9.901c-8.947,0-16.2-7.253-16.2-16.2V61.837c0-15.021,12.219-27.24,27.24-27.24H484.76 c15.021,0,27.24,12.22,27.24,27.24v159.472c0,15.02-12.219,27.24-27.24,27.24h-28.921l-22.028,38.16 C427.578,297.506,411.972,297.487,405.75,286.71z"></path>
                          <path style="fill:#FFD155;" d="M78.189,286.71l-22.028-38.161H27.24C12.219,248.549,0,236.33,0,221.309V61.837 c0-15.021,12.219-27.24,27.24-27.24h129.958c15.026,0,27.251,12.22,27.251,27.24v12.047c0,8.947-7.253,16.2-16.2,16.2h-9.901 c-0.213,0-0.393,0.179-0.393,0.393v141.872c0,8.947-7.253,16.2-16.2,16.2h-13.469l-22.038,38.162 C100.014,297.508,84.423,297.508,78.189,286.71z"></path>
                          <path style="fill:#FFE49C;" d="M256.006,432.447L256.006,432.447c-5.788,0-11.136-3.088-14.029-8.1l-35.456-61.414H158.35 c-18.083,0-32.794-14.711-32.794-32.794V90.477c0-18.083,14.711-32.794,32.794-32.794h195.312c18.083,0,32.794,14.711,32.794,32.794 v239.662c0,18.083-14.711,32.794-32.794,32.794h-48.17l-35.458,61.414C267.142,429.359,261.793,432.447,256.006,432.447z"></path>
                          <path style="fill:#FFD155;" d="M353.662,57.683h-97.657v374.762c5.788,0,11.136-3.088,14.029-8.1l35.458-61.414h48.17 c18.083,0,32.794-14.711,32.794-32.794V90.477C386.456,72.394,371.745,57.683,353.662,57.683z"></path>
                          <g>
                              <path style="fill:#056E5B;" d="M256.003,207.22c-27.743,0-50.314-22.57-50.314-50.314s22.57-50.314,50.314-50.314 c27.743,0,50.315,22.57,50.315,50.314S283.746,207.22,256.003,207.22z"></path>
                              <path style="fill:#056E5B;" d="M328.521,315.53H183.484c-8.947,0-16.2-7.253-16.2-16.2c0-48.919,39.8-88.719,88.719-88.719 c48.92,0,88.719,39.8,88.719,88.719C344.722,308.278,337.468,315.53,328.521,315.53z"></path>
                          </g>
                          <path style="fill:#D1D3D4;" d="M450.894,477.403H61.118c-8.947,0-16.2-7.253-16.2-16.2c0-8.947,7.253-16.2,16.2-16.2h389.776 c8.947,0,16.2,7.253,16.2,16.2C467.094,470.15,459.841,477.403,450.894,477.403z"></path>
                          <g>
                              <path style="fill:#05595B;" d="M306.317,156.906c0-27.742-22.569-50.311-50.311-50.314V207.22 C283.747,207.219,306.317,184.649,306.317,156.906z"></path>
                              <path style="fill:#05595B;" d="M256.006,210.612v104.919h72.516c8.947,0,16.2-7.253,16.2-16.2 C344.722,250.412,304.924,210.613,256.006,210.612z"></path>
                          </g>
                          <path style="fill:#BCBEC0;" d="M450.894,445.003H256.006v32.4h194.888c8.947,0,16.2-7.253,16.2-16.2 C467.094,452.256,459.841,445.003,450.894,445.003z"></path>
                      </g>
                  </svg>
                  {{-- <svg height="99px" width="99px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 511.999 511.999" xml:space="preserve" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <g>
                            <path style="fill:#055974;" d="M255.996,159.418c-36.473,0-66.145-29.673-66.145-66.145s29.673-66.145,66.145-66.145 s66.145,29.673,66.145,66.145S292.469,159.418,255.996,159.418z"></path>
                            <path style="fill:#055974;" d="M362.667,318.735H149.326c-8.818,0-15.967-7.149-15.967-15.967 c0-67.623,55.015-122.637,122.637-122.637s122.637,55.014,122.637,122.637C378.634,311.587,371.485,318.735,362.667,318.735z"></path>
                        </g>
                        <g>
                            <path style="fill:#F5DC81;" d="M286.974,483.009l-30.976-16.284l-30.976,16.284c-11.69,6.145-25.401-3.808-23.167-16.832 l5.916-34.492l-25.059-24.427c-9.457-9.219-4.228-25.334,8.849-27.235l34.632-5.033l15.488-31.381 c5.845-11.843,22.788-11.851,28.636,0l15.488,31.381l34.632,5.033c13.069,1.899,18.312,18.01,8.849,27.235l-25.059,24.427 l5.916,34.492C312.392,479.3,298.569,489.106,286.974,483.009z"></path>
                            <path style="fill:#F5DC81;" d="M109.086,483.009l-30.976-16.285l-30.976,16.285c-11.69,6.145-25.401-3.808-23.167-16.832 l5.916-34.492L4.826,407.259c-9.457-9.218-4.228-25.334,8.849-27.234l34.632-5.033l15.487-31.381 c5.845-11.843,22.788-11.85,28.636,0l15.488,31.381l34.632,5.033c13.069,1.899,18.311,18.01,8.849,27.235l-25.061,24.427 l5.916,34.492C134.49,479.212,120.768,489.151,109.086,483.009z"></path>
                        </g>
                        <path style="fill:#EBB700;" d="M464.861,483.009l-30.976-16.285l-30.976,16.285c-11.69,6.145-25.401-3.808-23.167-16.832 l5.916-34.492L360.6,407.258c-9.457-9.218-4.228-25.334,8.849-27.234l34.632-5.033l15.487-31.381 c5.845-11.843,22.788-11.85,28.636,0l15.488,31.381l34.632,5.033c13.069,1.899,18.311,18.01,8.849,27.235l-25.059,24.427 l5.916,34.492C490.264,479.212,476.542,489.151,464.861,483.009z"></path>
                        <g>
                            <path style="fill:#05595B;" d="M322.142,93.273c0-36.472-29.671-66.144-66.142-66.145v132.292 C292.47,159.416,322.142,129.744,322.142,93.273z"></path>
                            <path style="fill:#05595B;" d="M256,180.131v138.604h106.667c8.818,0,15.967-7.149,15.967-15.967 C378.634,235.148,323.619,180.133,256,180.131z"></path>
                        </g>
                        <path style="fill:#EBB700;" d="M320.436,380.025l-34.632-5.033l-15.488-31.381c-2.69-5.45-8.241-8.901-14.318-8.901v132.014 l30.976,16.284c11.625,6.112,25.415-3.727,23.167-16.832l-5.916-34.492l25.059-24.427 C338.742,398.04,333.513,381.925,320.436,380.025z"></path>
                    </g>
                </svg> --}}
              </div>
              <button id="showConseil" class="cursor-pointer">
                  <h2 class="font-dm-serif text-xl text-green-gs text-center">{{__('contact.need_info')}}</h2>
              </button>
          </div>
            <div id="comment" class="w-[36%] p-2 h-full  m-auto flex flex-col items-center">

                <div class="bg-gray-100 p-4 mb-2 rounded-lg">
                    <svg height="99px" width="99px" version="1.1" id="_x36_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <g>
                                    <g>
                                        <circle style="fill:#EBB700;" cx="255.693" cy="134.136" r="134.136"></circle>
                                        <path style="fill:#05595B;" d="M257.535,79.113H182.64c-6.078,0-11.05-4.973-11.05-11.05l0,0c0-6.077,4.973-11.05,11.05-11.05 h74.895c6.078,0,11.05,4.973,11.05,11.05l0,0C268.585,74.14,263.612,79.113,257.535,79.113z"></path>
                                        <path style="fill:#05595B;" d="M244.643,126.076h-74.895c-6.077,0-11.05-4.973-11.05-11.05l0,0c0-6.077,4.973-11.05,11.05-11.05 h74.895c6.077,0,11.05,4.973,11.05,11.05l0,0C255.693,121.103,250.72,126.076,244.643,126.076z"></path>
                                        <path style="fill:#05595B;" d="M351.461,176.722H169.748c-6.077,0-11.05-4.973-11.05-11.05l0,0c0-6.078,4.973-11.05,11.05-11.05 h181.713c6.077,0,11.05,4.973,11.05,11.05l0,0C362.511,171.749,357.538,176.722,351.461,176.722z"></path>
                                        <path style="fill:#05595B;" d="M270.887,212.635h-86.866c-6.078,0-11.05-4.973-11.05-11.05l0,0c0-6.078,4.973-11.05,11.05-11.05 h86.866c6.078,0,11.05,4.973,11.05,11.05l0,0C281.937,207.662,276.965,212.635,270.887,212.635z"></path>
                                        <path style="fill:#05595B;" d="M349.619,126.076h-74.895c-6.078,0-11.05-4.973-11.05-11.05l0,0c0-6.077,4.972-11.05,11.05-11.05 h74.895c6.077,0,11.05,4.973,11.05,11.05l0,0C360.669,121.103,355.696,126.076,349.619,126.076z"></path>
                                        <polygon style="fill:#EBB700;" points="209.185,252.621 282.019,241.572 284.185,311.096 "></polygon>
                                    </g>
                                    <path style="fill:#05595B;" d="M186.636,272.351c-14.07,14.07-31.953,24.347-51.991,29.117l-48.584,37.883l1.16-37.11 C37.441,292.039,0,247.986,0,195.203C0,134.851,48.933,85.918,109.285,85.918h0.055c-4.199,14.328-6.446,29.485-6.446,45.177 C102.895,191.999,136.727,245.021,186.636,272.351z"></path>
                                    <path style="fill:#05595B;" d="M325.364,272.351c14.07,14.07,31.953,24.347,51.991,29.117l48.584,37.883l-1.16-37.11 C474.559,292.039,512,247.986,512,195.203c0-60.352-48.934-109.285-109.285-109.285h-0.055 c4.199,14.328,6.446,29.485,6.446,45.177C409.105,191.999,375.273,245.021,325.364,272.351z"></path>
                                </g>
                                <g style="opacity:0.04;">
                                    <path style="fill:#070405;" d="M389.829,134.136c0-27.879-8.515-53.763-23.072-75.216L180.623,245.053 c13.122,8.877,27.842,15.574,43.714,19.382l59.847,46.661l-1.419-45.56C343.869,253.013,389.829,198.943,389.829,134.136z"></path>
                                    <path style="fill:#070405;" d="M87.256,338.42l47.389-36.952c20.037-4.77,37.92-15.046,51.991-29.117 c-7.07-3.871-13.774-8.311-20.148-13.163L87.256,338.42z"></path>
                                    <path style="fill:#070405;" d="M512,195.203c0-60.352-48.934-109.286-109.286-109.286h-0.055 c4.199,14.328,6.446,29.485,6.446,45.177c0,60.904-33.832,113.926-83.741,141.257c14.07,14.07,31.953,24.347,51.991,29.117 l48.584,37.884l-1.16-37.11C474.559,292.039,512,247.986,512,195.203z"></path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>


                <button id="showCommentaire" class="cursor-pointer">
                    <h2 class="font-dm-serif text-xl text-green-gs text-center">{{__('contact.make_comment')}}</h2>
                </button>
            </div>
            @else
            <div  class="w-full p-2 h-full  m-auto flex  items-center justify-around ">

              <div class="bg-gray-100 p-4 mb-2 rounded-lg">
                  <svg height="100px" width="100px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000">
                      <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                      <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                      <g id="SVGRepo_iconCarrier">
                          <path style="fill:#EBB700;" d="M405.75,286.71l-22.028-38.16h-13.467c-8.947,0-16.2-7.253-16.2-16.2V90.477 c0-0.213-0.179-0.393-0.393-0.393h-9.901c-8.947,0-16.2-7.253-16.2-16.2V61.837c0-15.021,12.219-27.24,27.24-27.24H484.76 c15.021,0,27.24,12.22,27.24,27.24v159.472c0,15.02-12.219,27.24-27.24,27.24h-28.921l-22.028,38.16 C427.578,297.506,411.972,297.487,405.75,286.71z"></path>
                          <path style="fill:#FFD155;" d="M78.189,286.71l-22.028-38.161H27.24C12.219,248.549,0,236.33,0,221.309V61.837 c0-15.021,12.219-27.24,27.24-27.24h129.958c15.026,0,27.251,12.22,27.251,27.24v12.047c0,8.947-7.253,16.2-16.2,16.2h-9.901 c-0.213,0-0.393,0.179-0.393,0.393v141.872c0,8.947-7.253,16.2-16.2,16.2h-13.469l-22.038,38.162 C100.014,297.508,84.423,297.508,78.189,286.71z"></path>
                          <path style="fill:#FFE49C;" d="M256.006,432.447L256.006,432.447c-5.788,0-11.136-3.088-14.029-8.1l-35.456-61.414H158.35 c-18.083,0-32.794-14.711-32.794-32.794V90.477c0-18.083,14.711-32.794,32.794-32.794h195.312c18.083,0,32.794,14.711,32.794,32.794 v239.662c0,18.083-14.711,32.794-32.794,32.794h-48.17l-35.458,61.414C267.142,429.359,261.793,432.447,256.006,432.447z"></path>
                          <path style="fill:#FFD155;" d="M353.662,57.683h-97.657v374.762c5.788,0,11.136-3.088,14.029-8.1l35.458-61.414h48.17 c18.083,0,32.794-14.711,32.794-32.794V90.477C386.456,72.394,371.745,57.683,353.662,57.683z"></path>
                          <g>
                              <path style="fill:#056E5B;" d="M256.003,207.22c-27.743,0-50.314-22.57-50.314-50.314s22.57-50.314,50.314-50.314 c27.743,0,50.315,22.57,50.315,50.314S283.746,207.22,256.003,207.22z"></path>
                              <path style="fill:#056E5B;" d="M328.521,315.53H183.484c-8.947,0-16.2-7.253-16.2-16.2c0-48.919,39.8-88.719,88.719-88.719 c48.92,0,88.719,39.8,88.719,88.719C344.722,308.278,337.468,315.53,328.521,315.53z"></path>
                          </g>
                          <path style="fill:#D1D3D4;" d="M450.894,477.403H61.118c-8.947,0-16.2-7.253-16.2-16.2c0-8.947,7.253-16.2,16.2-16.2h389.776 c8.947,0,16.2,7.253,16.2,16.2C467.094,470.15,459.841,477.403,450.894,477.403z"></path>
                          <g>
                              <path style="fill:#05595B;" d="M306.317,156.906c0-27.742-22.569-50.311-50.311-50.314V207.22 C283.747,207.219,306.317,184.649,306.317,156.906z"></path>
                              <path style="fill:#05595B;" d="M256.006,210.612v104.919h72.516c8.947,0,16.2-7.253,16.2-16.2 C344.722,250.412,304.924,210.613,256.006,210.612z"></path>
                          </g>
                          <path style="fill:#BCBEC0;" d="M450.894,445.003H256.006v32.4h194.888c8.947,0,16.2-7.253,16.2-16.2 C467.094,452.256,459.841,445.003,450.894,445.003z"></path>
                      </g>
                  </svg>
                  {{-- <svg height="99px" width="99px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 511.999 511.999" xml:space="preserve" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <g>
                            <path style="fill:#055974;" d="M255.996,159.418c-36.473,0-66.145-29.673-66.145-66.145s29.673-66.145,66.145-66.145 s66.145,29.673,66.145,66.145S292.469,159.418,255.996,159.418z"></path>
                            <path style="fill:#055974;" d="M362.667,318.735H149.326c-8.818,0-15.967-7.149-15.967-15.967 c0-67.623,55.015-122.637,122.637-122.637s122.637,55.014,122.637,122.637C378.634,311.587,371.485,318.735,362.667,318.735z"></path>
                        </g>
                        <g>
                            <path style="fill:#F5DC81;" d="M286.974,483.009l-30.976-16.284l-30.976,16.284c-11.69,6.145-25.401-3.808-23.167-16.832 l5.916-34.492l-25.059-24.427c-9.457-9.219-4.228-25.334,8.849-27.235l34.632-5.033l15.488-31.381 c5.845-11.843,22.788-11.851,28.636,0l15.488,31.381l34.632,5.033c13.069,1.899,18.312,18.01,8.849,27.235l-25.059,24.427 l5.916,34.492C312.392,479.3,298.569,489.106,286.974,483.009z"></path>
                            <path style="fill:#F5DC81;" d="M109.086,483.009l-30.976-16.285l-30.976,16.285c-11.69,6.145-25.401-3.808-23.167-16.832 l5.916-34.492L4.826,407.259c-9.457-9.218-4.228-25.334,8.849-27.234l34.632-5.033l15.487-31.381 c5.845-11.843,22.788-11.85,28.636,0l15.488,31.381l34.632,5.033c13.069,1.899,18.311,18.01,8.849,27.235l-25.061,24.427 l5.916,34.492C134.49,479.212,120.768,489.151,109.086,483.009z"></path>
                        </g>
                        <path style="fill:#EBB700;" d="M464.861,483.009l-30.976-16.285l-30.976,16.285c-11.69,6.145-25.401-3.808-23.167-16.832 l5.916-34.492L360.6,407.258c-9.457-9.218-4.228-25.334,8.849-27.234l34.632-5.033l15.487-31.381 c5.845-11.843,22.788-11.85,28.636,0l15.488,31.381l34.632,5.033c13.069,1.899,18.311,18.01,8.849,27.235l-25.059,24.427 l5.916,34.492C490.264,479.212,476.542,489.151,464.861,483.009z"></path>
                        <g>
                            <path style="fill:#05595B;" d="M322.142,93.273c0-36.472-29.671-66.144-66.142-66.145v132.292 C292.47,159.416,322.142,129.744,322.142,93.273z"></path>
                            <path style="fill:#05595B;" d="M256,180.131v138.604h106.667c8.818,0,15.967-7.149,15.967-15.967 C378.634,235.148,323.619,180.133,256,180.131z"></path>
                        </g>
                        <path style="fill:#EBB700;" d="M320.436,380.025l-34.632-5.033l-15.488-31.381c-2.69-5.45-8.241-8.901-14.318-8.901v132.014 l30.976,16.284c11.625,6.112,25.415-3.727,23.167-16.832l-5.916-34.492l25.059-24.427 C338.742,398.04,333.513,381.925,320.436,380.025z"></path>
                    </g>
                </svg> --}}
              </div>
              <button id="showConseil" class="cursor-pointer">
                  <h2 class="font-dm-serif text-2xl text-green-gs text-center">{{__('contact.need_info')}}</h2>
              </button>
          </div>
            @endif
        </div>

        <div class=" w-full px-4">

            @if(auth()->user())
            <form id="commentaireForm" method="POST" class="flex flex-col gap-3 w-full hidden" action="{{ route('commentaires.store') }}">
                @csrf
                <div class="flex flex-col w-full gap-2">
                    <input type="hidden" name="lang" value="{{ session('locale', 'fr') }}">
                    <label for="messageCommentaire">{{__('contact.comment')}}</label>
                    <textarea name="content" id="messageCommentaire" rows="10" class="border rounded-lg focus:border-amber-400 ring-0" placeholder="{{__('contact.message_placeholder')}}"></textarea>
                </div>
                <button type="submit" class="w-full bg-green-gs rounded-lg text-center text-white p-3 text-lg cursor-pointer hover:bg-green-gs/70">{{__('contact.send')}}</button>
            </form>
            @endif


            @livewire('contact')



        </div>
    </div>

    <div class="hidden lg:block lg:w-1/2 h-screen rounded-lg" style="background: url('images/girl_deco_contact_001.jpg') center center /cover"></div>
</div>
<style>
  .myborder {
    background-color: rgba(247, 247, 247, 0.525);
      border-bottom: 2px solid #056E5B; /* Remplacez par la couleur de votre choix */
  }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const commentaireForm = document.getElementById('commentaireForm');
        const info = document.getElementById('info');
        info.classList.add('myborder');
        const comment = document.getElementById('comment');

        const conseilForm = document.getElementById('conseilForm');
        const showCommentaireButton = document.getElementById('showCommentaire');
        const showConseilButton = document.getElementById('showConseil');

        showCommentaireButton.addEventListener('click', function() {
            commentaireForm.classList.remove('hidden');
            conseilForm.classList.add('hidden');
            comment.classList.add('myborder');
            info.classList.remove('myborder');


        });

        showConseilButton.addEventListener('click', function() {
            conseilForm.classList.remove('hidden');
            commentaireForm.classList.add('hidden');
            info.classList.add('myborder');
            comment.classList.remove('myborder');


        });

        conseilForm.classList.remove('hidden');
        commentaireForm.classList.add('hidden');
    });

</script>
@stop
