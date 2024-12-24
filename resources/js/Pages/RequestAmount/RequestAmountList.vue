<template>
  <div>
    <h1>Your Request Amounts</h1>
    <ul>
      <li v-for="request in requestAmounts" :key="request.id">
        <div>
          <strong>{{ request.name }}</strong>
          <p>Amount: {{ request.amount }}</p>
          <p>Status: {{ request.status }}</p>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      requestAmounts: [],
    };
  },
  mounted() {
    this.fetchRequestAmounts();
  },
  methods: {
    async fetchRequestAmounts() {
      try {
        const response = await axios.get("/request-amounts");
        this.requestAmounts = response.data;
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>
