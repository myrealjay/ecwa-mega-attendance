import{_ as r,H as u,o as i,c as l,a as s,F as h,d as m,w as p,x as _,t as f}from"./app-235f6814.js";const b={data(){return{selectedContacts:[],users:[]}},created(){this.makeRequest("GET",this.endpoints.recipients).then(t=>{this.selectedContacts=t.data.data})},mounted(){this.$store.dispatch("fetchContactData")},computed:{...u(["contactData"]),allUsers(){return this.users=[],this.contactData.forEach(t=>{this.users.push({user_id:t.id,name:t.name})}),this.users}},methods:{submitAttendance(){let t=[];this.selectedContacts.forEach(e=>{t.push(e.user_id)}),this.errors={},this.showLoader(),this.makeRequest("POST",this.endpoints.recipients,{},{users:t}).then(e=>{this.sweetAlert().success("Recipients added successfully")}).catch(e=>{console.log(e.response),e.response?e.response.data.data?this.errors=e.response.data.data:this.sweetAlert().error(e.response.data.message):this.sweetAlert().error(e)}).finally(()=>{this.hideLoader()})}}},C=s("h2",null,"Follow Up Committee",-1),v={class:"grid-container"},g=["value"],w={class:"mt-3 boutton-submit"},k=["disabled"];function x(t,e,y,A,n,o){return i(),l("div",null,[C,s("div",v,[(i(!0),l(h,null,m(o.allUsers,(a,d)=>(i(),l("div",{class:"grid-item",key:d},[s("label",null,[p(s("input",{type:"checkbox","onUpdate:modelValue":e[0]||(e[0]=c=>n.selectedContacts=c),value:a},null,8,g),[[_,n.selectedContacts]]),s("p",null,f(a.name),1)])]))),128))]),s("div",w,[s("button",{onClick:e[1]||(e[1]=(...a)=>o.submitAttendance&&o.submitAttendance(...a)),disabled:n.selectedContacts.length===0,class:"btn btn-info btn-lg font-weight-medium auth-form-btn"}," Save Committee ",8,k)])])}const D=r(b,[["render",x]]);export{D as default};