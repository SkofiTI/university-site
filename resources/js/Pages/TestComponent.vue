<template>
    <Navbar />
    <div class="test-component">
        <h1 class="title">Тест</h1>
    
        <form action="#" method="POST" @submit.prevent="handleSubmit">
            <div class="form-item">
                <label for="surname">Фамилия</label>
                <input type="text" id="surname" v-model="formData.surname" placeholder="Введите фамилию" />
            </div>
    
            <div class="form-item">
                <label for="name">Имя</label>
                <input type="text" id="name" v-model="formData.name" placeholder="Введите имя" />
            </div>
    
            <div class="form-item">
                <label for="lastname">Отчество</label>
                <input type="text" id="lastname" v-model="formData.lastname" placeholder="Введите отчество" />
            </div>
    
            <div class="form-item">
                <label for="group">Группа</label>
                <select id="group" v-model="formData.group" name="group">
                    <option value="" disabled selected>Выберите Группу</option>
                    <optgroup v-for="course in courses" :label="course.label" :key="course.label">
                        <option v-for="option in course.options" :value="option.value" :key="option.value">{{ option.label }}</option>
                    </optgroup>
                </select>
            </div>

            <div class="form-item">
                <div class="questions">
                    <div class="question-first">
                        <label for="question1">
                            1. Каковы преимущества активного образа жизни?
                        </label>
                        <textarea name="question1" id="question1" rows="5" v-model="formData.first"></textarea>
                    </div>

                    <div class="question-second">
                        <label for="question2">
                            2. Какой фактор наиболее влияет на развитие сердечно-сосудистых заболеваний?
                        </label>
                        <div class="radio-group">
                            <label>
                                <input type="radio" name="factor" value="food" v-model="formData.second">
                                Неправильное питание
                            </label>
                            <label>
                                <input type="radio" name="factor" value="smoking" v-model="formData.second">
                                Курение
                            </label>
                            <label>
                                <input type="radio" name="factor" value="alcogol" v-model="formData.second">
                                Алкоголь
                            </label>
                        </div>
                    </div>

                    <div class="question-third">
                        <label for="question3">
                            3. Какой продукт является наибольшим источником белка?
                        </label>
                        <select name="protein" id="protein" v-model="formData.third">
                            <option value="" disabled selected>Выберите продукт</option>
                            <option value="meat">Мясо</option>
                            <option value="fish">Рыба</option>
                        </select>
                    </div>
                </div>
            </div>
    
            <div class="button-container">
                <button id="send" type="submit">Отправить</button>
                <button id="clear" type="reset">
                    <img id="reset" src="@assets/reset.svg" alt="reset" />
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import '@/sass/TestComponent.scss';
import { updatePageHistory } from '@src/Utils/historyFunctions';
import Navbar from "@src/Components/Navbar.vue";

export default {
    name: 'TestComponent',
    components: {
        Navbar
    },

    data() {
        return {
            formData: {
                surname: '',
                name: '',
                lastname: '',
                group: '',
                first: '',
                second: '',
                third: '',
            },
            courses: [
                {
                    label: '1 курс',
                    options: [
                        { label: 'ИС-1', value: 'ИС-1' },
                        { label: 'ИТ-1', value: 'ИТ-1' },
                    ],
                },
                {
                    label: '2 курс',
                    options: [
                        { label: 'ИС-2', value: 'ИС-2' },
                        { label: 'ИТ-2', value: 'ИТ-2' },
                    ],
                },
                {
                    label: '3 курс',
                    options: [
                        { label: 'ИС/б-21-1-о', value: 'ИС/б-21-1-о' },
                        { label: 'ИТ/б-21-1-о', value: 'ИТ/б-21-1-о' },
                    ],
                },
            ],
        };
    },
    mounted() {
        const testForm = document.querySelector('.test-component form');
        const textarea = document.getElementById('question1');
        const minWordCount = 30;

        const handleSubmit = (event) => {
            if (!this.validateTestForm()) {
                event.preventDefault();
                return;
            }
        
            const text = textarea.value.trim();
            const wordCount = text.split(/\s+/).length;
        
            if (wordCount < minWordCount) {
                alert('Минимальная длина ответа 30 слов.');
                textarea.focus();
                event.preventDefault();
                return;
            }

            this.$inertia.post('/test', this.formData);
        };
        
        testForm.addEventListener('submit', handleSubmit);

        updatePageHistory();
    },
    methods: {
        validateTestForm() {
            const form = document.querySelector('.test-component form');
            const inputs = form.querySelectorAll('input, select, textarea');
            let radioChecked = false;

            for (let i = 0; i < inputs.length; i++) {
                if (!inputs[i].value) {
                    alert('Пожалуйста, заполните все поля формы');
                    inputs[i].focus();
                    return false;
                }

                if (inputs[i].type === 'radio' && inputs[i].checked) {
                    radioChecked = true;
                }
            }

            if (!radioChecked) {
                alert('Пожалуйста, заполните все поля формы');
                return false;
            }

            return true;
        },
    }
};
</script>