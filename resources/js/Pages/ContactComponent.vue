<template>
    <Navbar />
    <div class="contact-component">
      <h1 class="title">Контакты</h1>
      
      <form action="#" method="POST">
            <div class="form-item">
                <label for="name">Фамилия Имя Отчество <span id="required">*</span></label>
                <input type="text" id="name" name="name" v-model="formData.name" placeholder="Введите ФИО" data-popover='Иванов Иван Иванович'>
                <div class="error-message"></div>
            </div>

            <div class="form-item">
                <label>Дата рождения <span id="required">*</span></label>
                <input type="text" id="date" name="date" v-model="formData.date" placeholder="ДД.ММ.ГГ" readonly>
                <div class="error-message"></div>
                <div id="calendar">
                    <ul class="calendar-info">
                        <li class="year-name"></li>
                        <li class="month-name"></li>
                        <div class="input-calendar">
                            <select name="birth-year" id="birth-year"></select>
                            <select name="birth-month" id="birth-month"></select>
                        </div>
                    </ul>
                    <ul class="weekdays">
                        <li>Пн</li>
                        <li>Вт</li>
                        <li>Ср</li>
                        <li>Чт</li>
                        <li>Пт</li>
                        <li>Сб</li>
                        <li>Вс</li>
                    </ul>
                    <ul class="days">
                    </ul>
                </div>
            </div>

            <div class="form-item">
                <label for="phone">Телефон <span id="required">*</span></label>
                <input type="tel" id="phone" name="phone" v-model="formData.phone" placeholder="Введите номер телефона" data-popover="+7/+3xxxxxxxxx">
                <div class="error-message"></div>
            </div>
            
            <div class="form-item">
                <label>Пол <span id="required">*</span></label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="gender" value="male" v-model="formData.gender">
                        Мужской
                    </label>
                    <label>
                        <input type="radio" name="gender" value="female" v-model="formData.gender">
                        Женский
                    </label>
                </div>
            </div>
            
            <div class="form-item">
                <label for="age">Возраст <span id="required">*</span></label>
                <select id="age" name="age" v-model="formData.age">
                    <option value="" disabled selected>Выберите возраст</option>
                    <option value="18-25">18-25</option>
                    <option value="26-35">26-35</option>
                    <option value="36-45">36-45</option>
                    <option value="46+">46+</option>
                </select>
            </div>
            
            <div class="form-item">
                <label for="email">E-mail <span id="required">*</span></label>
                <input type="email" id="email" name="email" v-model="formData.email" placeholder="Введите e-mail" data-popover="example@example.com">
                <div class="error-message"></div>
            </div>
            
            <div class="button-container">
                <button id="send" disabled>Отправить</button>
                <button id="clear" type="reset">
                    <img id="reset" src="@assets/reset.svg" alt="reset">
                </button>
            </div>
        </form>
    </div>
    <div class="modal-contact" id="modalSubmit">
        <div class="modal-content">
            <div class="modal-title">
                <p>Вы действительно хотите это сделать?</p>
            </div>
            <div class="modal-button-container">
                <button id="send-modal" type="submit">Да</button>
                <button id="close-modal">Нет</button>
            </div>
        </div>
    </div>
</template>
  
<script>
import '@/sass/ContactComponent.scss';
import { updatePageHistory } from '@src/Utils/historyFunctions';
import Navbar from "@src/Components/Navbar.vue";

const monthNames = [
    'Январь',
    'Февраль',
    'Март',
    'Апрель',
    'Май',
    'Июнь',
    'Июль',
    'Август',
    'Сентябрь',
    'Октябрь',
    'Ноябрь',
    'Декабрь'
];

let selectedBirthDay = 0;
let selectedBirthMonth = 0;
let selectedBirthYear = 0;

export default {
    name: 'ContactComponent',
    components: {
        Navbar
    },

    data() {
        return {
            formData: {
                name: '',
                gender: '',
                date: '',
                age: '',
                phone: '',
                email: '',
            }
        }
    },
    mounted() {
        updatePageHistory();

        const modal = document.getElementById('modalSubmit');
        const sendModalButton = document.getElementById('send-modal');
        const closeModalButton = document.getElementById('close-modal');

        const dateInput = document.getElementById('date');
        const calendar = document.getElementById('calendar');

        const birthYearSelect = document.getElementById('birth-year');
        const birthMonthSelect = document.getElementById('birth-month');

        const nowDate = new Date();
        const nowYear = nowDate.getFullYear();
        
        // Генератор годов
        for (let year = nowYear; year >= 1900; year--) {
            birthYearSelect.appendChild(new Option(year, year));
        }

        // Генератор месяцев
        monthNames.forEach((monthName, i) => {
            birthMonthSelect.appendChild(new Option(monthName, i));
        });

        // Слушатели событий на изменение месяца и года
        birthYearSelect.addEventListener('change', () => this.updateCalendar(birthYearSelect, birthMonthSelect));
        birthMonthSelect.addEventListener('change', () => this.updateCalendar(birthYearSelect, birthMonthSelect));

        // Инициализация календаря
        this.setCalendar(birthYearSelect.value, parseInt(birthMonthSelect.value));

        // Слушатели событий на открытие/закрытие календаря
        dateInput.addEventListener('click', (event) => {
            event.stopPropagation();
            const calendarDisplay = getComputedStyle(calendar).display;

            if (calendarDisplay === 'block') {
                calendar.style.display = 'none';
            } else if (calendarDisplay === 'none') {
                calendar.style.display = 'block';
            }
        });
        
        document.addEventListener('click', (event) => {
            if (!calendar.contains(event.target)) {
                calendar.style.display = 'none';
            }
        });

        // Валидация
        const form = document.querySelector('.contact-component form');

        form.addEventListener('input', (event) => {
            const target = event.target;

            if (target.id === 'name') {
                this.validateName(target);
            } else if (target.id === 'phone') {
                this.validatePhone(target);
            } else if (target.id === 'email') {
                this.validateEmail(target);
            }

            this.checkFormValidate(form);
        });

        const days = form.querySelectorAll('.days');
        days.forEach(day => {
            day.addEventListener('click', () => {
                this.checkFormValidate(form);
            });
        });

        const resetButton = form.querySelector('#clear');
        resetButton.addEventListener('click', () => {
            setTimeout(() => {
                this.checkFormValidate(form);
            }, 0);
        });

        // Слушатель события на открытие popover окна
        form.querySelectorAll('input').forEach(input => {
            input.addEventListener('mouseenter', (event) => {
                const target = event.currentTarget;
                if (!target.nextElementSibling.classList.contains('popover')) {
                    this.showPopover(target);
                }
            });
        });

        // Отправка формы
        const sendButton = document.getElementById('send');

        sendButton.addEventListener('click', (event) => {
            event.preventDefault();
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });

        sendModalButton.addEventListener('click', () => {
            if (this.checkFormValidate(form)) {
                this.$inertia.post('/contact', this.formData);
                modal.style.display = 'none';
                document.body.style.overflow = 'scroll';
            }
        });

        closeModalButton.addEventListener('click', () => {
            modal.style.display = 'none';
            document.body.style.overflow = 'scroll';
        });
    },
    methods: {
        showPopover(target){
            const formItem = target.closest('.form-item');
            const popoverText = target.dataset.popover;

            if (!popoverText) {
                return;
            }

            const popover = document.createElement('div');
            popover.classList.add('popover');
            popover.textContent = popoverText;
          
            formItem.appendChild(popover);
          
            const inputPosition = target.getBoundingClientRect();
            const popoverPosition = {
                top: inputPosition.top + target.offsetHeight / 2 - popover.offsetHeight / 2,
                left: inputPosition.left + target.offsetWidth + 10,
            };
          
            Object.assign(popover.style, popoverPosition);

            target.addEventListener('mouseleave', () => {
                setTimeout(() => {
                    popover.remove();
                }, 2000);
            });
        },
        checkFormValidate(form) {
            const nameInput = form.querySelector('#name');
            const phoneInput = form.querySelector('#phone');
            const emailInput = form.querySelector('#email');
            const dateInput = form.querySelector('#date');
            const ageInput = form.querySelector('#age');
            const radioInputs = form.querySelectorAll('input[type="radio"]');
            const sendButton = form.querySelector('#send');
            let isFormValid = true;
        
            if (!this.validateName(nameInput) ||
                !this.validatePhone(phoneInput) ||
                !this.validateEmail(emailInput) ||
                dateInput.value === '' ||
                ageInput.value === '') {
                isFormValid = false;
            }
        
            let isRadioSelected = false;
            radioInputs.forEach(input => {
                if (input.checked) {
                    isRadioSelected = true;
                    return;
                }
            });

            if (!isRadioSelected) {
                isFormValid = false;
            }
        
            sendButton.disabled = !isFormValid;
            
            return isFormValid;
        },
        regexName(name) {
            const nameRegex = /^([а-яА-ЯёЁ]+\s[а-яА-ЯёЁ]+\s[а-яА-ЯёЁ]+|[a-zA-Z]+\s[a-zA-Z]+\s[a-zA-Z]+)$/;
            return nameRegex.test(name);
        },
        regexPhone(phone) {
            const phoneRegex = /^(?:\+7|\+3)\d{9,11}$/;
            return phoneRegex.test(phone);
        },
        regexEmail(email) {
            const emailRegex = /^\S+@\S+\.\S+$/;
            return emailRegex.test(email);
        },
        validateName(nameInput) {
            if (nameInput.value !== '') {
                if (!this.regexName(nameInput.value)) {
                    if (!nameInput.classList.contains('error')) {
                        nameInput.classList.remove('success');
                        nameInput.classList.add('error');
                        nameInput.nextElementSibling.textContent = 'Введите ФИО в формате "Фамилия Имя Отчество"';
                        
                        return false;
                    }
                } else {
                    nameInput.classList.remove('error');
                    nameInput.classList.add('success');

                    nameInput.nextElementSibling.textContent = '';

                    return true;
                }
            } else {
                nameInput.classList.remove('error');
                nameInput.classList.remove('success');
                nameInput.nextElementSibling.textContent = '';
            }
        },
        validatePhone(phoneInput) {
            if (phoneInput.value !== '') {
                if (!this.regexPhone(phoneInput.value)) {
                    if (!phoneInput.classList.contains('error')) {
                        phoneInput.classList.remove('success');
                        phoneInput.classList.add('error');
                        phoneInput.nextElementSibling.textContent = 'Введите правильный номер телефона +7/+3xxxxxxxxx';
                        return false;
                    }
                } else {
                    phoneInput.classList.remove('error');
                    phoneInput.classList.add('success');
                    phoneInput.nextElementSibling.textContent = '';
                    return true;
                }
            } else {
                phoneInput.classList.remove('error');
                phoneInput.classList.remove('success');
                phoneInput.nextElementSibling.textContent = '';
            }
        },
        validateEmail(emailInput) {
            if (emailInput.value !== '') {
                if (!this.regexEmail(emailInput.value)) {
                    if (!emailInput.classList.contains('error')) {
                        emailInput.classList.remove('success');
                        emailInput.classList.add('error');
                        emailInput.nextElementSibling.textContent = 'Введите корректный email-адрес';
                        return false;
                    }
                } else {
                    emailInput.classList.remove('error');
                    emailInput.classList.add('success');
                    emailInput.nextElementSibling.textContent = '';
                    return true;
                }
            } else {
                emailInput.classList.remove('error');
                emailInput.classList.remove('success');
                emailInput.nextElementSibling.textContent = '';
            }
        },
        setCalendar(year, month) { // Функция генерации календаря
            const container = document.getElementById('calendar');
            const monthContainer = container.querySelector('.month-name');
            const yearContainer = container.querySelector('.year-name');
            const daysContainer = container.querySelector('.days');

            let monthDays = new Date(year, month + 1, 0).getDate(), // Количество дней в текущем месяце
                monthPrefix = new Date(year, month, 0).getDay(), // Количество дней прошлого месяца в текущей неделе
                monthDaysText = '';

                monthContainer.textContent = monthNames[month];
                yearContainer.textContent = year;
                daysContainer.innerHTML = '';
            
            if (monthPrefix > 0){
                for (let i = 1; i <= monthPrefix; i++){
                    monthDaysText += '<li class="empty-day"></li>';
                }
            }

            for (let i = 1; i <= monthDays; i++){
                monthDaysText += '<li>' + i + '</li>';
            }

            daysContainer.innerHTML = monthDaysText;

            this.setDayCalendar(year, month, daysContainer);
        },
        setDayCalendar(year, month, daysContainer) { // Функция выбора определённого дня в календаре
            const days = daysContainer.querySelectorAll('li');
            const calendar = document.getElementById('calendar');

            days.forEach(day => {
                if ((year == selectedBirthYear) && (month == selectedBirthMonth) && (day.textContent == selectedBirthDay)) {
                    day.classList.add('selected-day');
                }

                day.addEventListener('click', () => {
                    const selectedDay = day.textContent;

                    if (selectedDay === '') {
                        return;
                    }

                    days.forEach(day => {
                        day.classList.remove('selected-day');
                    });

                    const formattedDate = `${selectedDay}.${month + 1}.${year}`;

                    const dateInput = document.getElementById('date');
                    dateInput.value = formattedDate;
                    this.formData.date = formattedDate

                    selectedBirthDay = selectedDay;
                    selectedBirthMonth = month;
                    selectedBirthYear = year;

                    day.classList.add('selected-day');
                    calendar.style.display = 'none';
                });
            });
        },
        updateCalendar(birthYearSelect, birthMonthSelect) { // Функция обновления календаря
            const selectedYear = parseInt(birthYearSelect.value);
            const selectedMonth = parseInt(birthMonthSelect.value);
            this.setCalendar(selectedYear, selectedMonth);
        },
    },
};
</script>