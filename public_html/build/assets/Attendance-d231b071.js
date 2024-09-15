import{_ as g,f as i,g as r,i as e,k as b,y as A,m as d,F as c,l as u,G as P,e as v,H as f,p as y,j as k}from"./app-788a9215.js";const x={data(){return{selectedDate:"",currentPage:1,currentPageAbsent:1,pageSize:10,presentAttendees:[],absentAttendees:[]}},computed:{totalPages(){return Math.ceil(this.presentAttendees.length/this.pageSize)},totalPagesAbsent(){return Math.ceil(this.absentAttendees.length/this.pageSize)},paginatedPresent(){const s=(this.currentPage-1)*this.pageSize;return this.presentAttendees.slice(s,s+this.pageSize)},paginatedAbsent(){const s=(this.currentPageAbsent-1)*this.pageSize;return this.absentAttendees.slice(s,s+this.pageSize)}},methods:{fetchDataByDate(){this.makeRequest("GET",`${this.endpoints.fetchAttendanceByDate}?date=${this.selectedDate}`).then(s=>{this.presentAttendees=s.data.data.present,this.absentAttendees=s.data.data.absent}).catch(s=>{console.log(s.response.data)})},nextPage(){this.currentPage<this.totalPages&&this.currentPage++},prevPage(){this.currentPage>1&&this.currentPage--},nextPageAbsent(){this.currentPageAbsent<this.totalPagesAbsent&&this.currentPageAbsent++},prevPageAbsent(){this.currentPageAbsent>1&&this.currentPageAbsent--}}},D=e("h2",null,"Attendance by Date",-1),C=e("label",{for:"date-select"},"Select Date:",-1),S={key:0,class:"attendance-list"},N=e("thead",null,[e("tr",null,[e("th",null,"Name"),e("th",null,"Phone Number"),e("th",null,"Email"),e("th",null,"Address")])],-1),w={class:"pagination"},z=["disabled"],B={class:"pages"},E=["disabled"],M={key:1},L=e("p",null,"No present attendees recorded for the selected date.",-1),V=[L],R={key:2,class:"attendance-list"},T=e("thead",null,[e("tr",null,[e("th",null,"Name"),e("th",null,"Phone Number"),e("th",null,"Email"),e("th",null,"Address")])],-1),U={class:"pagination"},q=["disabled"],G={class:"pages"},F=["disabled"],I={key:3},j=e("p",null,"No absent attendees recorded for the selected date.",-1),H=[j];function O(s,t,_,p,l,a){return i(),r("div",null,[D,e("div",null,[C,b(e("input",{id:"date-select",type:"date","onUpdate:modelValue":t[0]||(t[0]=n=>l.selectedDate=n),class:"date-select",onChange:t[1]||(t[1]=(...n)=>a.fetchDataByDate&&a.fetchDataByDate(...n))},null,544),[[A,l.selectedDate]])]),l.presentAttendees.length>0?(i(),r("div",S,[e("h3",null,"Present Member on "+d(l.selectedDate),1),e("table",null,[N,e("tbody",null,[(i(!0),r(c,null,u(a.paginatedPresent,(n,o)=>(i(),r("tr",{key:o},[e("td",null,d(n.name),1),e("td",null,d(n.phone_number),1),e("td",null,d(n.email),1),e("td",null,d(n.address),1)]))),128))])]),e("div",w,[e("button",{onClick:t[2]||(t[2]=(...n)=>a.prevPage&&a.prevPage(...n)),disabled:l.currentPage===1,class:"previous"}," Previous ",8,z),e("span",B," Page "+d(l.currentPage)+" of "+d(a.totalPages),1),e("button",{onClick:t[3]||(t[3]=(...n)=>a.nextPage&&a.nextPage(...n)),disabled:l.currentPage===a.totalPages,class:"next"}," Next ",8,E)])])):(i(),r("div",M,V)),l.absentAttendees.length>0?(i(),r("div",R,[e("h3",null,"Absent Member on"+d(l.selectedDate),1),e("table",null,[T,e("tbody",null,[(i(!0),r(c,null,u(a.paginatedAbsent,(n,o)=>(i(),r("tr",{key:o},[e("td",null,d(n.name),1),e("td",null,d(n.phone_number),1),e("td",null,d(n.email),1),e("td",null,d(n.address),1)]))),128))])]),e("div",U,[e("button",{onClick:t[4]||(t[4]=(...n)=>a.prevPageAbsent&&a.prevPageAbsent(...n)),disabled:l.currentPageAbsent===1,class:"previous"}," Previous ",8,q),e("span",G," Page "+d(l.currentPageAbsent)+" of "+d(a.totalPagesAbsent),1),e("button",{onClick:t[5]||(t[5]=(...n)=>a.nextPageAbsent&&a.nextPageAbsent(...n)),disabled:l.currentPageAbsent===a.totalPagesAbsent,class:"next"}," Next ",8,F)])])):(i(),r("div",I,H))])}const J=g(x,[["render",O]]);const K={data(){return{selectedContacts:[],submittedAttendances:[]}},mounted(){this.$store.dispatch("fetchContactData")},created(){this.makeRequest("GET",this.endpoints.fetchAttendance).then(s=>{this.selectedContacts=s.data.data})},components:{Attendants:J},computed:{...P(["contactData"]),gridColumns(){return Math.ceil(this.contacts.length/20)},gridRows(){const s=[];for(let t=0;t<this.gridColumns;t++)s.push(this.contacts.slice(t*20,(t+1)*20));return s},allUsers(){return this.users=[],this.contactData.forEach(s=>{this.users.push({id:s.id,name:s.name})}),this.users}},methods:{submitAttendance(){let s=[];this.selectedContacts.forEach(t=>{s.push(t.id)}),this.errors={},this.showLoader(),this.makeRequest("POST",this.endpoints.takeAttendance,{},{users:s}).then(t=>{this.hideLoader(),this.sweetAlert().success("Attendance successfully submitted")}).catch(t=>{this.hideLoader(),t.response?t.response.data.data?this.errors=t.response.data.data:this.sweetAlert().error(t.response.data.message):this.sweetAlert().error(t)})}}},Q=e("h2",null,"Attendance List",-1),W={class:"grid-container"},X=["value"],Y={class:"mt-3"},Z=["disabled"],$={key:0},ee=e("h3",null,"Submitted Attendances:",-1),te={class:"attendance"};function se(s,t,_,p,l,a){const n=v("Attendants");return i(),r("div",null,[Q,e("div",W,[(i(!0),r(c,null,u(a.allUsers,(o,h)=>(i(),r("div",{class:"grid-item",key:h},[e("label",null,[b(e("input",{type:"checkbox","onUpdate:modelValue":t[0]||(t[0]=m=>l.selectedContacts=m),value:o},null,8,X),[[f,l.selectedContacts]]),e("p",null,d(o.name),1)])]))),128))]),e("div",Y,[e("button",{onClick:t[1]||(t[1]=(...o)=>a.submitAttendance&&a.submitAttendance(...o)),disabled:l.selectedContacts.length===0,class:"btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"}," Submit Attendance ",8,Z)]),l.submittedAttendances.length>0?(i(),r("div",$,[ee,e("ul",null,[(i(!0),r(c,null,u(l.submittedAttendances,(o,h)=>(i(),r("li",{key:h}))),128))])])):y("",!0),e("div",te,[k(n)])])}const ae=g(K,[["render",se]]);export{ae as default};