<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <passport-clients></passport-clients>
                <passport-authorized-clients></passport-authorized-clients>
                <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users.data"  :key="user.id">
                        <td>{{ user.id }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    name: "Developer",
    data(){
        return{
        }
    },
    computed:{
        users(){
            return this.$store.getters.getUsers;
        }
    },
    created() {
        this.$store.dispatch("getUsersFromServer");
    }
}
</script>

<style scoped>

</style>
