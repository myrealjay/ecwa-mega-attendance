<template>
  <div class="row tableContainer">
      <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
          <div class="card-body">
      
              <div class="row">
              <div class="col-12">
                  <div class="table-responsive">
                  <table id="example" class="display expandable-table table-striped" style="width:100%">
                      <thead>
                      <tr>
                          <th v-for="(header,i) in headers" v-html="header.name" :style="'width:' +(header.width ? `${header.width}%`: '10%')" 
                          :key="i"></th>
                      </tr>
                      </thead>
                      <tbody>
                          <slot class="body"></slot>
                      </tbody>
                  </table>
                  </div>
              </div>
              </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script lang="ts">
export default {
  props:['title','modelValue','displaySearch','headers'],
  emits: ['update:modelValue'],
  computed: {
      tableTitle() {
          return this.title ? this.title.replace(' ','&nbsp;') : '';
      }
  }
}
</script>

<style scoped>
td {
  color: rgb(47, 45, 45);
}
.body {
  color: rgb(47, 45, 45);
}
.headers {
  display:flex;
  gap:1rem;
  padding-bottom: 10px;
}
#search {
  height: 30px;
  max-width: 250px;
}
.select {
  height: 30px;
  min-width: 80px;
}
#length {
  justify-self: flex-end;
}
.search {
  width:90%;
  display: flex;
  gap:1rem;
}
.filters {
  display: flex;
  gap:1rem;
}
.filters * {
  height: 30px;
}
#length * {
  height: 30px;
}
.tableContainer {
  margin-top:50px;
}
</style>