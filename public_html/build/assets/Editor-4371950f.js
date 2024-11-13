import{L as b,N as B,O as I,l as U,P as E,m as j,Q as _,R,U as x,V as p}from"./app-235f6814.js";var K=["onActivate","onAddUndo","onBeforeAddUndo","onBeforeExecCommand","onBeforeGetContent","onBeforeRenderUI","onBeforeSetContent","onBeforePaste","onBlur","onChange","onClearUndos","onClick","onContextMenu","onCopy","onCut","onDblclick","onDeactivate","onDirty","onDrag","onDragDrop","onDragEnd","onDragGesture","onDragOver","onDrop","onExecCommand","onFocus","onFocusIn","onFocusOut","onGetContent","onHide","onInit","onKeyDown","onKeyPress","onKeyUp","onLoadContent","onMouseDown","onMouseEnter","onMouseLeave","onMouseMove","onMouseOut","onMouseOver","onMouseUp","onNodeChange","onObjectResizeStart","onObjectResized","onObjectSelected","onPaste","onPostProcess","onPostRender","onPreProcess","onProgressState","onRedo","onRemove","onReset","onSaveContent","onSelectionChange","onSetAttrib","onSetContent","onShow","onSubmit","onUndo","onVisualAid"],N=function(n){return K.map(function(t){return t.toLowerCase()}).indexOf(n.toLowerCase())!==-1},T=function(n,t,e){Object.keys(t).filter(N).forEach(function(o){var i=t[o];typeof i=="function"&&(o==="onInit"?i(n,e):e.on(o.substring(2),function(a){return i(a,e)}))})},z=function(n,t,e,o){var i=n.modelEvents?n.modelEvents:null,a=Array.isArray(i)?i.join(" "):i;b(o,function(c,d){e&&typeof c=="string"&&c!==d&&c!==e.getContent({format:n.outputFormat})&&e.setContent(c)}),e.on(a||"change input undo redo",function(){t.emit("update:modelValue",e.getContent({format:n.outputFormat}))})},F=function(n,t,e,o,i,a){o.setContent(a()),e.attrs["onUpdate:modelValue"]&&z(t,e,o,i),T(n,e.attrs,o)},D=0,P=function(n){var t=Date.now(),e=Math.floor(Math.random()*1e9);return D++,n+"_"+e+D+String(t)},G=function(n){return n!==null&&n.tagName.toLowerCase()==="textarea"},w=function(n){return typeof n>"u"||n===""?[]:Array.isArray(n)?n:n.split(" ")},H=function(n,t){return w(n).concat(w(t))},k=function(n){return n==null},O=function(){return{listeners:[],scriptId:P("tiny-script"),scriptLoaded:!1}},q=function(){var n=O(),t=function(i,a,c,d){var r=a.createElement("script");r.referrerPolicy="origin",r.type="application/javascript",r.id=i,r.src=c;var v=function(){r.removeEventListener("load",v),d()};r.addEventListener("load",v),a.head&&a.head.appendChild(r)},e=function(i,a,c){n.scriptLoaded?c():(n.listeners.push(c),i.getElementById(n.scriptId)||t(n.scriptId,i,a,function(){n.listeners.forEach(function(d){return d()}),n.scriptLoaded=!0}))},o=function(){n=O()};return{load:e,reinitialize:o}},Q=q(),W=function(){return typeof window<"u"?window:global},f=function(){var n=W();return n&&n.tinymce?n.tinymce:null},J={apiKey:String,cloudChannel:String,id:String,init:Object,initialValue:String,inline:Boolean,modelEvents:[String,Array],plugins:[String,Array],tagName:String,toolbar:[String,Array],modelValue:String,disabled:Boolean,tinymceScriptSrc:String,outputFormat:{type:String,validator:function(n){return n==="html"||n==="text"}}},s=globalThis&&globalThis.__assign||function(){return s=Object.assign||function(n){for(var t,e=1,o=arguments.length;e<o;e++){t=arguments[e];for(var i in t)Object.prototype.hasOwnProperty.call(t,i)&&(n[i]=t[i])}return n},s.apply(this,arguments)},X=function(n,t,e,o){return n(o||"div",{id:t,ref:e})},Y=function(n,t,e){return n("textarea",{id:t,visibility:"hidden",ref:e})},$=B({props:J,setup:function(n,t){var e=n.init?s({},n.init):{},o=I(n),i=o.disabled,a=o.modelValue,c=o.tagName,d=U(null),r=null,v=n.id||P("tiny-vue"),C=n.init&&n.init.inline||n.inline,S=!!t.attrs["onUpdate:modelValue"],h=!0,A=n.initialValue?n.initialValue:"",y="",M=function(u){return S?function(){return a!=null&&a.value?a.value:""}:function(){return u?A:y}},g=function(){var u=M(h),l=s(s({},e),{readonly:n.disabled,selector:"#"+v,plugins:H(e.plugins,n.plugins),toolbar:n.toolbar||e.toolbar,inline:C,setup:function(m){r=m,m.on("init",function(V){return F(V,n,t,m,a,u)}),typeof e.setup=="function"&&e.setup(m)}});G(d.value)&&(d.value.style.visibility=""),f().init(l),h=!1};b(i,function(u){var l;r!==null&&(typeof((l=r.mode)===null||l===void 0?void 0:l.set)=="function"?r.mode.set(u?"readonly":"design"):r.setMode(u?"readonly":"design"))}),b(c,function(u){var l;S||(y=r.getContent()),(l=f())===null||l===void 0||l.remove(r),E(function(){return g()})}),j(function(){if(f()!==null)g();else if(d.value&&d.value.ownerDocument){var u=n.cloudChannel?n.cloudChannel:"5",l=n.apiKey?n.apiKey:"no-api-key",m=k(n.tinymceScriptSrc)?"https://cdn.tiny.cloud/1/"+l+"/tinymce/"+u+"/tinymce.min.js":n.tinymceScriptSrc;Q.load(d.value.ownerDocument,m,g)}}),_(function(){f()!==null&&f().remove(r)}),C||(R(function(){h||g()}),x(function(){var u;S||(y=r.getContent()),(u=f())===null||u===void 0||u.remove(r)}));var L=function(u){var l;y=r.getContent(),(l=f())===null||l===void 0||l.remove(r),e=s(s({},e),u),E(function(){return g()})};return t.expose({rerender:L}),function(){return C?X(p,v,d,n.tagName):Y(p,v,d)}}});export{$ as E};
