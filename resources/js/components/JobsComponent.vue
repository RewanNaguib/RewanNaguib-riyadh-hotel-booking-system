<script>
import axios from "axios";
import Navbar from './NavbarComponent.vue';
import Header from './HeaderComponent.vue';
import Footer from './FooterComponent.vue';

export default {
  components: {
    Navbar,
    Header,
    Footer
  },
  data() {
    return {
      jobData: null,
      selectedJob: null,
      applicant: {
        name: '',
        phone: '',
        email: '',
        coverLetter: '',
        resume: null,
      },
      submittingApplication: false,
      submissionResult: null,
    }
  },
  methods: {
    async fetchData() {
      this.jobData = null;
      const { data } = await axios.get('/api/jobs');
      this.jobData = data.data;
    },
    openModal(card) {
      this.$modal.show('jobModal');
      this.selectedJob = card;
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      this.applicant.resume = file;
    },
    submitApplication(jobId) {
        this.submittingApplication = true;
        this.submissionResult = null;

        const formData = new FormData();
        formData.append('name', this.applicant.name);
        formData.append('phone_number', this.applicant.phone);
        formData.append('email', this.applicant.email);
        formData.append('cover_letter', this.applicant.coverLetter);
        formData.append('resume', this.applicant.resume);

        axios.post(`/api/jobs/${jobId}`, formData)
            .then(response => {
                this.submissionResult = {
                    status: response.data.status,
                    message: response.data.message,
                };

                console.log(this.submissionResult.status, this.submissionResult.message)
            })
            .catch(error => {
                const arraysOfErrors = Object.values(error.response.data.errors);
                const singleArrayOfErrors = [].concat(...arraysOfErrors);
                this.submissionResult = {
                    status: error.response.data.status,
                    errors: singleArrayOfErrors,
                };
            })
            .finally(() => {
                this.submittingApplication = false;
            });
    },
    handleModalClose() {
        this.applicant = {
            name: '',
            phone: '',
            email: '',
            coverLetter: '',
            resume: null,
      };

      this.submissionResult = null;
    },
  },
  mounted() {
    this.fetchData()
  },
};
</script>

<template>
    <div>
        <Header/>
    <div>
        <p v-if="!jobData">Loading...</p>
        <div v-else class="card-list">
            <div class="job-item card" v-for="job in jobData" :key="job.id">
                <h2>{{ job.title }}</h2>
                <p>{{ job.description }}</p>
                <button @click="openModal(job)">Apply</button>
            </div>
        </div>

        <modal name="jobModal" :width="'60%'" :height="'auto'" :scrollable="true" @closed="handleModalClose">
            <div v-if="selectedJob" class="modal">
                <h2>Applying to: '{{ selectedJob.title }}'</h2>
                <div v-if="submissionResult" class="submission-result">
                    <div v-if="submissionResult.status" class="success">
                        {{ submissionResult.message }}
                    </div>
                    <div v-else class="error">
                        <ul>
                            <li v-for="(error, index) in submissionResult.errors" :key="index">{{ error }}</li>
                        </ul>
                    </div>
                </div>
                <form @submit.prevent="submitApplication(selectedJob.id)">
                    <label for="name">Name:</label>
                    <input type="text" v-model="applicant.name" required placeholder="John Doe">

                    <label for="phone">Phone Number:</label>
                    <input type="tel" v-model="applicant.phone" required placeholder="00201119999999">

                    <label for="email">Email:</label>
                    <input type="email" v-model="applicant.email" required placeholder="john.doe@example.com">

                    <label for="cover-letter">Cover Letter:</label>
                    <textarea v-model="applicant.coverLetter" required placeholder="Please insert your letter here..."></textarea>

                    <label for="resume">Resume:</label>
                    <input type="file" @change="handleFileUpload" accept=".pdf, .doc, .docx" required>

                    <div style="margin-bottom: 30px">
                        <button type="submit" :disabled="submittingApplication">Submit Application</button>
                    </div>
                </form>
            </div>
        </modal>

    </div>
        <Footer/>
    </div>
</template>

<!-- JobsComponent Styles -->
<style scoped>
.card-list {
  max-width: 800px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  font-family: 'Your Font', sans-serif;
}

.job-item {
  background-color: #f5f5f5;
  border: 1px solid #ddd;
  padding: 15px;
  margin: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
  font-family: 'Your Font', sans-serif;
}

h2 {
  color: #333;
}

p {
  color: #666;
}

button {
  font-family: 'Your Font', sans-serif;
  background-color: #4CAF50; /* Green color, you can change this */
  color: white;
  padding: 8px 16px;
  border: none;
  cursor: pointer;
  border-radius: 3px;
}

button:hover {
  background-color: #45a049; /* Darker green on hover */
}

button:disabled {
  background-color: #78a2b8; /* Gray color for disabled state */
  cursor: unset;
}

.modal {
  padding: 20px;
  position: relative;
  font-family: 'Your Font', sans-serif;
}

form {
  margin-top: 20px;
  font-family: 'Your Font', sans-serif;
}

label {
  display: block;
  margin-bottom: 5px;
  font-family: 'Your Font', sans-serif;
}

input,
textarea {
  padding: 8px;
  margin-bottom: 10px;
  width: 100%;
  font-family: 'Your Font', sans-serif;
}

.submission-result {
  margin-top: 10px;
  border-radius: 5px;
  font-family: 'Your Font', sans-serif;
}

.submission-result .success {
  background-color: #d4edda;
  color: #155724;
  padding: 10px;
}

.submission-result .error {
  background-color: #f8d7da;
  color: #721c24;
  padding: 10px;
}
</style>
