<template>
  <div
    v-if="showModal"
    class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50"
  >
    <div class="bg-white p-6 rounded-lg w-96">
      <h3 class="text-xl font-semibold mb-4">Create New Request</h3>

      <!-- User ID Input -->
      <div class="mb-4">
        <input
          id="user_id"
          v-model="newRequest.user_id"
          type="hidden"
          class="w-full p-2 border border-gray-300 rounded-md"
          placeholder="Enter User ID"
        />
      </div>

      <!-- Requested Amount Input -->
      <div class="mb-4">
        <label for="requested_amount" class="block text-gray-700">Requested Amount</label>
        <input
          id="requested_amount"
          v-model="newRequest.requested_amount"
          type="number"
          step="0.01"
          class="w-full p-2 border border-gray-300 rounded-md"
          placeholder="Enter Requested Amount"
          required
        />
      </div>

      <!-- Reason Input -->
      <div class="mb-4">
        <label for="reason" class="block text-gray-700">Reason</label>
        <textarea
          id="reason"
          v-model="newRequest.reason"
          rows="3"
          class="w-full p-2 border border-gray-300 rounded-md"
          placeholder="Enter Reason"
          required
        ></textarea>
      </div>

      <!-- Title Input -->
      <div class="mb-4">
        <label for="title" class="block text-gray-700">Title</label>
        <input
          id="title"
          v-model="newRequest.title"
          type="text"
          class="w-full p-2 border border-gray-300 rounded-md"
          placeholder="Enter Title"
        />
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-end gap-4">
        <button
          @click="submitRequest"
          :disabled="isSubmitting"
          class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
        >
          Create
        </button>
        <button
          @click="closeModal"
          class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded"
        >
          Cancel
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    showModal: {
      type: Boolean,
      required: true,
    },
    isSubmitting: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      newRequest: {
        user_id: this.authUserId,
        requested_amount: null,
        reason: '',
        title: '',
      },
    };
  },
  methods: {
    submitRequest() {
      this.$emit('create-request', { ...this.newRequest });
    },
    closeModal() {
      this.$emit('close-modal');
    },
  },
};
</script>

<style scoped>
/* Add any necessary modal styling */
</style>
