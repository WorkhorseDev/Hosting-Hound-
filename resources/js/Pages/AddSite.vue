<script setup>

import {Head, useForm} from "@inertiajs/vue3";
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
                    <span class="link-item link-item_add hidden">
                       <button type="submit"><i class="fas fa-add"></i></button>
                    </span>
          <span class="link-item link-item_user">
                        <i class="fas fa-user"></i>
                    </span>
        </div>
      </header>
      <form @submit.prevent="submit" id="addSite">
        <div class="main-panel main-panel_edit">
          <div class="flex flex-row items-center">
            <div class="pr-6">
              <span @click="goBack" class="btn-back"><i class="fas fa-arrow-left"></i></span>
            </div>
            <div class="panel-title">Add Website</div>
          </div>
          <div class="panel-controls flex flex-row justify-end items-center">
            <button type="submit" class="btn-md btn-inverted">Save Changes</button>
            <button class="btn-remove">
              <i class="fa fa-trash-can" v-if="path !== '/addSite'"></i>
            </button>
            <button class="btn-edit">
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
                    <InputError class="mt-2" :message="form.errors.name"/>
                  </div>
                </div>

                <div class="mb-5 left">
                  <label for="file-upload" class="block text-sm font-medium leading-6 text-gray-900">Icon</label>
                  <div class="mt-2">
                    <img class="previe" v-if="img" :src="img"/>
                    <label v-if="!img" for="file" class="preview block text-sm font-medium leading-6 text-gray-900"> <i
                        class="fa-solid fa-plus"></i> </label>
                    <input class="file" id="file" type="file" hidden="hidden"
                           @change="appendFile($event.target.name, $event.target.files)"
                           ref="file">
                  </div>
                </div>

                <div class="mb-5 right">
                  <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                  <div class="mt-2">
                    <input v-model="form.name" required id="name" name="name" type="text" autocomplete="name"
                           placeholder="Website Name"
                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                  </div>
                </div>

                <div class="mb-5 right color">
                  <label for="color" class="block text-sm font-medium leading-6 text-gray-900">Color</label>
                  <div class="mt-2">
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
              <div class="service">
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
                        <input type="text" v-model="form.provider.name" placeholder="Host Name">
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
                            <input class="bg-grey" type="text" v-model="form.provider.renewal_date" placeholder="00 / 00 / 00">
                            <i class="fa-solid fa-calendar"></i>
                          </div>
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
                      <button type="button" class="btn" @click="setProvider">Add Provider</button>
                    </div>
                  </div>
                </div>

                <div class="provider-list" v-if="!serviceShow">
                  <div class="provider-item">
                    <div class="inner">
                      <div class="row">
                        <span>{{ providerName }}</span>
                        <i class="icon fa-solid fa-lock"></i>
                      </div>
                    </div>
                    <div class="inner">
                      <div class="row">
                        <span>{{providerHost}}</span>
                        <i class="icon fa-solid fa-lock"></i>
                      </div>
                    </div>
                  </div>
                  <!-- end .provider-list -->
                </div>
              </div>
              <div class="software">
                <div class="mb-5">
                  <label class="block text-sm font-medium leading-6 text-gray-900 show-form"
                         @click="softwareShow = !softwareShow"> <i class="fa-solid fa-plus"></i> <span class="service">Software & Add-Ons</span>
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
                          <option>Host</option>
                          <option>Domain Register</option>
                          <option>Email Plan Provider</option>
                          <option>SSL Provider</option>
                        </select>
                      </div>

                      <div class="form-group right-side">
                        <input type="text" placeholder="Host Name" v-model="form.software.name">
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
                            <input class="bg-grey" type="text" placeholder="00 / 00 / 00" v-model="form.software.renewal_date">
                            <i class="fa-solid fa-calendar"></i>
                          </div>
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
                      <button class="btn" type="button" @click="setSoftware">Add Provider</button>
                    </div>
                  </div>
                </div>
                <div class="software-list" v-if="!softwareShow">
                  <div class="software-item">
                    <div class="inner">
                      <div class="row">
                        <span>{{softwareName}}</span>
                        <i class="icon fa-solid fa-lock"></i>
                      </div>
                    </div>
                    <div class="inner">
                      <div class="row">
                        <span>{{softwareHost}}</span>
                        <i class="icon fa-solid fa-lock"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
      </form>
    </div>
  </div> <!-- end .wrapper -->
</template>
<script>
import {reactive} from "vue";
import {useForm} from "@inertiajs/vue3";

export default {
  methods: {
    goBack() {
      window.history.back();
    },
    setColor(color) {
      this.itemShow = false;
      this.color = color;
    },
    appendFile(name, files) {
      this.formFile.filename = name;
      this.formFile.file = files[0];
      const file = files[0];
      this.img = URL.createObjectURL(file);
    },
    submit() {
      this.form.file = ['file', this.formFile.file, this.formFile.filename];
      if (this !== undefined && this.color) {
        this.form.color = this.color;
      }
      this.form.post(route('saveSite'), {
        onFinish: () => this.form.get(route('dashboard'))
      });
    },
    setSoftware() {
      this.softwareName = this.form.software.name;
      this.softwareHost = this.form.software.url;
      this.softwareShow = false;
    },

    setProvider() {
      this.providerName = this.form.provider.name;
      this.providerHost = this.form.provider.url;
      this.serviceShow = false;
    }
  },
  data() {
    return {
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
            pin: ''
        },
        software: {
          type: '',
          name:'',
          url: '',
          renewal_type: '',
          cost: '',
          renewal_date: '',
          user_mame: '',
          password: '',
          pin: ''
        }
      })
    };
  },
};
</script>

