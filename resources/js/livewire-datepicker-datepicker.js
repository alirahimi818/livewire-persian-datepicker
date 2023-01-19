import * as moment from 'jalali-moment';

window.persianDatepicker = function (componentId, defaultDate = null, setNullInput = false, showFormat = null, returnFormat = null) {
    return {
        showDatepicker: false,
        showFormat: 'jYYYY/jMM/jDD',
        returnFormat: 'X',
        defaultDate: '',
        datepickerValue: '',
        selectedItemElement: 'datepickerItemSelected',
        month: '',
        year: '',
        no_of_days: [],
        blankDays: [],
        monthNames: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
        days: ['ش', 'ی', 'د', 'س', 'چ', 'پ', 'ج'],

        initDate() {
            this.showFormat = showFormat ? showFormat : this.showFormat;
            this.returnFormat = returnFormat ? returnFormat : this.returnFormat;
            this.defaultDate = defaultDate ? defaultDate : this.defaultDate;

            let today;
            if (this.defaultDate) {
                today = moment(this.defaultDate, 'YYYY-MM-DD HH:mm:ss').locale('fa');
            } else {
                today = moment().locale('fa');
            }
            this.month = today.jMonth() + 1;
            this.year = today.jYear();
            if (!setNullInput) {
                this.datepickerValue = moment(`${this.year}/${this.month}/${today.jDate()}`, 'jYYYY/jMM/jDD').format(this.showFormat);
            }
            this.setReturnValue(this.year, this.month, today.jDate())
        },

        isToday(date) {
            const today = moment().locale('fa');
            const d = moment(`${this.year}/${this.month}/${date}`, 'jYYYY/jMM/jDD');
            return today.format('jYYYY/jMM/jDD') === d.format('jYYYY/jMM/jDD');
        },

        goToToday() {
            this.initDate()
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
            if (selectReturnInput) {
                return selectReturnInput.value === selected.format(this.returnFormat);
            }
            return false;
        },

        selectDay(date) {
            let selectedDate = moment(`${this.year}/${this.month}/${date}`, 'jYYYY/jMM/jDD');
            this.datepickerValue = selectedDate.format(this.showFormat);
            this.showDatepicker = false;
            this.setReturnValue(selectedDate.jYear(), selectedDate.jMonth() + 1, selectedDate.jDate())
        },

        setReturnValue(year, month, day) {
            let selectReturnInput = document.querySelector(`#${componentId} .dp-return-input`);
            if (selectReturnInput) {
                selectReturnInput.value = moment(`${year}/${('0' + (month)).slice(-2)}/${('0' + day).slice(-2)}`, 'jYYYY/jMM/jDD').format(this.returnFormat);
                selectReturnInput.dispatchEvent(new Event('input'));
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
                daysArray.push(i);
            }

            this.blankDays = blankDaysArray;
            this.no_of_days = daysArray;
        }
    }
}
