<template>
    <div class="form-group">
        <label for="amount">{{ label }}</label>
        <input
            type="text"
            :value="modelValue"
            class="form-control"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <span class="Formerror" v-if="error">{{ error }}</span>
    </div>
</template>

<script>
export default {
    props: ["modelValue", "error", "label"],
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
input {
    border-radius: 8px !important;
}
.Formerror {
    color: rgb(242, 81, 11);
}
</style>
