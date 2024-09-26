<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

<!--    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>-->

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
                        <i class="fas fa-add"></i>
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
                    <div class="empty-state">
                        <div class="icon">
                            <i class="fa-solid fa-heart-crack"></i>
                        </div>
                        <p>
                            Oh no!
                            <br>
                            No websites found here
                        </p>
                        <p>
                            You can <a class="new-site" href="#">add a new website</a> by pressing the + icon at the top right-hand corner of this screen
                        </p>
                    </div>
                </div>
            </main>
        </div>
    </div> <!-- end .wrapper -->
</template>

