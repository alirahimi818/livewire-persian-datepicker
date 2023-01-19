@props(['defaultDate' => null, 'setNullInput' => false, 'label'=> null, 'required'=> false, 'showFormat' => null, 'returnFormat' => null, 'wirePropertyName' => null, 'uniqueId' => 'dp-'. uniqid()])
<div class="w-full" dir="rtl" wire:ignore>
    <div class="relative"
         x-data="persianDatepicker('{{ $uniqueId  }}','{{ $defaultDate  }}','{{ $setNullInput  }}','{{ $showFormat }}','{{ $returnFormat }}')"
         x-init="[initDate(), getNoOfDays()]" id="{{$uniqueId}}"
         x-cloak>
        <div class="relative">
            <input type="text" name="datepickerDate" class="dp-return-input hidden"
                   @input="$wire.set('{{$wirePropertyName}}', $event.target.value)">
            @if($label)
                <label class="block font-medium text-sm text-gray-700">
                    {{ $label }} {!! $required ? '<span class="text-red-600 text-xl relative top-1.5 leading-none">*</span>' : ''!!}
                </label>
            @endif
            <div class="relative flex items-center mt-1">
                <input @click="showDatepicker = !showDatepicker"
                       class="border-gray-300 focus:border-gray-400 focus:ring focus:ring-gray-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full pl-14 text-sm"
                       type="text" readonly
                       x-model="datepickerValue"
                       @keydown.escape="showDatepicker = false"
                       placeholder="{{ $label }}" {{ $attributes }}>

                <div class="absolute left-0 pl-3" @click="showDatepicker = !showDatepicker">
                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span x-show="datepickerValue"
                      class="material-icons cursor-pointer absolute left-9 text-red-500 remove_date"
                      @click="removeDate(); showDatepicker = false">close</span>
            </div>
        </div>
        <div
                class="bg-white {{ $label ? '' : '' }} z-40 rounded-lg shadow p-4 absolute left-0"
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

            <div class="flex mt-1">
                <button type="button" @click="goToToday()"
                        class="inline-flex items-center w-full justify-center px-4 py-2 bg-sky-500/100 text-white shadow-md border border-transparent rounded-lg text-xs text-white uppercase focus:outline-none disabled:opacity-25 transition">
                    امروز
                </button>
            </div>
        </div>
    </div>
</div>
