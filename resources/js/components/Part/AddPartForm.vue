<template>
    <div>
        <form @submit.prevent="addPart"
            style="border: 2px solid black; border-radius: 10px; background-color: white; padding: 10px; margin: 5px">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" v-model="part.name" required>
            </div>
            <div class="form-group">
                <label for="serial_number">Serial Number:</label>
                <input type="text" class="form-control" id="serial_number" v-model="part.serialnumber" required>
            </div>
            <div class="form-group">
                <label for="car_id">Car:</label>
                <select class="form-control" id="car_id" v-model="part.car_id">
                    <option value="">Select a car</option>
                    <option v-for="car in cars" :key="car.id" :value="car.id">{{ car.name }}</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">Create</button>
        </form>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            part: {
                name: '',
                serialnumber: '',
                car_id: ''
            },
            cars: []
        };
    },
    mounted() {
        this.fetchCars();
    },
    methods: {
        addPart() {
            axios.post('/api/parts/add', this.part)
                .then(response => {
                    this.clearFormFields();
                    this.$emit('part-created');
                })
                .catch(error => {
                    alert('Invalid data');
                });
        },
        clearFormFields() {
            this.part.name = '';
            this.part.serialnumber = '';
            this.part.car_id = '';
        },
        fetchCars() {
            axios.get('/api/cars')
                .then(response => {
                    this.cars = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
}
</script>
  