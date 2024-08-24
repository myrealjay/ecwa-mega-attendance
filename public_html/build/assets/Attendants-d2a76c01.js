import{_ as g,f as r,g as i,i as e,k as c,z as b,m as n,F as h,l as o}from"./app-28ad1224.js";const P={data(){return{selectedDate:"",currentPage:1,currentPageAbsent:1,pageSize:10,presentAttendees:[],absentAttendees:[]}},computed:{totalPages(){return Math.ceil(this.presentAttendees.length/this.pageSize)},totalPagesAbsent(){return Math.ceil(this.absentAttendees.length/this.pageSize)},paginatedPresent(){const d=(this.currentPage-1)*this.pageSize;return this.presentAttendees.slice(d,d+this.pageSize)},paginatedAbsent(){const d=(this.currentPageAbsent-1)*this.pageSize;return this.absentAttendees.slice(d,d+this.pageSize)}},methods:{fetchDataByDate(){this.makeRequest("GET",`${this.endpoints.fetchAttendanceByDate}?date=${this.selectedDate}`).then(d=>{this.presentAttendees=d.data.data.present,this.absentAttendees=d.data.data.absent}).catch(d=>{console.log(d.response.data)})},nextPage(){this.currentPage<this.totalPages&&this.currentPage++},prevPage(){this.currentPage>1&&this.currentPage--},nextPageAbsent(){this.currentPageAbsent<this.totalPagesAbsent&&this.currentPageAbsent++},prevPageAbsent(){this.currentPageAbsent>1&&this.currentPageAbsent--}}},_=e("h2",null,"Attendance by Date",-1),A=e("label",{for:"date-select"},"Select Date:",-1),p={key:0,class:"attendance-list"},m=e("thead",null,[e("tr",null,[e("th",null,"Name"),e("th",null,"Phone Number"),e("th",null,"Email"),e("th",null,"Address")])],-1),v={class:"pagination"},f=["disabled"],x={class:"pages"},y=["disabled"],D={key:1},k=e("p",null,"No present attendees recorded for the selected date.",-1),N=[k],S={key:2,class:"attendance-list"},z=e("thead",null,[e("tr",null,[e("th",null,"Name"),e("th",null,"Phone Number"),e("th",null,"Email"),e("th",null,"Address")])],-1),B={class:"pagination"},C=["disabled"],M={class:"pages"},E=["disabled"],F={key:3},I=e("p",null,"No absent attendees recorded for the selected date.",-1),T=[I];function V(d,a,q,w,l,s){return r(),i("div",null,[_,e("div",null,[A,c(e("input",{id:"date-select",type:"date","onUpdate:modelValue":a[0]||(a[0]=t=>l.selectedDate=t),class:"date-select",onChange:a[1]||(a[1]=(...t)=>s.fetchDataByDate&&s.fetchDataByDate(...t))},null,544),[[b,l.selectedDate]])]),l.presentAttendees.length>0?(r(),i("div",p,[e("h3",null,"Present Member on "+n(l.selectedDate),1),e("table",null,[m,e("tbody",null,[(r(!0),i(h,null,o(s.paginatedPresent,(t,u)=>(r(),i("tr",{key:u},[e("td",null,n(t.name),1),e("td",null,n(t.phone_number),1),e("td",null,n(t.email),1),e("td",null,n(t.address),1)]))),128))])]),e("div",v,[e("button",{onClick:a[2]||(a[2]=(...t)=>s.prevPage&&s.prevPage(...t)),disabled:l.currentPage===1,class:"previous"}," Previous ",8,f),e("span",x," Page "+n(l.currentPage)+" of "+n(s.totalPages),1),e("button",{onClick:a[3]||(a[3]=(...t)=>s.nextPage&&s.nextPage(...t)),disabled:l.currentPage===s.totalPages,class:"next"}," Next ",8,y)])])):(r(),i("div",D,N)),l.absentAttendees.length>0?(r(),i("div",S,[e("h3",null,"Absent Member on"+n(l.selectedDate),1),e("table",null,[z,e("tbody",null,[(r(!0),i(h,null,o(s.paginatedAbsent,(t,u)=>(r(),i("tr",{key:u},[e("td",null,n(t.name),1),e("td",null,n(t.phone_number),1),e("td",null,n(t.email),1),e("td",null,n(t.address),1)]))),128))])]),e("div",B,[e("button",{onClick:a[4]||(a[4]=(...t)=>s.prevPageAbsent&&s.prevPageAbsent(...t)),disabled:l.currentPageAbsent===1,class:"previous"}," Previous ",8,C),e("span",M," Page "+n(l.currentPageAbsent)+" of "+n(s.totalPagesAbsent),1),e("button",{onClick:a[5]||(a[5]=(...t)=>s.nextPageAbsent&&s.nextPageAbsent(...t)),disabled:l.currentPageAbsent===s.totalPagesAbsent,class:"next"}," Next ",8,E)])])):(r(),i("div",F,T))])}const L=g(P,[["render",V]]);export{L as default};