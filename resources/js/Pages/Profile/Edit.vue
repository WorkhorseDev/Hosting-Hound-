<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import {Link} from '@inertiajs/vue3';
import {inject, reactive} from "vue";

const route = inject("route");
</script>

<template>
  <Head title="Dashboard"/>

  <div class="wrapper">
    <div class="container dashboard">
      <header class="header">
        <div class="tabs">
          <Link :href="route('dashboard')" class="tab-item is-active">
            <span class="">Websites</span>
          </Link>
          <Link :href="route('billing')" href="#" class="tab-item">
            <span class="">Billings</span>
          </Link>
        </div>

        <div class="links">
                    <span class="link-item link-item_add">
                       <Link :href="route('addSite')"><i class="fas fa-add"></i></Link>
                    </span>
          <span class="link-item link-item_user">
            <Link :href="route('profile')"> <i class="fas fa-user"></i></Link>
                    </span>
        </div>
      </header>
      <vf-form @submit.prevent="submit" id="saveAccount">
        <div class="main-panel main-panel_edit">
          <div class="flex flex-row items-center">
            <div class="pr-6">
              <span @click="goBack" class="btn-back"><i class="fas fa-arrow-left"></i></span>
            </div>
            <div class="panel-title">Account Settings</div>
          </div>
          <div class="panel-controls flex flex-row justify-end items-center">
            <button type="submit" @click="submit" class="btn-md btn-inverted">Save Changes</button>
            <button class="btn-edit">
              <i class="fa-solid fa-pencil"></i>
            </button>
          </div>
        </div>
        <main class="main-content add-site">
          <div class="inner">
            <div class="grid grid-cols-3 gap-4">
              <div class="mb-5">
                <span class="link-item link-item_user account"><i class="fas fa-user"></i></span>
                <div class="account-data">
                    <span class="account">{{user.name }} {{user.last_name}}</span>
                    <span class="account-gray">Email: {{user.email}}</span>
                    <span class="account-gray">Phone: {{user.phone_number}}</span>
                </div>
                <button type="button" class="account btn-md btn-inverted">Personal Details & Password  <i class="fa-solid fa-caret-right"></i></button>
                <button type="button" class="account btn-md btn-inverted">Notifications  <i class="fa-solid fa-caret-right"></i></button>
                <button type="button" class="account btn-md btn-inverted">Google Integration  <i class="fa-solid fa-caret-right"></i></button>
                <Link :href="route('logout')" href="#" class="logout">
                  <span class="">Log Out</span>
                </Link>
              </div>
              <div class="mb-5">
                <div class="form-group form-group-icon account">
                  <input readonly type="text" placeholder="First Name" v-model="user.name">
                  <i class="fa-regular fa-user"></i>
                  <i class="fa-solid fa-pencil" @click="showEdit"></i>
                </div>
                <div class="form-group form-group-icon account">
                  <input readonly type="text" placeholder="Last Name" v-model="user.last_name">
                  <i class="fa-regular fa-user"></i>
                  <i class="fa-solid fa-pencil"></i>
                </div>
                <div class="form-group form-group-icon account">
                  <input readonly type="text" placeholder="Phone" v-model="user.phone_number">
                  <i class="fa fa-phone"></i>
                  <i class="fa-solid fa-pencil"></i>
                </div>
                <div class="form-group form-group-icon account">
                  <input readonly type="text" placeholder="Email" v-model="user.email">
                  <i class="fa-regular fa-envelope"></i>
                  <i class="fa-solid fa-pencil"></i>
                </div>
                <div class="form-group form-group-icon account">
                  <input readonly v-bind:type="[showPassword ? 'text' : 'password']" id="password"
                         :value="user.password" >
                  <i class="fa-solid fa-lock"></i>
                  <i class="fa-solid fa-eye-slash" @click="showTextPass"
                     v-if="!showPassword"></i>
                  <i class="fa-solid fa-eye" @click="showTextPass"
                     v-if="showPassword"></i>
                  <i class="fa-solid fa-pencil"></i>
                </div>
              </div>
              <div class="mb-5">
                <div class="filter-block" v-if="isEdit">
                  <div class="filter-form">
                    <div class="heading row flex justify-center text-2xl mb-5">
                      <span class="filter-close md:hidden"><i class="fa-solid fa-xmark"></i></span>
                      Filter <span class="hidden md:inline-flex">&nbsp;items below</span>
                    </div>
                    <div class="filter-inner">
                      <div class="filter-search mb-5">
                        <input type="text" @change="search" v-model="searchData" class="filter-search-input"
                               id="filter-search" placeholder="Search term...">
                        <button type="button" class="search-btn">
                          <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
      </vf-form>
    </div>
  </div>
</template>
<script>
import {reactive, toRaw} from "vue";
import {useForm} from "@inertiajs/vue3";

export default {
  props: {
    user: Array
  },
  data() {
    return {
      showPassword: false,
      isEdit: false,
    }
  },
  methods: {
    goBack() {
      window.history.back();
    },
    showTextPass () {
      this.showPassword = !this.showPassword;
    },
    showEdit() {
      this.isEdit = !this.isEdit;
    },
    submit() {}
  }
}

</script>
