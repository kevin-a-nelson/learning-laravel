<template>
    <div class="container col-lg-6">
        <form class="form-container" @submit.prevent="login" novalidate>
            <fieldset>
                <legend>Login</legend>
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
                    <p class="text-danger">incorrect email or password</p>
                </div>
                <div class="submit-btn-container">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="register-container">
                    <router-link class="nav-link" to="Register"> Don't have a account? Click here to Register
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
    name: 'Login',
    data() {
        return {
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
        async login() {
            let url = 'http://localhost:8000/api/login'
            let params = {
                email: this.accountEmail,
                password: this.accountPassword
            }
            await axios.get(url, { params })
                .then(response => {
                    if (response.data.code === 200) {
                        localStorage['user'] = JSON.stringify(response.data.user)
                        router.push('/')
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
    margin-top: 20x;
    margin-bottom: 15px;
}


.login-failed-container {
    margin-top: 5px;
}
</style>