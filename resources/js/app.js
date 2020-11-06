require('./bootstrap');
import Axios from 'axios';

var pusher = new Pusher('3654e69354fd23fbfaf6', {
  cluster: 'us2'
});

var channel = pusher.subscribe('clients');
channel.bind('client-update', function() {
  app.getAllClients();
});

var app = new Vue({
    el: '#app',
    data: {
      clients: [],
      uploadProgress: 0,
    },
    computed: {
        hasClients: function(){
            return this.clients.length > 0;
        },

    },
    methods: {
        getAllClients: function(){
            Axios.get('/api/clients').then((response) => {
                this.clients = response.data;

                Vue.nextTick().then(function () {
                    jQuery('[data-toggle="tooltip"]').tooltip();
                });
            });
        },
        removeClient: function(id) {
            Axios.delete(`/api/clients/${id}`).then(() => {
                this.getAllClients();
            });
        },
        uploadFile: function() {
            this.uploadProgress = 0;

            var formData = new FormData();
            var fileUpload = document.querySelector('#fileUpload');
            formData.append("clients", fileUpload.files[0]);

            const config = {
                onUploadProgress: (event) => {
                    this.uploadProgress = Math.round(
                      (event.loaded * 100) / event.total
                    );
                },
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }

            Axios.post('/api/import', formData, config).then(()=>{
                $('#importModal').modal('hide')
                this.getAllClients();
                this.uploadProgress = 0;
            })
        },
        formatedClientTooltip: function(client){
            return `<b>E-Mail: </b>${client.email}<br><b>CPF: </b>${client.cpf}<br><b>Nascimento: </b> ${client.birthday}<br>`;
        },
        formatedAddressTooltip: function(address){
            const complement = address.complementary != null ? ' - '+ address.complementary : '';
            return `${address.street}, ${address.street_number}${complement}<br>`+
                   `${address.neighborhood}, ${address.city}, ${address.state}<br>`+
                   `<b>CEP: </b> ${address.zipcode}`;
        },
        exportClients: function(){
            window.open('/export', '_blank');
        }
    },
    mounted() {
        this.getAllClients();
    },
  })
