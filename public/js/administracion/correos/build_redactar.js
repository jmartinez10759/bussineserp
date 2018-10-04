new Vue({
  el: "#vue-redactar",
  created: function () {
    this.consulta_general();
  },
  data: {
    datos: [],
    newKeep: {

    },
    fillKeep: {

    },

  },
  mixins : [mixins],
  methods:{
    consulta_general: function(){}
  }


});
