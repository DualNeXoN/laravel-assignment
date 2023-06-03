<template>
    <div class="modal fade" id="deleteDialog" tabindex="-1" role="dialog" aria-labelledby="deleteDialogLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteDialogLabel">{{ messageTitle }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ messageBody }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" @click="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
export default {
    methods: {
        confirmDelete() {
            this.$emit('confirm-delete');
        }
    },
    props: ['messageTitle', 'messageBody'],
}
</script>
  
<style>
.modal {
    color: black;
}
</style>
  