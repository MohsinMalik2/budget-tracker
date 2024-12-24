<template>
  <div>
    <h1>Submit a Request Amount</h1>
    <form @submit.prevent="submitRequest">
      <div>
        <label for="name">Event Name</label>
        <input v-model="requestAmount.name" type="text" id="name" required />
      </div>
      <div>
        <label for="amount">Requested Amount</label>
        <input v-model="requestAmount.amount" type="number" id="amount" required min="0.01" step="0.01" />
      </div>
      <div>
        <label for="reason">Reason</label>
        <textarea v-model="requestAmount.reason" id="reason" required></textarea>
      </div>
      <button type="submit">Submit Request</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      requestAmount: {
        name: "",
        amount: "",
        reason: "",
      },
    };
  },
  methods: {
    async submitRequest() {
      try {
        await axios.post("/request-amounts", this.requestAmount);
        alert("Request submitted successfully.");
        this.$router.push({ name: "request_amounts.index" });
      } catch (error) {
        console.error(error);
        alert("There was an error submitting your request.");
      }
    },
  },
};
</script>
