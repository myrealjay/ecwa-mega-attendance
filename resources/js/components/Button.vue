<template>
    <button  @click="$emit('buttonClicked')" :class="'btn btn-'+(color ? color : 'warning')">
        <i :class="'mdi '+icon"></i>
        {{text}}
    </button>
</template>

<script lang="ts">
export default {
    props:['color','text','icon']
}
</script>

<style>
    
</style>