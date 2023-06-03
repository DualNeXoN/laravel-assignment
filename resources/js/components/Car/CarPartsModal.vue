<template>
    <div class="modal fade" :id="modalId" tabindex="-1" role="dialog" aria-labelledby="carPartsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="carPartsModalLabel">Car Parts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="overflow-auto" style="max-height: 300px;">
                        <ul class="list-group" v-if="car.parts.length > 0">
                            <li v-for="part in car.parts" :key="part.id"
                                class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ part.name }} ({{ part.serialnumber }})</span>
                                <button type="button" class="btn btn-danger btn-sm"
                                    @click="removePart(part.id)">Remove from car</button>
                            </li>
                        </ul>
                        <p v-else>No parts available.</p>
                    </div>
                    <div class="mt-4">
                        <label for="newPartSelect">Add New Part:</label>
                        <select id="newPartSelect" class="form-control" v-model="selectedPart">
                            <option value="">Select Part</option>
                            <option v-for="part in partsList" :key="part.id" :value="part.id">{{ part.name }} ({{ part.serialnumber }})</option>
                        </select>
                        <button type="button" class="btn btn-primary mt-2" @click="addPart">Add Part</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeDialog">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        car: {
            type: Object,
            required: true
        },
        availableParts: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            selectedPart: '',
            partsList: [],
        };
    },
    created() {
        this.fetchCarParts();
    },
    computed: {
        modalId() {
            return `carPartsModal-${this.car.id}`;
        }
    },
    methods: {
        closeDialog() {
            this.$emit('close-dialog');
        },
        removePart(partId) {
            axios.delete(`/api/cars/${this.car.id}/parts/${partId}/remove`)
                .then(response => {
                    this.car.parts = this.car.parts.filter(part => part.id !== partId);
                    axios.get(`/api/parts/${partId}`)
                        .then(response => {
                            this.partsList.push(response.data);
                        })
                })
                .catch(error => {
                    console.error(error);
                });
        },
        addPart() {
            if (this.selectedPart) {
                const index = this.partsList.findIndex(part => part.id === this.selectedPart);
                if (index !== -1) {
                    const newPart = this.partsList.splice(index, 1)[0];
                    axios.post(`/api/cars/${this.car.id}/parts/${newPart.id}/add`)
                        .then(response => {
                            this.car.parts.push(newPart);
                            this.selectedPart = '';
                            this.fetchCarParts();
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }
            }
        },
        fetchCarParts() {
            axios.get(`/api/cars/${this.car.id}/parts`)
                .then(response => {
                    this.car.parts = response.data;
                    this.updatePartsList();
                })
                .catch(error => {
                    console.error(error);
                });
        },
        updatePartsList() {
            const assignedPartIds = this.car.parts.map(part => part.id);
            this.partsList = this.availableParts.filter(part => !assignedPartIds.includes(part.id));
        }
    }
};
</script>
