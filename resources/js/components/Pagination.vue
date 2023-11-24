<template>
    <div class="pagination">
        <button @click="prevPage" :disabled="currentPage === 1">Previous</button>
        <span>{{ currentPage }}</span>
        <button @click="nextPage" :disabled="currentPage === totalPages">Next</button>
    </div>
</template>

<script>
export default {
    props: {
        currentPage: {
            type: Number,
            required: true,
        },
        totalPages: {
            type: Number,
            required: true,
        },
        prevPage: Function,
        nextPage: Function,
    },
};
</script>

<style scoped>
.pagination {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
}

button {
    padding: 10px 20px;
    margin: 0 10px;
    cursor: pointer;
}
</style>
