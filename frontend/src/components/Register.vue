<template>
    <div class="container col-lg-6">
        <form class="form-container" @submit.prevent="createAccount" novalidate>
            <fieldset>
                <legend>Register</legend>
                <div>
                    <label for="exampleInputName1" class="form-label mt-4">Name</label>
                    <input v-model="accountName" type="name" class="form-control" id="exampleInputName1"
                        aria-describedby="nameHelp">
                </div>
                <div>
                    <label for="exampleInputEmail1" class="form-label mt-4">Email</label>
                    <input v-model="accountEmail" type="email" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp">
                </div>
                <div>
                    <label for="exampleInputPassword1" class="form-label mt-4">Password</label>
                    <input v-model="accountPassword" class="form-control" id="exampleInputPassword1"
                        aria-describedby="passwordHelp">
                </div>
                <div class="login-failed-container" v-if="loginFailed">
                    <p class="text-danger">Unable to create account</p>
                </div>
                <div class="submit-btn-container">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="register-container">
                    <router-link class="nav-link" to="Login"> Already have an account? Click here to Login
                    </router-link>
                </div>
            </fieldset>
        </form>
    </div>
</template>

<script>
import axios from 'axios'
import router from '../routes/routes.js'

export default {
    name: 'Register',
    data() {
        return {
            accountName: '',
            accountEmail: '',
            accountPassword: '',
            loginFailed: false,
        }
    },
    props: {
    },
    components: {
    },
    methods: {
        async createAccount() {
            let url = 'http://localhost:8000/api/user'
            let newAccount = {
                name: this.accountName,
                email: this.accountEmail,
                password: this.accountPassword,
            }
            await axios.post(url, newAccount)
                .then(response => {
                    if (response.data.code === 200) {
                        this.accountName = "";
                        this.accountEmail = "";
                        this.accountPassword = "";
                        router.push('/Login')
                    }
                    else { this.loginFailed = true }
                }).catch(error => {
                    this.loginFailed = true
                    console.log(error)
                })
        }
    }
}

</script>

<style>
.register-container {
    margin-top: 20px;
    margin-bottom: 15px;
}

.login-failed-container {
    margin-top: 5px;
}
</style>