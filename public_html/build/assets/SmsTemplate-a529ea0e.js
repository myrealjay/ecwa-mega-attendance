import{_ as v,B as k,S as b,M as D,T as M,e as n,f as i,g as r,i as l,j as m,k as A,v as C,F as c,l as u,m as h,p as E,q as w,s as p,u as x}from"./app-28ad1224.js";import{M as P}from"./Message-2cb98147.js";import{P as V}from"./Pagination-cbe6df2a.js";const B={components:{Message:P,Button:k,SingleSelect:b,Modal:D,Pagination:V,TextAreaField:M},mounted(){this.makeRequest("GET",this.endpoints.userStructre).then(e=>{this.userStructure=e.data.data}).catch(e=>{console.log(e.response.data)}),this.makeRequest("GET",this.endpoints.getCategories).then(e=>{this.categories=e.data.data}).catch(e=>{console.log(e.response)}),this.fetchTemplates()},data(){return{emailTemplateOpen:!1,userStructure:{},smsTemplate:{email_category_id:"",template:""},categories:[],templates:[],paginationData:{},smsTemplateOpen:!1,edit:!1,tableData:{length:15,currentPage:1},lengthData:[10,15,20,30,40,50,100]}},methods:{setPage(e){this.tableData.currentPage=e,this.fetchTemplates()},fetchTemplates(){this.makeRequest("GET",`${this.endpoints.fetchSmsTemplates}?page=${this.tableData.currentPage}`,this.tableData).then(e=>{this.templates=e.data.data.data,this.paginationData=e.data.data}).catch(e=>{console.log(e.response.data)})},showSmsTemplateModal(){this.smsTemplateOpen=!0},getAttributes(){let e="";for(let s in this.userStructure)e+=`$${s}$ , `;return e},addSmsTemplate(){this.showLoader(),this.makeRequest("POST",this.endpoints.createSmsTemplate,this.smsTemplate).then(e=>{this.sweetAlert().success("SMS template successfully saved"),this.smsTemplateOpen=!1,this.smsTemplate={email_category_id:"",template:""},this.fetchTemplates()}).catch(e=>{this.sweetAlert().error("Error creating template"),console.log(e.response.data)}).finally(()=>{this.hideLoader()})},editTemplate(e){this.smsTemplate={...e},this.smsTemplateOpen=!0,this.edit=!0},editSmsTemplate(){this.showLoader(),this.makeRequest("PUT",`${this.endpoints.updateSmsTemplate}/${this.smsTemplate.id}`,this.smsTemplate).then(e=>{this.sweetAlert().success("Sms template Edit successfully saved"),this.smsTemplateOpen=!1,this.smsTemplate={email_category_id:"",template:""},this.edit=!1,this.fetchTemplates()}).catch(e=>{this.sweetAlert().error("Error editing template"),console.log(e.response.data)}).finally(()=>{this.hideLoader()})},deleteTemplate(e){confirm("Are you sure you want to delete this template?")&&this.makeRequest("DELETE",`${this.endpoints.deleteSmsTemplate}/${e}`).then(s=>{this.sweetAlert().success("Template deleted successfully"),this.fetchTemplates()}).catch(s=>{this.sweetAlert().error("Error deleting template"),console.log(s.response.data)})}}},O={class:"button-container"},q=["value"],L=["value"],R=l("div",{class:"line"},null,-1),F=l("h2",{class:"head"},"SMS Templates",-1),N={class:"messages"},U=["onClick"],G=["onClick"],j=l("b",null,"You can use any of these attributes:",-1),Y=l("br",null,null,-1),z=l("div",{class:"line"},null,-1);function H(e,s,I,J,a,o){const d=n("Button"),g=n("Message"),T=n("Pagination"),_=n("SingleSelect"),f=n("TextAreaField"),S=n("Modal");return i(),r("div",null,[l("div",O,[m(d,{"aria-label":"Attendance for last 4 Sundays",text:"ADD SMS TEMPLATE",color:"primary",icon:"mdi mdi-plus-box",onButtonClicked:s[0]||(s[0]=t=>o.showSmsTemplateModal())}),A(l("select",{class:"form-control select-legnth",name:"",id:"","onUpdate:modelValue":s[1]||(s[1]=t=>a.tableData.length=t),onChange:s[2]||(s[2]=t=>o.fetchTemplates())},[(i(!0),r(c,null,u(a.lengthData,t=>(i(),r("option",{key:t,value:t},h(t),9,q))),128)),a.paginationData.total?(i(),r("option",{key:0,value:a.paginationData.total},"All",8,L)):E("",!0)],544),[[C,a.tableData.length]])]),R,F,l("div",N,[(i(!0),r(c,null,u(a.templates,t=>(i(),w(g,{key:t.id,message:t.template,category:"Category:"+t.category?t.category.name:""},{actions:p(()=>[l("button",{onClick:y=>o.editTemplate(t)},"Edit",8,U),l("button",{onClick:y=>o.deleteTemplate(t.id)},"Delete",8,G)]),_:2},1032,["message","category"]))),128))]),m(T,{from:a.paginationData.from,to:a.paginationData.to,links:a.paginationData.links,total:a.paginationData.total,onPageClicked:o.setPage},null,8,["from","to","links","total","onPageClicked"]),m(S,{id:"addSmsTemplate",title:"Add SMS Template",open:a.smsTemplateOpen,onClosed:s[6]||(s[6]=t=>a.smsTemplateOpen=!1),large:!1},{buttons:p(()=>[m(d,{icon:"mdi-book",text:a.edit?"Edit Template":"Submit Template",color:"primary",onButtonClicked:s[5]||(s[5]=t=>a.edit?o.editSmsTemplate():o.addSmsTemplate())},null,8,["text"])]),default:p(()=>[l("div",null,[l("div",null,[j,Y,x(h(o.getAttributes()),1)]),z,m(_,{options:a.categories,custom_value:"id",modelValue:a.smsTemplate.email_category_id,"onUpdate:modelValue":s[3]||(s[3]=t=>a.smsTemplate.email_category_id=t),text:"name",label:"Category"},null,8,["options","modelValue"]),m(f,{label:"Message",modelValue:a.smsTemplate.template,"onUpdate:modelValue":s[4]||(s[4]=t=>a.smsTemplate.template=t),rows:"10",placeholder:"Enter SMS Template..."},null,8,["modelValue"])])]),_:1},8,["open"])])}const X=v(B,[["render",H]]);export{X as default};
