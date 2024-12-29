<template>
    <div class="container-scroller">
        <div class="container-fluid full-page-wrapper">
            <NavBar />
            <div class="hero" id="hero">
                <Transition name="fade" mode="out-in">
                    <h1 :key="bannerText">{{ bannerText }}</h1>
                </Transition>
            </div>
            <div class="carosel">
                <Carousel id="banners" :imageUrls="imageUrls" />
            </div>
                <div
                    class="chant"
                >
                <transition name="slide-fade" mode="out-in">
                    <div :key="displayTest" :style="{ color: color }" v-text="displayTest"></div>
                </transition>
            </div>
            <div class="carosel events" id="events">
                <h4>EVENTS</h4>
                <div v-if="dataFetched">
                    <Carousel id="eventsCarousel" :imageUrls="events" />
                </div>
            </div>
            <div class="footer">
                <h4>ECWA MEGA CHAPEL GBAGADA</h4>
                <div class="row">
                    <div class="col-md-4">
                        <h4>Address</h4>
                        <p>Noic Compound opposite Charly Boy Bus Stop Gbagada, Lagos.</p>
                        <h4>Weekly Activities</h4>
                        <ul>
                            <li>Tuesdays: Bible study by 6PM - 8PM</li>
                            <li>Sunday: Sunday school 7:30 AM, main Service: 8:30Am - 10:30AM</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- page-body-wrapper ends -->
    </div>
</template>

<script setup>
import NavBar from "../components/NavBar.vue";
import Carousel from "../components/Carousel.vue";
import { onBeforeUnmount, computed ,onMounted, ref} from "vue";
import { makeRequest } from '../helpers/requester'
import { endpoints } from '../helpers/endpoints'

const displayTest = ref("Mega People!");
const color = ref('#4287f5');
const bannerText = ref("Ecwa Mega Gbagada");
const imageUrls = ref([
    "../assets/images/carousel/banner1.jpg",
    "../assets/images/carousel/banner2.jpg",
    "../assets/images/carousel/banner3.jpg",
    "../assets/images/carousel/banner4.jpg"
])

const events = ref([]);

onMounted(() => {
    makeRequest('GET', `${endpoints().fetchEvent}/all`).then(response=> {
        const urls = [];
        response.data.data.forEach(ev => {
            urls.push(ev.url);
        })

        events.value = Array.isArray(urls) ? urls : [];
    }).catch(error => {

    })

    const intervalId = setInterval(() => {
        if (displayTest.value === "Mega People!") {
            displayTest.value = "Happy People!";
            color.value = '#225980';
        } else {
            displayTest.value = "Mega People!";
            color.value = '#4287f5';
        }

        if (bannerText.value === "Ecwa Mega Gbagada") {
            bannerText.value = "Where happiness lives";
        } else {
            bannerText.value = "Ecwa Mega Gbagada";
        }
    }, 4000);

    onBeforeUnmount(() => {
        clearInterval(intervalId);
    });
});

const dataFetched = computed(() => {
    const isNotEmpty = Array.isArray(events.value) && events.value.length > 0;
    return isNotEmpty;
});

</script>
<style scoped>
.hero {
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.3);
    width: 100%;
    display: flex;
    justify-content: center; /* Horizontal centering */
    align-items: center;
}

.hero h1 {
    font-size: 80px;
    padding-top: 100px;
    color: #fff;
    text-align: center;
    font-weight: bolder
}

.chant {
    min-height: 200px;
    background-color: #fff;
    padding: 100px;
    text-align: center;
    font-size: 100px;
    font-weight: bolder;
    font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif
}

.carosel {
    min-height: 400px;
    background-color: #edeaf7;
    width: 100%;
    padding: 100px;
}

.carosel.events{
    padding-top: 30px;
    background-color: #797876;
}

.carosel.events h4{
    text-align: center;
    font-size: 60px;
    font-weight: bolder;
    color:#fff;
}

.footer {
    min-height: 300px;
    background-color: #aeafb3;
    width: 100%;
    color: #2f2e2e;
}

.footer h4 {
    color: #191818;
}

.footer > h4 {
    text-align: center;
}

.container,
.container-fluid,
.container-sm,
.container-md,
.container-lg,
.container-xl {
    width: 100%;
    padding-right: 0;
    padding-left: 0;
    margin-right: auto;
    margin-left: auto;
}

.container-fluid {
    background: url(../assets/images/church.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}

.slide-fade-enter-active {
  transition: all .3s ease;
}

.slide-fade-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}

.slide-fade-enter,
.slide-fade-leave-to {
  transform: translateX(10px);
  opacity: 0;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

@media screen and (max-width: 680px) {
    .carosel {
        min-height: 100px;
        background-color: #9a89c7;
        width: 100%;
        padding: 10px;
    }

    .chant {
        min-height: 100px;
        background-color: #fff;
        padding: 10px;
        text-align: center;
        font-size: 40px;
        font-weight: bolder;
        font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif
    }

    .footer > h4 {
        text-align: left;
    }

    .hero h1 {
        font-size: 35px;
        padding-top: 0px;
        color: #fff;
        text-align: center;
        font-weight: bolder
    }

    .carosel.events{
        padding-top: 10px;
    }

    .carosel.events h4{
        text-align: center;
        font-size: 30px;
        font-weight: bolder;
        color:#fff;
    }

    .container-fluid {
        background: url(../assets/images/church.jpg);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: left;
        background-attachment: fixed;
    }
}
</style>
