<template>
    <div class="wrapper">
        <div class="auth-container">
            <h2>Create New Account</h2>
            <form @submit.prevent="register">
                <label for="name">Name:</label>
                <input type="text" v-model="name" required />

                <label for="email">Email:</label>
                <input type="email" v-model="email" required />

                <label for="password">Password:</label>
                <input type="password" v-model="password" required />

                <button type="submit">Register</button>
            </form>
            <div v-if="registrationError" class="error-message">{{ registrationError }}</div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            registrationError: null,
        };
    },
    methods: {
        async register() {
            console.log('register');
            try {
                const response = await axios.post('/api/auth/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                });
                this.registrationError = null;
                localStorage.setItem('api_token', response.data.token);
                window.location.href = '/riyadh-hotel';
            } catch (error) {
                this.registrationError = 'Registration failed. Please try again.';
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

form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

label {
    font-weight: bold;
}

input {
    padding: 10px;
    border: 1px solid #2c3e50; /* Dark border color */
    border-radius: 3px;
    color: #2c3e50; /* Dark text color */
}

button {
    padding: 12px;
    background-color: #28a745; /* Green button color */
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

button:hover {
    background-color: #218838; /* Darker green on hover */
}

.error-message {
    color: #e74c3c; /* Red error message color */
    margin-top: 10px;
}
</style>
