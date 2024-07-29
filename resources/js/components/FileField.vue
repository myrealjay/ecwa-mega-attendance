<template>
    <div class="form-group">
        <label for="file-upload">{{ label }}</label>
        <input type="file" class="form-control" @change="validateFile" />
        <span class="Formerror" v-if="error">{{ error }}</span>
    </div>
</template>

<script>
export default {
    props: ["modelValue", "error", "label"],
    emits: ["update:modelValue"],
    data() {
        return {
            error: this.error || "", // Ensure error is defined
        };
    },
    methods: {
        validateFile(event) {
            const file = event.target.files[0];
            if (file) {
                const allowedTypes = ["image/jpeg", "image/jpg", "image/png"];
                if (!allowedTypes.includes(file.type)) {
                    this.error =
                        "The picture must be a file of type: jpg, jpeg, png.";
                } else {
                    this.error = "";
                    this.$emit("update:modelValue", file);
                }
            } else {
                this.error = "No file selected.";
            }
        },
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
