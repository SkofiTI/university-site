<template>
    <Navbar />
    <div class="home-component">
        <h1 class="title">Аракелян Сурен Рубенович</h1>
        <img class="avatar" src="@assets/avatar.jpg" alt="avatar">
        <p class="class-info">ИС/б-21-3-о</p>
        <p class="lab-info">Лабораторная работа №1 «Исследование возможностей языка разметки гипертекстов HTML и каскадных таблиц стилей CSS»</p>
    </div>
</template>

<script>
import '@/sass/HomeComponent.scss'
import { updatePageHistory } from '@src/Utils/historyFunctions';
import Navbar from "@src/Components/Navbar.vue";

export default {
    name: 'HomeComponent',
    components: {
        Navbar
    },

    mounted() {
        updatePageHistory();
    },
};
</script>