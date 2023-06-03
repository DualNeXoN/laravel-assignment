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
          <input type="checkbox" v-model="filter.serialNumberFilterEnabled">
          Serial Number:
        </label>
        <input type="text" v-model="filter.serialNumber" placeholder="Serial Number" class="form-control"
          :disabled="!filter.serialNumberFilterEnabled">
      </div>
      <div>
        <label>
          <input type="checkbox" v-model="filter.carFilterEnabled">
          Car:
        </label>
        <select v-model="filter.car" class="form-control" :disabled="!filter.carFilterEnabled">
          <option value="">Any</option>
          <option v-for="car in cars" :key="car.id" :value="car.id">{{ car.name + " (" + (car.registration_number
            ? car.registration_number : "-") + ")" }}</option>
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
            <th>Serial Number</th>
            <th>Car</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="parts.length === 0">
            <td colspan="5">No part records in database</td>
          </tr>
          <tr v-for="part in parts" :key="part.id">
            <td>
              <template v-if="part.isEditing">
                <input type="text" v-model="part.name">
              </template>
              <template v-else>
                {{ part.name }}
              </template>
            </td>
            <td>
              <template v-if="part.isEditing">
                <input type="text" v-model="part.serialnumber">
              </template>
              <template v-else>
                {{ part.serialnumber }}
              </template>
            </td>
            <td>
              <template v-if="part.isEditing">
                <select v-model="part.car_id" class="form-control">
                  <option value="-1">Select a car</option>
                  <option v-for="car in cars" :key="car.id" :value="car.id">{{ car.name + " (" + (car.registration_number
                    ? car.registration_number : "-") + ")" }}</option>
                </select>
              </template>
              <template v-else>
                {{ part.car ? (part.car.name + " (" + (part.car.registration_number ? part.car.registration_number : "-")
                  + ")") : '' }}
              </template>
            </td>
            <td class="text-right">
              <template v-if="!part.isEditing">
                <button type="button" class="btn btn-info w-20" @click="toggleEdit(part)">Edit</button>
              </template>
              <template v-else>
                <button type="button" class="btn btn-success w-20" @click="saveChanges(part)">Save</button>
              </template>
              <button type="button" class="btn btn-danger w-20" data-toggle="modal" data-target="#deleteDialog"
                @click="showDeleteDialog(part)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <delete-dialog messageTitle="Delete Part" messageBody="Are you sure you want to delete this part?"
      @confirm-delete="deletePart"></delete-dialog>


  </div>
</template>

<script>
import DeleteDialog from '../Utility/DeleteDialog.vue';

export default {
  data() {
    return {
      parts: [],
      loading: false,
      filter: {
        name: '',
        serialNumber: '',
        car: '',
        carFilterEnabled: false,
      },
      cars: [],
    };
  },
  mounted() {
    this.fetchParts();
    this.fetchCars();
  },
  methods: {
    fetchParts() {
      this.loading = true;
      axios.get('/api/parts')
        .then(response => {
          this.parts = response.data.map(part => {
            return {
              ...part,
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
    fetchCars() {
      axios.get('/api/cars')
        .then(response => {
          this.cars = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    showDeleteDialog(part) {
      this.selectedPart = part;
      this.selectedPartId = part.id;
    },
    deletePart() {
      axios.delete(`/api/parts/${this.selectedPart.id}`)
        .then(response => {
          this.fetchParts();
        })
        .catch(error => {
          console.error(error);
        });
    },
    toggleEdit(part) {
      part.isEditing = !part.isEditing;
    },
    saveChanges(part) {
      if (part.car_id == -1) {
        part.car_id = null;
      }

      axios.put(`/api/parts/${part.id}`, part)
        .then(response => {
          this.fetchParts();
        })
        .catch(error => {
          alert('Invalid data');
        });
    },
    applyFilter() {
      const filteredParts = this.parts.filter(part => {
        const nameMatch = !this.filter.nameFilterEnabled || part.name.toLowerCase().includes(this.filter.name.toLowerCase());
        const serialNumberMatch = !this.filter.serialNumberFilterEnabled || part.serialnumber?.toString().startsWith(this.filter.serialNumber);
        const carMatch = !this.filter.carFilterEnabled || this.filter.car === '' || this.filter.car == part.car_id;

        return nameMatch && serialNumberMatch && carMatch;
      });
      this.parts = filteredParts;
    },
    resetFilter() {
      this.filter = {
        name: '',
        serialNumber: '',
        car: '',
        carFilterEnabled: false,
      };
      this.fetchParts();
    },
  },
  components: {
    DeleteDialog,
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