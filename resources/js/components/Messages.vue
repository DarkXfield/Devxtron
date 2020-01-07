<template>
    <div class="row">
          <div class="col-md-3">
            <div class="card direct-chat">
              <div class="card-header bg-white">
                <h3 class="card-title">Contacts</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                  <ul class="contacts-list nav nav-pills flex-column" v-for="privateMsg in privateMsgs" :key="privateMsg.name">
                    <li class="nav-item">
                      <a @click="messages(privateMsg.chat_id)" href="#" class="nav-link">
                        <img class="contacts-list-img" src="">

                        <div class="contacts-list-info" style="color: #6c757d;">
                          <span class="contacts-list-name">
                            {{privateMsg.name}}
                            <small class="contacts-list-date float-right">2/28/2015</small>
                          </span>
                          <span class="contacts-list-msg">How have you been? I was...</span>
                        </div>
                        <!-- /.contacts-list-info -->
                      </a>
                    </li>
                    <!-- End Contact Item -->
                  </ul>
                  <!-- /.contatcts-list -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        <div class="col-md-9">
          <!-- DIRECT CHAT PRIMARY -->
            <div class="card card-prirary cardutline direct-chat direct-chat-primary">
              <div class="card-header bg-white">
                <h3 class="card-title">Direct Chat</h3>

                <div class="card-tools">
                  <span data-toggle="tooltip" title="3 New Messages" class="badge bg-primary">3</span>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages" id="chatWindow">
                 <div v-for="SingleMsg in SingleMsgs" :key="SingleMsg.msg_id">
                  <!-- Message. Default to the left -->
                  <div class="direct-chat-msg" v-if="SingleMsg.user_from == userData.id">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-left">{{SingleMsg.name}}</span>
                      <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" :src="'/uploads/avatars/' + userData.avatar" alt="Message User Image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                      {{SingleMsg.msg}}
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>
                  <!-- /.direct-chat-msg -->
                  <!-- Message to the right -->
                  <div class="direct-chat-msg right" v-else>
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-right">{{SingleMsg.name}}</span>
                      <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="" alt="Message User Image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                      {{SingleMsg.msg}}
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>
                  <!-- /.direct-chat-msg -->
                 </div>
                </div>
                <!--/.direct-chat-messages-->
              </div>
              <!-- /.card-body -->
              <div class="card-footer bg-white">
                <form action="#" method="post">
                  <div class="input-group msg-modal">
                    <input type="text" v-model="conID" hidden>
                    <input type="text" name="message" v-model="msgFrom" @keydown="inputHandler" placeholder="Type Message ..." class="form-control">
                  </div>
                </form>
              </div>
              <!-- /.card-footer-->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
</template>
<script>
    export default {
        data () {
             return {
                msg: '',
                content: '',
                privateMsgs: [],
                SingleMsgs: [],
                userData: [],
                msgFrom: '',
                conID: '',
            }
        },
        created() {
            axios.get('message')
                .then(response => {
                    console.log(response.data);
                    this.privateMsgs = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            
            axios.get('current')
                .then(response => {
                    console.log(response.data);
                    this.userData = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        methods: {
            messages: function(chat_id){
                axios.get('message/' + chat_id)
                .then(response => {
                    console.log(response.data);
                    this.SingleMsgs = response.data;
                    this.conID = response.data[0].chat_id
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            inputHandler(e) {
              if(e.keyCode === 13 && !e.shiftKey) {
                e.preventDefault();
                this.sendMsg();
              }
            },
            sendMsg() {
              if(this.msgFrom) {
                axios.post('message', {
                  conID: this.conID,
                  msg: this.msgFrom,
                })
                .then(response => {
                    console.log(response.data);
                    if(response.status===200) {
                      this.SingleMsgs = response.data;
                     };
                })
                .catch(function(error) {
                  console.log(error);
                });
              }
            },
        },
    }

</script>
