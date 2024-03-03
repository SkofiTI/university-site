<template>
    <nav>
        <ul>
            <li><Link class="navbar-link" href="/">Главная страница</Link></li>
            <li><Link class="navbar-link" href="/about">Обо мне</Link></li>
            <li class="interests-dropdown">
                <Link class="navbar-link" href="/interests">Мои интересы</Link>
                <div class="dropdown-content">
                </div>
            </li>
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

const interests = [
    ['hobby', 'Мои хобби'],
    ['book', 'Мои любимые книги'],
    ['music', 'Моя любимая музыка'],
    ['films', 'Мои любимые фильмы']
];

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
        const interestsDropdown = document.querySelector('.interests-dropdown');
        const dropdown = document.querySelector('.dropdown-content');
        
        interestsDropdown.addEventListener('mouseenter', () => this.createInterests(interests, dropdown));
        interestsDropdown.addEventListener('mouseleave', () => { dropdown.innerHTML = ''; });
        
        this.scrollToHash();
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
        },
        createInterests(interests, dropdown) {
            const interestDropdown = document.createElement('ul');

            interests.forEach(([interest, name]) => {
                const itemDropdownLi = document.createElement('li');
                const link = document.createElement('a');
                link.href = `/interests#${interest}`;
                link.textContent = name;
                itemDropdownLi.appendChild(link);
                interestDropdown.appendChild(itemDropdownLi);
            });
            
            dropdown.appendChild(interestDropdown);
        },
        scrollToHash() {
            const hash = window.location.hash;

            if (hash) {
                setTimeout(() => {
                    const element = document.querySelector(hash);

                    if (element) {
                        document.querySelector('.interests-content').scrollTo({
                            top: element.offsetTop,
                            behavior: 'smooth'
                        });
                    }
                }, 0);
            }
        },
    },
};
</script>