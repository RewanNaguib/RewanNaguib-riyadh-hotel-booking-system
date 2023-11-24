<template>
    <nav class="navbar">
        <div class="navbar-left">
            <h3>Riyadh<span>Hotel</span></h3>
        </div>
        <div class="navbar-right">
            <a href="/riyadh-hotel" class="nav-link">Home</a>
            <a href="/riyadh-hotel/jobs" class="nav-link">Career</a>
            <a v-if="!isLoggedIn" @click="redirectToLogin" class="nav-link">Login</a>
            <a v-if="isLoggedIn" @click="logout" class="nav-link">Logout</a>
        </div>
    </nav>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            isLoggedIn: false,
        };
    },
    methods: {
        redirectToLogin() {
            window.location.href = '/riyadh-hotel/login';
        },
        async logout() {
            this.isLoggedIn = false;
            await axios.post('/api/auth/logout', null, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('api_token')}`
                }
            });
            localStorage.removeItem('api_token');
        },
        async checkLogin() {
            const { data } = await axios.get('/api/user', {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('api_token')}`
                }
            });
            if (data) {
                this.isLoggedIn = true;
            } else {
                this.isLoggedIn = false;
            }
        }
    },
    mounted() {
        this.checkLogin();
    }
};
</script>

<style scoped>
nav.navbar {
    position: sticky;
    top: 0;
}
.navbar {
    background-color: #666;
    color: lightseagreen;
    padding: 10px 120px;
    display: contents;
}

.navbar-left .navbar-title {
    font-size: 24px;
    margin: 0;
}

.navbar-left .navbar-highlight {
    color: lightseagreen;
}

.navbar-right .nav-link {
    margin-left: 15px;
    color: lightseagreen;
    text-decoration: none;
    font-size: 16px;
    font-family: sans-serif;
}

.navbar-right .nav-link:hover {
    text-decoration: underline;
}

.navbar .navbar-left h3{
    color:  #ffffff;
    font: normal 36px 'Open Sans', cursive;
    margin: 0;
}

.navbar .navbar-left h3 span{
    color:  lightseagreen;
}
</style>
