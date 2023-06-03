<template>
    <form @submit.prevent="addCar"
        style="border: 2px solid black; border-radius: 10px; background-color: white; padding: 10px; margin: 5px">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" v-model="car.name" required>
        </div>
        <div class="form-group">
            <label for="registration_number">Registration Number:</label>
            <input type="number" class="form-control" id="registration_number" v-model="car.registration_number"
                :required="car.is_registered">
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="is_registered" v-model="car.is_registered">
            <label class="form-check-label" for="is_registered">Is Registered</label>
        </div>
        <button type="submit" class="btn btn-success w-100">Create</button>
        <div v-if="!isValidName || !isValidRegistrationNumber" class="text-danger">
            Please enter valid data in all required fields.
        </div>
    </form>
</template>

<script>
export default {
    data() {
        return {
            car: {
                name: '',
                registration_number: '',
                is_registered: false
            },
            isValidName: true,
            isValidRegistrationNumber: true
        };
    },
    methods: {
        addCar() {
            this.isValidRegistrationNumber = !this.car.is_registered || /^[0-9]+$/.test(this.car.registration_number);

            if (this.isValidName && this.isValidRegistrationNumber) {
                axios.post('/api/cars/add', this.car)
                    .then(response => {
                        this.clearFormFields();
                        this.$emit('car-created');
                    })
                    .catch(error => {
                        alert('Invalid data');
                    });
            }
        },
        clearFormFields() {
            this.car.name = '';
            this.car.registration_number = '';
            this.car.is_registered = false;
        }
    }
}
</script>
