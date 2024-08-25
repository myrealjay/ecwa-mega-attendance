import{_ as c,f as i,g as d,i as l,m,p as v,B as M,M as B,y as P,E as w,D as x,e as u,j as n,k as b,z as E,v as T,F as g,l as _,s as D}from"./app-b6a64476.js";import{P as U}from"./Pagination-8f2b6799.js";const A={props:["modelValue","error","label"],emits:["update:modelValue"],data(){return{error:this.error||""}},methods:{validateFile(o){const e=o.target.files[0];e?["image/jpeg","image/jpg","image/png"].includes(e.type)?(this.error="",this.$emit("update:modelValue",e)):this.error="The picture must be a file of type: jpg, jpeg, png.":this.error="No file selected."}}},R={class:"form-group"},S={for:"file-upload"},N={key:0,class:"Formerror"};function O(o,e,a,V,t,s){return i(),d("div",R,[l("label",S,m(a.label),1),l("input",{type:"file",class:"form-control",onChange:e[0]||(e[0]=(...p)=>s.validateFile&&s.validateFile(...p))},null,32),t.error?(i(),d("span",N,m(t.error),1)):v("",!0)])}const L=c(A,[["render",O],["__scopeId","data-v-cbfb6a9a"]]);const j={data(){return{currentPage:1,pageSize:10,form:{first_name:"",last_name:"",email:"",address:"",dob:"",phone_number:"",wedding_date:"",picture:""},errors:{},registerModalOpen:!1,searchQuery:"",userData:[],lengthData:[5,10,20,30,40,50,100],tableData:{search:"",currentPage:1,length:5,links:{},from:"",to:"",total:"",sort:"id",sort_direction:"ASC"}}},mounted(){this.fetchData()},computed:{},methods:{sortBy(o){this.tableData.sort=o,this.tableData.sort_direction=="ASC"?this.tableData.sort_direction="DESC":this.tableData.sort_direction="ASC",this.fetchData()},setPage(o){this.tableData.currentPage=o,this.fetchData()},fetchData(o=this.endpoints.fetchUsers){this.makeRequest("GET",`${o}?page=${this.tableData.currentPage}`,this.tableData).then(e=>{let a=e.data.data;this.tableData.currentPage=a.current_page,this.tableData.from=a.from,this.tableData.to=a.to,this.tableData.prevPage=a.prev_page_url,this.tableData.nextPage=a.next_page_url,this.tableData.links=a.links,this.tableData.total=a.total,this.userData=a.data}).catch(e=>{console.log(e.response.data)})},showRegisterModal(){this.registerModalOpen=!0},register(){this.errors={};let o=new FormData;for(let e in this.form)o.append(e,this.form[e]);this.showLoader(),this.makeRequest("POST",this.endpoints.createUser,{},o).then(e=>{this.sweetAlert().success("Member Added successfully"),this.registerModalOpen=!1,this.form={first_name:"",last_name:"",email:"",address:"",dob:"",phone_number:"",wedding_date:""},this.fetchData()}).catch(e=>{this.sweetAlert().error("Error Registration"),console.log(e.response.data)}).finally(()=>{this.hideLoader()})},fetchContactDetails(o){this.$router.push({path:`/members/${o}`})}},components:{Button:M,Modal:B,TextField:P,EmailField:w,DateTimeField:x,Pagination:U,FileField:L}},H={class:"button-container"},I=l("h2",null,"LIST OF ALL CHURCH MEMBER",-1),q={class:"search-items"},z=["value"],G=["value"],Q=["onClick"],W=l("div",{class:"line"},null,-1),J={class:"pt-3"};function K(o,e,a,V,t,s){const p=u("Button"),y=u("Pagination"),f=u("TextField"),k=u("EmailField"),h=u("DateTimeField"),C=u("FileField"),F=u("Modal");return i(),d("div",null,[l("div",H,[n(p,{text:"ADD MEMBER",color:"primary",icon:"mdi mdi-plus-circle",onButtonClicked:e[0]||(e[0]=r=>s.showRegisterModal())})]),I,l("div",q,[b(l("input",{type:"text","onUpdate:modelValue":e[1]||(e[1]=r=>t.tableData.search=r),placeholder:"Search members",class:"search",onInput:e[2]||(e[2]=r=>s.fetchData())},null,544),[[E,t.tableData.search]]),b(l("select",{class:"form-control length-select","onUpdate:modelValue":e[3]||(e[3]=r=>t.tableData.length=r),onChange:e[4]||(e[4]=r=>s.fetchData())},[(i(!0),d(g,null,_(t.lengthData,r=>(i(),d("option",{value:r,key:r},m(r),9,z))),128)),t.tableData.total?(i(),d("option",{key:0,value:t.tableData.total},"All",8,G)):v("",!0)],544),[[T,t.tableData.length]])]),l("table",null,[l("thead",null,[l("tr",null,[l("th",{onClick:e[5]||(e[5]=r=>s.sortBy("first_name"))},"Name"),l("th",{onClick:e[6]||(e[6]=r=>s.sortBy("phone_number"))},"Phone Number"),l("th",{onClick:e[7]||(e[7]=r=>s.sortBy("email"))},"Email"),l("th",{onClick:e[8]||(e[8]=r=>s.sortBy("address"))},"Address"),l("th",{onClick:e[9]||(e[9]=r=>s.sortBy("dob"))},"Date of Birth")])]),l("tbody",null,[(i(!0),d(g,null,_(t.userData,r=>(i(),d("tr",{key:r.id,onClick:X=>s.fetchContactDetails(r.id),class:"detail-click"},[l("td",null,m(r.name),1),l("td",null,m(r.phone_number),1),l("td",null,m(r.email),1),l("td",null,m(r.address),1),l("td",null,m(o.formatDate(r.dob,!0)),1)],8,Q))),128))])]),n(y,{from:t.tableData.from,to:t.tableData.to,links:t.tableData.links,total:t.tableData.total,onPageClicked:s.setPage},null,8,["from","to","links","total","onPageClicked"]),n(F,{id:"registerModal",title:"Register Church Member",open:t.registerModalOpen,onClosed:e[19]||(e[19]=r=>t.registerModalOpen=!1),large:!1},{buttons:D(()=>[n(p,{icon:"mdi-send",text:"Register",color:"primary",onButtonClicked:e[18]||(e[18]=r=>s.register())})]),default:D(()=>[l("div",null,[W,l("form",J,[n(f,{label:"First Name",modelValue:t.form.first_name,"onUpdate:modelValue":e[10]||(e[10]=r=>t.form.first_name=r),error:t.errors.first_name?t.errors.first_name[0]:""},null,8,["modelValue","error"]),n(f,{label:"Last Name",modelValue:t.form.last_name,"onUpdate:modelValue":e[11]||(e[11]=r=>t.form.last_name=r),error:t.errors.last_name?t.errors.last_name[0]:""},null,8,["modelValue","error"]),n(f,{label:"Phone Number",modelValue:t.form.phone_number,"onUpdate:modelValue":e[12]||(e[12]=r=>t.form.phone_number=r),error:t.errors.phone_number?t.errors.phone_number[0]:""},null,8,["modelValue","error"]),n(f,{label:"Home Address",modelValue:t.form.address,"onUpdate:modelValue":e[13]||(e[13]=r=>t.form.address=r),error:t.errors.address?t.errors.address[0]:""},null,8,["modelValue","error"]),n(k,{label:"Email",modelValue:t.form.email,"onUpdate:modelValue":e[14]||(e[14]=r=>t.form.email=r),error:t.errors.email?t.errors.email[0]:""},null,8,["modelValue","error"]),n(h,{label:"DOB",modelValue:t.form.dob,"onUpdate:modelValue":e[15]||(e[15]=r=>t.form.dob=r),error:t.errors.dob?t.errors.dob[0]:""},null,8,["modelValue","error"]),n(h,{label:"Wedding Date",modelValue:t.form.wedding_date,"onUpdate:modelValue":e[16]||(e[16]=r=>t.form.wedding_date=r),error:t.errors.wedding_date?t.errors.wedding_date[0]:""},null,8,["modelValue","error"]),n(C,{modelValue:t.form.picture,"onUpdate:modelValue":e[17]||(e[17]=r=>t.form.picture=r),error:t.errors.picture?t.errors.picture[0]:""},null,8,["modelValue","error"])])])]),_:1},8,["open"])])}const $=c(j,[["render",K]]);export{$ as default};