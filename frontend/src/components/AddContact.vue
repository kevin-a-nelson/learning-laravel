<template>
    <div class="container col-lg-6">
        <form class="form-container" @submit.prevent="saveContact" novalidate>
            <fieldset>
                <legend>New Contact</legend>
                <div>
                    <label for="exampleInputName1" class="form-label mt-4">Name</label>
                    <input v-model="contactName" class="form-control" id="exampleInputName1"
                        aria-describedby="nameHelp">
                </div>
                <div>
                    <label for="exampleInputEmail1" class="form-label mt-4">Email</label>
                    <input v-model="contactEmail" type="email" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp">
                </div>
                <div>
                    <label for="exampleInputDesignation1" class="form-label mt-4">Designation</label>
                    <input v-model="contactDesignation" type="Designation" class="form-control"
                        id="exampleInputDesignation1" aria-describedby="designationHelp">
                </div>
                <div>
                    <label for="exampleInputContactNo1" class="form-label mt-4">Contact No</label>
                    <input v-model="contactContactNo" type="ContactNo" class="form-control" id="exampleInputContactNo1"
                        aria-describedby="contactNoHelp">
                </div>
                <div class="submit-btn-container">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </fieldset>
        </form>
    </div>
</template>

<script>
// const [contactName, contactNameModifiers] = defineModel('contactName')

import axios from 'axios'

export default {
    name: 'AddContact',
    data() {
        return {
            contactName: '',
            contactEmail: '',
            contactDesignation: '',
            contactContactNo: '',
        }
    },
    methods: {
        async saveContact() {
            let url = 'http://localhost:8000/api/save_contact'
            let newContact = {
                name: this.contactName,
                email: this.contactEmail,
                designation: this.contactDesignation,
                contact_no: this.contactContactNo
            }
            await axios.post(url, newContact)
                .then(() => {
                }).catch(error => {
                    console.log(error)
                })
            this.contactName = "";
            this.contactEmail = "";
            this.contactDesignation = "";
            this.contactContactNo = "";
        }
    }
}
</script>

<style>
.form-container {
    padding: 20px;
}

.submit-btn-container {
    margin-top: 25px;
}
</style>