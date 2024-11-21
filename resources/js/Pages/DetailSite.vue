<script setup>

import {Head, Link, useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import {reactive} from "vue";
import InputError from "@/Components/InputError.vue";
</script>

<template>
  <Head title="Add Site"/>
`z
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
              <div class="card-content detail" v-for="item in site.provider">
                <div class="info">
                  <p class="card-title">{{ item.name }}</p>
                  <span class="card-link">{{ item.url }}</span>
                </div>
                <i class="fa-solid fa-sort-up"></i>
                <span class="card-color" style="backgroundColor: #000"></span>
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
    site: Array,
  },
  methods: {
    goBack() {
      window.history.back();
    },
  }
}
</script>
