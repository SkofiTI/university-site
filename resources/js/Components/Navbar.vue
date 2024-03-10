<template>
    <nav>
        <ul>
            <li><Link class="navbar-link" href="/">Главная страница</Link></li>
            <li><Link class="navbar-link" href="/about">Обо мне</Link></li>
            <li><Link class="navbar-link" href="/interests">Мои интересы</Link></li>
            <li><Link class="navbar-link" href="/education">Учеба</Link></li>
            <li><Link class="navbar-link" href="/photo-album">Фотоальбом</Link></li>
            <li><Link class="navbar-link" href="/contact">Контакт</Link></li>
            <li><Link class="navbar-link" href="/test">Тест по БЖД</Link></li>
            <li><Link class="navbar-link" href="/history">История просмотра</Link></li>
        </ul>
        <div class="current-date">{{ currentDateTime }}</div>
    </nav>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import '@/sass/NavbarComponent.scss';

export default {
    name: 'NavbarComponent',
    components: {
        Link,
    },
  
    watch: {
        '$route'() {
            this.scrollToHash();
        },
    },
    data() {
        return {
            currentDateTime: ''
        };
    },
    mounted() {
        this.updateDateTime();
        setInterval(this.updateDateTime, 1000);
    },
  
    methods: {
        updateDateTime() {
            const currentDate = new Date();
            const day = currentDate.getDate();
            const month = currentDate.toLocaleString('default', { month: 'long' });
            const year = currentDate.getFullYear();
            
            this.currentDateTime = `${day} ${month} ${year}`;
        }
    },
};
</script>