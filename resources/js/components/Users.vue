<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12" v-if="$gate.isAdminOrisAuthor()">
                <div class="card" >
                    <div class="card-header">
                        <h3 class="card-title">Users Table</h3>

                        <div class="card-tools">
                            <button @click="newModal" class="btn btn-outline-success py-2"> <i class="fas fa-user-plus pr-1"></i> Add User</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Registered At</th>
                                <th>Modify</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in users.data"  :key="user.id">
                                <td>{{ user.id }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td><span class="tag tag-success">{{ user.type | upText }}</span></td>
                                <td>{{ user.created_at | myDate}}</td>
                                <td>
                                    <a href="#" @click="editModal(user)" class="pr-5 text-decoration-none"> <i class="fas fa-user-edit"></i> Edit </a>
                                    <a href="#"  @click="deleteUser(user.id )" class="text-decoration-none text-danger"> <i class="fas fa-trash-alt"></i>  Delete </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="users" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>

        <!-- /.Modal -->

        <div class="modal fade" id="add-User" tabindex="-1" aria-labelledby="addUser" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-if="!editMode" id="addUser">Add User</h5>
                        <h5 class="modal-title" v-else >Edit User info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <form @submit.prevent="editMode ? updateUser() : createUser()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">Name </label>
                                    <input id="name" v-model="form.name" type="text" name="name"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Enter you name ">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input v-model="form.email" type="email" name="email" id="email"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" placeholder="Enter you Email Address ">
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select v-model="form.type" id="type"  name="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                        <option value="" >Select your role</option>
                                        <option value="admin" >Admin</option>
                                        <option value="user" selected>User</option>
                                        <option value="author">Author</option>
                                    </select>
                                    <has-error :form="form" field="type"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="bio">bio</label>
                                    <input v-model="form.bio" type="text" name="bio" id="bio"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }">
                                    <has-error :form="form" field="bio"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input v-model="form.password" type="password" name="password" id="password"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                    <has-error :form="form" field="password"></has-error>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                                <button v-if="!editMode" type="submit" class="btn btn-outline-primary">Create User</button>
                                <button v-else type="submit" class="btn btn-outline-primary">Edit </button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                users : {} ,
                form : new Form({
                    id : '',
                    name : '' ,
                    email : '' ,
                    type : '' ,
                    bio : '' ,
                    password : '' ,
                    photo : ''

                }),
                editMode : false ,
            }
        },
        methods: {
            loadUsers(){
                if (this.$gate.isAdminOrisAuthor()){
                    axios.get('api/user').then(({data} ) => (this.users = data ));
                }
            },
            newModal(){
                this.editMode = false ;
                this.form.reset();
                $('#add-User').modal('show');

            },
            editModal(user){
                this.editMode = true ;
                this.form.fill(user);
                $('#add-User').modal('show');
            },
            createUser(){
                this.form.post('api/user');
                Fire.$emit('updateUser');
                $('#add-User').modal('hide');
                Toast.fire({
                    icon: 'success',
                    title: 'User Created successfully'
                });
            },
            updateUser(){
              this.form.put('api/user/' + this.form.id).then(()=>{
                  //succss
              }).catch(()=>{
                  //eror
              });
                $('#add-User').modal('hide');
                Toast.fire({
                    icon: 'success',
                    title: 'User Updated successfully'
                });
                Fire.$emit('updateUser');
            },
            deleteUser(id){
                Swal.fire({
                    title: 'Are you sure you want to delete?',
                    icon: 'warning',
                    showCancelButton: true,
                    customClass: {
                        confirmButton: 'btn btn-outline-success mr-3',
                        cancelButton: 'btn btn-outline-danger'
                    },
                    buttonsStyling: false,
                    confirmButtonText: 'Yes, delete it !',
                }).then((result) => {
                    if(result.value){
                        this.form.delete('api/user/' + id).then(() => {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            Fire.$emit('updateUser');
                        });
                    }
                });
            },
            getResults(page = 1) {
                axios.get('api/user?page=' + page)
                    .then(response => {
                        this.users = response.data;
                    });
            }
        },
        created() {
            Fire.$on('searching', ()=>{
                let query = this.$parent.search ;
                axios.get('api/findUser?q=' +  query)
                .then((data)=>{
                    this.users = data.data
                })
                .catch()
            });
            this.loadUsers();
            Fire.$on('updateUser' , ()=> {
                this.loadUsers() ;
            });
        },

    }
</script>
