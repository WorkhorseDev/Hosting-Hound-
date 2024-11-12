<script setup>

import {Head, Link, useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import {reactive} from "vue";

const form = useForm({
  url: '',
  file: '',
  name: '',
  color: '',
  company: '',
  tags: '',
  shared_with: '',
  business_unit: '',
  notes: ''
});

const formFile = reactive({
  name: "",
  file: null,
  filename: null
});
const appendFile = (name, files) => {
  formFile.filename = name;
  formFile.file = files[0];
}

const submit = () => {
  form.file =['file', formFile.file, formFile.filename];
  form.color = this.color;
  form.post(route('saveSite'), {
    onFinish: () => window.history.back(),
  });
};
const path = window.location.pathname;
</script>

<template>
    <Head title="Add Site" />

    <div class="wrapper">
        <div class="container dashboard">
          <form @submit.prevent="submit">
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
                        <div class="">
                            <form action="">
                                <div class="mb-5">
                                    <label for="url" class="block text-sm font-medium leading-6 text-gray-900">URL</label>
                                    <div class="mt-2">
                                      <TextInput v-model="form.url" id="url" name="url" type="text" autocomplete="url" placeholder="http://www.website.com" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6"></TextInput>
                                    </div>
                                </div>

                              <div class="mb-5 left">
                                <label for="file-upload" class="block text-sm font-medium leading-6 text-gray-900">Icon </label>
                                <div class="mt-2">
                                  <label for="file" class="preview block text-sm font-medium leading-6 text-gray-900"> <i class="fa-solid fa-plus"></i> </label>
                                  <input class="file" id="file" type="file" hidden="hidden" @change="appendFile($event.target.name, $event.target.files)"
                                         ref="file">
                                </div>
                              </div>

                                <div class="mb-5 right">
                                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                                    <div class="mt-2">
                                      <TextInput v-model="form.name" id="name" name="name" type="text" autocomplete="name" placeholder="Website Name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></TextInput>
                                    </div>
                                </div>

                                <div class="mb-5 right color">
                                    <label for="color" class="block text-sm font-medium leading-6 text-gray-900">Color</label>
                                  <div class="mt-2">
                                    <div id="color" v-bind:style="{background: color}" @click="itemShow = !itemShow"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                      <div class="for-caret"><i class="fa-solid fa-caret-down"></i></div>
                                    </div>
                                    <div class="select-item" v-if="itemShow">
                                      <div style="background: #3D5F58" @click=setColor(dark_green)></div>
                                      <div style="background: #A7B57C" @click=setColor(light_green)></div>
                                      <div style="background: #FF920A" @click=setColor(orang)></div>
                                    </div>
                                  </div>
                                </div>

                                <div class="mb-5">
                                    <label for="company" class="block text-sm font-medium leading-6 text-gray-900">Company</label>
                                    <div class="mt-2">
                                      <TextInput v-model="form.company" id="company" name="company" type="text" autocomplete="company" placeholder="Company Name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></TextInput>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <label for="business_unit" class="block text-sm font-medium leading-6 text-gray-900">Business Unit</label>
                                    <div class="mt-2">
                                      <TextInput v-model="form.business_unit" id="business_unit" name="business_unit" type="text" autocomplete="business_unit" placeholder="Business Unit Name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></TextInput>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <label for="tags" class="block text-sm font-medium leading-6 text-gray-900">Tags</label>
                                    <div class="mt-2">
                                      <TextInput v-model="form.tags" id="tags" name="tags" type="text" autocomplete="tags" placeholder="Type tags separated by commas" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></TextInput>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <label for="shared_with" class="block text-sm font-medium leading-6 text-gray-900">Shared with:</label>
                                    <div class="mt-2">
                                        <textarea v-model="form.shared_with" id="shared_with" name="shared_with" rows="3" placeholder="Type a name or email serparated by a comma…" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <label for="notes" class="block text-sm font-medium leading-6 text-gray-900">Notes</label>
                                    <div class="mt-2">
                                        <textarea v-model="form.notes" id="notes" name="notes" rows="3" placeholder="Enter notes here" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="service">
                          <div class="mb-5">
                            <label class="block text-sm font-medium leading-6 text-gray-900"> <i class="fa-solid fa-plus"></i> <span class="service">Service Providers</span> <i class="fa-solid fa-caret-up"></i></label>
                          </div>

                            <div class="service-form">
                                <div class="form-container">
                                    <div class="form-header">Add Provider</div>

                                    <div class="form-group-wrap bg-grey p-6 pt-4">
                                        <div class="form-group">
                                            <label>Host</label>
                                            <select>
                                                <option>Host</option>
                                                <option>Domain Register</option>
                                                <option>Email Plan Provider</option>
                                                <option>SSL Provider</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" placeholder="Host Name">
                                        </div>

                                        <div class="form-group">
                                            <input type="text" placeholder="Web URL">
                                        </div>
                                    </div>

                                    <div class="form-group-wrap p-6 pt-4">
                                        <div class="form-group">
                                            <label>Renewal Type</label>
                                            <select class="bg-grey">
                                                <option>Annual</option>
                                            </select>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label>Cost</label>
                                                <input class="bg-grey" type="text" placeholder="$ 00.00">
                                            </div>
                                            <div class="form-group m-0">
                                                <label>Renewal Date</label>
                                                <div class="form-group form-group-icon">
                                                    <input class="bg-grey" type="text" placeholder="00 / 00 / 00">
                                                    <i class="fa-solid fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group-wrap bg-grey p-6 pt-4 security-group">
                                        <div class="form-group form-group-icon">
                                            <input type="text" placeholder="UserName">
                                            <i class="fa-regular fa-user"></i>
                                        </div>

                                        <div class="form-group form-group-icon">
                                            <input type="password" placeholder="••••••••">
                                            <i class="fa-solid fa-lock"></i>
                                        </div>

                                        <div class="form-group form-group-icon m-0">
                                            <input type="text" placeholder="PIN">
                                            <i class="fa-solid fa-fingerprint"></i>
                                        </div>
                                    </div>

                                    <div class="form-footer p-5">
                                        <button class="cancel-btn">Cancel</button>
                                        <button class="submit-btn">Add Provider</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="software">
                          <div class="mb-5">
                            <label class="block text-sm font-medium leading-6 text-gray-900"> <i class="fa-solid fa-plus"></i> <span class="service">Software & Add-Ons</span> <i class="fa-solid fa-caret-up"></i></label>
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
export default {
    methods: {
        goBack() {
            window.history.back();
        },
       setColor(color) {
          this.itemShow = false;
          this.color = color;
      }
    },
  data() {
    return {
      itemShow: false,
      color: '#FF920A',
      orang: '#FF920A',
      dark_green: '#3D5F58',
      light_green: '#A7B57C'
    };
  },
};
</script>

<style scoped>
.form-container {
    background-color: #f3f3f3;
    border-radius: 22px;
    -webkit-box-shadow: 0px 2px 4px 0px rgba(0,0,0,0.5);
    -moz-box-shadow: 0px 2px 4px 0px rgba(0,0,0,0.5);
    box-shadow: 0px 2px 4px 0px rgba(0,0,0,0.5);
    font-family: "Lato", sans-serif;
}

.form-header {
    font-size: 1.25rem;
    font-family: "Lato", sans-serif;
    font-weight: bold;
    text-align: center;
    padding: 15px;
}

.form-group-wrap.bg-grey {
    background: #d8d8d8;
}

.form-group {
    margin-bottom: 10px;
}

.form-group label {
    font-size: 1.125rem;
    color: #15202E;
    display: block;
    margin-bottom: 10px;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 10px;
    font-size: 18px;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
    background-color: #ffffff;
    color: #7a8088;
}
.form-group select {
    background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z"/></svg>');
}

.form-group input.bg-grey,
.form-group select.bg-grey {
    background-color: #d8d8d8;
}

.form-group-icon {
    display: flex;
    align-items: center;
    position: relative;
}

.form-group-icon input {
    padding-left: 35px;
}

.form-group-icon i {
    position: absolute;
    left: 10px;
    font-size: 18px;
    color: #555;
}
.security-group input {
    font-size: 1.2rem;
    padding-left: 50px;
    border-radius: 4px;
    -webkit-box-shadow: 0px 5px 8px -6px rgba(0,0,0,0.75);
    -moz-box-shadow: 0px 5px 8px -6px rgba(0,0,0,0.75);
    box-shadow: 0px 5px 8px -6px rgba(0,0,0,0.75);
}
.security-group .form-group-icon {

}
.security-group .form-group-icon i {
    font-size: 1.5rem;
    left: 15px;
}

.form-row {
    display: flex;
    gap: 10px;
}

.form-row .form-group {
    flex: 1;
}

.form-footer {
    display: flex;
    gap: 15px;
}

.form-footer button {
    flex: 1;
    padding: 10px;
    font-size: 1.2rem;
    font-weight: bold;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    webkit-box-shadow: 0px 5px 8px -4px rgba(0,0,0,0.5);
    -moz-box-shadow: 0px 5px 8px -4px rgba(0,0,0,0.5);
    box-shadow: 0px 5px 8px -4px rgba(0,0,0,0.5);
    background-color: #3a5656;
    color: white;
}
</style>
