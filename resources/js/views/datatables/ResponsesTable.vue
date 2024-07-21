<template>
    <div>
        <Table
        :headers="headers"
        >
        <template #length>
          <select class="form-control length" v-model="tableData.length" @change="getHistory()">
            <option>5</option>
            <option>10</option>
            <option>20</option>
            <option>30</option>
            <option>50</option>
            <option>100</option>
            <option value="1000">All</option>
          </select>
        </template>
          <tr v-for="item in questions" :key="item.id">
            <td>{{ item.user ? (item.user.first_name+' '+item.user.last_name) : '' }}</td>
            <td>{{ item.user ? item.user.email : '' }}</td>
            <td>{{ item.user ? item.user.phone_number : '' }}</td>
            <td>{{ item.score }}</td>
            <td> 
              <DropDown>
                
              </DropDown>
            </td>
          </tr>
        </Table>
  
        <Pagination 
          :links="links.links" 
          :from="links.from"
          :to="links.to"
          :total="links.total"
          @page-clicked="getHistory"
        />
    </div>
</template>

<script lang="ts">
 import Pagination from '../../components/Pagination.vue';
 import Table from '../../components/Table.vue';
 import DropDown from '../../components/DropDown.vue'
export default {
    components: {
      Table,
      Pagination,
      DropDown
  },
  props:['quizId'],
  mounted(){
    this.getHistory()
  },
  data()
  {
    return {
        headers:[
        {name:'User', width:25},
        {name:'Email', width:15},
        {name:'Phone Number', width:15},
        {name:'Score (%)', width:10},
        {name:'Actions', width:10},
      ],
      links:[],
      tableData:{
        length:5,
        wallet_id:'',
        amount:'',
        type:''
      },
      questions:[]
    }
  },
  methods: {
    getHistory(page = 1) {
      this.showLoader();
      this.makeRequest('GET',`${this.endpoints.responses}?quiz_id=${this.quizId}&page=${page}`, this.tableData)
      .then(response => {
        this.questions = response.data.data.data;
        this.links = response.data.data.meta;
      }).catch(error => {
      }).finally(() => {
        this.hideLoader();
      })
    }
  }
}
</script>