<template>
    <div>
      <div class="setting-group">
        <h4>Age Settings</h4>
        <div class="setting-item">
            <TextField
                label="Min Age"
                v-model="age.min_age"
                :error="
                    errors.min_age
                        ? errors.min_age[0]
                        : ''
                "
            />
            <TextField
                label="Max Age"
                v-model="age.max_age"
                :error="
                    errors.max_age
                        ? errors.max_age[0]
                        : ''
                "
            />

            <Button color="primary" text="Save" @buttonClicked="saveAge()"/>
        </div>
      </div>
    </div>
</template>

<script lang="ts">
import { error } from 'console';
 import Button from "../components/Button.vue";
 import TextField from "../components/TextField.vue";
export default {
    components: { TextField, Button },
    created() {
        this.makeRequest('GET', this.endpoints.ageRestrictions)
        .then(response => {
            this.age = response.data.data;
        }).catch(error => {

        })
    },
    data() {
      return {
        age:{
            min_age:'',
            max_age:''
        },
        errors: {},
      }
    },
    methods: {
        saveAge(){
            this.showLoader();
            this.makeRequest('POST', this.endpoints.ageRestrictions, {}, this.age)
            .then(response => {
                this.sweetAlert().success(
                    response.data.message
                );
            })
            .catch(error => {
                if (error.response) {
                        if (!error.response.data.data) {
                            this.sweetAlert().error(
                                error.response.data.message
                            );
                        } else {
                            this.errors = error.response.data.data;
                        }
                    } else {
                        this.sweetAlert().error(error);
                    }
            }).finally(() => {
                this.hideLoader();
            })
        }
    },
    computed: {
     
    }
}
</script>

<style>
    .setting-item {
        width: 300px;
    }
    .setting-group{
        background-color: #f0eded;
        border-radius: 15px;
        padding: 15px;
    }
</style>