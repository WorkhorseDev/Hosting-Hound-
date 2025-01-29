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
      <header class="header hidden md:flex">
        <div class="tabs">
          <Link :href="route('dashboard')" class="tab-item is-active">
            <span class="">Websites</span>
          </Link>
          <Link :href="route('billing')" href="#" class="tab-item">
            <span class="">Billings</span>
          </Link>
        </div>

        <div class="links">
                    <span class="link-item link-item_add hidden">
                       <button type="submit"><i class="fas fa-add"></i></button>
                    </span>
          <span class="link-item link-item_user">
                       <Link :href="route('profile')"> <i class="fas fa-user"></i></Link>
                    </span>
        </div>
      </header>
      <vf-form @submit.prevent="submit" id="addSite">
        <div class="main-panel main-panel_edit main-panel_new">
          <div class="flex flex-row items-center w-full md:w-auto">
            <div class="pr-6 b-back">
              <span @click="goBack" class="btn-back"><i class="fas fa-arrow-left"></i></span>
            </div>
            <div class="panel-title">
                <span class="hidden md:inline">Add Website</span>
                <span class="md:hidden">New Site</span>
            </div>
          </div>
          <div class="panel-controls flex flex-row justify-end items-center">
            <button type="submit" @click="submit" class="btn-md btn-inverted">Save Changes</button>
            <button class="btn-remove">
              <i class="fa fa-trash-can" v-if="path !== '/addSite'"></i>
            </button>
            <button class="btn-edit hidden md:flex">
              <i class="fa-solid fa-pencil" v-if="path !== '/addSite'"></i>
              <i class="fa-solid fa-pencil" style="color: #979797" v-if="path == '/addSite'"></i>
            </button>
          </div>
        </div>
        <main class="main-content add-site">
          <div class="inner">
            <div class="grid grid-cols-3 gap-4">
              <div>
                <div class="mb-5">
                  <label for="url" class="block text-sm font-medium leading-6 text-gray-900">URL</label>
                  <div class="mt-2">
                      <TextInput v-model="form.url" required id="url" name="url" type="text" autocomplete="url"
                               placeholder="http://www.website.com"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6"/>
                    <InputError v-if="urlError" class="mt-2" :message="form.errors.url"/>
                  </div>
                </div>

                <div class="site-name-wrap">
                    <div class="mb-5 left">
                        <label for="file-upload" class="block text-sm font-medium leading-6 text-gray-900">Icon</label>
                        <div class="mt-2">
                            <label  for="file" class="preview block text-sm font-medium leading-6 text-gray-900">
                                <i v-if="!img"  class="fa-solid fa-plus"></i>
                                <img class="previe" v-if="img" :src="img"/>
                            </label>
                            <input class="file" id="file" type="file" hidden="hidden"
                                   @change="appendFile($event.target.name, $event.target.files)"
                                   ref="file">
                        </div>
                    </div>

                    <div class="right-group">
                        <div class="mb-5 right">
                            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                            <div class="mt-2">
                                <input v-model="form.name" required id="name" name="name" type="text" autocomplete="name"
                                       placeholder="Website Name"
                                       class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <InputError v-if="nameError" class="mt-2" :message="form.errors.name"/>
                            </div>
                        </div>

                        <div class="mb-5 right color">
                            <label for="color" class="block text-sm font-medium leading-6 text-gray-900">Color</label>
                            <div class="mt-2 color-select-wrap">
                                <div id="color" v-bind:style="{background: color}" @click="itemShow = !itemShow"
                                     class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                    <div class="for-caret"><i class="fa-solid fa-caret-down"></i></div>
                                </div>
                                <div class="select-item" v-if="itemShow">
                                    <div style="background: #3D5F58" @click=setColor(dark_green)></div>
                                    <div style="background: #A7B57C" @click=setColor(light_green)></div>
                                    <div style="background: #FF920A" @click=setColor(orange)></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end .site-name-wrap -->

                <div class="mb-5"><span v-if="fileErr" class="text-red-600 text-sm">{{form.errors.fileErr}}</span></div>
                <div class="mb-5">
                  <label for="company" class="block text-sm font-medium leading-6 text-gray-900">Company</label>
                  <div class="mt-2">
                    <TextInput v-model="form.company" id="company" name="company" type="text" autocomplete="company"
                               placeholder="Company Name"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></TextInput>
                  </div>
                </div>

                <div class="mb-5">
                  <label for="business_unit" class="block text-sm font-medium leading-6 text-gray-900">Business
                    Unit</label>
                  <div class="mt-2">
                    <TextInput v-model="form.business_unit" id="business_unit" name="business_unit" type="text"
                               autocomplete="business_unit" placeholder="Business Unit Name"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></TextInput>
                  </div>
                </div>

                <div class="mb-5">
                  <label for="tags" class="block text-sm font-medium leading-6 text-gray-900">Tags</label>
                  <div class="mt-2">
                    <TextInput v-model="form.tags" id="tags" name="tags" type="text" autocomplete="tags"
                               placeholder="Type tags separated by commas"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></TextInput>
                  </div>
                </div>

                <div class="mb-5">
                  <label for="shared_with" class="block text-sm font-medium leading-6 text-gray-900">Shared
                    with:</label>
                  <div class="mt-2">
                    <textarea v-model="form.shared_with" id="shared_with" name="shared_with" rows="3"
                              placeholder="Type a name or email serparated by a comma…"
                              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                  </div>
                </div>

                <div class="mb-5">
                  <label for="notes" class="block text-sm font-medium leading-6 text-gray-900">Notes</label>
                  <div class="mt-2">
                    <textarea v-model="form.notes" id="notes" name="notes" rows="3" placeholder="Enter notes here"
                              class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                  </div>
                </div>
              </div>
              <div class="service mt-8 md:mt-0">
                <div class="mb-5">
                  <label class="block text-sm font-medium leading-6 text-gray-900 show-form"
                         @click="serviceShow = !serviceShow"> <i class="fa-solid fa-plus"></i> <span class="service">Service Providers</span>
                    <i class="fa-solid fa-caret-up"></i></label>
                </div>

                <div class="service-form" v-if="serviceShow">
                  <div class="form-container">
                    <div class="form-header">Add Provider</div>

                    <div class="form-group-wrap bg-grey p-6 pt-4 globe-div">
                      <div class="globe">
                        <i class="fa-solid fa-globe"></i>
                      </div>
                      <div class="form-group right-side">
                        <select v-model="form.provider.type">
                          <option>Host</option>
                          <option>Domain Register</option>
                          <option>Email Plan Provider</option>
                          <option>SSL Provider</option>
                        </select>
                      </div>

                      <div class="form-group right-side">
                        <input type="text" v-model="form.provider.name" placeholder="Name">
                      </div>

                      <div class="form-group right-side">
                        <input type="text" v-model="form.provider.url" placeholder="Web URL">
                      </div>
                    </div>

                    <div class="form-group-wrap p-6 pt-4">
                      <div class="form-group">
                        <label>Renewal Type</label>
                        <select class="bg-grey" v-model="form.provider.renewal_type">
                          <option>Annual</option>
                          <option>Monthly</option>
                          <option>Weekly</option>
                        </select>
                      </div>

                      <div class="form-row">
                        <div class="form-group">
                          <label>Cost</label>
                          <input class="bg-grey" type="text" placeholder="$ 00.00" v-model="form.provider.cost">
                        </div>
                        <div class="form-group m-0">
                          <label>Renewal Date</label>
                          <div class="form-group form-group-icon">
                            <VueDatePicker format="yyyy/MM/dd" v-model="form.provider.renewal_date"></VueDatePicker>
                            <i class="fa-solid fa-calendar"></i>
                          </div>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group">
                          <label>Bills to CC ending in</label>
                          <input class="bg-grey cc" type="text" placeholder="####" v-model="form.provider.cc">
                        </div>
                      </div>
                    </div>

                    <div class="form-group-wrap bg-grey p-6 pt-4 security-group">
                      <div class="form-group form-group-icon">
                        <input type="text" placeholder="UserName" v-model="form.provider.user_mame">
                        <i class="fa-regular fa-user"></i>
                      </div>

                      <div class="form-group form-group-icon">
                        <input type="password" placeholder="••••••••" v-model="form.provider.password">
                        <i class="fa-solid fa-lock"></i>
                      </div>

                      <div class="form-group form-group-icon m-0">
                        <input type="text" placeholder="PIN" v-model="form.provider.pin">
                        <i class="fa-solid fa-fingerprint"></i>
                      </div>
                    </div>

                    <div class="form-footer p-5">
                      <button class="cancel-btn"  @click="serviceShow = !serviceShow">Cancel</button>
                      <button  v-if="serviceSave === false" type="button" class="btn" @click="setProvider">Add Provider</button>
                      <button v-if="serviceSave !== false" type="button" class="btn" @click="saveProvider(serviceSave)">Save Provider</button>
                    </div>
                  </div>
                </div> <!-- end .service-form -->

                <div class="provider-list" v-if="!serviceShow">
                  <div class="provider-item"v-for="(item, key, index) in form.providers" :key="key">
                    <div class="inner">
                      <div class="row">
                        <span>{{ item.name }}</span>
                        <i class="fas fa-edit" @click="editProvider(key,item)"></i>
                        <i class="icon fa-solid fa-lock"></i>
                      </div>
                    </div>
                    <div class="inner">
                      <div class="row">
                        <span>{{item.url}}</span>
                        <i class="icon fa-solid fa-lock"></i>
                      </div>
                    </div>
                  </div>
                  <!-- end .provider-list -->
                </div>
              </div>
              <div class="software mt-8 md:mt-0">
                <div class="mb-5">
                  <label class="block text-sm font-medium leading-6 text-gray-900 show-form"
                         @click="showSoftware"> <i class="fa-solid fa-plus"></i> <span class="service">Software & Add-Ons</span>
                    <i class="fa-solid fa-caret-up"></i></label>
                </div>

                <div class="service-form" v-if="softwareShow">
                  <div class="form-container">
                    <div class="form-header">Add Software</div>

                    <div class="form-group-wrap bg-grey p-6 pt-4 globe-div">
                      <div class="globe">
                        <i class="fa-solid fa-globe"></i>
                      </div>
                      <div class="form-group right-side">
                        <select v-model="form.software.type">
                          <option>Software</option>
                          <option>CMS</option>
                          <option>Theme</option>
                          <option>Plugin</option>
                          <option>Other</option>
                        </select>
                      </div>

                      <div class="form-group right-side">
                        <input type="text" placeholder="Name" v-model="form.software.name">
                      </div>

                      <div class="form-group right-side">
                        <input type="text" placeholder="Web URL" v-model="form.software.url">
                      </div>
                    </div>

                    <div class="form-group-wrap p-6 pt-4">
                      <div class="form-group">
                        <label>Renewal Type</label>
                        <select class="bg-grey" v-model="form.software.renewal_type">
                          <option>Annual</option>
                          <option>Monthly</option>
                          <option>Weekly</option>
                        </select>
                      </div>

                      <div class="form-row">
                        <div class="form-group">
                          <label>Cost</label>
                          <input class="bg-grey" type="text" placeholder="$ 00.00" v-model="form.software.cost">
                        </div>
                        <div class="form-group m-0">
                          <label>Renewal Date</label>
                          <div class="form-group form-group-icon">
                            <VueDatePicker format="yyyy/MM/dd" v-model="form.software.renewal_date"></VueDatePicker>
                            <i class="fa-solid fa-calendar"></i>
                          </div>
                        </div>
                      </div>

                      <div class="form-row">
                        <div class="form-group">
                          <label>Bills to CC ending in</label>
                          <input class="bg-grey cc" type="text" placeholder="####" v-model="form.software.cc">
                        </div>
                      </div>
                    </div>

                    <div class="form-group-wrap bg-grey p-6 pt-4 security-group">
                      <div class="form-group form-group-icon">
                        <input type="text" placeholder="UserName" v-model="form.software.user_mame">
                        <i class="fa-regular fa-user"></i>
                      </div>

                      <div class="form-group form-group-icon">
                        <input type="password" placeholder="••••••••" v-model="form.software.password">
                        <i class="fa-solid fa-lock"></i>
                      </div>

                      <div class="form-group form-group-icon m-0">
                        <input type="text" placeholder="PIN" v-model="form.software.pin">
                        <i class="fa-solid fa-fingerprint"></i>
                      </div>
                    </div>

                    <div class="form-footer p-5">
                      <button class="cancel-btn"  @click="softwareShow = !softwareShow">Cancel</button>
                      <button class="btn" type="button"  v-if="softwareSave === false" @click="setSoftware">Add Provider</button>
                      <button v-if="softwareSave !== false" type="button" class="btn" @click="saveSoftware(softwareSave)">Save Provider</button>
                    </div>
                  </div>
                </div>
                <div class="software-list" v-if="!softwareShow">
                  <div class="software-item" v-for="(item, key, index) in form.softwares" :key="key">
                    <div class="inner">
                      <div class="row">
                        <span>{{item.name}}</span>
                        <i class="fas fa-edit" @click="editSoftware(key,item)"></i>
                        <i class="icon fa-solid fa-lock"></i>
                      </div>
                    </div>
                    <div class="inner">
                      <div class="row">
                        <span>{{item.url}}</span>
                        <i class="icon fa-solid fa-lock"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div> <!-- end .software -->

              <div class="form-footer flex justify-center mt-10 md:hidden">
                  <button type="submit" class="btn" @click="submit" >Save Changes</button>
              </div>
            </div>
          </div>
        </main>
      </vf-form>
    </div>
  </div> <!-- end .wrapper -->
</template>
<script>
import {reactive} from "vue";
import {useForm} from "@inertiajs/vue3";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

export default {
  methods: {
    editProvider(key,item) {
      this.form.provider= {
        type: item.type,
        name: item.name,
        url: item.url,
        renewal_type: item.renewal_type,
        cost: item.cost,
        renewal_date: item.renewal_date,
        user_mame: item.user_mame,
        password: item.password,
        pin: item.pin,
        cc: item.cc
      };
      this.serviceShow = true;
      this.serviceSave = key;
    },
    editSoftware(key,item) {
      this.form.software= {
        type: item.type,
        name: item.name,
        url: item.url,
        renewal_type: item.renewal_type,
        cost: item.cost,
        renewal_date: item.renewal_date,
        user_mame: item.user_mame,
        password: item.password,
        pin: item.pin,
        cc: item.cc
      };
      this.softwareShow = true;
      this.softwareSave = key;
    },
    goBack() {
      window.history.back();
    },
    setColor(color) {
      this.itemShow = false;
      this.color = color;
    },
    appendFile(name, files) {
      this.fileErr = false;
      this.formFile.filename = name;
      this.formFile.file = files[0];
      const file = files[0];
      if (file.size > 500 * 1024) {
        this.fileErr = true;
        this.form.errors.fileErr = "File should be smaller than 500Kb";
        return false;
      }
      this.img = URL.createObjectURL(file);
    },
    submit() {
      if(this.form.url === '') {
        this.urlError = true;
        this.form.errors.url = "Field URL is required";
        return false;
      }
      if(this.form.name === '') {
        this.nameError = true;
        this.form.errors.name = "Field Name is required";
        return false;
      }
      if(this.form.providers.length === 0) {
        this.form.providers.push(this.form.provider);
      }
      if(this.form.softwares.length === 0) {
        this.form.softwares.push(this.form.software);
      }
      this.form.file = ['file', this.formFile.file, this.formFile.filename];
      if (this !== undefined && this.color) {
        this.form.color = this.color;
      }
      this.form.post(route('saveSite'), {
        onFinish: () => this.form.get(route('dashboard'))
      });
    },
    setSoftware() {
      this.softwareShow = false;
      this.form.softwares.push(this.form.software);
      this.form.software= {
        type: '',
        name:'',
        url: '',
        renewal_type: '',
        cost: '',
        renewal_date: '',
        user_mame: '',
        password: '',
        pin: '',
        cc: ''
      };
    },
    saveSoftware(key) {
      this.softwareShow = false;
      this.softwareSave = false;
      this.form.softwares[key].type =  this.form.software.type;
      this.form.softwares[key].name =  this.form.software.name;
      this.form.softwares[key].url =  this.form.software.url;
      this.form.softwares[key].renewal_type =  this.form.software.renewal_type;
      this.form.softwares[key].cost =  this.form.software.cost;
      this.form.softwares[key].renewal_date =  this.form.software.renewal_date;
      this.form.softwares[key].user_mame =  this.form.software.user_mame;
      this.form.softwares[key].password =  this.form.software.password;
      this.form.softwares[key].pin =  this.form.software.pin;
      this.form.softwares[key].cc =  this.form.software.cc;
      this.form.software= {
        type: '',
        name:'',
        url: '',
        renewal_type: '',
        cost: '',
        renewal_date: '',
        user_mame: '',
        password: '',
        pin: '',
        cc: ''
      };
    },
    saveProvider(key) {
      this.serviceShow = false;
      this.serviceSave = false;
      this.form.providers[key].type =  this.form.provider.type;
      this.form.providers[key].name =  this.form.provider.name;
      this.form.providers[key].url =  this.form.provider.url;
      this.form.providers[key].renewal_type =  this.form.provider.renewal_type;
      this.form.providers[key].cost =  this.form.provider.cost;
      this.form.providers[key].renewal_date =  this.form.provider.renewal_date;
      this.form.providers[key].user_mame =  this.form.provider.user_mame;
      this.form.providers[key].password =  this.form.provider.password;
      this.form.providers[key].pin =  this.form.provider.pin;
      this.form.providers[key].cc =  this.form.provider.cc;
      this.form.provider= {
        type: '',
        name:'',
        url: '',
        renewal_type: '',
        cost: '',
        renewal_date: '',
        user_mame: '',
        password: '',
        pin: '',
        cc: ''
      };
    },
    setProvider() {
      this.serviceShow = false;
      this.form.providers.push(this.form.provider);
      this.form.provider= {
            type: '',
            name:'',
            url: '',
            renewal_type: '',
            cost: '',
            renewal_date: '',
            user_mame: '',
            password: '',
            pin: '',
            cc: ''
      };
    },
    showSoftware() {
      this.softwareShow = !this.softwareShow
    }
  },
  data() {
    return {
      nameError: false,
      urlError: false,
      fileErr: false,
      softwareName: 'Host Name',
      softwareHost: 'https://www.host.com',
      providerName: 'Host Name',
      providerHost: 'https://www.host.com',
      itemShow: false,
      path: window.location.pathname,
      serviceShow: false,
      softwareShow: false,
      showMe: false,
      img: '',
      color: '#FF920A',
      orange: '#FF920A',
      dark_green: '#3D5F58',
      light_green: '#A7B57C',
      formFile: reactive({
        name: "",
        file: null,
        filename: null
      }),
      serviceSave: false,
      softwareSave: false,
      form: useForm({
        url: '',
        file: '',
        name: '',
        color: '',
        company: '',
        tags: '',
        shared_with: '',
        business_unit: '',
        notes: '',
        provider: {
            type: '',
            name:'',
            url: '',
            renewal_type: '',
            cost: '',
            renewal_date: '',
            user_mame: '',
            password: '',
            pin: '',
            cc: ''
        },
        softwares: [],
        providers: [],
        software: {
          type: '',
          name:'',
          url: '',
          renewal_type: '',
          cost: '',
          renewal_date: '',
          user_mame: '',
          password: '',
          pin: '',
          cc: ''
        }
      })
    };
  },
};
</script>

