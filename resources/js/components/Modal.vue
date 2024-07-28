<template>
    <div
        class="modal fade"
        :id="id"
        :data-backdrop="notStatic ?? 'static'"
        data-keyboard="false"
        tabindex="-1"
        aria-labelledby="staticBackdropLabel"
        aria-hidden="true"
    >
        <div :class="`modal-dialog ${large ? 'modal-lg' : ''}`">
            <div class="modal-content">
                <div
                    :class="
                        'modal-header modal-header-' +
                        (color ? color : 'default')
                    "
                >
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <img
                            src="../assets/images/megalogo.jpg"
                            alt="logo"
                            style="width: 30px"
                        />
                        {{ title }}
                    </h5>
                    <button
                        v-if="xIcon"
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
                <div class="modal-footer">
                    <Button
                        icon="mdi-close-circle"
                        text="Cancel"
                        @buttonClicked="$emit('closed')"
                    />
                    <slot name="buttons"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Button from "./Button.vue";
export default {
    props: ["id", "title", "open", "color", "xIcon", "notStatic", "large"],
    watch: {
        open: function (newVal, oldVal) {
            console.log("changed", newVal);
            if (newVal) {
                $(`#${this.id}`).modal("show");
            } else {
                $(`#${this.id}`).modal("hide");
            }
        },
    },
    components: { Button },
};
</script>

<style scoped>
.modal-title {
    color: #f5f4f9;
}
.modal-header {
    background-color: ;
}
.modal-header-success {
    color: #fff;
    padding: 9px 15px;
    border-bottom: 1px solid #eee;
    background-color: #5cb85c;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}
.modal-header-warning {
    color: #fff;
    padding: 9px 15px;
    border-bottom: 1px solid #eee;
    background-color: #f0ad4e;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}
.modal-header-danger {
    color: #fff;
    padding: 9px 15px;
    border-bottom: 1px solid #eee;
    background-color: #d9534f;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}
.modal-header-info {
    color: #fff;
    padding: 9px 15px;
    border-bottom: 1px solid #eee;
    background-color: #5bc0de;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}
.modal-header-primary {
    color: #fff;
    padding: 9px 15px;
    border-bottom: 1px solid #eee;
    background-color: #428bca;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}

.modal-header-default {
    color: #fff;
    padding: 9px 15px;
    border-bottom: 1px solid #eee;
    background-color: #a9a7e4;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}

.modal-content {
    background-color: #f4f7fe;
}
.modalLogo {
    width: 100px;
}
</style>
