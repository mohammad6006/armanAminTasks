<template>
  <div>
    <div>
      <input type="text" v-model="searchQuery" placeholder="Search movies">
      <button @click="searchMovies">Search</button>
    </div>
    <div v-if="loading">Loading...</div>
    <div v-else>
      <ul>
        <li v-for="movie in movies" :key="movie.id">
          {{ movie.title }}
        </li>
      </ul>
      <div>
        <button :disabled="currentPage === 1" @click="previousPage">Previous</button>
        <span>{{ currentPage }}</span>
        <button :disabled="currentPage === totalPages" @click="nextPage">Next</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      searchQuery: '',
      movies: [],
      currentPage: 1,
      totalPages: 1,
      loading: false
    };
  },
  methods: {
    searchMovies() {
      this.currentPage = 1;
      this.fetchMovies();
    },
    fetchMovies() {
      this.loading = true;

      axios.post('/api/searchMovie', {
          q: this.searchQuery,
          page: this.currentPage
      })
      .then(response => {
        this.movies = response.data.data;
        this.totalPages = response.data.metadata.page_count;
        this.loading = false;
      })
      .catch(error => {
        console.error(error);
        this.loading = false;
      });
    },
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.fetchMovies();
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
        this.fetchMovies();
      }
    }
  }
};
</script>
