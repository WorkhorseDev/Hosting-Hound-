<script setup>

import {Head, Link, useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import {reactive} from "vue";
import InputError from "@/Components/InputError.vue";
</script>

<template>
  <Head title="Add Site"/>
  <div class="wrapper">
    <div class="container dashboard">
      <header class="header">
        <div class="tabs">
          <a href="#" class="tab-item is-active">
            <span class="">Websites</span>
          </a>
          <a href="#" class="tab-item">
            <span class="">Billings</span>
          </a>
        </div>
        <div class="links">
                    <span class="link-item link-item_add">
                       <Link :href="route('addSite')"><i class="fas fa-add"></i></Link>
                    </span>
          <span class="link-item link-item_user">
                        <i class="fas fa-user"></i>
                    </span>
        </div>
      </header>
      <div class="main-panel main-panel_edit">
        <div class="flex flex-row items-center">
          <div class="pr-6">
            <span @click="goBack" class="btn-back"><i class="fas fa-arrow-left"></i></span>
          </div>
          <div class="panel-title">Site Details</div>
        </div>
        <div class="panel-controls flex flex-row justify-end items-center">
          <button class="btn-edit">
            <i class="fa-solid fa-pencil" v-if="path !== '/addSite'"></i>
            <i class="fa-solid fa-pencil" style="color: #979797" v-if="path == '/addSite'"></i>
          </button>
        </div>
      </div>
      <main class="main-content">
        <div class="inner sited-detail">
          <div class="data card-list">
            <div class="card-content">
              <div class="info">
                <p class="card-title">{{ site.name }}</p>
                <span class="card-link">{{ site.url }}</span>
              </div>
              <div class="card-logo">
                <img v-if="site.icon" :src="site.icon" :alt="site.name"/>
                <span v-else>Logo</span>
              </div>
              <span class="card-color" :style="{ backgroundColor: site.color }"></span>
            </div>
          </div>
          <div class="grid grid-cols-3 gap-4">
            <div>
              <div class="left-line"></div>
              <div class="text-block">
                <div class="circle"></div>
                <em class="gray-text">Company Information</em>
              </div>
              <div class="left-line second">
                <p class="info">{{ site.name }}</p>
                <p class="info">{{ site.business_unit }}</p>
              </div>
              <div class="text-block">
                <div class="circle"></div>
                <em class="gray-text">Notes</em>
              </div>
              <div class="left-line second third">
                <p class="info">{{ site.notes }}</p>
              </div>
              <div class="text-block">
                <div class="circle"></div>
                <em class="gray-text">Tags</em>
              </div>
              <div class="left-line second" v-if="site.tags">
                <div class="tags" v-for="tag in (site.tags.split(','))">
                  <p class="info">{{ tag }}</p>
                  <div class="arrow-right"></div>
                </div>
              </div>
              <div class="text-block">
                <div class="circle"></div>
                <em class="gray-text">Shared With:</em>
              </div>
              <div class="left-line second">
                <p class="info">{{ site.shared_with }}</p>
              </div>
            </div>
            <div class="mb-5 block-serv">
              <div class="left-line"></div>
              <div class="text-block">
                <div class="circle"></div>
                <em class="gray-text">Service Providers</em>
              </div>
              <div v-for="(item, key, index) in site.provider" :key="key" @click="showDetail(item, key)">
                <div class="card-content detail">
                  <div class="info">
                    <p class="card-title">{{ item.name }}</p>
                    <span class="card-link">{{ item.url }}</span>
                  </div>
                  <i v-if="!item.show" class="fa-solid fa-sort-up"></i>
                  <i v-if="item.show" class="fa-solid fa-sort-down"></i>
                  <span class="card-color" style="backgroundColor: #000"></span>
                </div>

                <div class="service-form detail" :id="'id'+key">
                  <div class="form-container">
                    <div class="form-header"><span class="serv-detail">Host Provider</span><i class="fa-solid fa-pen"></i></div>
                    <div class="form-group-wrap bg-grey p-6 pt-4 globe-div">
                      <div class="globe">
                        <i class="fa-solid fa-globe"></i>
                      </div>
                      <div class="form-group right-side">
                        <b>{{element.name}}</b>
                      </div>
                      <div class="form-group right-side">
                        <em>{{element.url}}</em>
                      </div>
                    </div>
                    <div class="form-group-wrap p-6 pt-4">
                      <i class="fa-solid fa-sack-dollar"></i> <span class="card-title"> $ {{element.cost}}</span>
                      <div class="dark-line"></div>
                    </div>
                    <div class="form-group-wrap bg-grey p-6 pt-4 subscribe">
                      <div class="globe">
                        <i class="fas fa-hourglass-half"></i>
                      </div>
                      <div class="form-group right-side">
                        <em>Next Deadline:</em> <span>{{element.renewal_date}}</span>
                      </div>
                      <div class="form-group right-side">
                        <em>Renewal Type:</em> <span>{{element.renewal_type}}</span>
                      </div>
                    </div>
                    <div class="form-group-wrap p-6 pt-4">
                      <i class="fa-solid fa-key"></i> <span class="text"> Login Information</span>
                      <div class="dark-line"></div>
                    </div>
                    <div class="form-group-wrap p-6 pt-4 user-detail">
                      <div class="form-group form-group-icon">
                        <input readonly type="text" id="userName" :value="userName" :placeholder="element.user_mame">
                        <i class="fa-regular fa-user"></i>
                        <i class="fa-regular fa-copy" @click="copy('#userName')"></i>
                      </div>
                      <div class="form-group form-group-icon">
                        <input readonly v-bind:type="[showPassword ? 'text' : 'password']"  id="password" :value="password" :placeholder="element.password">
                        <i class="fa-solid fa-lock"></i>
                        <i class="fa-solid fa-eye-slash" @click="showTextPass" v-if="!showPassword"></i>
                        <i class="fa-solid fa-eye" @click="showTextPass" v-if="showPassword"></i>
                        <i class="fa-regular fa-copy" @click="copy('#password')"></i>
                      </div>
                      <div class="form-group form-group-icon m-0">
                        <input readonly v-bind:type="[showPin ? 'text' : 'password']"  id="pin" :value="pin" :placeholder="element.pin">
                        <i class="fa-solid fa-fingerprint"></i>
                        <i class="fa-solid fa-eye-slash" @click="showTextPin" v-if="!showPin"></i>
                        <i class="fa-solid fa-eye" @click="showTextPin" v-if="showPin"></i>
                        <i class="fa-regular fa-copy" @click="copy('#pin')"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-5 block-serv">
              <div class="left-line"></div>
              <div class="text-block">
                <div class="circle"></div>
                <em class="gray-text">Software & Add-ons</em>
              </div>
              <div class="card-content detail" v-for="item in site.software">
                <div class="info">
                  <p class="card-title">{{ item.name }}</p>
                  <span class="card-link">{{ item.url }}</span>
                </div>
                <i class="fa-solid fa-sort-up"></i>
                <span class="card-color" style="backgroundColor: #000"></span>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>
<script>
import {reactive} from "vue";
import {useForm} from "@inertiajs/vue3";

export default {
  props: {
    site: Array
  },
  data() {
    return {
      showProvider: false,
      element: {},
      userName: '',
      password: '',
      pin: '',
      showPassword: false,
      showPin: false
    }
  },
  methods: {
    showTextPass() {
      this.showPassword = !this.showPassword;
      event.preventDefault();
      event.stopPropagation();
      return false;
    },
    showTextPin() {
      this.showPin = !this.showPin;
      event.preventDefault();
      event.stopPropagation();
      return false;
    },
    copy(param) {
      let testingCodeToCopy = document.querySelector(param)
      testingCodeToCopy.setAttribute('type', 'text')
      testingCodeToCopy.select()
      try {
        var successful = document.execCommand('copy');
      } catch (err) {
        alert('Oops, unable to copy');
      }
      event.preventDefault();
      event.stopPropagation();
      return false;
    },
    goBack() {
      window.history.back();
    },
    showDetail(item, key) {
      var el = document.getElementById('id'+key);
      el.style.display = "block";
      item.show = !item.show;
      if (!item.show) {
        el.style.display =  "none";
      }
      this.element.type =  item.type;
      this.userName = this.element.name =  item.name;
      this.element.url =  item.url;
      this.element.renewal_type =  item.renewal_type;
      this.element.cost =  item.cost;
      this.element.renewal_date =  item.renewal_date;
      this.element.user_mame =  item.user_mame;
      this.password = this.element.password =  item.password;
      this.pin = this.element.pin =  item.pin;
    }
  }
}
</script>
