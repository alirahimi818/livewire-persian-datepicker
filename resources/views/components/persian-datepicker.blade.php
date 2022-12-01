@props(['defaultDate' => null,'label'=> '', 'showFormat' => null,'returnFormat' => null, 'wirePropertyName' => '', 'uniqueId' => 'dp-'. uniqid()])
<div class="w-full" wire:ignore>
    <div x-data="persianDatepicker('{{ $uniqueId  }}','{{ $defaultDate  }}','{{ $showFormat }}','{{ $returnFormat }}')"
         x-init="[initDate(), getNoOfDays()]" id="{{$uniqueId}}"
         x-cloak>
        <div class="relative">
            <div @click="showDatepicker = !showDatepicker">
                <input type="text" name="datepickerDate" class="dp-return-input"
                       @input="$wire.set('{{$wirePropertyName}}', $event.target.value)">
                @if($label)
                    <x-jet-label value="{{ $label }}"/>
                @endif
                <x-jet-input type="text" readonly class="mt-1 block w-full text-sm"
                             x-model="datepickerValue"
                             @keydown.escape="showDatepicker = false"
                             placeholder="{{ $label }}"/>

                <div class="absolute top-6 left-0 px-3 py-2">
                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>

            <div
                class="bg-white mt-[4.3rem] rounded-lg shadow p-4 absolute top-0 left-0"
                style="width: 17rem"
                x-show.transition="showDatepicker"
                @click.away="showDatepicker = false">

                <div class="flex justify-between items-center mb-2">
                    <div>
                        <span x-text="monthNames[month - 1]" class="text-lg font-bold text-gray-800"></span>
                        <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
                    </div>
                    <div>
                        <button
                            type="button"
                            class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
                            @click="month--; getNoOfDays()">
                            <svg class="h-6 w-6 text-gray-500 inline-flex" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                        <button
                            type="button"
                            class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full"
                            @click="month++; getNoOfDays()">
                            <svg class="h-6 w-6 text-gray-500 inline-flex" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex flex-wrap mb-3 -mx-1">
                    <template x-for="(day, index) in days" :key="index">
                        <div style="width: 14.26%" class="px-1">
                            <div
                                x-text="day"
                                class="text-gray-800 font-medium text-center text-xs"></div>
                        </div>
                    </template>
                </div>

                <div class="flex flex-wrap -mx-1">
                    <template x-for="blankDay in blankDays">
                        <div
                            style="width: 14.28%"
                            class="text-center border p-1 border-transparent text-sm"
                        ></div>
                    </template>
                    <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                        <div style="width: 14.28%" class="px-1 mb-1">
                            <div
                                @click="selectDay(date);isSelectedDay(date,$event.target)"
                                x-text="date"
                                class="cursor-pointer text-center text-sm leading-none rounded-full leading-loose transition ease-in-out duration-100"
                                :class="{'todayItem bg-blue-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-blue-200': isToday(date) == false, 'datepickerItemSelected bg-emerald-700 text-white': isSelectedDay(date) == true}"
                            ></div>
                        </div>
                    </template>
                </div>

                <div class="flex">
                    <x-button.blue type="button" class="w-full justify-center" @click="goToToday()">امروز
                    </x-button.blue>
                </div>
            </div>
        </div>
    </div>
</div>
