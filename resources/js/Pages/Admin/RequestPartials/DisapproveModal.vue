<template>
  <div
    v-if="showModal"
    class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50"
  >
    <div class="bg-white p-6 rounded-lg w-96">
      <h3 class="text-xl font-semibold mb-4">Disapprove Request</h3>

      <!-- Remarks Input -->
      <div class="mb-4">
        <label for="remarks" class="block text-gray-700">Remarks (Optional)</label>
        <textarea
          id="remarks"
          v-model="remarks"
          rows="4"
          class="w-full p-2 border border-gray-300 rounded-md"
          placeholder="Enter remarks here..."
        ></textarea>
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-end gap-4">
        <button
          @click="submitDisapprove"
          :disabled="isUpdating"
          class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
        >
          Disapprove
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
    isUpdating: {
      type: Boolean,
      required: true,
    },
    requestDetails: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      remarks: '',
    };
  },
  methods: {
    // Method to handle submission of the disapproval
    submitDisapprove() {
      this.$emit('disapprove-request', this.remarks);
    },
    // Method to close the modal
    closeModal() {
      this.$emit('close-modal');
    },
  },
};
</script>

<style scoped>
/* Styles for the modal */
</style>
