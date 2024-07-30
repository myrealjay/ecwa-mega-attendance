<template>
    <div :class="`count-container ${color ? color : 'blue'}`">
        <div class="count">{{ count }}</div>
        <div class="name">{{ name }}</div>
    </div>
</template>

<script>
export default {
    props: ["count", "name", "color"],
}
</script>
<style>
.count-container {
    display:flex;
    justify-content:start;
    width: 100%;
    color: #fff;
    border-radius: 10px;
    font-weight: bold;
    max-width: 400px;
}
.name{
    width: 75%;
    padding:15px;
}
.count {
    width: 25%;
    padding:15px;
}

.green {
    background-color: #3b8a44;
    font-weight: bold;
    color:#0d0d0d;
}
.green .count {
    background-color: #3a6b3f;
    font-weight: bold;
}
.blue {
    background-color: #2255a8;
}
.blue .count {
    background-color: #1a3d75;
}

.red {
    background-color: #cf7548;
}
.red .count {
    background-color: #b3440c;
}

.yellow {
    background-color: #dbd032;
    color:#262424;
}

.yellow .count {
    background-color: #9e9623;
    color:#262424;
}
</style>