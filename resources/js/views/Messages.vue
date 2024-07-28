<template>
    <div>
        <h1>Messages</h1>
        <div class="messages">
            <Message
                title="Title of the Message"
                message=" This is the main content of the message. It can be a few lines
                long and will be displayed in this section of the card."
                category="Category: Information"
            />
            <Message
                title="Title of the Message"
                message=" This is the main content of the message. It can be a few lines
                long and will be displayed in this section of the card."
                category="Category: Information"
            />
            <Message
                title="Title of the Message"
                message=" This is the main content of the message. It can be a few lines
                long and will be displayed in this section of the card."
                category="Category: Information"
            />
            <Message
                title="Title of the Message"
                message=" This is the main content of the message. It can be a few lines
                long and will be displayed in this section of the card."
                category="Category: Information"
            />
            <Message
                title="Title of the Message"
                message=" This is the main content of the message. It can be a few lines
                long and will be displayed in this section of the card."
                category="Category: Information"
            />
            <Message
                title="Title of the Message"
                message=" This is the main content of the message. It can be a few lines
                long and will be displayed in this section of the card."
                category="Category: Information"
            />
            <Message
                title="Title of the Message"
                message=" This is the main content of the message. It can be a few lines
                long and will be displayed in this section of the card."
                category="Category: Information"
            />
        </div>
    </div>
</template>
<script>
import Message from "../components/Message.vue";
export default {
    components: { Message },
};
</script>
<style>
.messages {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-gap: 10px;
}
</style>
