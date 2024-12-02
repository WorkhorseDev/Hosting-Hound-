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
              <div v-for="(item, key, index) in site.provider" :key="key">
                <div class="card-content detail" @click="showDetail(item, key)">
                  <div class="info">
                    <p class="card-title">{{ item.name }}</p>
                    <span class="card-link">{{ item.url }}</span>
                  </div>
                  <i v-if="!item.show" class="fa-solid fa-sort-up"></i>
                  <i v-if="item.show" class="fa-solid fa-sort-down"></i>
                  <span class="card-color" style="backgroundColor: #000"></span>
                </div>
                <div class="service-form detail edit-provider" :id="'idEditProvider'+key">
                  <div class="form-container">
                    <div class="form-header">
                      <span @click="hideProvider(key)" class="btn-back"><i class="fas fa-arrow-left detail"></i></span>
                      <i @click="deleteProvider(key)" class="fa-solid fa-trash-can detail"></i>
                    </div>

                    <div class="form-group-wrap bg-grey p-6 pt-4 globe-div">
                      <div class="globe">
                        <i class="fa-solid fa-globe"></i>
                      </div>
                      <div class="form-group right-side">
                        <select v-model="element.type" v-bind:value="element.type">
                          <option>Host</option>
                          <option>Domain Register</option>
                          <option>Email Plan Provider</option>
                          <option>SSL Provider</option>
                        </select>
                      </div>

                      <div class="form-group right-side">
                        <input type="text" v-model="element.name" placeholder="Name" v-bind:value="element.name">
                      </div>

                      <div class="form-group right-side">
                        <input type="text" v-model="element.url" placeholder="Web URL" v-bind:value="element.url">
                      </div>
                    </div>

                    <div class="form-group-wrap p-6 pt-4">
                      <div class="form-group">
                        <label>Renewal Type</label>
                        <select class="bg-grey" v-model="element.renewal_type" v-bind:value="element.renewal_type">
                          <option>Annual</option>
                          <option>Monthly</option>
                          <option>Weekly</option>
                        </select>
                      </div>

                      <div class="form-row">
                        <div class="form-group">
                          <label>Cost</label>
                          <input class="bg-grey" type="text" placeholder="$ 00.00" v-model="element.cost" v-bind:value="element.cost">
                        </div>
                        <div class="form-group m-0">
                          <label>Renewal Date</label>
                          <div class="form-group form-group-icon">
                            <input class="bg-grey" type="text" v-model="element.renewal_date" v-bind:value="element.renewal_date"
                                   placeholder="00 / 00 / 00">
                            <i class="fa-solid fa-calendar"></i>
                          </div>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group">
                          <label>Bills to CC ending in</label>
                          <input class="bg-grey cc" type="text" placeholder="####" v-model="element.cc" v-bind:value="element.cc">
                        </div>
                      </div>
                    </div>

                    <div class="form-group-wrap bg-grey p-6 pt-4 security-group">
                      <div class="form-group form-group-icon">
                        <input type="text" placeholder="UserName" v-model="element.user_mame" v-bind:value="element.user_mame">
                        <i class="fa-regular fa-user"></i>
                      </div>

                      <div class="form-group form-group-icon">
                        <input type="password" placeholder="••••••••" v-model="element.password" v-bind:value="element.password">
                        <i class="fa-solid fa-lock"></i>
                      </div>

                      <div class="form-group form-group-icon m-0">
                        <input type="text" placeholder="PIN" v-model="element.pin" v-bind:value="element.pin">
                        <i class="fa-solid fa-fingerprint"></i>
                      </div>
                    </div>

                    <div class="form-footer p-5">
                      <button type="button" class="btn" @click="editSiteProvider(key, element)">Save Changes</button>
                    </div>
                  </div>
                </div>
                <div class="service-form detail" :id="'id'+key">
                  <div class="form-container">
                    <div class="form-header"><span class="serv-detail">{{ element.type }}</span><i
                        class="fa-solid fa-pen" @click="editProvider(element, key)"></i></div>
                    <div class="form-group-wrap bg-grey p-6 pt-4 globe-div">
                      <div class="globe">
                        <i class="fa-solid fa-globe"></i>
                      </div>
                      <div class="form-group right-side">
                        <b>{{ element.name }}</b>
                      </div>
                      <div class="form-group right-side">
                        <em>{{ element.url }}</em>
                      </div>
                    </div>
                    <div class="form-group-wrap p-6 pt-4">
                      <i class="fa-solid fa-sack-dollar"></i> <span class="card-title"> $ {{ element.cost }}</span>
                      <div class="dark-line"></div>
                    </div>
                    <div class="form-group-wrap bg-grey p-6 pt-4 subscribe">
                      <div class="globe">
                        <i class="fas fa-hourglass-half"></i>
                      </div>
                      <div class="form-group right-side">
                        <em>Next Deadline:</em> <span>{{ element.renewal_date }}</span>
                      </div>
                      <div class="form-group right-side">
                        <em>Renewal Type:</em> <span>{{ element.renewal_type }}</span>
                      </div>
                      <div class="form-group right-side">
                        <em>Last 4 digits of CC:</em> <span>{{ element.cc }}</span>
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
                        <input readonly v-bind:type="[showPassword ? 'text' : 'password']" id="password"
                               :value="password" :placeholder="element.password">
                        <i class="fa-solid fa-lock"></i>
                        <i class="fa-solid fa-eye-slash" @click="showTextPass('showPassword')" v-if="!showPassword"></i>
                        <i class="fa-solid fa-eye" @click="showTextPass('showPassword')" v-if="showPassword"></i>
                        <i class="fa-regular fa-copy" @click="copy('#password')"></i>
                      </div>
                      <div class="form-group form-group-icon m-0">
                        <input readonly v-bind:type="[showPin ? 'text' : 'password']" id="pin" :value="pin"
                               :placeholder="element.pin">
                        <i class="fa-solid fa-fingerprint"></i>
                        <i class="fa-solid fa-eye-slash" @click="showTextPin('showPin')" v-if="!showPin"></i>
                        <i class="fa-solid fa-eye" @click="showTextPin('showPin')" v-if="showPin"></i>
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
              <div v-for="(item, key, index) in site.software" :key="key">
                <div class="card-content detail"  @click="showDetailSoft(item, key)">
                  <div class="info">
                    <p class="card-title">{{ item.name }}</p>
                    <span class="card-link">{{ item.url }}</span>
                  </div>
                  <i v-if="!item.showSoft" class="fa-solid fa-sort-up"></i>
                  <i v-if="item.showSoft" class="fa-solid fa-sort-down"></i>
                  <span class="card-color" style="backgroundColor: #000"></span>
                </div>
                <div class="service-form detail edit-provider" :id="'idEditSoft'+key">
                  <div class="form-container">
                    <div class="form-header">
                    <span @click="hideSoft(key)" class="btn-back"><i class="fas fa-arrow-left detail"></i></span>
                    <i @click="deleteSoft(key)" class="fa-solid fa-trash-can detail"></i>
                  </div>

                    <div class="form-group-wrap bg-grey p-6 pt-4 globe-div">
                      <div class="globe">
                        <i class="fa-solid fa-globe"></i>
                      </div>
                      <div class="form-group right-side">
                        <select v-bind:value="elementSoft.type" v-model="elementSoft.type">
                          <option>Software</option>
                          <option>CMS</option>
                          <option>Theme</option>
                          <option>Plugin</option>
                          <option>Other</option>
                        </select>
                      </div>

                      <div class="form-group right-side">
                        <input type="text" placeholder="Name" v-model="elementSoft.name" v-bind:value="elementSoft.name">
                      </div>

                      <div class="form-group right-side">
                        <input type="text" placeholder="Web URL" v-model="elementSoft.url" v-bind:value="elementSoft.url">
                      </div>
                    </div>

                    <div class="form-group-wrap p-6 pt-4">
                      <div class="form-group">
                        <label>Renewal Type</label>
                        <select class="bg-grey" v-bind:value="elementSoft.renewal_type" v-model="elementSoft.renewal_type">
                          <option>Annual</option>
                          <option>Monthly</option>
                          <option>Weekly</option>
                        </select>
                      </div>

                      <div class="form-row">
                        <div class="form-group">
                          <label>Cost</label>
                          <input class="bg-grey" type="text" placeholder="$ 00.00" v-model="elementSoft.cost" v-bind:value="elementSoft.cost">
                        </div>
                        <div class="form-group m-0">
                          <label>Renewal Date</label>
                          <div class="form-group form-group-icon">
                            <input class="bg-grey" type="text" placeholder="00 / 00 / 00" v-model="elementSoft.renewal_date" v-bind:value="elementSoft.renewal_date">
                            <i class="fa-solid fa-calendar"></i>
                          </div>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group">
                          <label>Bills to CC ending in</label>
                          <input class="bg-grey cc" type="text" placeholder="####" v-model="elementSoft.cc" v-bind:value="elementSoft.cc">
                        </div>
                      </div>
                    </div>

                    <div class="form-group-wrap bg-grey p-6 pt-4 security-group">
                      <div class="form-group form-group-icon">
                        <input type="text" placeholder="UserName" v-model="elementSoft.user_mame" v-bind:value="elementSoft.user_mame">
                        <i class="fa-regular fa-user"></i>
                      </div>

                      <div class="form-group form-group-icon">
                        <input type="password" placeholder="••••••••" v-model="elementSoft.password" v-bind:value="elementSoft.password">
                        <i class="fa-solid fa-lock"></i>
                      </div>

                      <div class="form-group form-group-icon m-0">
                        <input type="text" placeholder="PIN" v-model="elementSoft.pin" v-bind:value="elementSoft.pin">
                        <i class="fa-solid fa-fingerprint"></i>
                      </div>
                    </div>

                    <div class="form-footer p-5">
                      <button type="button" class="btn" @click="editSiteSoft(key, elementSoft)">Save Provider</button>
                    </div>
                  </div>
                </div>
                <div class="service-form detail" :id="'idSoft'+key">
                  <div class="form-container">
                    <div class="form-header"><span class="serv-detail">{{ elementSoft.type }}</span><i
                        class="fa-solid fa-pen" @click="editSoft(elementSoft, key)"></i></div>
                    <div class="form-group-wrap bg-grey p-6 pt-4 globe-div">
                      <div class="globe">
                        <i class="fa-solid fa-globe"></i>
                      </div>
                      <div class="form-group right-side">
                        <b>{{ elementSoft.name }}</b>
                      </div>
                      <div class="form-group right-side">
                        <em>{{ elementSoft.url }}</em>
                      </div>
                    </div>
                    <div class="form-group-wrap p-6 pt-4">
                      <i class="fa-solid fa-sack-dollar"></i> <span class="card-title"> $ {{ elementSoft.cost }}</span>
                      <div class="dark-line"></div>
                    </div>
                    <div class="form-group-wrap bg-grey p-6 pt-4 subscribe">
                      <div class="globe">
                        <i class="fas fa-hourglass-half"></i>
                      </div>
                      <div class="form-group right-side">
                        <em>Next Deadline:</em> <span>{{ elementSoft.renewal_date }}</span>
                      </div>
                      <div class="form-group right-side">
                        <em>Renewal Type:</em> <span>{{ elementSoft.renewal_type }}</span>
                      </div>
                      <div class="form-group right-side">
                        <em>Last 4 digits of CC:</em> <span>{{ elementSoft.cc }}</span>
                      </div>
                    </div>
                    <div class="form-group-wrap p-6 pt-4">
                      <i class="fa-solid fa-key"></i> <span class="text"> Login Information</span>
                      <div class="dark-line"></div>
                    </div>
                    <div class="form-group-wrap p-6 pt-4 user-detail">
                      <div class="form-group form-group-icon">
                        <input readonly type="text" id="userName" :value="userName"
                               :placeholder="elementSoft.user_mame">
                        <i class="fa-regular fa-user"></i>
                        <i class="fa-regular fa-copy" @click="copy('#userName')"></i>
                      </div>
                      <div class="form-group form-group-icon">
                        <input readonly v-bind:type="[showPasswordSoft ? 'text' : 'password']" id="password"
                               :value="password" :placeholder="elementSoft.password">
                        <i class="fa-solid fa-lock"></i>
                        <i class="fa-solid fa-eye-slash" @click="showTextPass('showPasswordSoft')"
                           v-if="!showPasswordSoft"></i>
                        <i class="fa-solid fa-eye" @click="showTextPass('showPasswordSoft')"
                           v-if="showPasswordSoft"></i>
                        <i class="fa-regular fa-copy" @click="copy('#password')"></i>
                      </div>
                      <div class="form-group form-group-icon m-0">
                        <input readonly v-bind:type="[showPinSoft ? 'text' : 'password']" id="pin" :value="pin"
                               :placeholder="elementSoft.pin">
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
    deleteProvider(key) {
      this.site.provider.splice(key, 1);
     this.editSite();
    },
    deleteSoft(key) {
      this.site.software.splice(key, 1);
      this.editSite();
    },
    editSiteSoft(key, data)
    {
      this.site.software[key].name = data.name;
      this.site.software[key].url = data.url;
      this.site.software[key].type = data.type;
      this.site.software[key].renewal_type = data.renewal_type;
      this.site.software[key].cost = data.cost;
      this.site.software[key].renewal_date = data.renewal_date;
      this.site.software[key].user_mame = data.user_mame;
      this.site.software[key].password = data.password;
      this.site.software[key].pin = data.pin;
      this.site.software[key].cc = data.cc;
      this.editSite();
    },
    editSiteProvider(key, data)
    {
      this.site.provider[key].name = data.name;
      this.site.provider[key].url = data.url;
      this.site.provider[key].type = data.type;
      this.site.provider[key].renewal_type = data.renewal_type;
      this.site.provider[key].cost = data.cost;
      this.site.provider[key].renewal_date = data.renewal_date;
      this.site.provider[key].user_mame = data.user_mame;
      this.site.provider[key].password = data.password;
      this.site.provider[key].pin = data.pin;
      this.site.provider[key].cc = data.cc;
      this.editSite();
    },
    editSite() {
      this.form.id = this.site._id;
      this.form.name = this.site.name;
      this.form.url = this.site.url;
      this.form.color = this.site.color;
      this.form.icon = this.site.icon;
      this.form.company = this.site.company;
      this.form.business_unit = this.site.business_unit;
      this.form.tags = this.site.tags;
      this.form.shared_with = this.site.shared_with;
      this.form.notes = this.site.notes;
      this.form.providers = this.site.provider;
      this.form.softwares = this.site.software;
      this.form.post(route('editSite'), {});
    },
    editProvider(el, key) {
      var block = document.getElementById('id' + key);
      block.style.display = "none";
      var editBlock = document.getElementById('idEditProvider' + key);
      editBlock.style.display = "block";
    },
    hideProvider(key) {
      var block = document.getElementById('id' + key);
      block.style.display = "block";
      var editBlock = document.getElementById('idEditProvider' + key);
      editBlock.style.display = "none";
    },
    editSoft(el, key) {
      var block = document.getElementById('idSoft' + key);
      block.style.display = "none";
      var editBlock = document.getElementById('idEditSoft' + key);
      editBlock.style.display = "block";
    },
    hideSoft(key) {
      var block = document.getElementById('idSoft' + key);
      block.style.display = "block";
      var editBlock = document.getElementById('idEditSoft' + key);
      editBlock.style.display = "none";
    },
    showDetail(item, key) {
      var el = document.getElementById('id' + key);
      el.style.display = "block";
      if (!item.show) {
        el.style.display = "none";
      }
      item.show = !item.show;
      this.element.type = item.type;
      this.userName = this.element.name = item.name;
      this.element.url = item.url;
      this.element.renewal_type = item.renewal_type;
      this.element.cost = item.cost;
      this.element.renewal_date = item.renewal_date;
      this.element.user_mame = item.user_mame;
      this.password = this.element.password = item.password;
      this.pin = this.element.pin = item.pin;
      this.cc = this.element.cc = item.cc;
    },

    showDetailSoft(item, key) {
      var el = document.getElementById('idSoft' + key);
      el.style.display = "block";
      if (!item.showSoft) {
        el.style.display = "none";
      }
      item.showSoft = !item.showSoft;
      this.elementSoft.type = item.type;
      this.userName = this.elementSoft.name = item.name;
      this.elementSoft.url = item.url;
      this.elementSoft.renewal_type = item.renewal_type;
      this.elementSoft.cost = item.cost;
      this.elementSoft.renewal_date = item.renewal_date;
      this.elementSoft.user_mame = item.user_mame;
      this.password = this.elementSoft.password = item.password;
      this.pin = this.elementSoft.pin = item.pin;
      this.elementSoft.cc = item.cc;
    }
  }
}
</script>
