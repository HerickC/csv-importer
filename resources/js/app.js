import Axios from 'axios';

var app = new Vue({
    el: '#app',
    data: {
      clients: [],
    },
    methods: {
        getAllClients: function(){
            Axios.get('/api/clients').then((response) => {
                this.clients = response.data;
            });
        },
        removeClient: function(id) {
            Axios.delete(`/api/clients/${id}`).then((response) => {
                this.getAllClients();
            });
        }
    },
    mounted() {
        this.getAllClients();
    },
  })
