<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import {Link} from '@inertiajs/vue3';
import {inject, reactive} from "vue";

const route = inject("route");
</script>

<template>
  <Head title="Billing"/>

  <div class="wrapper">
    <div class="container dashboard">
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
    </div>
  </div>
</template>
