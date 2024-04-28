<template>
  <div class="container">
    <!-- <h1 class="contact-header">Contact List</h1> -->
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Designation</th>
          <th scope="col">Contact No.</th>
        </tr>
      </thead>

      <tbody>
        <tr class="table-secondary" v-for="contact in contacts" :key="contact.id">
          <th scope="row">{{ contact.id }}</th>
          <th scope="row">{{ contact.name }}</th>
          <th scope="row">{{ contact.email }}</th>
          <th scope="row">{{ contact.designation }}</th>
          <th scope="row">{{ contact.contact_no }}</th>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ContactList',
  data() {
    return {
      contacts: Array,
    }
  },
  created() {
    this.getContacts();
  },
  mounted() {
  },
  methods: {
    async getContacts() {
      let url = 'http://localhost:8000/api/contacts'
      await axios.get(url).then(response => {
        this.contacts = response.data.contacts
      }).catch(error => {
        console.log(error)
      })
    }
  }
}

</script>

<style>
.contact-header {
  margin-top: 10px;
  margin-bottom: 10px;
}
</style>