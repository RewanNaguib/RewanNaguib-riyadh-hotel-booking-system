<script>
import Navbar from './NavbarComponent.vue';

export default {
    components: {
        Navbar
    }
}
</script>

<template>
    <header class="header">
        <div class="header-inner">
            <Navbar />
        </div>
    </header>
</template>

<style scoped>
.header {
    font-family: sans-serif;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1;
    background-color: rgba(102, 102, 102, 0.9);
    padding: 20px 20px;
    box-sizing: border-box;
}

.header-inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-right: 50px;
}

</style>
