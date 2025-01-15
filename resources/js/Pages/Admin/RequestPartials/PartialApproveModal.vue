<template>
  <div
    v-if="showModal"
    class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50"
  >
    <div class="bg-white p-6 rounded-lg w-96">
      <h3 class="text-xl font-semibold mb-4">Partial Approval</h3>

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

      <!-- Approved Amount Input -->
      <div class="mb-4">
        <label for="approve_amount" class="block text-gray-700">Approved Amount (Optional)</label>
        <input
          id="approve_amount"
          v-model="approve_amount"
          type="number"
          min="0"
          class="w-full p-2 border border-gray-300 rounded-md"
          placeholder="Enter approved amount"
        />
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-end gap-4">
        <button
          @click="submitPartialApproval"
          :disabled="isUpdating"
          class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
        >
          Partial Approve
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
      approve_amount: null, // To hold the approved amount
    };
  },
  methods: {
    // Method to handle partial approval submission
    submitPartialApproval() {
      const payload = {
        remarks: this.remarks,
        approve_amount: this.approve_amount !== null ? this.approve_amount : 0, // Handle null as 0
      };
      this.$emit('partial-approve-request', payload); // Emit the payload with remarks and approvedAmount
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
