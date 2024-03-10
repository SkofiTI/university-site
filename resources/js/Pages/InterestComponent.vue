<template>
    <Navbar />
    <div class="interests-container">
        <div class="interests-component">
            <div class="menu">
            </div>
        </div>
        <div class="interests-content">
        </div>
        <div class="interests-add">
            <div class="interests-add__item">
                <h4>Добавить новый интерес</h4>
                <form @submit.prevent="addInterest">
                    <div class="form-item">
                        <input type="text" v-model="newInterest.name" placeholder="Название (id)" required />
                    </div>
                    <div class="form-item">
                        <input type="text" v-model="newInterest.description" placeholder="Описание" required />
                    </div>
                    <div class="form-item">
                        <button type="submit">Отправить</button>
                    </div>
                </form>
            </div>
            <div class="interests-add__item">
                <h4>Добавить элемент к интересу</h4>
                <form @submit.prevent="addInterestItem">
                    <div class="form-item">
                        <select v-model="newInterestItem.name">
                            <option disabled value="">Выберите интерес</option>
                            <option v-for="interest in interests" :value="interest.name">{{ interest.description }}</option>
                        </select>
                    </div>
                    <div class="form-item">
                        <input type="text" v-model="newInterestItem.item" placeholder="Элемент" required />
                    </div>
                    <div class="form-item">
                        <button type="submit">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import '@/sass/InterestComponent.scss';
import { updatePageHistory } from '@src/Utils/historyFunctions';
import Navbar from "@src/Components/Navbar.vue";

export default {
    name: 'InterestComponent',
    components: {
        Navbar
    },
    props: {
        interests: Array
    },
    
    data() {
        return {
            newInterest: {
                name: '',
                description: '',
                
            },
            newInterestItem: {
                name: '',
                item: '',
            },
        };
    },
    mounted() {
        updatePageHistory();
        this.createInterests(this.interests);
    },
    methods: {
        createInterests(interests) {
            const sidebar = document.querySelector('.menu');
            const content = document.querySelector('.interests-content');
            console.log(interests)
            interests.forEach(({ name, description, items }) => {
                const interestSidebarTitle = document.createElement('h2');
                interestSidebarTitle.innerHTML = `${description}<a href="#${name}"> #</a>`;

                const interestSidebarItem = document.createElement('ul');
                items.forEach((item, index) => {
                    const itemSidebarLi = document.createElement('li');
                    itemSidebarLi.innerHTML = `<a href="#${name}${index}">${item}</a>`;
                    interestSidebarItem.appendChild(itemSidebarLi);
                });

                sidebar.appendChild(interestSidebarTitle);
                sidebar.appendChild(interestSidebarItem);

                const interestContent = document.createElement('h1');
                interestContent.textContent = description;
                interestContent.setAttribute('id', name);
                content.appendChild(interestContent);

                items.forEach((item, index) => {
                    const itemContent = document.createElement('p');
                    itemContent.textContent = item;
                    itemContent.setAttribute('id', name + index);
                    content.appendChild(itemContent);
                });
            });
        },
        addInterest() {
            const { name, description } = this.newInterest;

            if (!name || !description) {
                return;
            }

            this.$inertia.post('/interests', this.newInterest);
        },
        addInterestItem() {
            const { name, item } = this.newInterestItem;

            if (!name || !item) {
                return;
            }

            this.$inertia.post('/interests', this.newInterestItem);
        },
    },
};
</script>