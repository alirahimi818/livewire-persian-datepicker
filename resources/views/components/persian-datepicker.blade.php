@props([
    'defaultDate' => null,
    'minDate' => null,
    'maxDate' => null,
    'setNullInput' => false,
    'withTime' => false,
    'withTimeSeconds' => true,
    'ignoreWire' => true,
    'label'=> null,
    'required'=> false,
    'showFormat' => null,
    'returnFormat' => null,
    'wirePropertyName' => null,
    'currentView' => 'day',
    'uniqueId' => 'dp-'. uniqid()
    ])
<div class="w-full persian-datepicker" dir="rtl" {{ $ignoreWire ? 'wire:ignore' : '' }}>
    <div class="relative"
         x-data="persianDatepicker('{{ $uniqueId  }}','{{ $defaultDate  }}','{{ $setNullInput  }}','{{ $withTime  }}','{{ $showFormat }}','{{ $returnFormat }}','{{ $currentView }}','{{ $minDate }}','{{ $maxDate }}')"
         x-init="[initDate(), getNoOfDays()]" id="{{$uniqueId}}"
         x-cloak>
        <div class="relative pdp-input-area">
            <input type="text" name="datepickerDate" class="dp-return-input hidden"
                   @input="$wire.set('{{$wirePropertyName}}', (!$event.target.value ? null : $event.target.value) )">
            @if($label)
                <label class="block font-medium text-sm text-gray-700">
                    {!! $label !!} {!! $required ? '<span class="text-red-600 text-xl relative top-1.5 leading-none">*</span>' : ''!!}
                </label>
            @endif
            <div class="relative flex items-center mt-1">
                <input @click="showDatepicker = !showDatepicker"
                       class="auto-go-to-next pdp-input border-gray-300 focus:border-gray-400 focus:ring focus:ring-gray-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full pl-14 text-sm h-11"
                       type="text" readonly
                       x-model="datepickerValue"
                       @keydown.escape="showDatepicker = false"
                       placeholder="{{ strip_tags($label) }}" {{ $attributes }}>

                <div class="absolute left-0 pl-3" @click="showDatepicker = !showDatepicker">
                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span x-show="datepickerValue"
                      class="material-icons cursor-pointer absolute left-9 remove_date"
                      @click="removeDate(); showDatepicker = false">
                        <svg class="w-6 h-6" viewBox="0 0 24 24"><path
                                    d="M5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289Z"
                                    fill="#ef4444"></path>
                        </svg>
                </span>
            </div>
        </div>
        <div
                class="bg-white z-40 rounded-lg shadow p-4 absolute left-0"
                style="width: 17rem"
                x-show.transition="showDatepicker"
                @click.away="showDatepicker = false">

            <div class="flex justify-between items-center mb-2">
                <div>
                    <span x-text="monthNames[month - 1]" @click="currentView = 'month'" class="text-lg font-bold text-gray-800 cursor-pointer"></span>
                    <span x-text="year" @click="currentView = 'year'" class="ml-1 text-lg text-gray-600 font-normal cursor-pointer"></span>
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

            <div class="flex flex-col" x-show="currentView == 'day'" x-transition>
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
                                    @click="if(date.isActive) { selectDay(date.day); isSelectedDay(date.day,$event.target)}"
                                    x-text="date.day"
                                    class="cursor-pointer w-6 h-6 flex flex-wrap items-center justify-center text-center text-sm rounded-full leading-loose transition ease-in-out duration-100"
                                    :class="{'todayItem bg-blue-500 text-white': isToday(date.day) == true, 'text-gray-700 hover:bg-blue-200': isToday(date.day) == false, 'datepickerItemSelected bg-emerald-700 text-white': isSelectedDay(date.day) == true}"
                                    x-bind:style="date.isActive === false && { color: '#ccc' }"
                            ></div>
                        </div>
                    </template>
                </div>
            </div>
            <div class="flex flex-col" x-show="currentView == 'month'" x-transition>
                <div class="flex flex-wrap justify-between gap-2 p-2">
                    <template x-for="(monthItem, monthIndex) in monthRanges" :key="monthIndex">
                        <div
                                @click="monthItem.isActive ? selectMonth(monthItem.month) : null"
                                x-text="monthItem.name"
                                class="cursor-pointer flex flex-wrap w-16 items-center justify-center text-center text-sm leading-loose transition ease-in-out duration-100"
                                :class="{'monthItem bg-blue-500 text-white': isThisMonth(monthItem.month) == true, 'text-gray-700 hover:bg-blue-200': isThisMonth(monthItem.month) == false}"
                                x-bind:style="monthItem.isActive === false && { color: '#ccc' }"
                        ></div>
                    </template>
                </div>
            </div>
            <div class="flex flex-col" x-show="currentView == 'year'" x-transition>
                <div class="flex flex-wrap justify-between gap-2 p-2 h-44 overflow-y-auto">
                    <template x-for="(yearItem, yearIndex) in yearRanges" :key="yearIndex">
                        <div
                                @click="yearItem.isActive ? selectYear(yearItem.year) : null"
                                x-text="yearItem.year"
                                class="cursor-pointer flex flex-wrap w-16 items-center justify-center text-center text-sm leading-loose transition ease-in-out duration-100"
                                :class="{'yearItem bg-blue-500 text-white': isThisYear(yearItem.year) == true, 'text-gray-700 hover:bg-blue-200': isThisYear(yearItem.year) == false}"
                                x-bind:style="yearItem.isActive === false && { color: '#ccc' }"
                        ></div>
                    </template>
                </div>
            </div>

            <div class="flex mt-1">
                <button type="button" @click="goToToday()"
                        class="inline-flex items-center w-full justify-center px-4 py-2 !bg-sky-500 text-white shadow-md border border-transparent rounded-lg text-xs text-white focus:outline-none disabled:opacity-25 transition">
                    امروز
                </button>
            </div>
        </div>
        <div class="relative pdp-time-area mt-2 flex flex-row-reverse items-center gap-1" x-show="datepickerValue && withTime"
             x-transition>
            <div class="w-full relative">
                <input type="number" min="0" max="23" maxlength="2" x-model="hour"
                       @input="setTime('hour',$event.target)"
                       class="number_format block w-full text-center border-gray-300 focus:border-gray-400 focus:ring focus:ring-gray-200 focus:ring-opacity-50 rounded-md shadow-sm h-11"/>
                <span class="absolute top-0.5 right-1 text-xxs text-gray-400">ساعت</span>
            </div>
            <span>:</span>
            <div class="w-full relative">
                <input type="number" min="0" max="59" maxlength="2" x-model="minute"
                       @input="setTime('minute',$event.target)"
                       class="number_format block w-full text-center border-gray-300 focus:border-gray-400 focus:ring focus:ring-gray-200 focus:ring-opacity-50 rounded-md shadow-sm h-11"/>
                <span class="absolute top-0.5 right-1 text-xxs text-gray-400">دقیقه</span>
            </div>
            @if($withTimeSeconds)
                <span>:</span>
                <div class="w-full relative">
                    <input type="number" min="0" max="59" maxlength="2" x-model="second"
                           @input="setTime('second',$event.target)"
                           class="number_format block w-full text-center border-gray-300 focus:border-gray-400 focus:ring focus:ring-gray-200 focus:ring-opacity-50 rounded-md shadow-sm h-11"/>
                    <span class="absolute top-0.5 right-1 text-xxs text-gray-400">ثانیه</span>
                </div>
            @endif
        </div>

    </div>
</div>
