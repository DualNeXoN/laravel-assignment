<template>
  <div>

    <div class="row mt-5 justify-content-center">
      <div class="col div-title">
        <span>Parts</span>
      </div>
    </div>

    <div class="row mt-3 justify-content-center">
      <div class="col col-sm-10 col-md-8 col-lg-6 col-xl-4">
        <button class="btn btn-primary w-100" type="button" data-toggle="collapse" data-target="#collapseNewPartRecord"
          aria-expanded="false" aria-controls="collapseNewPartRecord">Add new part</button>
        <div class="collapse" id="collapseNewPartRecord">
          <add-part-form @part-created="eventPartCreated"></add-part-form>
        </div>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col">
        <part-table ref="partTable" v-if="showPartTable"></part-table>
      </div>
    </div>
  </div>
</template>
  
<script>
import AddPartForm from './AddPartForm.vue';
import PartTable from './PartTable.vue';

export default {
  data() {
    return {
      showPartTable: false,
    };
  },
  mounted() {
    this.showPartTable = true;
    this.$nextTick(() => {
      this.$refs.partTable.fetchParts();
    });
  },
  methods: {
    eventPartCreated() {
      this.$refs.partTable.fetchParts();
    },
  },
  components: {
    AddPartForm,
    PartTable,
  },
};
</script>
  
<style>
.div-title>span {
  font-size: 2rem;
  font-weight: bold;
}
</style>