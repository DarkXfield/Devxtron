<template>
    <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row d-flex align-items-stretch">
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch" v-for="contact in contacts" :key="contact.name">
              <div class="card bg-light">
                <div class="card-header text-muted border-bottom-0" style="background-color: transparent;">
                  Digital Strategist
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b>{{contact.name}}</b></h2>
                      <p class="text-muted text-sm"><b>About: </b> Web Designer / UX / Graphic Artist / Coffee Lover </p>
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Address: Demo Street 123, Demo City 04312, NJ</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone #: + 800 - 12 12 23 52</li>
                      </ul>
                    </div>
                    <div class="col-5 text-center">
                      <img src="" alt="" class="img-circle img-fluid">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-right">
                    <a @click="newMsg(contact.id)" href="#" class="btn btn-sm bg-teal" data-toggle="modal" data-target="#newChat">
                      <i class="fas fa-comments"></i>
                    </a>
                    <a href="#" class="btn btn-sm btn-primary">
                      <i class="fas fa-user"></i> View Profile
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <nav aria-label="Contacts Page Navigation">
            <ul class="pagination justify-content-center m-0">
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">4</a></li>
              <li class="page-item"><a class="page-link" href="#">5</a></li>
              <li class="page-item"><a class="page-link" href="#">6</a></li>
              <li class="page-item"><a class="page-link" href="#">7</a></li>
              <li class="page-item"><a class="page-link" href="#">8</a></li>
            </ul>
          </nav>
        </div>
        <!-- /.card-footer -->
         <!-- Modal -->
        <div class="modal fade" id="newChat" tabindex="-1" role="dialog" aria-labelledby="newChatTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newChatTitle">Chat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Recipient:</label>
                  <input type="text" v-model="contName" class="form-control" id="recipient-name" readonly>
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">Message:</label>
                    <input type="text" v-model="contID" hidden>
                    <textarea class="form-control" v-model="newMsgFrom" id="message-text"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" @click="inputHandler">Send message</button>
            </div>
            </div>
        </div>
        </div>
      </div>
      <!-- /.card -->
</template>

<script>
    export default {
        data () {
             return {
                contacts: [],
                newMsgFrom: '',
                contID: '',
                contName: '',
            }
        },
        created() {
            axios.get('contact')
                .then(response => {
                    console.log(response.data);
                    this.contacts = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        methods: {
          newMsg: function(id){
                axios.get('contact/' + id)
                .then(response => {
                    console.log(response.data);
                    this.contID = response.data[0].id
                    this.contName = response.data[0].name
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            inputHandler() {
                this.sendNewMsg();
              },
            sendNewMsg() {
                axios.post('new', {
                  contID: this.contID,
                  msg: this.newMsgFrom,
                })
                .then(response => {
                    console.log(response.data);
                    if(response.status===200) {
                      window.location.replace('messages');
                      this.msg = 'you message has been sent successfully';
                    };
                })
                .catch(function(error) {
                  console.log(error);
                });
              }
            },
        }
</script>
