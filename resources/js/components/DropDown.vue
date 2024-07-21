<template>
    <div class="dropdown">
    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    {{label ?? 'Actions'}}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <slot>

        </slot>
    </div>
</div>
</template>

<script>
    export default {
        props: ['label'],
        data () {
            return {
                
            }
        }
    }
</script>