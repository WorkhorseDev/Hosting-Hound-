<script setup>

import {Head, Link, useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import {reactive} from "vue";

const form = useForm({
  url: '',
  file: '',
  name: '',
  color: '#ff920a',
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
                                      <input type="color" v-model="form.color" id="color" name="color" value="#ff920a">
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
    },
};
</script>

