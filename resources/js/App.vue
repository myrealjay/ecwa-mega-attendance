<template>
  <div class="mymain">
    <RouterView />
    <DialogsWrapper />
  </div>
  </template>
   
   <script lang="ts">
     export default {
       data() {
         return {
           loading:true
         }
       }
     }
   </script>
   
   <style>
   .button-container{
        display:flex;
        row-gap: 10px;
        gap: 10px;
    }
    .error {
      color: #ff0000;
    }

    .mymain{
      color: #000;
    }

    .line {
      height: 5px;
      background-color: #073883;
      margin-bottom: 15px;
      margin-top: 8px;
  }

   </style>