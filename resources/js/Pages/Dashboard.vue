<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { inject,reactive } from "vue";

const route = inject("route");

// // just for testing
// const sites = [{
//     url: 'https://website.com',
//     name: 'Test website 1',
//     logo: 'https://picsum.photos/70',
//     color: 'red'
// },{
//     url: 'https://website123.com',
//     name: 'Test website 2',
//     logo: 'https://picsum.photos/70',
//     color: '#ff930a'
// },{
//     url: 'https://website-qwe.com',
//     name: 'Test website 3',
//     logo: '',
//     color: 'blue'
// },
// ];

</script>

<template>
    <Head title="Dashboard" />

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

            <div class="main-panel">
                <div class="search-section">
                    <div class="search-bar">
                        <form action="" class="search-form" id="search_form">
                            <input type="text" class="search-input" id="search" placeholder="search...">
                            <button type="button" class="search-btn">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>

                        <span class="filter-btn">
                            <i class="icon fas fa-filter"></i>
                        </span>
                    </div>
                    <span class="select-items" v-if="selectAll && !showShareBlock && !showUnshareBlock && !showDeleteBlock"><em>{{countAll}} selected item (s)</em></span>
                    <span class="select-items" v-if="showShareBlock"><em>Share {{siteLength}} item (s) with</em></span>
                    <span class="select-items" v-if="showUnshareBlock"><em>Unshare {{siteLength}} item (s) ?</em></span>
                  <span class="select-items" v-if="showDeleteBlock"><em>Delete  {{siteLength}} item (s) ?</em></span>
                </div>
                <div v-if="(selectAll || selectOnes) && !showShareBlock && !showUnshareBlock && !showDeleteBlock" class="panel-controls flex flex-row justify-end items-center gap-5">
                    <button class="btn-md" type="button" @click="showShare">Share</button>
                    <button class="btn-md" type="button" @click="showUnshare">Unshare</button>
                    <button class="btn-md" type="button" @click="showDelete">Delete</button>
                </div>
              <div v-if="showShareBlock && !showUnshareBlock && !showDeleteBlock" class="panel-controls flex flex-row justify-end items-center gap-5">
                <i class="fa fa-users in-textarea" aria-hidden="true"></i>
                <textarea placeholder="Type a name or email serparated by a comma…" id="share" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm
                ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                <button class="btn-md" type="button" @click="cancel">Cancel</button>
                <button class="btn-md" type="button" @click="share">Share</button>
              </div>
              <div v-if="showUnshareBlock && !showDeleteBlock" class="panel-controls flex flex-row justify-end items-center gap-5">
                <i class="fa-solid fa-circle-exclamation in-textarea"></i>
                <textarea :placeholder="placeholderUnshare" id="unshare" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                <button class="btn-md" type="button" @click="cancel">Cancel</button>
                <button class="btn-md" type="button" @click="unshare">Unshare</button>
              </div>
              <div v-if="showDeleteBlock" class="panel-controls flex flex-row justify-end items-center gap-5">
                <i class="fa-solid fa-trash-can in-textarea"></i>
                <textarea readonly :placeholder="plaсeholderDelete" id="delete" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                <button class="btn-md" type="button" @click="cancel">Cancel</button>
                <button class="btn-md" type="button" @click="deleteSite">Delete</button>
              </div>
            </div>

            <div class="sort-panel">
                <div class="options">
                    <label for="select_all" class="option-item">
                        <input type="checkbox" @click="selectAll = !selectAll" id="select_all">
                        <span class="select-text">select all</span>
                    </label>
                    <label for="sort_by_company" class="option-item">
                        <input type="checkbox" @click="sortedArray" id="sort_by_company">
                        <span class="select-text">sort by company</span>
                    </label>
                  <span class="message" v-if="showDeleteBlock"><i class="fas fa-exclamation-triangle"></i> THIS ACTION CANNOT BE UNDONE <i class="fas fa-exclamation-triangle"></i></span>
                </div>
            </div>

            <main class="main-content">
                <div class="inner">
                    <div class="empty-state" v-show="!sites">
                        <div class="icon">
                            <i class="fa-solid fa-heart-crack"></i>
                        </div>
                        <p>
                            Oh no!
                            <br>
                            No websites found here
                        </p>
                        <p>
                            You can <Link :href="route('addSite')" class="new-site">add a new website</Link> by pressing the + icon at the top right-hand corner of this screen
                        </p>
                    </div>

                    <div class="data card-list" v-if="sites && sites.length !== 0">
                        <div v-for="item in sites" class="card-item">
                           <label class="options"><input v-model="checkedSites[item._id]" type="checkbox" name="sites" @change="getCheck($event)" :checked="selectAll" :id=item._id class="card-selection selected sites"></label>
                            <div class="card-content" @click="siteDetail(item._id)">
                                <div class="info">
                                    <p class="card-title">{{ item.name }}</p>
                                    <span class="card-link">{{ item.url }}</span>
                                </div>
                                <div class="card-logo">
                                    <img v-if="item.icon" :src="item.icon" :alt="item.name" />
                                    <span v-else>Logo</span>
                                </div>
                                <span class="card-color" :style="{ backgroundColor: item.color }"></span>
                            </div>
                        </div> <!-- end .card-item -->
                    </div> <!-- end .card-list -->
                </div>
            </main>
        </div>
    </div> <!-- end .wrapper -->
</template>
<script>
import {useForm} from "@inertiajs/vue3";
import {toRaw} from "vue";

export default {
  props: {
    sites: [],
  },
  data() {
    return {
      selectAll: false,
      selectOnes: false,
      showShareBlock: false,
      siteLength: 0,
      countAll: this.sites.length,
      showUnshareBlock: false,
      showDeleteBlock: false,
      checkedSites:[],
      form: useForm({
        sitesList: []
      })
    }
  },
  computed: {
    plaсeholderDelete() {
     return "Are you sure you want to delete " + this.siteLength + " selected item(s)?";
    },
    placeholderUnshare() {
    return  "Are you sure you want to unshare " + this.siteLength + " selected item(s)?";
    }
  },
  methods: {
    siteDetail(id) {
      window.location.href= 'siteDetail/'+id;
    },
    sortedArray() {
      this.selectAll = false;
      console.log(this.sites);

      return this.sites.sort((a, b) => (a.company > b.company ? 1 : -1));
    },
    getCheck(el) {
      this.selectOnes = true;
      if(!el.target.checked && this.selectAll) {
        this.countAll--;
        this.siteLength--;
      } else if(!el.target.checked && !this.selectAll) {
        this.siteLength--;
      } else if (el.target.checked && !this.selectAll) {
        this.siteLength++;
      }
    },
    showShare() {
      this.showShareBlock = true;
      if(this.selectAll) {
        this.siteLength = this.countAll;
      }
    },
    showUnshare() {
      this.showUnshareBlock = true;
      if(this.selectAll) {
        this.siteLength = this.countAll;
      }
    },
    showDelete() {
      this.showDeleteBlock = true;
      if(this.selectAll) {
        this.siteLength = this.countAll;
      }
    },
    cancel() {
      this.showShareBlock = false;
      this.showUnshareBlock = false;
      this.showDeleteBlock = false;
    },
    deleteSite() {
      var arr = toRaw(this.checkedSites);
      for (const key in arr) {
        this.form.sitesList.push(key);
      }
      this.form.post(route('deleteSites'), {
        onFinish: () => this.form.get(route('dashboard'))
      });
    }
  },
}

</script>
