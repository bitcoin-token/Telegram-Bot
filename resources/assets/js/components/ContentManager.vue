<template>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <!-- List Bot Replies -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-split">
                                <span class="panel-component-heading">
                                    Bot Replies by Command
                                </span>
                                <button class="btn btn-primary" @click="showCreateReplyForm">
                                    Add New Bot Reply
                                </button>
                            </div>
                        </div>
                        <div class="panel-body">

                            <p v-if="replies.length === 0">
                                There are currently no entries.
                            </p>

                            <table class="table table-bordered table-striped table-bottom" v-if="replies.length > 0">
                                <thead>
                                    <tr>
                                        <th width="130">Command</th>
                                        <th width="130">Start Date</th>
                                        <th width="130">End Date</th>
                                        <th>Content</th>
                                        <th width="45"></th>
                                        <th width="45"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="reply in replies">
                                        <td style="vertical-align: middle;">{{ reply.command }}</td>
                                        <td style="vertical-align: middle;">{{ reply.start_date }}</td>
                                        <td style="vertical-align: middle;">{{ reply.end_date }}</td>
                                        <td style="vertical-align: middle; white-space: pre-line;">
                                            <p v-html="reply.content"></p>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <button class="btn btn-info" @click="showEditReplyForm(reply)">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                        </td>
                                        <td style="vertical-align: middle;">
                                            <button class="btn btn-danger" @click="approveReplyDelete(reply)">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Create Reply Modal -->
                    <div class="modal fade" id="modal-create-reply" tabindex="-1" role="dialog">
                        <div class="modal-dialog" v-if="createForm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 style="margin-top: 0; margin-bottom: 0;">Add New Bot Reply</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-danger" v-if="createForm.errors.length > 0">
                                        <ul>
                                            <li v-for="error in createForm.errors">{{ error }}</li>
                                        </ul>
                                    </div>
                                    <form class="form" role="form">
                                        <div class="form-group">
                                            <label class="control-label">Command:</label>
                                            <select class="form-control" name="command" v-model="createForm.command">
                                                <option value="">Please Select</option>
                                                <option :value="command.shortname" v-for="command in commands">{{ command.name }}</option>
                                            </select>
                                        </div>
				                        <div class="form-group">
				                            <div class="row">
				                                <div class="col-md-6">
				                                    <label>Start Date:</label>
				                                    <div class="input-group">
				                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				                                        <input type="text" id="create_start_date" name="start_date" class="form-control" v-model="createForm.start_date">
				                                    </div>
				                                </div>
				                                <div class="col-md-6">
				                                    <label>End Date:</label>
				                                    <div class="input-group">
				                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				                                        <input type="text" id="create_end_date" name="end_date" class="form-control" v-model="createForm.end_date">
				                                    </div>
				                                </div>
				                            </div>
				                        </div>
                                        <div class="form-group">
                                        	<label class="control-label">Content</label>
                                            <p>
                                                <button type="button" @click="addCreateFormBold">Add Bold Text</button>
                                                <button type="button" @click="addCreateFormItalics">Add Italics Text</button>
                                                <button type="button" @click="addCreateFormLink">Add Link URL</button>
                                            </p>
                                        	<textarea class="form-control" name="content" rows="8" v-model="createForm.content"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" @click="store">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Reply Modal -->
                    <div class="modal fade" id="modal-edit-reply" tabindex="-1" role="dialog">
                        <div class="modal-dialog" v-if="editForm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 style="margin-top: 0; margin-bottom: 0;">Edit Bot Reply</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                                        <ul>
                                            <li v-for="error in editForm.errors">{{ error }}</li>
                                        </ul>
                                    </div>
                                    <form class="form" role="form">
                                        <div class="form-group">
                                            <label class="control-label">Command:</label>
                                            <select class="form-control" name="command" v-model="editForm.command">
                                                <option :value="command.shortname" v-for="command in commands">{{ command.name }}</option>
                                            </select>
                                        </div>
				                        <div class="form-group">
				                            <div class="row">
				                                <div class="col-md-6">
				                                    <label>Start Date:</label>
				                                    <div class="input-group">
				                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				                                        <input type="text" id="edit_start_date" name="start_date" class="form-control" v-model="editForm.start_date">
				                                    </div>
				                                </div>
				                                <div class="col-md-6">
				                                    <label>End Date:</label>
				                                    <div class="input-group">
				                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				                                        <input type="text" id="edit_end_date" name="end_date" class="form-control" v-model="editForm.end_date">
				                                    </div>
				                                </div>
				                            </div>
				                        </div>
                                        <div class="form-group">
                                        	<label class="control-label">Content</label>
                                            <p>
                                                <button type="button" @click="addEditFormBold">Add Bold Text</button>
                                                <button type="button" @click="addEditFormItalics">Add Italics Text</button>
                                                <button type="button" @click="addEditFormLink">Add Link URL</button>
                                            </p>
                                        	<textarea class="form-control" name="content" rows="8" v-model="editForm.content"></textarea>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" @click="update">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Reply Modal -->
                    <div class="modal fade" id="modal-delete-reply" tabindex="-1" role="dialog">
                        <div class="modal-dialog" v-if="deleteReply">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 style="margin-top: 0; margin-bottom: 0;">Delete Bot Reply</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-danger" v-if="deleteReply.errors.length > 0">
                                        <ul>
                                            <li v-for="error in deleteReply.errors">{{ error }}</li>
                                        </ul>
                                    </div>

                                    Are you sure you want to delete this bot reply for ({{ deleteReply.command }}) command? This cannot be undone.
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">No, Go Back</button>
                                    <button type="button" class="btn btn-danger" @click="destroy">Yes, Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
        /*
         * The component's data.
         */
        data: function () {
            return {
                commands: [],             
                replies: [],

                createForm: {
                    command: '',
                    start_date: '',
                    end_date: '',
                    content: '',
                    errors: []
                },

                editForm: {
                    command: '',
                    start_date: '',
                    end_date: '',
                    content: '',
                    errors: []
                },

                deleteReply: {
                    command: '',
                    errors: []
                }
            };
        },

        created: function () {
            this.getCommands();
        },

        mounted: function () {
            this.getReplies();
        },

        methods: {
            /**
             * Get all of the bot commands
             */
            getCommands: function () {
                axios.get(App.url + '/commands/all')
                    .then(response => {
                        this.commands = response.data;
                    });
            },

            /**
             * Get all of the bot replies
             */
            getReplies: function () {
                axios.get(App.url + '/replies/all')
                    .then(response => {
                        this.replies = response.data;
                    });
            },

            /**
             * Show the form for creating new replies.
             */
            showCreateReplyForm: function () {
                $('#modal-create-reply').modal('show');
            },

            /**
             * Add bold text placeholder.
             */
            addCreateFormBold: function () {
                this.createForm.content = this.createForm.content + '<b>text</b>';
            },

            /**
             * Add italics text placeholder.
             */
            addCreateFormItalics: function () {
                this.createForm.content = this.createForm.content + '<i>text</i>';
            },

            /**
             * Add link URL text placeholder.
             */
            addCreateFormLink: function () {
                this.createForm.content = this.createForm.content + '<a href="#">text</a>';
            },

            /**
             * Add bold text placeholder.
             */
            addEditFormBold: function () {
                this.editForm.content = this.editForm.content + '<b>text</b>';
            },

            /**
             * Add italics text placeholder.
             */
            addEditFormItalics: function () {
                this.editForm.content = this.editForm.content + '<i>text</i>';
            },

            /**
             * Add link URL text placeholder.
             */
            addEditFormLink: function () {
                this.editForm.content = this.editForm.content + '<a href="#">text</a>';
            },

            /**
             * Create a new reply.
             */
            store: function () {
                this.createForm.errors = [];

                axios.post(App.url + '/replies', this.createForm)
                    .then(response => {
                        this.getReplies();

                        this.createForm.command = '';
                        this.createForm.start_date = '';
                        this.createForm.end_date = '';
                        this.createForm.content = '';
                        this.createForm.errors = [];
                        
                        $('#modal-create-reply').modal('hide');
                    })
                    .catch(error => {
                        if(typeof error.response.data === 'object') {
                            this.createForm.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            this.createForm.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            },

            /**
             * Show the form for editing replies.
             */
            showEditReplyForm: function (reply) {
                this.editForm.id = reply.id;
                this.editForm.command = reply.command;
                this.editForm.start_date = reply.start_date;
                this.editForm.end_date = reply.end_date;
                this.editForm.content = reply.content;

                $('#modal-edit-reply').modal('show');
            },

            /**
             * Update the reply being edited.
             */
            update: function () {
                this.editForm.errors = [];

                axios.put(App.url + '/replies/' + this.editForm.id, this.editForm)
                    .then(response => {
                        this.getReplies();

                        this.editForm.command = '';
                        this.editForm.start_date = '';
                        this.editForm.end_date = '';
                        this.editForm.content = '';
                        this.editForm.errors = [];
                        
                        $('#modal-edit-reply').modal('hide');
                    })
                    .catch(error => {
                        if(typeof error.response.data === 'object') {
                            this.editForm.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            this.editForm.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            },

            /**
             * Get user confirmation that the reply should be deleted.
             */
            approveReplyDelete: function (reply) {
                this.deleteReply.errors = [];
                
                this.deleteReply.id = reply.id;
                this.deleteReply.command = reply.command;

                $('#modal-delete-reply').modal('show');
            },

            /**
             * Delete the reply.
             */
            destroy: function () {
                this.deleteReply.errors = [];

                axios.delete(App.url + '/replies/' + this.deleteReply.id)
                    .then(response => {
                        this.getReplies();

                        this.deleteReply.errors = [];

                        $('#modal-delete-reply').modal('hide');
                    })
                    .catch(error => {
                        if(typeof error.response.data === 'object') {
                            this.deleteDepartment.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            this.deleteDepartment.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            }
        }               
    }
</script>
