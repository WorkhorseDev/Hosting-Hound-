<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import {Link} from '@inertiajs/vue3';
import {inject, reactive} from "vue";
defineProps({
    connected: String,
    user: Array
})
const route = inject("route");
</script>

<template>
    <Head title="Dashboard"/>

    <div class="wrapper">
        <div class="container dashboard">
            <header class="header profile">
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
            <vf-form @submit.prevent="submit(false,false,false,false, true)" id="saveAccount">
                <div class="main-panel main-panel_edit">
                    <div class="flex flex-row items-center">
                        <div class="pr-6" v-if="!personal && !notification">
                            <span @click="goBack" class="btn-back"><i class="fas fa-arrow-left"></i></span>
                        </div>
                        <div class="panel-title" v-if="!personal && !notification">Account Settings</div>
                        <div class="pr-6" v-if="personal">
                            <span @click="goAccount" class="btn-back"><i class="fas fa-arrow-left"></i></span>
                        </div>
                        <div class="panel-title mobile-personal" v-if="personal">Personal Details</div>
                        <div class="pr-6" v-if="notification">
                            <span @click="goAccount" class="btn-back"><i class="fas fa-arrow-left"></i></span>
                        </div>
                        <div class="panel-title mobile-personal" v-if="notification">Notification Settings</div>
                    </div>
                    <div class="panel-controls flex flex-row justify-end items-center" v-if="notification || google">
                        <button type="submit" @click="submit" class="btn-md btn-inverted save">Save Changes</button>
                    </div>
                </div>
                <main class="main-content add-site profile">
                    <div class="inner">
                        <div class="grid grid-cols-3 gap-4">
                            <div class="mb-5" v-if="!personal && !notification">
                                <span class="link-item link-item_user account"><i class="fas fa-user"></i></span>
                                <div class="account-data">
                                    <span class="account">{{ user.name }} {{ user.last_name }}</span>
                                    <span class="account-gray">Email: {{ user.email }}</span>
                                    <span class="account-gray">Phone: {{ user.phone_number }}</span>
                                </div>
                              <div class="buttons">
                                <button type="button" @click="showPersonal" class="account btn-md btn-inverted">Personal
                                  Details & Password <i class="fa-solid fa-caret-right"></i></button>
                                <button type="button" @click="showNotification" class="account btn-md btn-inverted">
                                  Notifications <i class="fa-solid fa-caret-right"></i></button>
                                <button type="button" v-if="connected !== 'yes'" @click="showGoogle"
                                        class="account btn-md btn-inverted">Google Integration <i
                                    class="fa-solid fa-caret-right"></i></button>
                                <button type="button" v-if="connected === 'yes'" @click="showGoogleDisconnect"
                                        class="account btn-md btn-inverted">Disconnect Google Account <i
                                    class="fa-solid fa-caret-right"></i></button>
                                <Link :href="route('logout')" href="#" class="logout">
                                  <span class="">Log Out</span>
                                </Link>
                              </div>
                            </div>
                            <div class="mb-5 personal" v-if="personal">
                                <div class="form-group form-group-icon account">
                                    <input readonly type="text" placeholder="First Name" v-model="user.name">
                                    <i class="fa-regular fa-user"></i>
                                    <i class="fa-solid fa-pencil"
                                       @click="showEdit('Change First Name', user.name, 'New First Name', true, false, false, false)"></i>
                                </div>
                                <div class="form-group form-group-icon account">
                                    <input readonly type="text" placeholder="Last Name" v-model="user.last_name">
                                    <i class="fa-regular fa-user"></i>
                                    <i class="fa-solid fa-pencil"
                                       @click="showEdit('Change Last Name', user.last_name, 'New Last Name', false, false, false, false)"></i>
                                </div>
                                <div class="form-group form-group-icon account">
                                    <input readonly type="text" placeholder="Phone" v-model="user.phone_number">
                                    <i class="fa fa-phone"></i>
                                    <i class="fa-solid fa-pencil"
                                       @click="showEdit('Change Number', user.phone_number, 'New Phone Number', false, true, false, false)"></i>
                                </div>
                                <div class="form-group form-group-icon account">
                                    <input readonly type="text" placeholder="Email" v-model="user.email">
                                    <i class="fa-regular fa-envelope"></i>
                                    <i class="fa-solid fa-pencil"
                                       @click="showEdit('Change Email', user.email, 'New Email Address', false, false, true, false)"></i>
                                </div>
                                <div class="form-group form-group-icon account">
                                    <input readonly v-bind:type="[showPassword ? 'text' : 'password']" id="password"
                                           :value="user.pass">
                                    <i class="fa-solid fa-lock"></i>
                                    <i class="fa-solid fa-eye-slash" @click="showTextPass"
                                       v-if="!showPassword"></i>
                                    <i class="fa-solid fa-eye" @click="showTextPass"
                                       v-if="showPassword"></i>
                                    <i class="fa-solid fa-pencil"
                                       @click="showEdit('Change Password', user.pass, 'New Password', false, false, false, true)"></i>
                                </div>
                            </div>
                            <div class="mb-5 notification" v-if="notification">
                                <div class="form-group form-group-icon account">
                                    <label for="select_all" class="option-item">
                                        <span class="select-text">Allow notifications</span>
                                        <div class="w-16 h-10 flex items-center bg-gray-300 rounded-full p-1"
                                             @click="notificationActive = !notificationActive">
                                            <div class="bg-white w-8 h-8 rounded-full shadow-md transform"
                                                 :class="{ 'translate-x-6': notificationActive,}"></div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="mb-5 google" v-if="google">
                                <div class="panel-title calendar" v-if="connected === 'yes' && google">Google Calendar is
                                    connected! <a href="https://calendar.google.com" target="_blank">https://calendar.google.com </a>
                                    to view.
                                </div>
                                <div class="form-group form-group-icon account">
                                    <label for="select_all" class="option-item">
                                        <span class="select-text">In order to use these integration features, you will need to link your account with a Google Account</span>
                                        <div class="form-group form-group-icon account">
                                            <a :href="route('auth/google')"
                                               class="logout gray account btn-md btn-inverted">
                                                <img class="cross title-edit-account"
                                                     src="/images/google-g-logo.png"><span
                                                class="">Link Google Account</span>
                                            </a>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="mb-5 google" v-if="googleDisconnect">
                                <div class="form-group form-group-icon account">
                                    <label for="select_all" class="option-item">
                                        <span class="select-text">If you really want to disconnect your Google Account please click the button</span>
                                        <div class="form-group form-group-icon account">
                                            <a :href="route('disconnect/google')"
                                               class="logout gray account btn-md btn-inverted">
                                                <img class="cross title-edit-account"
                                                     src="/images/google-g-logo.png"><span
                                                class="">Disconnect</span>
                                            </a>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="mb-5 profile-edit notification" v-if="notification">
                                <h4 class="notification">Notification Frequency</h4>
                                <span class="select-text">Day of deadline</span>
                                <div class="w-16 h-10 flex items-center bg-gray-300 rounded-full p-1"
                                     @click="dayOfDeadline = !dayOfDeadline; notificationActive = true">
                                    <div class="bg-white w-8 h-8 rounded-full shadow-md transform"
                                         :class="{ 'translate-x-6': dayOfDeadline,}"></div>
                                </div>
                                <span class="select-text">Day before deadline</span>
                                <div class="w-16 h-10 flex items-center bg-gray-300 rounded-full p-1"
                                     @click="dayBeforeDeadline = !dayBeforeDeadline; notificationActive = true">
                                    <div class="bg-white w-8 h-8 rounded-full shadow-md transform"
                                         :class="{ 'translate-x-6': dayBeforeDeadline,}"></div>
                                </div>
                                <span class="select-text">One Week before deadline</span>
                                <div class="w-16 h-10 flex items-center bg-gray-300 rounded-full p-1"
                                     @click="oneWeek = !oneWeek; notificationActive = true">
                                    <div class="bg-white w-8 h-8 rounded-full shadow-md transform"
                                         :class="{ 'translate-x-6': oneWeek,}"></div>
                                </div>
                                <span class="select-text">Two Weeks before deadline</span>
                                <div class="w-16 h-10 flex items-center bg-gray-300 rounded-full p-1"
                                     @click="twoWeek = !twoWeek; notificationActive = true">
                                    <div class="bg-white w-8 h-8 rounded-full shadow-md transform"
                                         :class="{ 'translate-x-6': twoWeek,}"></div>
                                </div>
                            </div>
                            <div class="mb-5 profile-edit">
                                <div class="filter-block" v-if="isEdit">
                                    <div class="filter-form">
                                        <div class="heading row flex justify-center text-2xl mb-5">
                                            <i v-if="!phone && !email && !pass" class='fa-regular fa-user profile'></i>
                                            <i v-if="phone && !firstName && !email && !pass"
                                               class='fa fa-phone profile'></i>
                                            <i v-if="!phone && !firstName && email && !pass"
                                               class='fa-regular fa-envelope profile'></i>
                                            <i v-if="!phone && !firstName && !email && pass"
                                               class='fa-solid fa-key profile'></i>
                                            {{ header }}
                                        </div>
                                        <div class="form-group form-group-icon account filter-inner">
                                            <div class="filter-search mb-5">
                                                <input readonly type="text" v-model="field">
                                                <input v-if="!email && firstName && !phone && !pass" type="text"
                                                       v-bind:placeholder="placeholder" v-model="name">
                                                <input v-if="!email && !firstName && !phone && !pass" type="text"
                                                       v-bind:placeholder="placeholder" v-model="last_name">
                                                <input v-if="!email && phone && !firstName && !pass" type="text"
                                                       v-bind:placeholder="placeholder" v-model="phoneNum">
                                                <input v-if="email && !phone && !firstName && !pass" type="text"
                                                       v-bind:placeholder="placeholder" v-model="emailAdd">
                                                <input v-if="email && !phone && !firstName && !pass" type="text"
                                                       placeholder="Confirm Email Address" v-model="emailConf">
                                                <input v-if="!email && !phone && !firstName && pass" type="text"
                                                       v-bind:placeholder="placeholder" v-model="password">
                                                <input v-if="!email && !phone && !firstName && pass" type="text"
                                                       placeholder="Confirm Password" v-model="confirmPass">
                                                <i class="input-icon fas fa-lock profile"></i>
                                                <div class="mb-5"><span v-if="errorEmail || errorPass"
                                                                        class="text-red-600 text-sm">Please double check the fields match and resubmit</span>
                                                </div>
                                            </div>
                                            <div class="row flex justify-center mb-5 buttons"
                                                 :id="'email-'+marginBottom">
                                                <button type="button" @click="cancel" class="first btn-md btn-inverted">
                                                    Cancel
                                                </button>
                                                <button type="button"
                                                        @click="submit(firstName, phone, email, pass, false)"
                                                        class="btn-md btn-inverted">Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </vf-form>
        </div>
    </div>
</template>
<script>
import {reactive, toRaw} from "vue";
import {useForm} from "@inertiajs/vue3";

export default {
    props: {
        user: Array
    },
    data() {
        return {
            google: false,
            googleDisconnect: false,
            dayOfDeadline: this.user?.frequency?.dayOfDeadline || null,
            twoWeek: this.user?.frequency?.twoWeek || null,
            oneWeek: this.user?.frequency?.oneWeek || null,
            notificationActive: this.user?.notification || null,
            dayBeforeDeadline: this.user?.frequency?.dayBeforeDeadline,
            personal: false,
            notification: false,
            showPassword: false,
            isEdit: false,
            header: '',
            name: '',
            last_name: '',
            google_email: this.user?.google_email || '',
            phoneNum: '',
            phone: false,
            email: false,
            errorPass: false,
            field: '',
            marginBottom: false,
            emailConf: '',
            emailAdd: '',
            placeholder: '',
            firstName: true,
            errorEmail: false,
            password: '',
            pass: false,
            confirmPass: '',
            form: useForm({
                name: this.user.name,
                last_name: this.user.last_name,
                phone_number: this.user.phone_number,
                email: this.user.email,
                password: this.user.password,
                pass: this.user.pass,
                notification: false,
                google_email: this.user.google_email,
                frequency: {
                    'dayOfDeadline': this.user?.frequency?.dayOfDeadline || null,
                    'dayBeforeDeadline': this.user?.frequency?.dayBeforeDeadline || null,
                    'oneWeek': this.user?.frequency?.oneWeek || null,
                    'twoWeek': this.user?.frequency?.twoWeek || null
                }
            }),
        }
    },
    methods: {
        showGoogle() {
            this.notification = false;
            this.personal = false;
            this.google = true;
            this.googleDisconnect = false;
        },
        showGoogleDisconnect() {
            this.notification = false;
            this.personal = false;
            this.google = false;
            this.googleDisconnect = true;
        },
        showNotification() {
            this.notification = true;
            this.personal = false;
            this.google = false;
            this.googleDisconnect = false;
        },
        showPersonal() {
            this.personal = true;
            this.notification = false;
            this.google = false;
            this.googleDisconnect = false;
        },
        goAccount() {
            this.personal = false;
            this.notification = false;
            this.google = false;
            this.googleDisconnect = false;
        },
        goBack() {
            window.history.back();
        },
        showTextPass() {
            this.showPassword = !this.showPassword;
        },
        showEdit(text, filed, placeholder, firstName, phone, email, pass) {
            this.isEdit = !this.isEdit;
            this.marginBottom = false;
            this.header = text;
            this.field = filed;
            this.placeholder = placeholder;
            this.firstName = firstName;
            this.phone = phone;
            this.email = email;
            this.pass = pass;
            if (this.email || this.pass) {
                this.marginBottom = true;
            }
        },
        cancel() {
            this.isEdit = !this.isEdit;
        },
        submit(isNames, isPhone, isEmail, isPass, isNotification) {
            this.errorEmail = this.errorPass = false;
            if (this.notificationActive) {
                this.form.notification = true;
                this.form.frequency = {
                    'dayOfDeadline': this.dayOfDeadline,
                    'dayBeforeDeadline': this.dayBeforeDeadline,
                    'oneWeek': this.oneWeek,
                    'twoWeek': this.twoWeek
                }
            }
            if (this.google) {
                this.form.google_email = this.google_email;
            }
            if (isNames && !isPhone && !isEmail && !isPass) {
                this.form.name = this.name;
            } else if (!isNames && !isPhone && !isEmail && !isPass) {
                this.form.last_name = this.last_name;
            } else if (!isNames && isPhone && !isEmail && !isPass) {
                this.form.phone_number = this.phoneNum;
            } else if (!isNames && !isPhone && isEmail && !isPass) {
                if (this.emailAdd !== this.emailConf) {
                    this.errorEmail = true;
                    return false;
                }
                this.form.email = this.emailAdd;
            } else if (!isNames && !isPhone && !isEmail && isPass) {
                if (this.password !== this.confirmPass) {
                    this.errorPass = true;
                    return false;
                }
                this.form.password = this.password;
                this.form.pass = this.pass;
            }
            this.form.post(route('editProfile'), {
                //   onFinish: () => window.location.reload()
            });
        }
    },
    // mounted() {
    //     const urlParams = new URLSearchParams(window.location.search);
    //     if(urlParams.get('connected')) {
    //         this.connected = urlParams.get('connected');
    //     }
    //     console.log(this.connected);
    // }
}

</script>
