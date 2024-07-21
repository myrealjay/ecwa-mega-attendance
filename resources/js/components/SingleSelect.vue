<template>
    <div class="form-group">
    <label v-if="label">{{label}}</label>
    <select :value="modelValue" 
        class="js-example-basic-single w-100 form-control"
        @input="$emit('update:modelValue', $event.target.value)"
    >
        <option :value="''">Select an option ..</option>
        <option v-for="(option,i) in options" :key="i" :value="option[custom_value]">{{ getText(option) }}</option>
    </select>
    <span class="Formerror" v-if="error" >{{error}}</span>
    </div>
</template>

<script lang="ts">
import { isArray } from '@vue/shared';

export default {
    props: ['modelValue','error','label','text','custom_value','options', 'custom_text'],
    emits: ['update:modelValue'],
    methods: {
        getText(option) {
            if (this.custom_text) {
                return this.custom_text;
            }

            if (isArray(this.text)) {
                let text = '';
                this.text.forEach(item => {
                    text += ' '+ option[item];
                })
                return text.trim();
            }

            return option[this.text];
        }
    }
}
</script>

<style scoped>
    label {
        color:#555252;
    }
    .Formerror {
        color:rgb(242, 81, 11);
    }
</style>