@extends('layouts.master')

@section('page-title')
    Messaging
@endsection

@section('header')
    Messaging
@endsection

@section('content')

    <div id="messaging-app">
        <div class="main-section">
            <div class="head-section">
                <div class="headLeft-section">
                    <div class="headLeft-sub">
                        <h3>Managers</h3>
                    </div>
                </div>
                <div class="headRight-section" v-cloak>
                    <div class="headRight-sub">
                        <button class="btn btn-default float-right mt-2" @click="loadMessages" v-if="!isSend">
                            <i class="fa fa-refresh"></i>
                        </button>

                        <h3 v-if="!isSend && activeThread">@{{ activeThread.company ? activeThread.company : activeThread.name }}</h3>
                        <h3 v-if="isSend">Select admin to start messaging</h3>
                    </div>
                </div>
            </div>
            <div class="body-section">
                <div class="left-section mCustomScrollbar" data-mcs-theme="minimal-dark">
                    <div class="loader" v-show="threadLoading">
                        <i class="fa fa-circle-o-notch fa-spin"></i>
                    </div>

                    <ul v-cloak>
                        <li v-for="thread in filteredThreads" @click="selectThread(thread)" :class="{ active : activeThread.id === thread.id }">
                            <div class="chatList">
                                <div class="desc">
                                    <small class="time" v-if="thread.last_message">@{{ thread.last_message.created_at | moment }}</small>
                                    <h5>@{{thread.name}}</h5>
                                    <span class="last-message">
                                        @{{ thread.last_message ? thread.last_message.title : '....' }}
                                        @{{ (thread.last_message && thread.last_message.read_at) && '✓✓' }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="right-section">
                    <div class="loader" v-show="messagingLoading">
                        <i class="fa fa-circle-o-notch fa-spin"></i>
                    </div>

                    <div class="system-message mCustomScrollbar" data-mcs-theme="minimal-dark">
                        <ul :class="isSend && 'ml-3'">
                            <li :class="message.is_admin ? 'msg-left' : 'msg-right'" v-if="!isSend" v-for="message in messages" v-cloak>
                                <div class="msg-left-sub">
                                    <div class="msg-desc">
                                        <strong :class="message.is_admin ? 'text-info' : 'text-danger'">@{{message.title}}</strong>
                                        <p v-html="message.message"></p>
                                    </div>
                                    <small>
                                        @{{ message.created_at | moment }}
                                        <template v-if="message.read_at">
                                            . Read: @{{ message.read_at | moment }}
                                        </template>
                                    </small>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="right-section-bottom" :class="collapsed && 'collapsed'" v-show="activeThread">
                        <button class="btn btn-sm btn-warning collapse-btn" @click="toggleCollapse">
                            <i class="fa" :class="collapsed ? 'fa-arrow-up' : 'fa-arrow-down'"></i>
                            Toggle
                        </button>

                        <input type="text" class="form-control mb-3" v-model="title" placeholder="Title">

                        <textarea v-model="message" class="form-control" placeholder="Type message here..."></textarea>

                        <button class="btn btn-primary mt-2" @click="sendMessage" :disabled="messageLoading">
                            <i class="fa fa-send" v-if="!messageLoading"></i>
                            <i class="fa fa-circle-o-notch fa-spin" v-if="messageLoading"></i>
                            Send
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@voerro/vue-tagsinput@2.0.2/dist/voerro-vue-tagsinput.js"></script>

    <script>
        var messaingApp = new Vue({
            el: '#messaging-app',
            components: { "v-tags-input": VoerroTagsInput },
            data: {
                threads: [],
                filteredThreads: [],
                messages: [],
                users: [],
                selectedUsers: [],
                threadLoading: false,
                messageLoading: false,
                messagingLoading: false,
                searchLoading: false,
                activeThread: 0,
                isSend: true,
                singleMessage: false,
                sendMode: 'all',
                message: null,
                title: null,
                search: '',
                collapsed: true
            },
            created() {
                this.getThreads();
            },
            mounted: function () {

            },
            filters: {
                moment: function (date) {
                    return moment(date).format('DD-MM-YYYY - hh:mm a');
                }
            },
            methods: {
                toggleCollapse: function () {
                    this.collapsed = !this.collapsed;
                },
                getThreads: function () {
                    this.threadLoading = true;
                    axios.post('{{route("user.messages.threads")}}').then(response => {
                        this.threads = response.data.threads;
                        this.filteredThreads = this.threads;
                        this.threadLoading = false;
                    });
                },
                searchThreads: function () {
                    let search = this.search.toLowerCase();
                    this.filteredThreads = this.threads.filter(function (thread) {
                        let showItem = false;
                        if(thread.company && thread.company.toLowerCase().includes(search)) {
                            showItem = true;
                        }

                        if(thread.name && thread.name.toLowerCase().includes(search)) {
                            showItem = true;
                        }

                        if(thread.last_message && thread.last_message.title.toLowerCase().includes(search)) {
                            showItem = true;
                        }

                        return showItem;
                    })
                },
                searchUsers: function (e) {
                    this.$nextTick(() => {
                        if (e.target.value.length >= 1) {
                            this.searchLoading = true;
                            axios.post('{{route('autoComplete')}}', {
                                search: e.target.value,
                                select: ['id', 'company', 'name'],
                                item: 'user',
                                text: ['id', 'name'],
                                join: '-',
                                id: 'id'
                            }).then(response => {
                                this.users = response.data.results.slice(0, 10);
                                this.searchLoading = false;
                            });
                        }else{
                            this.users = []
                        }
                    });
                },
                sendMessage: function () {
                    let message = this.message;
                    let title = this.title;

                    if(!title || title.length === 0) {
                        return $.alert("Please type a title first!", "Error");
                    }

                    if(!message || message.length === 0) {
                        return $.alert("Please type a message first!", "Error");
                    }

                    this.messageLoading = true;
                    axios.post('{{route('user.messages.send')}}', {
                        title,
                        message,
                        singleMessage: this.singleMessage,
                        admin: this.selectedUsers
                    }).then(response => {
                        if(response.data.error) {
                            return $.alert(response.data.message, "Error");
                        }

                        this.getThreads();
                        this.messageLoading = false;
                        this.message = null;
                        this.title = null;
                        this.sendMode = 'all';

                        if(this.singleMessage) {
                            this.loadMessages()
                        }else{
                            this.users = [];
                            this.selectedUsers = [];
                        }
                    });
                },
                selectUser: function (user) {
                    this.selectedUsers.push(user);
                },
                selectThread: function (thread) {
                    this.activeThread = thread;
                    this.selectedUsers = thread.id;

                    this.loadMessages()
                },
                loadMessages: function () {
                    this.isSend = false;
                    this.singleMessage = true;

                    this.messagingLoading = true;
                    axios.post('{{route("user.messages.messages")}}', {
                        thread: this.activeThread.id
                    }).then(response => {
                        this.messages = response.data.messages;
                        this.messagingLoading = false;
                    });
                },
                newMessage: function () {
                    this.isSend = true;
                    this.singleMessage = false;
                    this.activeThread = 0;
                    this.selectedUsers = [];
                }
            }
        });
    </script>
@endsection

@section('styles')
    <style>
        [v-cloak] { display: none; }

        .loader {
            margin: 0 auto;
            display: table;
            padding: 10px;
            position: absolute;
            background: rgba(255,255,255, 0.4);
            right: 0;
            left: 0;
            width: 100%;
            text-align: center;
            z-index: 10;
        }

        .loader i{
            font-size: 25px;
            color: #ccc;
        }

        body{
            overflow: hidden;
        }

        div#messaging-app {
            margin: -29px!important;
            margin-top: -20px!important;
        }
    </style>
@endsection
