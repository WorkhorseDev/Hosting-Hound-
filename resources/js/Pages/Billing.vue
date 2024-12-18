<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import {Link} from '@inertiajs/vue3';
import {inject, reactive} from "vue";
import { Calendar } from "v-calendar";
import 'v-calendar/style.css';
import { ref } from 'vue';

const route = inject("route");

</script>

<template>
  <Head title="Billing"/>

  <div class="wrapper">
    <div class="container dashboard billing">
      <header class="header">
        <div class="tabs">
          <Link :href="route('dashboard')" class="tab-item">
            <span class="">Websites</span>
          </Link>
          <Link :href="route('billing')" href="#" class="tab-item is-active">
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

      <div class="main-panel">
        <div class="search-section">
          <i class="fa-solid fa-calendar-days"></i>
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
              You can
              <Link :href="route('addSite')" class="new-site">add a new website</Link>
              by pressing the + icon at the top right-hand corner of this screen
            </p>
          </div>

          <div class="data-container">
            <div class="filter-block" v-if="isFilterOpen">
              <div class="filter-form">
                <div class="heading row flex justify-center text-2xl mb-5">Filter items below</div>
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

              <div class="calendar-container">
                  <Calendar :attributes='calendarAttributes' />
              </div>

            <div class="data card-list" v-if="arr && arr.length !== 0" :class="{ filter_active: isFilterOpen }">
              <div v-for="item in arr" class="card-item">
                <div class="card-content" @click="hostDetail(item._id)">
                  <div class="info">
                    <p class="card-title">{{ item.provider.type }}</p>
                    <p class="card-link">$ {{ item.provider.cost }} - {{item.provider.renewal_date}}</p>
                    <span class="card-link">{{ item.url }}</span>
                  </div>
                  <div class="card-logo">
                    <img v-if="item.icon" :src="item.icon"/>
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
  </div>
</template>
<script>
import {useForm} from "@inertiajs/vue3";

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

    components: {
        Calendar,
    },

  data() {
    return {
      color: '#FF920A',
      orange: '#FF920A',
      dark_green: '#3D5F58',
      light_green: '#A7B57C',
      isDropdownColorOpen: false,
      sortColor: false,
      multi: false,
      multiColor: 'multi',
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
      countAll: this.sites.length,
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

        // Calendar attributes
        baseCalendarAttributes: [
            {
                key: 'today',
                highlight: true,
                dates: new Date(),
            }
        ]
    }
  },

    computed: {
        dynamicCalendarAttributes() {
            return this.arr.map((service) => {
                const [day, month, year] = service.provider.renewal_date.split("/").map(Number);
                return {
                    dates: new Date(year, month - 1, day),
                    dot: 'red',
                    popover: {
                        label: `${service.provider.type} (${service.url}) expires ${service.provider.renewal_date}`,
                    },
                };
            });
        },
        calendarAttributes() {
            return [...this.baseCalendarAttributes, ...this.dynamicCalendarAttributes];
        },
    },

  methods: {
    sortField() {
      this.arr = Object.values(JSON.parse(JSON.stringify(this.arr)));
      if (this.companySort) {
        if (this.companySort === 'All Companies') {
          this.arr = this.sites;
        } else {
          this.arr = [];
          this.sites.filter(item => {
            console.log(item.company,this.companySort );
            if (item.company) {
              if (this.companySort.toLowerCase() === item.company.toLowerCase()) {
                this.arr.push(item);
              }
            }
          });
        }
      }
      if (this.sortColor) {
        if (this.multi) {
          this.arr = this.sites;
        } else {
          this.arr = [];
          this.sites.filter(item => {
            if (item.color) {
              if (this.color.toLowerCase() === item.color.toLowerCase()) {
                this.arr.push(item);
              }
            }
          });
        }
      }
      return this.arr;
    },

    hostDetail(id) {
      window.location.href = 'hostDetail/' + id;
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

    showFilter() {
      this.isFilterOpen = !this.isFilterOpen;
    },

    showDropdownColor() {
      this.isDropdownColorOpen = !this.isDropdownColorOpen;
    },

    setColor(color) {
      if (color === 'multi') {
        this.multi = true;
      } else {
        this.multi = false;
        this.color = color;
      }
      this.sortColor = true;
      this.isDropdownColorOpen = !this.isDropdownColorOpen;
    },
  }
}
</script>
