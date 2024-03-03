<template>
    <Navbar />
    <div class="photo-album-component">
        <h1 class="title">Фотоальбом</h1>
        <div class="modal">
            <div class="slider">
                <div class="slider-track">
                </div>
                <div class="prev"><a><img src="@assets/arrow-circle-right.svg"></a></div>
                <div class="next"><a><img src="@assets/arrow-circle-left.svg"></a></div>
            </div>
            <span class="close">&times;</span>
        </div>
    </div>
</template>

<script>
import '@/sass/PhotoAlbumComponent.scss';
import { updatePageHistory } from '@src/Utils/historyFunctions';
import Navbar from "@src/Components/Navbar.vue";

const APP_URL = "http://127.0.0.1:5173";
const BASE_URL = APP_URL + "/resources/assets/album/";

let position = 0;
let movePosition = 0;

export default {
    name: "PhotoAlbumComponent",
    components: {
        Navbar
    },
    props: {
        photo: Array,
    },

    data() {
        return {
            photoAlbumElement: null,
            sliderItemWidth: 600,
        };
    },
    mounted() {
        updatePageHistory();
        this.createPhotoAlbum();

        const sliderItemsCount = this.photo.length;
        
        document.querySelector('.next').addEventListener('click', () => {
            position += 1;
            movePosition -= this.sliderItemWidth;
            
            this.setPosition(movePosition);
            this.checkButtons(sliderItemsCount, this.sliderItemWidth);
        });

        document.querySelector('.prev').addEventListener('click', () => {
            position -= 1;
            movePosition += this.sliderItemWidth;
            
            this.setPosition(movePosition);
            this.checkButtons(sliderItemsCount, this.sliderItemWidth);
        });
    },
    methods: {
        setPosition(sliderItemWidth) {
            const sliderItems = document.querySelectorAll('.slider-item');
            sliderItems.forEach(item => {
                item.style.transform = `translateX(${sliderItemWidth}px)`;
                item.style.transition = 'transform 0.5s';
            });
        },
        checkButtons(sliderItemsCount, sliderItemWidth) {
            const maxPosition = (sliderItemsCount - 1) * sliderItemWidth;
            
            if (position < 0) {
                position = sliderItemsCount - 1;
                movePosition = -maxPosition;
            } else if (position >= sliderItemsCount) {
                position = 0;
                movePosition = 0;
            }

            this.setPosition(movePosition);
        },
        createPhotoAlbum() {
            const modalContainer = document.querySelector('.modal');
            const modalCloseElement = document.querySelector('.close');
            const photoAlbumElement = document.querySelector('.photo-album-component');
            const sliderTrack = document.querySelector('.slider-track');
        
            for (let index = 0; index < this.photo.length; index++) {
                const sliderItem = document.createElement('div');
                sliderItem.classList.add('slider-item');
                
                const photoItem = document.createElement('div');
                photoItem.classList.add('photo-item');

                const img = document.createElement('img');
                img.src = BASE_URL + this.photo[index]['path'];
                img.alt = this.photo[index]['title'];
                img.classList.add('photo');

                const sliderImg = document.createElement('img');
                sliderImg.src = BASE_URL + this.photo[index]['path'];
                sliderImg.alt = this.photo[index]['title'];
                sliderImg.classList.add('slider-photo');

                const tooltip = document.createElement('div');
                tooltip.textContent = this.photo[index]['title'];
                tooltip.classList.add('tooltip');
                tooltip.style.pointerEvents = 'none';

                const caption = document.createElement('div');
                caption.textContent = this.photo[index]['title'];
                caption.classList.add('caption');

                const modalImage = document.createElement('div');
                modalImage.classList.add('modal');
                modalImage.setAttribute('id', this.photo[index]['title']);

                img.addEventListener('click', () => {
                    position = index;
                    movePosition = -(position * this.sliderItemWidth);
                    
                    this.setPosition(movePosition);
                    modalContainer.style.display = 'block';
                });

                modalCloseElement.addEventListener('click', () => {
                    modalContainer.style.display = 'none';
                });

                photoItem.append(img, tooltip, caption, modalImage);
                photoAlbumElement.append(photoItem);
                sliderItem.append(sliderImg);
                sliderTrack.append(sliderItem);
            }

            return photoAlbumElement;
        },
    },
};
</script>