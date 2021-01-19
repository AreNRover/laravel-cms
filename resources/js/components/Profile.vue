<template>
    <div class="col-md-12">
        <div class="row w-100">
            <div class="col-md-3" >

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img  img-circle " :src="getProfilePhoto()" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">Nina Mcintire</h3>

                        <p class="text-muted text-center">Software Engineer</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Followers</b> <a class="float-right">1,322</a>
                            </li>
                            <li class="list-group-item">
                                <b>Following</b> <a class="float-right">543</a>
                            </li>
                            <li class="list-group-item">
                                <b>Friends</b> <a class="float-right">13,287</a>
                            </li>
                        </ul>

                        <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
            <div class="col-md-9" >
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="activity">
                                <!-- Post -->
                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="/img/person.png" alt="user image">
                                        <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                                        <span class="description">Shared publicly - 7:30 PM today</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p>
                                        Lorem ipsum represents a long-held tradition for designers,
                                        typographers and the like. Some people hate it and argue for
                                        its demise, but others ignore the hate as they create awesome
                                        tools to help create filler text for everyone from bacon lovers
                                        to Charlie Sheen fans.
                                    </p>

                                    <p>
                                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                                    </p>

                                    <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                                </div>
                                <!-- /.post -->

                                <!-- Post -->
                                <div class="post clearfix">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="/img/person.png" alt="User Image">
                                        <span class="username">
                          <a href="#">Sarah Ross</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                                        <span class="description">Sent you a message - 3 days ago</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p>
                                        Lorem ipsum represents a long-held tradition for designers,
                                        typographers and the like. Some people hate it and argue for
                                        its demise, but others ignore the hate as they create awesome
                                        tools to help create filler text for everyone from bacon lovers
                                        to Charlie Sheen fans.
                                    </p>

                                    <form class="form-horizontal">
                                        <div class="input-group input-group-sm mb-0">
                                            <input class="form-control form-control-sm" placeholder="Response">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-danger">Send</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane" id="settings">
                                <form @submit.prevent="updateProfile">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input v-model="form.name" type="text" name="username"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                        <has-error :form="form" field="name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input v-model="form.email" type="email" name="email" id="email"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" placeholder="Enter you Email Address ">
                                        <has-error :form="form" field="email"></has-error>
                                    </div>
                                    <div class="form-group ">
                                        <label for="type">Type</label>
                                        <select v-model="form.type" id="type"  name="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                            <option value="" >Select your role</option>
                                            <option value="admin" >Admin</option>
                                            <option value="user" selected>User</option>
                                            <option value="author">Author</option>
                                        </select>
                                        <has-error :form="form" field="type"></has-error>
                                    </div>
                                    <label for="photo">Profile Photo</label>

                                    <div class="form-group custom-file mb-3">
                                        <input type="file" name="photo" @change="profilePhoto" class="custom-file-input" id="photo">
                                        <label class="custom-file-label" for="photo">Choose file...</label>
                                        <div class="invalid-feedback">Example invalid custom file feedback</div>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input v-model="form.password" type="password" name="password"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                        <has-error :form="form" field="password"></has-error>
                                    </div>

                                    <button  type="submit" class="btn btn-primary">Update Profile</button>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            form : new Form ({
                id : '' ,
                name : '' ,
                email : '' ,
                bio : '' ,
                type : '' ,
                photo : '',
                password : '' ,
            }),
        }
    },
    methods:{
        getProfilePhoto(){

            let photo = ( this.form.photo.length > 200 ) ? this.form.photo : "img/profile/" + this.form.photo ;

            return photo ;

        },
        profilePhoto(e){
            let file = e.target.files[0];
            let reader = new FileReader() ;
            reader.onloadend = (file) => {

                this.form.photo = reader.result ;
            }
            reader.readAsDataURL(file);

        },
        updateProfile(){
            this.form.put('api/updateProfile/').then(()=>{
                Toast.fire({
                    icon: 'success',
                    title: 'User Updated successfully'
                });
            }).catch(()=>{});
        },
    },
    created() {
        axios.get("api/profile").then(({data})=> (this.form.fill(data) ));
    },

    name: "Profile"
}
</script>

<style scoped>

</style>
