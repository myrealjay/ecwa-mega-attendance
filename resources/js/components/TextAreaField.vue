<template>
    <div class="form-group">
        <label for="amount">{{ label }}</label>
        <textarea
            type="text"
            :value="modelValue"
            :rows="rows ? rows : 4"
            :cols="cols ? cols : ''"
            class="form-control"
            @input="$emit('update:modelValue', $event.target.value)"
        ></textarea>
        <span class="Formerror" v-if="error">{{ error }}</span>
    </div>
</template>

<script lang="ts">
export default {
    props: ["modelValue", "error", "label", "rows", "cols"],
    emits: ["update:modelValue"],
    data() {
        return {};
    },
};
</script>

<style scoped>
label {
    color: #555252;
    font-weight: bold;
}
textarea {
    border-radius: 8px !important;
}
.Formerror {
    color: rgb(242, 81, 11);
}
</style>
