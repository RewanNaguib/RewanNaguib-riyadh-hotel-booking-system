<script>
import axios from 'axios';
import Navbar from './NavbarComponent.vue';
import Header from './HeaderComponent.vue';
import Footer from './FooterComponent.vue';
import Pagination from './Pagination.vue'; // Import the new Pagination component

export default {
    components: {
        Navbar,
        Header,
        Footer,
        Pagination,
    },
    data() {
        return {
            rooms: null,
            currentPage: 1,
            itemsPerPage: 10,
        };
    },
    computed: {
        totalPages() {
            return Math.ceil((this.rooms ? this.rooms.length : 0) / this.itemsPerPage);
        },
        paginatedRooms() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.rooms ? this.rooms.slice(start, end) : [];
        },
    },
    methods: {
        async fetchRooms() {
            this.rooms = null;
            try {
                const { data } = await axios.get('/api/rooms');
                this.rooms = data.data;
            } catch (error) {
                console.error('Error fetching rooms:', error);
            }
        },
        async bookRoom(roomId) {
            try {
                const { data } = await axios.post(`/api/rooms/${roomId}/book`, null, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('api_token')}`
                    }
                }).catch(error => {
                    if (error.response.status === 417) {
                        alert(error.response.data.message);
                    } else if (error.response.status === 401) {
                        alert('Please login first before booking the room.');
                    }
                });

                if (data) {
                    alert(data.message);
                    this.fetchRooms();
                };
            } catch (error) {
                console.error('Error booking room:', error);
                
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage += 1;
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage -= 1;
            }
        },
    },
    mounted() {
        this.fetchRooms()
    },
}
</script>


<template>
    <div>
        <Header />
        <div class="main-page">
            <div class="room-list">
                <div v-for="room in paginatedRooms" :key="room.id" class="room">
                    <img :src="'/storage/' + room.image" alt="Room Image" class="room-image" />
                    <div class="room-details">
                        <h2 class="room-type">{{ room.type }} room.</h2>
                        <p class="room-status" :class="{ 'status-available': room.status === 'available', 'status-booked': room.status === 'booked', 'status-pending': room.status === 'pending' }">{{ room.status }}</p>
                        <p class="room-price">{{ room.price }} SAR per night.</p>
                        <button @click="bookRoom(room.id)" class="book-button">Book Now</button>
                    </div>
                </div>
            </div>
            <Pagination :currentPage="currentPage" :totalPages="totalPages" :prevPage="prevPage" :nextPage="nextPage" />
        </div>
        <Footer />
    </div>
</template>

<!-- RoomsListComponent Styles -->
<style scoped>
.main-page {
    font-family: 'Your Font', sans-serif;
    padding: 20px;
    background-color: #f5f5f5;
}

.room-list {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.room {
    border: 1px solid #ccc;
    width: 100%;
    margin: 10px 0;
    text-align: center;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.room-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.room-details {
    padding: 10px;
}

.room button {
    margin-top: 10px;
}

.room-type {
    font-size: 24px;
    margin-bottom: 10px;
}

.room-status, .room-price {
    font-size: 18px;
    margin-bottom: 10px;
}

.book-button {
    background-color: #4CAF50;
    color: #fff;
    font-size: 18px;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.book-button:hover {
    background-color: #45a049;
}

.status-available {
    color: green;
}

.status-booked {
    color: red;
}

.status-pending {
    color: orange;
}
</style>

