<template>
    <div class="row">
        <div class="col-md-12 wallet-container">
            <slot></slot>
        </div>
    </div>
</template>

<style scoped>
    .wallet-container{
        display: flex;
        gap:1rem;
        flex-wrap: wrap;
        padding-bottom: 1rem;
        padding-top:1rem;
    }
</style>