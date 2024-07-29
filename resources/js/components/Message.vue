<template>
    <div class="message-card">
        <div class="card-header">
            <h2 class="card-title">{{ category }}</h2>
        </div>
        <div class="card-body">
            <p class="card-message" v-html="message"></p>
        </div>
        <!-- <div class="card-footer">
            <span class="card-category"> {{ category }} </span>
        </div> -->
    </div>
</template>

<script>
export default {
    props: ["title", "message", "category"],
};
</script>

<style>
.message-card {
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 16px;
    max-width: 400px;
    margin: 20px auto;
    background-color: #fff;
}

.card-header {
    border-bottom: 1px solid #eee;
    padding-bottom: 8px;
    margin-bottom: 16px;
}

.card-title {
    font-size: 1.5em;
    margin: 0;
}

.card-body {
    margin-bottom: 16px;
}

.card-message {
    font-size: 1em;
    line-height: 1.5;
}

.card-footer {
    border-top: 1px solid #eee;
    padding-top: 8px;
}

.card-category {
    font-size: 0.9em;
    color: #666;
}
</style>
