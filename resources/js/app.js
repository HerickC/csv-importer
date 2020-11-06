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
                    console.log(this.uploadProgress);
                },
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }

            Axios.post('/api/import', formData, config).then(()=>{
                this.getAllClients();
            })
        }
    },
    mounted() {
        this.getAllClients();
    },
  })
