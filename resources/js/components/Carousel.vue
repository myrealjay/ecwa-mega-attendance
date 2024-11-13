<template>
    <div>
        <div
            :id="id"
            class="carousel slide carousel-fade"
            data-bs-ride="carousel"
        >
            <div class="carousel-indicators">
                <button v-for="(url, i) in imageUrls"
                    type="button"
                    :data-bs-target="`#${id}`"
                    :data-bs-slide-to="i"
                    class="active"
                    aria-current="true"
                    :aria-label="'image '+i"
                ></button>
            </div>
            <div class="carousel-inner">
                <div v-for="(url, i) in imageUrls" :class="getClass(i)">
                    <img
                        :src="url"
                        class="d-block w-100"
                        alt="..."
                    />
                </div>
            </div>
            <button
                class="carousel-control-prev"
                type="button"
                :data-bs-target="`#${id}`"
                data-bs-slide="prev"
            >
                <span
                    class="carousel-control-prev-icon"
                    aria-hidden="true"
                ></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button
                class="carousel-control-next"
                type="button"
                :data-bs-target="`#${id}`"
                data-bs-slide="next"
            >
                <span
                    class="carousel-control-next-icon"
                    aria-hidden="true"
                ></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</template>

<script setup>
import { defineProps, onMounted } from 'vue';

const props = defineProps({
    id: String,
    imageUrls:{
        type: Array,
        default: () => []
    }
});

onMounted(() => {
    console.log('from component', props.imageUrls)
});

function getClass(i) {
    return i === 0 ? 'carousel-item active' : 'carousel-item';
}
</script>

<style scoped>
    .carousel-inner .carousel-item img {
    transition: transform 1.5s ease;
    }

    .carousel-inner .carousel-item.active img {
    transform: scale(1.1);
    }
    .carousel-control-next {
        padding:0;
        background: none;
    }

    .carousel-control-prev, .carousel-control-next {
        position: absolute;
        top: 0;
        bottom: 0;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 15%;
        color: #fff;
        text-align: center;
        opacity: 0;
        transition: opacity 0.15s ease;
    }
</style>
