import moment from 'jalali-moment';

window.persianDatepicker = function (componentId, defaultDate = null, setNullInput = false, withTime = false, showFormat = null, returnFormat = null, currentView = 'day', minDate = null, maxDate = null) {
    return {
        showDatepicker: false,
        withTime: false,
        showFormat: 'jYYYY/jMM/jDD',
        returnFormat: 'X',
        defaultDate: '',
        minDate: '',
        maxDate: '',
        datepickerValue: '',
        selectedItemElement: 'datepickerItemSelected',
        year: '',
        month: '',
        day: '',
        hour: '',
        minute: '',
        second: '',
        no_of_days: [],
        blankDays: [],
        monthNames: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
        days: ['ش', 'ی', 'د', 'س', 'چ', 'پ', 'ج'],
        monthRanges: [],
        yearRanges: [],
        calendarTypes: ['day', 'month', 'year'],
        currentView: currentView,

        initDate() {
            this.withTime = withTime;
            this.showFormat = showFormat ? showFormat : this.showFormat;
            this.returnFormat = returnFormat ? returnFormat : this.returnFormat;
            this.defaultDate = defaultDate ? defaultDate : this.defaultDate;
            this.minDate = minDate ? minDate : this.minDate;
            this.maxDate = maxDate ? maxDate : this.maxDate;

            let today;
            if (this.defaultDate) {
                today = moment(this.defaultDate, 'YYYY-MM-DD HH:mm:ss').locale('fa');
            } else {
                today = moment().locale('fa');
            }

            if (this.minDate) {
                this.minDate = moment(this.minDate, 'YYYY-MM-DD HH:mm:ss').locale('fa');
            }

            if (this.maxDate) {
                this.maxDate = moment(this.maxDate, 'YYYY-MM-DD HH:mm:ss').locale('fa');
            }

            this.year = today.jYear();
            this.month = ('0' + (today.jMonth() + 1)).slice(-2);
            this.day = ('0' + today.jDate()).slice(-2);
            this.hour = ('0' + today.hour()).slice(-2);
            this.minute = ('0' + today.minute()).slice(-2);
            this.second = ('0' + today.second()).slice(-2);

            if (!setNullInput) {
                this.datepickerValue = moment(`${this.year}/${this.month}/${this.day} ${this.hour}:${this.minute}:${this.second}`, 'jYYYY/jMM/jDD HH:mm:ss').format(this.showFormat);
            }
            this.setReturnValue(this.year, this.month, this.day, this.hour, this.minute, this.second)

            this.monthRanges = Array.from(this.monthNames, (monthName, index) => {
                let month = index + 1
                let currentDate = moment(`${this.year}/${month}/${this.day}`, 'jYYYY/jMM/jDD');
                let isActive = true;
                if (this.minDate && currentDate.isBefore(this.minDate, 'month')) {
                    isActive = false;
                }
                if (this.maxDate && currentDate.isAfter(this.maxDate, 'month')) {
                    isActive = false;
                }
                return { month: month, name: monthName , isActive: isActive}
            });
            const currentYear = moment().jYear() + 9
            this.yearRanges = Array.from({ length: 100 }, (_, index) => {
                let year = currentYear - index
                let currentDate = moment(`${year}/${this.month}/${this.day}`, 'jYYYY/jMM/jDD');
                let isActive = true;
                if (this.minDate && currentDate.isBefore(this.minDate, 'year')) {
                    isActive = false;
                }
                if (this.maxDate && currentDate.isAfter(this.maxDate, 'year')) {
                    isActive = false;
                }
                return { year: year , isActive: isActive}
            });
        },

        isToday(date) {
            const today = moment().locale('fa');
            const d = moment(`${this.year}/${this.month}/${date}`, 'jYYYY/jMM/jDD');
            return today.format('jYYYY/jMM/jDD') === d.format('jYYYY/jMM/jDD');
        },

        isThisMonth(month) {
            return Number(this.month) === month;
        },

        isThisYear(year) {
            return Number(this.year) === year;
        },

        goToToday() {
            let today = moment().locale('fa');
            this.year = today.jYear();
            this.month = ('0' + (today.jMonth() + 1)).slice(-2);
            this.getNoOfDays();
            this.removeSelected(document.querySelectorAll(`#${componentId} .${this.selectedItemElement}`));
        },

        removeSelected(items) {
            items.forEach(function (element) {
                if (element.classList.contains('todayItem')) {
                    element.classList.remove(this.selectedItemElement, 'bg-emerald-700')
                } else {
                    element.classList.remove(this.selectedItemElement, 'bg-emerald-700', 'text-white')
                }
            }, this)
        },

        isSelectedDay(date, el = null) {
            let items = document.querySelectorAll(`#${componentId} .${this.selectedItemElement}`);
            if (el) {
                this.removeSelected(items)
                el.classList.add(this.selectedItemElement, 'bg-emerald-700', 'text-white')
            } else if (items.length > 1) {
                this.removeSelected(items)
            }
            const selected = moment(`${this.year}/${this.month}/${date}`, 'jYYYY/jMM/jDD');
            let selectReturnInput = document.querySelector(`#${componentId} .dp-return-input`);
            if (selectReturnInput && selectReturnInput.value) {
                const returnInput = moment(selectReturnInput.value, this.returnFormat);
                const returnInputDay = moment(`${returnInput.jYear()}/${returnInput.jMonth() + 1}/${returnInput.jDate()}`, 'jYYYY/jMM/jDD');
                return returnInputDay.format(this.returnFormat) === selected.format(this.returnFormat);
            }
            return false;
        },

        selectDay(date, closeDatepicker = true) {
            this.day = date;
            let selectedDate = moment(`${this.year}/${this.month}/${date} ${this.hour}:${this.minute}:${this.second}`, 'jYYYY/jMM/jDD HH:mm:ss');
            this.datepickerValue = selectedDate.format(this.showFormat);
            this.showDatepicker = !closeDatepicker;
            this.setReturnValue(selectedDate.jYear(), selectedDate.jMonth() + 1, selectedDate.jDate(), selectedDate.hour(), selectedDate.minute(), selectedDate.second())
        },

        selectMonth(month) {
            this.month = month;
            let selectedDate = moment(`${this.year}/${this.month}/${this.day} ${this.hour}:${this.minute}:${this.second}`, 'jYYYY/jMM/jDD HH:mm:ss');
            this.datepickerValue = selectedDate.format(this.showFormat);
            this.getNoOfDays();
            this.currentView = 'day';
            this.setReturnValue(selectedDate.jYear(), selectedDate.jMonth() + 1, selectedDate.jDate(), selectedDate.hour(), selectedDate.minute(), selectedDate.second())
        },

        selectYear(year) {
            this.year = year;
            let selectedDate = moment(`${this.year}/${this.month}/${this.day} ${this.hour}:${this.minute}:${this.second}`, 'jYYYY/jMM/jDD HH:mm:ss');
            this.datepickerValue = selectedDate.format(this.showFormat);
            this.currentView = 'month';
            this.setReturnValue(selectedDate.jYear(), selectedDate.jMonth() + 1, selectedDate.jDate(), selectedDate.hour(), selectedDate.minute(), selectedDate.second())
        },

        setReturnValue(year, month, day, hour, minute, second) {
            let selectReturnInput = document.querySelector(`#${componentId} .dp-return-input`);
            if (selectReturnInput) {
                if (this.withTime) {
                    selectReturnInput.value = moment(`${year}/${('0' + (month)).slice(-2)}/${('0' + day).slice(-2)} ${('0' + hour).slice(-2)}:${('0' + minute).slice(-2)}:${('0' + second).slice(-2)}`, 'jYYYY/jMM/jDD HH:mm:ss').format(this.returnFormat);
                } else {
                    selectReturnInput.value = moment(`${year}/${('0' + (month)).slice(-2)}/${('0' + day).slice(-2)}`, 'jYYYY/jMM/jDD HH:mm:ss').format(this.returnFormat);
                }
                selectReturnInput.dispatchEvent(new Event('input'));
            }
        },
        setTime(type, element) {
            if (Number(element.value) >= 0) {
                let value = Number(('0' + (element.value)).slice(-2))
                if (value >= 0) {
                    if (type === 'hour') {
                        if (value > 23) {
                            value = element.value = 23;
                        }
                        this.hour = value;
                    } else if (type === 'minute') {
                        if (value > 59) {
                            value = element.value = 59;
                        }
                        this.minute = value;
                    } else if (type === 'second') {
                        if (value > 59) {
                            value = element.value = 59;
                        }
                        this.second = value;
                    }
                    this.datepickerValue = moment(`${this.year}/${this.month}/${this.day} ${this.hour}:${this.minute}:${this.second}`, 'jYYYY/jMM/jDD HH:mm:ss').format(this.showFormat);
                    this.setReturnValue(this.year, this.month, this.day, this.hour, this.minute, this.second)
                }
            }
        },
        removeDate() {
            let selectReturnInput = document.querySelector(`#${componentId} .dp-return-input`);
            if (selectReturnInput) {
                this.datepickerValue = '';
                selectReturnInput.value = '';
                selectReturnInput.dispatchEvent(new Event('input'));
            }
        },

        getNoOfDays() {
            if (this.month > 12) {
                this.year = this.year + 1;
                this.month = 1;
            } else if (this.month < 1) {
                this.year = this.year - 1;
                this.month = 12;
            }

            let daysInMonth = moment(`${this.year}/${this.month}/1`, 'jYYYY/jMM/jDD').jDaysInMonth();
            let dayOfWeek = moment(`${this.year}/${this.month}`, 'jYYYY/jMM').day();

            let blankDaysArray = [];
            for (let i = 0; i <= dayOfWeek; i++) {
                blankDaysArray.push(i);
            }

            let daysArray = [];
            for (let i = 1; i <= daysInMonth; i++) {
                let currentDate = moment(`${this.year}/${this.month}/${i}`, 'jYYYY/jMM/jDD');
                let isActive = true;

                if (this.minDate && currentDate.isBefore(this.minDate, 'day')) {
                    isActive = false;
                }
                if (this.maxDate && currentDate.isAfter(this.maxDate, 'day')) {
                    isActive = false;
                }

                daysArray.push({
                    day: i,
                    isActive: isActive
                });
            }
            this.blankDays = blankDaysArray;
            this.no_of_days = daysArray;
        }
    }
}
