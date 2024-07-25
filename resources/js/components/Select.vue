<template>
    <div class="form-group">
        <select @change="onSelectChange" class="form-control">
            <option
                v-for="option in options"
                :key="option.value"
                :value="option.value"
            >
                {{ option.text }}
            </option>
        </select>
        <span class="Formerror" v-if="error">{{ error }}</span>
    </div>
</template>
<script>
export default {
    props: {
        label: {
            type: String,
            default: "Select",
        },
        options: {
            type: Array,
            required: true,
        },
    },
    methods: {
        onSelectChange(event) {
            this.$emit("selection-changed", event.target.value);
        },
    },
};
</script>
<style scoped>
label {
    color: #555252;
    font-weight: bold;
}
select {
    border-radius: 8px !important;
}
.Formerror {
    color: rgb(242, 81, 11);
}
</style>
