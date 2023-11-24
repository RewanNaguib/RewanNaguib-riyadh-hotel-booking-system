<template>
    <div class="wrapper">
        <div class="auth-container">
            <h2>Login to Riyadh Hotel</h2>
            <form @submit.prevent="login">
                <label for="email">Email:</label>
                <input type="email" v-model="email" required />

                <label for="password">Password:</label>
                <input type="password" v-model="password" required />

                <button type="submit">Login</button>
            </form>
            <div v-if="loginError" class="error-message">{{ loginError }}</div>
            <a href="/riyadh-hotel/register" class="create-account-link">Create New Account</a>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            password: '',
            loginError: null,
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('/api/auth/login', {
                    email: this.email,
                    password: this.password,
                });
                console.log('Login successful:', response.data);
                if (response.data.status) {
                    this.loginError = null;
                    this.$emit('login', true);
                    localStorage.setItem('api_token', response.data.token);
                    window.location.href = '/riyadh-hotel';
                } else {
                    this.loginError = 'Invalid credentials. Please try again.';
                }
                this.$router.push('/riyadh-hotel');
            } catch (error) {
                this.loginError = 'An error occurred. Please try again later.';
            }
        },
    },
};
</script>

<style scoped>
.wrapper {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.auth-container {
    width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #2c3e50; /* Dark border color */
    border-radius: 5px;
    background-color: #34495e; /* Dark background color */
    color: white; /* Text color */
    font-family: sans-serif;
}

h2 {
    text-align: center;
}

form {
    display: flex;
    font-family: SansSerif;
    flex-direction: column;
    gap: 10px;
}

label {
    font-weight: bold;
    font-family: sans-serif;
}

input {
    padding: 10px;
    border: 1px solid #2c3e50; /* Dark border color */
    border-radius: 3px;
    color: #2c3e50; /* Dark text color */
}

button {
    padding: 12px;
    background-color: #3498db; /* Blue button color */
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    font-size: inherit;
}

button:hover {
    background-color: #2980b9; /* Darker blue on hover */
}

.error-message {
    color: #e74c3c; /* Red error message color */
    margin-top: 10px;
}

.create-account-link {
    display: block;
    text-align: center;
    color: #fff;
    margin-top: 10px;
    text-decoration: underline;
    cursor: pointer;
}

.create-account-link:hover {
    color: #e74c3c; /* Darker red on hover */
}
</style>
