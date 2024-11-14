<script setup>
import {Head} from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

import { inject } from "vue";

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
                    </div>
                    <span class="filter-btn">
                        <i class="fas fa-filter"></i>
                    </span>
                </div>
            </div>

            <div class="sort-panel">
                <div class="options">
                    <label for="select_all" class="option-item">
                        <input type="radio" name="select_all" id="select_all">
                        <span class="select-text">select all</span>
                    </label>
                    <label for="sort_by_company" class="option-item">
                        <input type="radio" name="sort_by_company" id="sort_by_company">
                        <span class="select-text">sort by company</span>
                    </label>
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
<!--                            <p>{{item.name}}</p>-->
                            <span class="card-selection selected"></span>
                            <div class="card-content">
                                <div class="info">
                                    <p class="card-title">{{ item.name }}</p>
                                    <span class="card-link">{{ item.url }}</span>
                                </div>
                                <div class="card-logo">
                                    <img v-if="item.logo" :src="item.logo" :alt="item.name" />
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
export default {
    props: {
        sites: Array,
    }
}

</script>
