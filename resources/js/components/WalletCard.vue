<template>
    <div class="wallet">
        <div :class="'card '+ getColor()">
            <div class="card-body">
                <p class="mb-4">{{currency}}</p>
                <p class="fs-30 mb-2">{{amount}}</p>
            </div>
        </div>
    </div>
   
</template>

<script lang="ts">
export default {
    props:['amount','currency','color'],
    data() {
        return {
            colors:['card-tale','card-light-blue','card-light-danger','card-dark-blue']
        }
    },
    methods:{
        getColor() {
            if (this.color) return this.color;

            let index = Math.floor(Math.random() * ((this.colors.length -1) - 0) + 0);
            return this.colors[index];
        }
    }
}
</script>
<style scoped>
    .wallet{
        min-width:250px;
    }

    @media only screen and (max-width:768px) {
        .wallet{
            min-width:100%;
        }
    }
</style>