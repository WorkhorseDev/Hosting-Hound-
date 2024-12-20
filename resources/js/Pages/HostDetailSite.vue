<script setup>

import {Head, Link, useForm} from "@inertiajs/vue3";
import {reactive} from "vue";
</script>

<template>
  <Head title="Add Site"/>
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
      </div>
      <main class="main-content host-detail">
        <div class="inner sited-detail">
          <div class="grid grid-cols-3 gap-4">
            <div class="mb-5">
              <p class="provider-text">{{ provider.type }} Renewal Details</p>
              <div class="form-group-wrap p-6 pt-4">
                <i class="fa-solid fa-sack-dollar"></i> <span class="card-title"> $ {{ provider.cost }}</span>
                <div class="dark-line host-detail"></div>
              </div>
              <div class="form-group-wrap bg-grey p-6 pt-4 subscribe">
                <div class="globe">
                  <i class="fas fa-hourglass-half host"></i>
                </div>
                <div class="form-group right-side host">
                  <em>Next Deadline:</em> <span>{{ provider.renewal_date }}</span>
                </div>
                <div class="form-group right-side host">
                  <em>Suggested Deadline:</em> <span></span>
                </div>
                <div class="form-group right-side host">
                  <em>Renewal Type:</em> <span>{{ provider.renewal_type }}</span>
                </div>
              </div>
              <div class="text-block host">
                <div class="circle"></div>
                <em class="gray-text" @click="showProvider()">Service Providers</em>
                <i v-if="!serviceShow" class="fa-solid fa-sort-up"></i>
                <i v-if="serviceShow" class="fa-solid fa-sort-down"></i>
              </div>
              <div class="provider-list" v-if="serviceShow">
                <div class="provider-item" v-for="(item, key, index) in site.provider" :key="key">
                  <div class="inner">
                    <div class="row">
                      <span>{{ item.name }}</span>
                      <i class="fas fa-edit"></i>
                      <i class="icon fa-solid fa-lock"></i>
                    </div>
                  </div>
                  <div class="inner">
                    <div class="row">
                      <span>{{ item.url }}</span>
                      <i class="icon fa-solid fa-lock"></i>
                    </div>
                  </div>
                </div>
                <!-- end .provider-list -->
              </div>
              <div class="left-line on-host"></div>
              <div class="text-block host second">
                <div class="circle"></div>
                <em class="gray-text" @click="showSoftware()">Software & Add-ons</em>
                <i v-if="!showSoft" class="fa-solid fa-sort-up"></i>
                <i v-if="showSoft" class="fa-solid fa-sort-down"></i>
              </div>
              <div class="provider-list" v-if="showSoft">
                <div class="provider-item" v-for="(item, key, index) in site.software" :key="key">
                  <div class="inner">
                    <div class="row">
                      <span>{{ item.name }}</span>
                      <i class="fas fa-edit"></i>
                      <i class="icon fa-solid fa-lock"></i>
                    </div>
                  </div>
                  <div class="inner">
                    <div class="row">
                      <span>{{ item.url }}</span>
                      <i class="icon fa-solid fa-lock"></i>
                    </div>
                  </div>
                </div>
                <!-- end .provider-list -->
              </div>
            </div>
            <div class="mb-5">
              <div class="text-block">
                <em class="gray-text">Billing Source:</em>
              </div>
              <div class="card-content">
                <div class="info">
                  <p class="card-title">{{ site.name }}</p>
                  <span class="card-link">{{ site.url }}</span>
                </div>
                <div class="card-logo">
                  <img v-if="site.icon" :src="site.icon"/>
                  <span v-else>Logo</span>
                </div>
                <span class="card-color" :style="{ backgroundColor: site.color }"></span>
              </div>
              <div class="host-site-detail">
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
            </div>
            <div class="mb-5 last-host">
              <div class="card-content">
                <div class="info">
                  <p class="card-title">{{ provider.name }}</p>
                  <span class="card-link">{{ provider.url }}</span>
                </div>
                <div class="card-logo">
                  <img v-if="site.icon" :src="site.icon"/>
                  <span v-else>Logo</span>
                </div>
                <span class="card-color" :style="{ backgroundColor: site.color }"></span>
              </div>
              <div class="service-form detail host">
                <div class="form-container">
                  <div class="left-line"></div>
                  <div class="form-group-wrap bg-grey p-6 pt-4 globe-div">
                    <div class="globe">
                      <i class="fa-solid fa-globe"></i>
                    </div>
                    <div class="form-group right-side">
                      <b>{{ provider.name }}</b>
                    </div>
                    <div class="form-group right-side">
                      <em>{{ provider.url }}</em>
                    </div>
                  </div>
                  <div class="form-group-wrap p-6 pt-4">
                    <i class="fa-solid fa-sack-dollar"></i> <span class="card-title"> $ {{ provider.cost }}</span>
                    <div class="dark-line"></div>
                  </div>
                  <div class="form-group-wrap bg-grey p-6 pt-4 subscribe">
                    <div class="globe">
                      <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="form-group right-side">
                      <em>Next Deadline:</em> <span>{{ provider.renewal_date }}</span>
                    </div>
                    <div class="form-group right-side">
                      <em>Renewal Type:</em> <span>{{ provider.renewal_type }}</span>
                    </div>
                    <div class="form-group right-side">
                      <em>Last 4 digits of CC:</em> <span>{{ provider.cc }}</span>
                    </div>
                  </div>
                  <div class="form-group-wrap p-6 pt-4">
                    <i class="fa-solid fa-key"></i> <span class="text"> Login Information</span>
                    <div class="dark-line"></div>
                  </div>
                  <div class="form-group-wrap p-6 pt-4 user-detail">
                    <div class="form-group form-group-icon">
                      <input readonly type="text" id="userName" :value="userName"
                             :placeholder="provider.user_mame">
                      <i class="fa-regular fa-user"></i>
                      <i class="fa-regular fa-copy" @click="copy('#userName')"></i>
                    </div>
                    <div class="form-group form-group-icon">
                      <input readonly v-bind:type="[showPasswordSoft ? 'text' : 'password']" id="password"
                             :value="password" :placeholder="provider.password">
                      <i class="fa-solid fa-lock"></i>
                      <i class="fa-solid fa-eye-slash" @click="showTextPass('showPasswordSoft')"
                         v-if="!showPasswordSoft"></i>
                      <i class="fa-solid fa-eye" @click="showTextPass('showPasswordSoft')"
                         v-if="showPasswordSoft"></i>
                      <i class="fa-regular fa-copy" @click="copy('#password')"></i>
                    </div>
                    <div class="form-group form-group-icon m-0">
                      <input readonly v-bind:type="[showPinSoft ? 'text' : 'password']" id="pin" :value="pin"
                             :placeholder="provider.pin">
                      <i class="fa-solid fa-fingerprint"></i>
                      <i class="fa-solid fa-eye-slash" @click="showTextPin('showPinSoft')" v-if="!showPinSoft"></i>
                      <i class="fa-solid fa-eye" @click="showTextPin('showPinSoft')" v-if="showPinSoft"></i>
                      <i class="fa-regular fa-copy" @click="copy('#pin')"></i>
                    </div>
                  </div>
                </div>
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
    site: Array,
    provider: Array,
  },
  data() {
    return {
      serviceShow: false,
      showSoft: false,
      element: {},
      elementSoft: {},
      userName: '',
      password: '',
      pin: '',
      showPassword: false,
      showPin: false,
      showPasswordSoft: false,
      showPinSoft: false,
      form: useForm({
        id: '',
        url: '',
        file: '',
        name: '',
        color: '',
        company: '',
        tags: '',
        shared_with: '',
        business_unit: '',
        notes: '',
        softwares: [],
        providers: [],
      })
    }
  },
  methods: {
    showProvider() {
      this.serviceShow = !this.serviceShow;
    },
    showSoftware() {
      this.showSoft = !this.showSoft;
    },
    showTextPass(typeEl) {
      if (typeEl === 'showPasswordSoft') {
        this.showPasswordSoft = !this.showPasswordSoft;
      } else {
        this.showPassword = !this.showPassword;
      }
      event.preventDefault();
      event.stopPropagation();
      return false;
    },
    showTextPin(typeEl) {
      if (typeEl === 'showPinSoft') {
        this.showPinSoft = !this.showPinSoft;
      } else {
        this.showPin = !this.showPin;
      }
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

  }
}
</script>
