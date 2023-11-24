<template>
    <div class="modal" v-if="showModal">
        <div class="modal-content">
            <p>{{ modalMessage }}</p>
            <button @click="closeModal">Close</button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        showModal: Boolean,
        modalMessage: String,
    },
    methods: {
        closeModal() {
            this.$emit('close-modal');
        },
    },
};
</script>

<style scoped>
.modal {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    text-align: center;
}

button {
    padding: 10px 20px;
    margin-top: 10px;
    cursor: pointer;
}
</style>
