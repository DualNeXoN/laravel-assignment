<template>
  <div>

    <div class="row mt-5 justify-content-center">
      <div class="col div-title">
        <span>Cars</span>
      </div>
    </div>

    <div class="row mt-3 justify-content-center">
      <div class="col col-sm-10 col-md-8 col-lg-6 col-xl-4">
        <button class="btn btn-primary w-100" type="button" data-toggle="collapse" data-target="#collapseNewCarRecord"
          aria-expanded="false" aria-controls="collapseNewCarRecord">Add new car</button>
        <div class="collapse" id="collapseNewCarRecord">
          <add-car-form @car-created="eventCarCreated"></add-car-form>
        </div>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col">
        <car-table ref="carTable" v-if="showCarTable"></car-table>
      </div>
    </div>
  </div>
</template>
  
<script>
import AddCarForm from './AddCarForm.vue';
import CarTable from './CarTable.vue';

export default {
  data() {
    return {
      showCarTable: false,
    };
  },
  mounted() {
    this.showCarTable = true;
    this.$nextTick(() => {
      this.$refs.carTable.fetchCars();
    });
  },
  methods: {
    eventCarCreated() {
      this.$refs.carTable.fetchCars();
    },
  },
  components: {
    AddCarForm,
    CarTable,
  },
};
</script>
  
<style>
.div-title>span {
  font-size: 2rem;
  font-weight: bold;
}
</style>