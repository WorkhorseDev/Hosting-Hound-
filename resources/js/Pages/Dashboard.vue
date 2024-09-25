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
        <div class="container">
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
                        <span>Select all</span>
                    </label>
                    <label for="sort_by_company" class="option-item">
                        <input type="radio" name="sort_by_company" id="sort_by_company">
                        <span>Sort by company</span>
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
                            You can <a href="#">add a new website</a> by pressing the + icon at the top right-hand corner of this screen
                        </p>
                    </div>
                </div>
            </main>
        </div>
    </div> <!-- end .wrapper -->
</template>

<style scoped>
.wrapper {
    background: #f7f7f7;
    min-height: 100vh;
}
.container {
    max-width: 1380px;
    margin: 0 auto;
    padding-left: 20px;
    padding-right: 20px;
}
.header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 50px;
    margin-bottom: 30px;
}

.header .tabs {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    color: #15202e;
    background: #e7e7d8;
    -webkit-box-shadow: 0px 3px 3px 0px rgba(112,112,112,0.5);
    -moz-box-shadow: 0px 3px 3px 0px rgba(112,112,112,0.5);
    box-shadow: 0px 3px 3px 0px rgba(112,112,112,0.5);
    -webkit-border-radius: 34px;
    -moz-border-radius: 34px;
    border-radius: 34px;
    overflow: hidden;
}
.header .tab-item {
    position: relative;
    color: #15202e;
    font-size: 30px;
    padding: 17px 45px;
    text-align: center;
    font-family: sans-serif;
    text-decoration: none;
}
.header .tab-item:not(:first-child) {
    margin-left: -15px;
}
.header .tab-item.is-active {
    background: #a7b57c;
    -webkit-border-radius: 34px;
    -moz-border-radius: 34px;
    border-radius: 34px;
}
.header .links {

}
.header .link-item {
    font-size: 46px;
    color: #3d5f58;
    cursor: pointer;
    margin-left: 20px;
    margin-right: 20px;
}

.main-panel {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    background: #a7b57c;
    -webkit-box-shadow: 0px 3px 5px 0px rgba(112,112,112,0.5);
    -moz-box-shadow: 0px 3px 5px 0px rgba(112,112,112,0.5);
    box-shadow: 0px 3px 5px 0px rgba(112,112,112,0.5);
    padding: 22px 35px;
    -webkit-border-radius: 34px;
    -moz-border-radius: 34px;
    border-radius: 34px;
    margin-bottom: 30px;
}

.search-section {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
}
.search-bar {
    position: relative;
    background: #ebebeb;
    -webkit-box-shadow: 0px 3px 3px 0px rgba(112,112,112,0.5);
    -moz-box-shadow: 0px 3px 3px 0px rgba(112,112,112,0.5);
    box-shadow: 0px 3px 3px 0px rgba(112,112,112,0.5);
    -webkit-border-radius: 34px;
    -moz-border-radius: 34px;
    border-radius: 34px;
    overflow: hidden;
}
.search-bar .search-input {
    width: 370px;
    height: 70px;
    font-size: 24px;
    background: #ffffff;
    border: none;
    -webkit-border-radius: 34px;
    -moz-border-radius: 34px;
    border-radius: 34px;
    padding-left: 75px;
}
.search-bar .search-btn {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translate(0, -50%);
    height: 60px;
    width: 60px;
    border: none;
    background: none;
    font-size: 32px;
    padding: 0;
}

.main-content {
    position: relative;
    padding: 20px;
}

.main-content .empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding-top: 100px;
    font-size: 27px;
    text-align: center;
    color: #15202e;
    font-family: sans-serif;
    opacity: 0.72;
    max-width: 410px;
    margin: 0 auto;
}
.main-content .empty-state .icon {
    font-size: 72px;
}
</style>
