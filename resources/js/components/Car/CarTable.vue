<template>
  <div>
    <div class="filter-container">
      <div>
        <label>
          <input type="checkbox" v-model="filter.nameFilterEnabled">
          Name:
        </label>
        <input type="text" v-model="filter.name" placeholder="Name" class="form-control"
          :disabled="!filter.nameFilterEnabled">
      </div>
      <div>
        <label>
          <input type="checkbox" v-model="filter.registrationNumberFilterEnabled">
          Registration number:
        </label>
        <input type="number" v-model="filter.registrationNumber" placeholder="Registration number" class="form-control"
          :disabled="!filter.registrationNumberFilterEnabled">
      </div>
      <div>
        <label>
          <input type="checkbox" v-model="filter.isRegisteredFilterEnabled">
          Registered:
        </label>
        <select v-model="filter.isRegistered" class="form-control" :disabled="!filter.isRegisteredFilterEnabled">
          <option value="">Any</option>
          <option value="1">Yes</option>
          <option value="0">No</option>
        </select>
      </div>
      <button @click="applyFilter" class="btn btn-primary">Apply Filter</button>
      <button @click="resetFilter" class="btn btn-danger">Reset Filter</button>
    </div>
    <div v-if="loading">
      <loading-spinner></loading-spinner>
    </div>
    <div class="table-responsive" v-else>
      <table class="table table-sm table-striped table-dark">
        <thead>
          <tr>
            <th>Name</th>
            <th>Registration number</th>
            <th>Registered</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="cars.length === 0">
            <td colspan="5">No car records in database</td>
          </tr>
          <tr v-for="car in cars" :key="car.id">
            <td>
              <template v-if="car.isEditing">
                <input type="text" v-model="car.name">
              </template>
              <template v-else>
                {{ car.name }}
              </template>
            </td>
            <td>
              <template v-if="car.isEditing">
                <input type="number" v-model="car.registration_number">
              </template>
              <template v-else>
                {{ car.registration_number != null ? car.registration_number : '-' }}
              </template>
            </td>
            <td>
              <template v-if="car.isEditing">
                <input type="checkbox" v-model="car.is_registered">
              </template>
              <template v-else>
                {{ car.is_registered ? 'Yes' : 'No' }}
              </template>
            </td>
            <td class="text-right">
              <button type="button" class="btn btn-primary w-20" @click="showPartsDialog(car)"
                :data-target="`#carPartsModal-${car.id}`" data-toggle="modal">Parts</button>
              <template v-if="!car.isEditing">
                <button type="button" class="btn btn-info w-20" @click="toggleEdit(car)">Edit</button>
              </template>
              <template v-else>
                <button type="button" class="btn btn-success w-20" @click="saveChanges(car)">Save</button>
              </template>
              <button type="button" class="btn btn-danger w-20" data-toggle="modal" data-target="#deleteDialog"
                @click="showDeleteDialog(car)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <delete-dialog messageTitle="Delete Car" messageBody="Are you sure you want to delete this car?"
      @confirm-delete="deleteCar"></delete-dialog>
    <car-parts-modal :car="selectedCar" :availableParts="availableParts" v-if="selectedCar != null"
      @close-dialog="closePartsDialog" :key="`carPartsModal-${selectedCar.id}`"></car-parts-modal>


  </div>
</template>

<script>
import DeleteDialog from '../Utility/DeleteDialog.vue';
import CarPartsModal from './CarPartsModal.vue';

export default {
  data() {
    return {
      cars: [],
      loading: false,
      selectedCar: null,
      availableParts: [],
      filter: {
        name: '',
        registrationNumber: '',
        isRegistered: ''
      }
    };
  },
  mounted() {
    this.fetchCars();
  },
  methods: {
    fetchCars() {
      this.loading = true;
      axios.get('/api/cars')
        .then(response => {
          this.cars = response.data.map(car => {
            return {
              ...car,
              isEditing: false,
            };
          });
          this.loading = false;
        })
        .catch(error => {
          console.error(error);
          this.loading = false;
        });
    },
    showDeleteDialog(car) {
      this.selectedCar = car;
      this.selectedCarId = car.id;
    },
    deleteCar() {
      axios.delete(`/api/cars/${this.selectedCar.id}`)
        .then(response => {
          this.fetchCars();
        })
        .catch(error => {
          console.error(error);
        });
    },
    toggleEdit(car) {
      car.isEditing = !car.isEditing;
    },
    saveChanges(car) {
      if (car.is_registered && !car.registration_number) {
        alert("Registration number cannot be null when car is registered.");
        return;
      }
      if (car.name.length == 0) {
        alert("Name cannot be null.");
        return;
      }

      axios.put(`/api/cars/${car.id}`, car)
        .then(response => {
          this.fetchCars();
        })
        .catch(error => {
          alert('Invalid data');
        });
    },
    showPartsDialog(car) {
      this.selectedCar = car;

      axios.get('/api/parts')
        .then(response => {
          this.availableParts = response.data.filter(part => part.car_id === null);
        })
        .catch(error => {
          console.error(error);
        });
    },
    closePartsDialog() {
      this.selectedCar = null;
    },
    applyFilter() {
      const filteredCars = this.cars.filter(car => {
        const nameMatch = !this.filter.nameFilterEnabled || car.name.toLowerCase().includes(this.filter.name.toLowerCase());
        const registrationMatch = !this.filter.registrationNumberFilterEnabled || (this.filter.registrationNumber === '' ? car.registration_number === null : car.registration_number?.toString().startsWith(this.filter.registrationNumber));
        const isRegisteredMatch = !this.filter.isRegisteredFilterEnabled || (this.filter.isRegistered === '' || this.filter.isRegistered == car.is_registered.toString());

        return nameMatch && registrationMatch && isRegisteredMatch;
      });
      this.cars = filteredCars;
    },
    resetFilter() {
      this.fetchCars();
    },
  },
  components: {
    DeleteDialog,
    CarPartsModal,
  }
};
</script>

<style>
.w-20 {
  width: 20%;
  min-width: 100px;
}

.filter-container {
  display: flex;
  justify-content: flex-end;
  align-items: end;
  margin-bottom: 10px;
}

.filter-container>div,
button {
  margin: 5px;
}
</style>