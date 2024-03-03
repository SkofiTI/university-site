<template>
    <Navbar />
    <div class="interests-container">
        <div class="interests-component">
            <div class="menu">
            </div>
        </div>
        <div class="interests-content">
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

    mounted() {
        updatePageHistory();
        this.createInterests(this.interests);
    },
    methods: {
        createInterests(interests) {
            const sidebar = document.querySelector('.menu');
            const content = document.querySelector('.interests-content');

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
        }
    },
};
</script>