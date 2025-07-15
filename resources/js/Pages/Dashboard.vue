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

      <div class="main-panel">
        <div class="search-section">
          <div class="search-bar">
            <form action="" class="search-form" id="search_form">
              <input type="text" v-model="searchData" @change="search" class="search-input" id="search"
                     placeholder="search...">
              <button type="button" class="search-btn">
                <i class="fa-solid fa-magnifying-glass"></i>
              </button>
            </form>

            <span class="filter-btn" @click="showFilter" :class="{ active: isFilterOpen }">
                            <i class="icon fas fa-filter"></i>
                        </span>
          </div>

        </div>
          <div v-if="(selectAll || selectOnes)" class="controls-wrap flex flex-auto flex-col md:flex-row justify-between items-center">
              <span class="select-items hidden md:inline"
                    v-if="selectAll && !showShareBlock && !showUnshareBlock && !showDeleteBlock"><em>{{ countAll }} selected item (s)</em></span>
              <span class="select-items hidden md:inline" v-if="showShareBlock"><em>Share {{ siteLength }} item (s) with</em></span>
              <span class="select-items hidden md:inline" v-if="showUnshareBlock"><em>Unshare {{ siteLength }} item (s) ?</em></span>
              <span class="select-items hidden md:inline" v-if="showDeleteBlock"><em>Delete  {{ siteLength }} item (s) ?</em></span>
              <div v-if="(selectAll || selectOnes) && !showShareBlock && !showUnshareBlock && !showDeleteBlock"
                   class="panel-controls hidden md:flex flex-row flex-grow justify-end items-center gap-5">
                  <button class="btn-md" type="button" @click="showShare">Share</button>
                  <button class="btn-md" type="button" @click="showUnshare">Unshare</button>
                  <button class="btn-md" type="button" @click="showDelete">Delete</button>
              </div>
              <span v-if="selectAll" class="select-items md:hidden"><em>{{ countAll }} selected item (s)</em></span>
              <span v-if="!selectAll" class="select-items md:hidden"><em>{{ siteLength }} selected item (s)</em></span>
              <div class="panel-controls panel-controls_m-buttons md:hidden flex flex-row gap-4">
                  <button class="btn-md" type="button" @click="showShare">Share</button>
                  <button class="btn-md" type="button" @click="showUnshare">Unshare</button>
                  <button class="btn-md" type="button" @click="showDelete">Delete</button>
              </div>

              <div v-if="showShareBlock && !showUnshareBlock && !showDeleteBlock"
                   class="panel-controls panel-controls_share panel-controls_m-popup flex flex-row justify-center md:justify-end items-center md:gap-5">
                  <div class="inner-wrap">
                      <div class="heading-message flex gap-4">
                          <i class="inline md:hidden fa fa-users in-textarea" aria-hidden="true"></i>
                          <span class="select-items block md:hidden" v-if="showShareBlock">Share {{ siteLength }} item (s) with:</span>
                      </div>
                      <div class="textarea-wrap flex flex-col md:flex-row gap-5 items-center">
                          <i class="hidden md:inline fa fa-users in-textarea" aria-hidden="true"></i>
                          <textarea v-model="form.share"
                                    placeholder="Type a name or email separated by a comma…"
                                    id="share"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                          <div class="buttons flex gap-6 justify-center md:justify-normal self-stretch md:self-auto">
                              <button class="btn-md" type="button" @click="cancel">Cancel</button>
                              <button class="btn-md" type="button" @click="share">Share</button>
                          </div>
                      </div>
                  </div>
              </div> <!-- end .panel-controls_share -->

              <div v-if="showUnshareBlock && !showDeleteBlock"
                   class="panel-controls panel-controls_unshare panel-controls_m-popup flex flex-row justify-center md:justify-end items-center gap-5">
                  <div class="inner-wrap flex flex-col md:flex-row gap-4 md:gap-5 items-center">
                      <i class="fa-solid fa-circle-exclamation in-textarea"></i>
                      <textarea :placeholder="placeholderUnshare" id="unshare"
                            class="hidden md:block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                      <div class="msg md:hidden text-center text-xl mb-2">Are you sure you want to unshare {{ siteLength }} selected item (s) ?</div>
                      <div class="buttons flex gap-6 justify-center md:justify-normal self-stretch md:self-auto">
                          <button class="btn-md btn-md_m-white" type="button" @click="cancel">Cancel</button>
                          <button class="btn-md btn-md_m-white" type="button" @click="unshare">Unshare</button>
                      </div>
                  </div>
              </div> <!-- end .panel-controls_unshare -->

              <div v-if="showDeleteBlock" class="panel-controls panel-controls_delete panel-controls_m-popup flex flex-row justify-center md:justify-end items-center gap-5">
                  <div class="inner-wrap flex flex-col md:flex-row gap-4 md:gap-5 items-center">
                      <i class="fa-solid fa-trash-can in-textarea"></i>
                      <textarea readonly :placeholder="plaсeholderDelete" id="delete"
                                class="hidden md:block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                      <div class="msg md:hidden text-center text-xl mb-1">
                          Are you sure you want to delete {{ siteLength }} selected item (s) ?
                          <div class="attn mt-2">
                              <i class="fas fa-exclamation-triangle"></i>
                              THIS ACTION CANNOT BE UNDONE
                              <i class="fas fa-exclamation-triangle"></i>
                          </div>
                      </div>
                      <div class="buttons flex gap-6 justify-center md:justify-normal self-stretch md:self-auto">
                          <button class="btn-md btn-md_m-white" type="button" @click="cancel">Cancel</button>
                          <button class="btn-md btn-md_m-white" type="button" @click="deleteSite">Delete</button>
                      </div>
                  </div>
              </div> <!-- end .panel-controls_delete -->
          </div> <!-- end .controls-wrap -->
      </div> <!-- end .main-panel -->

      <div class="sort-panel sorting">
        <div class="options">
          <label for="select_all" class="option-item">
            <input type="checkbox" :checked="selectAll" @click="selectAll = !selectAll" id="select_all">
            <span class="select-text" v-if="!selectAll">select all</span>
            <span class="select-text" v-if="selectAll">deselect all</span>
          </label>
          <label for="sort_by_company" class="option-item">
            <input type="checkbox" :checked="sortCompany" @change="sortedArray" id="sort_by_company">
            <span class="select-text">sort by company</span>
          </label>
          <span class="message hidden md:inline-block" v-if="showDeleteBlock"><i class="fas fa-exclamation-triangle"></i> THIS ACTION CANNOT BE UNDONE <i
              class="fas fa-exclamation-triangle"></i></span>
        </div>
      </div>
      <div class="sort-panel">
            <div v-if="companyText" class="gray-border"> <i class="fa-solid fa-x" @click="sortNoCompany"></i> <span>{{companyText}}</span></div>
            <div v-if="colorText" class="gray-border">
              <i class="fa-solid fa-x" @click="sortNoColor"></i>
              <span>Color</span>
              <div  v-if="colorText !== 'multi'" class="item-circle small"v-bind:style="{background: colorText}"></div>
              <div class="item-circle small multi-color" v-if="colorText === 'multi'">
                <div class="half" style="background-color: #FF9500;"></div>
                <div class="half" style="background-color: #2E4C42;"></div>
                <div class="half" style="background-color: #B6C793;"></div>
              </div>
            </div>
            <div v-if="hostText" class="gray-border"> <i class="fa-solid fa-x" @click="sortNoHost"></i> <span>{{hostText}}</span></div>
            <div v-if="domainText" class="gray-border"> <i class="fa-solid fa-x" @click="sortNoDomain"></i> <span>{{domainText}}</span></div>
            <div v-if="sslText" class="gray-border"> <i class="fa-solid fa-x" @click="sortNoSSl"></i> <span>{{sslText}}</span></div>
            <div v-if="emailText" class="gray-border"> <i class="fa-solid fa-x" @click="sortNoEmail"></i> <span>{{emailText}}</span></div>
            <div v-if="cmsText" class="gray-border"> <i class="fa-solid fa-x" @click="sortNoCMS"></i> <span>{{cmsText}}</span></div>
      </div>

      <main class="main-content">
        <div class="inner">
          <div class="empty-state" v-show="arr.length === 0">
            <div class="icon">
              <i class="fa-solid fa-heart-crack"></i>
            </div>
            <p>
              Oh no!
              <br>
              No websites found here
            </p>
            <p>
              You can
              <Link :href="route('addSite')" class="new-site">add a new website</Link>
              by pressing the + icon at the top right-hand corner of this screen
            </p>
          </div>

          <div class="data-container">
            <div class="filter-block" v-if="isFilterOpen">
              <div class="filter-form">
                <div class="heading row flex justify-center text-2xl mb-5">
                    <span class="filter-close xl:hidden" @click="showFilter"><i class="fa-solid fa-xmark"></i></span>
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

                  <div class="row flex flex-row gap-3">
                    <div class="form-group flex-grow">
                      <label for="company">Company</label>
                      <select id="company" v-model="companySort">
                        <option>All Companies</option>
                        <option v-for="company in companies">{{ company }}</option>
                      </select>
                    </div>
                    <div class="form-group ">
                      <label for="color">Color</label>

                      <div class="dropdown-color" :class="{ active: isDropdownColorOpen }">
                        <div class="selected-color" @click="showDropdownColor">
                          <div class="item-circle multi-color" v-if="multi">
                            <div class="half" style="background-color: #FF9500;"></div>
                            <div class="half" style="background-color: #2E4C42;"></div>
                            <div class="half" style="background-color: #B6C793;"></div>
                          </div>
                          <div class="item-circle" v-if="!multi" v-bind:style="{background: color}"></div>
                          <span class="dropdown-arrow">
                              <i class="fa-solid fa-caret-down"></i>
                          </span>
                        </div>
                        <div class="dropdown-list" v-if="isDropdownColorOpen">
                          <div class="item">
                            <div class="item-circle" @click=setColor(dark_green) style="background-color: #4A6A65;"></div>
                          </div>
                          <div class="item">
                            <div class="item-circle" @click=setColor(orange) style="background-color: #FFA726;"></div>
                          </div>
                          <div class="item">
                            <div class="item-circle" @click=setColor(light_green) style="background-color: #B6C793;"></div>
                          </div>
                          <div class="item">
                            <div class="item-circle multi-color" @click=setColor(multiColor)>
                              <div class="half" style="background-color: #FF9500;"></div>
                              <div class="half" style="background-color: #2E4C42;"></div>
                              <div class="half" style="background-color: #B6C793;"></div>
                            </div>
                          </div>
                        </div>
                      </div> <!-- end .dropdown-color -->
                    </div>
                  </div>

                  <div class="row flex flex-row gap-3">
                      <div class="form-group w-1/2">
                          <label for="hosts">Hosts</label>
                          <select id="hosts" v-model="hostSort">
                              <option>View All</option>
                              <option v-for="host in hosts">{{ host }}</option>
                          </select>
                      </div>

                      <div class="form-group w-1/2">
                          <label for="domain-provider">Domain Provider</label>
                          <select id="domain-provider" v-model="providerSort">
                              <option>View All</option>
                              <option v-for="provider in providers">{{ provider }}</option>
                          </select>
                      </div>
                  </div>

                  <div class="row flex flex-row gap-3">
                      <div class="form-group w-1/2">
                          <label for="ssl-provider">SSL Provider</label>
                          <select id="ssl-provider" v-model="sslSort">
                              <option>View All</option>
                              <option v-for="provider in sslArr">{{ provider }}</option>
                          </select>
                      </div>

                      <div class="form-group w-1/2">
                          <label for="email-provider">Email Provider</label>
                          <select id="email-provider" v-model="emailSort">
                              <option>View All</option>
                              <option v-for="provider in emails">{{ provider }}</option>
                          </select>
                      </div>
                  </div>


                  <div class="form-group">
                    <label for="cms">Content Management System</label>
                    <select id="cms" v-model="cmsSort">
                      <option>All CMS</option>
                      <option v-for="provider in cms">{{ provider }}</option>
                    </select>
                  </div>

                  <div class="row flex justify-center mt-6">
                    <button type="button" @click="sortField" class="btn-md btn-inverted">Apply Filters</button>
                  </div>
                </div> <!-- end .filter-inner -->
              </div>
            </div>

            <div class="data card-list" v-if="arr && arr.length !== 0" :class="{ filter_active: isFilterOpen }">
              <div v-for="item in arr" :key="item.id" class="card-item">
                <label class="options">
                  <span class="readonly" v-if="item.readonly"></span>
                  <input v-if="!item.readonly" v-model="checkedSites[item._id]" type="checkbox" name="sites"
                         @change="getCheck($event)" :checked="selectAll" :id=item._id
                         class="card-selection selected sites">
                </label>
                <div class="card-content" @click="siteDetail(item._id)">
                  <div class="info">
                    <p class="card-title">{{ item.name }}</p>
                    <span class="card-link">{{ item.url }}</span>
                  </div>
                  <div class="card-logo">
                    <img v-if="item.icon" :src="item.icon" :alt="item.name"/>
                    <span v-else>Logo</span>
                  </div>
                  <span class="card-color" :style="{ backgroundColor: item.color }"></span>
                </div>
              </div> <!-- end .card-item -->
            </div> <!-- end .card-list -->
          </div>
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
    companies: [],
    hosts: [],
    providers: [],
    sslArr: [],
    emails: [],
    cms: []
  },
  data() {
    return {
      cmsText: '',
      emailText:'',
      companyText: '',
      colorText: '',
      hostText: '',
      domainText: '',
      sslText: '',
      color: 'multi',
      orange: '#FF920A',
      dark_green: '#3D5F58',
      light_green: '#A7B57C',
      searchData: '',
      companySort: '',
      providerSort: '',
      sslSort: '',
      hostSort: '',
      emailSort: '',
      cmsSort: '',
      sortCompany: false,
      selectAll: false,
      selectOnes: false,
      showShareBlock: false,
      siteLength: 0,
      countAll: Object.values(this.sites).length,
      showUnshareBlock: false,
      showDeleteBlock: false,
      checkedSites: [],
      data: [],
      form: useForm({
        sitesList: [],
        share: ''
      }),
      arr: this.sites,
      isFilterOpen: false,
      isDropdownColorOpen: false,
      sortColor: false,
      multi: true,
      multiColor: 'multi',
      sortArr: []
    }
  },
  computed: {
    plaсeholderDelete() {
      return "Are you sure you want to delete " + this.siteLength + " selected item(s)?";
    },
    placeholderUnshare() {
      return "Are you sure you want to unshare " + this.siteLength + " selected item(s)?";
    }
  },
  methods: {
    setColor(color) {
      if (color === 'multi') {
        this.multi = true;
        this.color = 'multi';
      } else {
        this.multi = false;
        this.color = color;
      }
      this.sortColor = true;
      this.isDropdownColorOpen = !this.isDropdownColorOpen;
    },
    sortNoCompany() {
      this.companySort = '';
      this.companyText = '';
      this.closeChips();
    },
    sortNoColor() {
      this.sortColor = '';
      this.colorText = '';
      this.closeChips();
    },
    sortNoHost() {
      this.hostSort = '';
      this.hostText = '';
      this.closeChips();
    },
    sortNoEmail() {
      this.emailSort = '';
      this.emailText = '';
      this.closeChips();
    },
    sortNoDomain() {
      this.domainText = '';
      this.providerSort = '';
      this.closeChips();
    },
    sortNoSSl() {
      this.sslText = '';
      this.sslSort = '';
      this.closeChips();
    },
    sortNoCMS() {
      this.cmsText = '';
      this.cmsSort = '';
      this.closeChips();
    },
    closeChips() {
      this.sortField();
      this.isFilterOpen = !this.isFilterOpen;
    },
    sortField() {
      this.sortArr = [];
      this.arr = [];
      if (this.companySort && this.companySort !== '')  {
        this.companyText = this.companySort;
        if (this.companySort === 'All Companies') {
          this.arr = this.sites;
        } else {
          Object.values(this.sites).filter(item => {
            if (item.company) {
              if (this.companySort.toLowerCase() === item.company.toLowerCase()) {
                this.arr.push(item);
              }
            }
          });
        }
        this.sortArr = this.arr;
      } else {
        this.companyText = '';
        this.arr = this.sites;
        this.sortArr = this.arr;
      }
      if (this.sortColor && this.sortColor !== '')  {
        this.colorText = this.color;
        this.arr = [];
        if (this.color === 'multi') {
          if(this.sortArr.length === 0) {
            this.arr = this.sites;
          } else {
            this.arr = this.sortArr;
          }
        } else {
          Object.values(this.sortArr).filter(item => {
            if (item.color) {
              if (this.color.toLowerCase() === item.color.toLowerCase()) {
                this.arr.push(item);
              }
            }
          });
        }
        this.sortArr = this.arr;
      } else {
        this.colorText = '';
        this.arr = this.sortArr;
      }
      if (this.hostSort && this.hostSort !== '') {
        this.hostText = this.hostSort;
         this.arr = this.sortProviders('Host', this.hostSort, this.sortArr);
         this.sortArr = this.arr;
      } else {
        this.hostText = '';
      }
      if (this.providerSort && this.providerSort !== '') {
        this.domainText = this.providerSort;
        this.arr = this.sortProviders('Domain Register', this.providerSort, this.sortArr);
        this.sortArr = this.arr;
      } else {
        this.domainText = '';
      }
      if (this.sslSort && this.sslSort !== '') {
        this.sslText = this.sslSort;
        this.arr = this.sortProviders('SSL Provider', this.sslSort, this.sortArr);
        this.sortArr = this.arr;
      } else {
        this.sslText = '';
      }
      if (this.emailSort && this.emailSort !== '') {
        this.emailText = this.emailSort;
        this.arr = this.sortProviders('Email Plan Provider', this.emailSort, this.sortArr);
        this.sortArr = this.arr;
      } else {
        this.emailText = '';
      }
      if (this.cmsSort && this.cmsSort !== '') {
        this.cmsText = this.cmsSort;
        this.arr = this.sortSoftware('CMS', this.cmsSort, this.sortArr);
      } else {
        this.cmsText = '';
      }
      this.arr  =
          [...new Set(Object.values(this.arr).map(JSON.stringify))].map(JSON.parse);
      this.isFilterOpen = !this.isFilterOpen;
    },

    sortSoftware (filed, value, arr) {
      this.data = [];
      this.arr = [];
      if (this.cmsSort === 'All CMS') {
        this.arr = arr;
        return this.arr;
      }
      Object.values(arr).filter(item => {
        if (item.software && item.software.length !== 0) {
          for (var host in item.software) {
            if (item.software[host].type === filed) {
              if (item.software[host].name.toLowerCase() === value.toLowerCase()) {
                this.data.push(item);
              }
            }
          }
        }
      });
      return this.data;
    },
    sortProviders(filed, value, arr) {
      this.data = [];
      this.arr = [];
      if (value === 'View All') {
        this.arr = arr;
        return this.arr;
      }
      Object.values(arr).filter(item => {
        if (item.provider && item.provider.length !== 0) {
          for (var host in item.provider) {
            if (item.provider[host].type === filed) {
              if (item.provider[host].name.toLowerCase() === value.toLowerCase()) {
                this.data.push(item);
              }
            }
          }
        }
      });
      return this.data;
    },
    search() {
      this.arr = Object.values(JSON.parse(JSON.stringify(this.arr)));
      this.arr = this.arr.filter(item => {
        return (
            item.name
                .toLowerCase()
                .indexOf(this.searchData.toLowerCase()) != -1 ||
            item.url
                .toLowerCase()
                .indexOf(this.searchData.toLowerCase()) != -1
        );
      });
    },
    siteDetail(id) {
      window.location.href = 'siteDetail/' + id;
    },
    sortedArray() {
      this.selectAll = false;
      this.arr = Object.values(JSON.parse(JSON.stringify(this.arr)));
      this.sortCompany = !this.sortCompany;
      return this.arr.sort((a, b) => (a.company > b.company ? 1 : -1));
    },

    getCheck(el) {
      this.selectOnes = true;
      if (!el.target.checked && this.selectAll) {
        this.countAll--;
        this.siteLength--;
      } else if (!el.target.checked && !this.selectAll) {
        this.siteLength--;
      } else if (el.target.checked && !this.selectAll) {
        this.siteLength++;
      }
    },

    showFilter() {
      this.isFilterOpen = !this.isFilterOpen;
    },

    showDropdownColor() {
      this.isDropdownColorOpen = !this.isDropdownColorOpen;
    },

    showShare() {
      this.showShareBlock = true;
      if (this.selectAll) {
        this.siteLength = this.countAll;
      }
    }
    ,
    showUnshare() {
      this.showUnshareBlock = true;
      if (this.selectAll) {
        this.siteLength = this.countAll;
      }
    }
    ,
    showDelete() {
      this.showDeleteBlock = true;
      if (this.selectAll) {
        this.siteLength = this.countAll;
      }
    }
    ,
    cancel() {
      this.showShareBlock = false;
      this.showUnshareBlock = false;
      this.showDeleteBlock = false;
    }
    ,
    deleteSite() {
      var arr = toRaw(this.checkedSites);
      for (const key in arr) {
        this.form.sitesList.push(key);
      }
      this.form.post(route('deleteSites'), {
        onFinish: () => this.form.get(route('dashboard'))
      });
    }
    ,
    share() {
      var arr = toRaw(this.checkedSites);
      for (const key in arr) {
        this.form.sitesList.push(key);
      }
      this.form.post(route('share'), {
        onFinish: () => this.form.get(route('dashboard'))
      });
    }
    ,
    unshare() {
      var arr = toRaw(this.checkedSites);
      for (const key in arr) {
        this.form.sitesList.push(key);
      }
      this.form.post(route('unShareSites'), {
        onFinish: () => this.form.get(route('dashboard'))
      });
    }
  }
  ,
}

</script>
