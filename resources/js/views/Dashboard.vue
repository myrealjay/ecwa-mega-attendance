<template>
    <div>
        <div className="board_upper">
            <div>
                <h1>
                    Welcome back, {{ currentUser.first_name }}
                    <font-awesome-icon icon="fa-solid fa-hand" class="hand" />
                </h1>
                <p>
                    To register a new church member in the portal, please fill
                    out the required member details in the registration form and
                    click the 'Submit' button to complete the process.
                </p>
            </div>

            <div class="bible">
                <img src="../assets/images/church.jpg" alt="logo" />
            </div>
        </div>

        <div class="line"></div>

        <div> <h4>Attendance for the last 4 weeks</h4></div>
        <div class="row charts">
            <div class="col-md-4">
                <Bar v-if="chartData"
                    id="my-chart-id"
                    :options="chartOptions"
                    :data="chartData"
                />
            </div>

            <div class="col-md-4">
                <Line v-if="chartData"
                    id="my-chart-id"
                    :options="chartOptions"
                    :data="chartData"
                />
            </div>

            <div class="col-md-4">
                <Pie v-if="chartData"
                    id="my-chart-id"
                    :options="chartOptions"
                    :data="chartData"
                />
            </div>
           
        </div>
    </div>
</template>

<script lang="ts">
import Button from "../components/Button.vue";
import Modal from "../components/Modal.vue";
import TextField from "../components/TextField.vue";
import TextAreaField from "../components/TextAreaField.vue";
import EmailField from "../components/EmailField.vue";
import DateTimeField from "../components/DateTimeField.vue";
import SingleSelect from "../components/SingleSelect.vue";
import { Bar, Line, Pie, Bubble , Doughnut} from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale ,ArcElement,
  PointElement,
  LineElement,} from 'chart.js'
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement, PointElement, LineElement)

export default {
    mounted() {
        this.makeRequest("GET", this.endpoints.getCategories)
            .then((response) => {
                this.categories = response.data.data;
            })
            .catch((error) => {
                console.log(error.response);
            });

        this.makeRequest("GET", this.endpoints.last4Sundays)
        .then((response) => {
            let labels = [];
            let data = [];
            let backgroundColors = ['#3252a8', '#33898f', '#DD1B16', '#41B883']
            let usedColors = [];

            let counter = 0;
            response.data.data.forEach(item => {
                labels.push(item.date);
                data.push(item.total);
                usedColors.push(backgroundColors[counter]);
                counter++;
            });

            this.chartData = {
                labels,
                datasets:[
                    {
                        label: '',
                        backgroundColor: usedColors,
                        data
                    }
                ]
            }
        })
        .catch((error) => {
            console.log(error.response);
            });
    },
    data() {
        return {
            errors: {},
            categories: [],
            userStructure: {},
            chartData: null,
            chartOptions: {
                responsive: true
            }
        };
    },
    methods: {
    },
    components: {
        Button,
        Modal,
        TextField,
        EmailField,
        DateTimeField,
        SingleSelect,
        TextAreaField,
        Bar,
        Line,
        Pie,
        Bubble,
        Doughnut
    },
    computed: {
        currentUser() {
            return this.$store.state.currentUser;
        },
    }
};
</script>

<style scoped>
.container-fluid {
    background: url(../assets/images/ecwa.png);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
}
.content-wrapper {
    background-color: rgba(0, 0, 0, 0.7);
}
.font-weight-dark {
    color: rgb(111, 108, 108);
}
.auth-form-light > h4 {
    font-size: 28px;
}
h4 {
    text-align: center;
}
.brand-logo {
    display: flex;
    justify-content: center;
}
.error {
    color: #ff0000;
    text-align: center;
}
.board_upper {
    display: flex;
    justify-content: space-between;
    padding: 20px;
    background-color: #073883;
    color: #fff;
    border-radius: 16px;
    margin-bottom: 20px;
}
.line {
    height: 5px;
    background-color: #073883;
    margin-bottom: 15px;
}
.board_upper > div > h1 {
    text-align: left;
    font-size: 50px;
    font-weight: 700;
    text-transform: capitalize;
}
.board_upper > div > p {
    color: #e7bebe;
}
.hand {
    color: gold;
}
.bible > img {
    background-color: #073883;
    width: 90%;
    height: 80%;
    border-radius: 8px;
}
@media screen and (max-width: 900px) {
    .board_upper {
        padding: 10px;
    }
    .board_upper > h1 {
        font-size: 20px;
        word-wrap: break-word;
    }
}
</style>
