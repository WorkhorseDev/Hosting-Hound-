<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import {Link} from '@inertiajs/vue3';
import {inject, reactive} from "vue";
import {Calendar} from "v-calendar";
import 'v-calendar/style.css';
import {ref} from 'vue';

const currentPageDate = ref(new Date());
const today = new Date();
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
                         <Link :href="route('profile')"> <i class="fas fa-user"></i></Link>
                    </span>
                </div>
            </header>
            <div class="main-panel billing">
                <div class="search-section">
          <span class="calendar-btn" @click="showCalendar">
              <i class="fa-solid" :class="[ isCalendarOpen ? 'fa-list' : 'fa-calendar-days' ]"></i>
          </span>
                    <div class="search-bar">
                        <form action="" class="search-form" id="search_form" @submit.prevent>
                            <input type="text" v-model="searchData" @input="search" class="search-input" id="search"
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
            <div class="sort-panel">
                <div v-if="companyText" class="gray-border"><i class="fa-solid fa-x" @click="sortNoCompany"></i> <span>{{ companyText }}</span>
                </div>
                <div v-if="colorText" class="gray-border">
                    <i class="fa-solid fa-x" @click="sortNoColor"></i>
                    <span>Color</span>
                    <div v-if="colorText !== 'multi'" class="item-circle small"
                         v-bind:style="{background: colorText}"></div>
                    <div class="item-circle small multi-color" v-if="colorText === 'multi'">
                        <div class="half" style="background-color: #FF9500;"></div>
                        <div class="half" style="background-color: #2E4C42;"></div>
                        <div class="half" style="background-color: #B6C793;"></div>
                    </div>
                </div>
                <div v-if="sourceText" class="gray-border"><i class="fa-solid fa-x" @click="sortNoSource"></i>
                    <span>{{ sourceText }}</span></div>
                <div v-if="sourceName" class="gray-border"><i class="fa-solid fa-x" @click="sortNoSourceName"></i>
                    <span>{{ sourceName }}</span></div>
                <div v-if="deadline" class="gray-border"><i class="fa-solid fa-x" @click="sortNoDeadline"></i>
                    <span>{{ deadline }}</span></div>
                <div v-if="cost" class="gray-border"><i class="fa-solid fa-x" @click="sortNoCost"></i>
                    <span>{{ cost }}</span></div>
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
                                <div class="heading row flex justify-center text-2xl mb-5">
                                    <span class="filter-close md:hidden" @click="showFilter"><i
                                        class="fa-solid fa-xmark"></i></span>
                                    Filter <span class="hidden md:inline-flex">&nbsp;items below</span>
                                </div>
                                <div class="filter-inner">
                                    <div class="filter-search mb-5">
                                        <input type="text" @input="search" v-model="searchData"
                                               class="filter-search-input"
                                               id="filter-search" placeholder="Search term...">
                                        <button type="button" class="search-btn">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </div>

                                    <div class="row flex flex-row gap-3 billing-filter-date">
                                        <div class="form-group w-1/2">
                                            <label class="filter-date">Deadline Time Frame</label>
                                            <VueDatePicker position="left" class="billing-filter" value-type="date"
                                                           format="MM/dd/yyyy" v-model="dateStart"></VueDatePicker>
                                        </div>
                                        <hr>
                                        <div class="form-group w-1/2 top-space">
                                            <VueDatePicker position="right" class="billing-filter second"
                                                           value-type="date" format="MM/dd/yyyy"
                                                           v-model="dateEnd"></VueDatePicker>
                                        </div>
                                    </div>

                                    <div class="row flex flex-row gap-3">
                                        <div class="form-group w-1/2">
                                            <label>Cost Range</label>
                                            <input class="billing-filter" type="text" v-model="small"><span
                                            class="in-input">$</span>
                                        </div>
                                        <hr>
                                        <div class="form-group w-1/2">
                                            <input class="billing-filter second" type="text" v-model="big"><span
                                            class="in-input">$</span>
                                        </div>
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
                                                    <div class="item-circle" v-if="!multi"
                                                         v-bind:style="{background: color}"></div>
                                                    <span class="dropdown-arrow">
                              <i class="fa-solid fa-caret-down"></i>
                          </span>
                                                </div>
                                                <div class="dropdown-list" v-if="isDropdownColorOpen">
                                                    <div class="item">
                                                        <div class="item-circle" @click=setColor(dark_green)
                                                             style="background-color: #4A6A65;"></div>
                                                    </div>
                                                    <div class="item">
                                                        <div class="item-circle" @click=setColor(orange)
                                                             style="background-color: #FFA726;"></div>
                                                    </div>
                                                    <div class="item">
                                                        <div class="item-circle" @click=setColor(light_green)
                                                             style="background-color: #B6C793;"></div>
                                                    </div>
                                                    <div class="item">
                                                        <div class="item-circle multi-color"
                                                             @click=setColor(multiColor)>
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
                                            <label for="hosts">Source Type</label>
                                            <select id="hosts" @change="setName(hostSort)" v-model="hostSort">
                                                <option>View All</option>
                                                <option v-for="host in hosts">{{ host }}</option>
                                            </select>
                                        </div>

                                        <div class="form-group w-1/2">
                                            <label for="domain-provider">Source Name</label>
                                            <select id="domain-provider" v-model="hostNameSort">
                                                <option>View All</option>
                                                <option v-for="name in names">{{ name }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row flex justify-center mt-6">
                                        <button type="button" @click="sortField" class="btn-md btn-inverted">Apply
                                            Filters
                                        </button>
                                    </div>
                                </div> <!-- end .filter-inner -->
                            </div>
                        </div>

                        <div class="flex w-full"
                             :class="[ isCalendarOpen ? 'gap-x-14 gap-y-8' : '', isFilterOpen && isCalendarOpen ? 'flex-col': '' ]">
                            <div class="data card-list"
                                 v-if="arr && arr.length !== 0"
                                 :class="{
                           filter_active: isFilterOpen,
                           calendar_active: isCalendarOpen,
                           'order-2': isFilterOpen && isCalendarOpen }">
                                <div v-for="item in arr" class="card-item">
                                    <div class="card-content" @click="hostDetail(item.id, item.key)">
                                        <div class="info">
                                            <p class="card-title">{{ item.provider.type }}</p>
                                            <p class="card-title">{{ item.provider.name }}</p>
                                            <p class="card-link">$ {{ item.provider.cost }} -
                                                {{ item.provider.renewal_date }}</p>
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
                            <div class="data card-list empty"
                                 v-if="arr && arr.length === 0 && searchData.trim()">
                                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                                <p class="empty-calendar black">No results found for "{{ searchData }}".</p>
                                <p class="empty-calendar black">Try a different search term.</p>
                            </div>

                            <div class="data card-list empty"
                                 v-if="arr && arr.length === 0 && !searchData.trim()">
                                <p class="empty-calendar">{{ monthName(currentPageDate) }} Renewals<br>as of today, {{ formatDate(today) }} </p>
                                <i class="fa fa-check" aria-hidden="true"></i>
                                <p class="empty-calendar black">You have no {{ monthName(currentPageDate) }} Renewals<br>with this  {{nameField}} .</p>
                                <p class="empty-calendar black">Try changing your "Filter > {{nameField}}"<br>
                                    to other value <br>
                                    in order to view all of your<br> renewels for {{ monthName(currentPageDate) }}.</p>
                            </div>

                            <div class="calendar-container" v-if="isCalendarOpen">
                                <Calendar class="billing-calendar" :attributes='calendarAttributes'/>
                            </div> <!-- end .calendar-container -->
                        </div> <!-- end .data-wrapper -->
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
<script>
import {useForm} from "@inertiajs/vue3";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import moment from 'moment';

export default {
    props: {
        sites: [],
        companies: [],
        hosts: [],
        hostName: [],
        sslArr: [],
        emails: [],
        cms: [],
        namesHost: []
    },

    components: {
        Calendar,
    },

    data() {
        return {
            nameField: '',
            names: this.namesHost,
            sourceText: '',
            sourceName: '',
            companyText: '',
            colorText: '',
            deadline: '',
            cost: '',
            color: 'multi',
            orange: '#FF920A',
            dark_green: '#3D5F58',
            light_green: '#A7B57C',
            isDropdownColorOpen: false,
            sortColor: false,
            multi: true,
            multiColor: 'multi',
            searchData: '',
            companySort: '',
            hostNameSort: '',
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
            isCalendarOpen: false,
            sortArr: [],
            dateStart: '',
            dateEnd: '',
            big: '',
            small: '',

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
            const groupedAttributes = {};
            const maxDate = new Date();
            maxDate.setFullYear(maxDate.getFullYear() + 1);

            this.arr.forEach((service) => {
                let [day, month, year] = service.provider.renewal_date.split("/").map(Number);
                let eventDate = new Date(year, month - 1, day);

                // Custom added to the list so it passes the type check below
                const knownTypes = ['Weekly', 'Monthly', 'Annual', 'Custom'];
                const p = service.provider;
                // Build a human-readable label for the popover; Custom shows "every N units"
                const renewalLabel = p.renewal_type === 'Custom'
                    ? `every ${p.renewal_custom_period} ${p.renewal_custom_unit ? p.renewal_custom_unit.toLowerCase() : 'years'}`
                    : p.renewal_type;

                if (knownTypes.includes(p.renewal_type)) {
                    while (eventDate <= maxDate) {
                        const dateKey = `${eventDate.getFullYear()}-${eventDate.getMonth() + 1}-${eventDate.getDate()}`;

                        if (!groupedAttributes[dateKey]) {
                            groupedAttributes[dateKey] = {
                                dates: new Date(eventDate),
                                dot: {
                                    style: {
                                        backgroundColor: service.color,
                                    }
                                },
                                popover: {
                                    label: `${p.type} (${service.url}) renews ${renewalLabel} starting on ${p.renewal_date}`,
                                },
                            };
                        } else {
                            groupedAttributes[dateKey].popover.label += `\n ${p.type} (${service.url}) renews ${renewalLabel} starting on ${p.renewal_date}`;
                        }

                        if (p.renewal_type === "Weekly") {
                            eventDate.setDate(eventDate.getDate() + 7);
                        } else if (p.renewal_type === "Monthly") {
                            eventDate.setMonth(eventDate.getMonth() + 1);
                        } else if (p.renewal_type === "Annual") {
                            eventDate.setFullYear(eventDate.getFullYear() + 1);
                        } else if (p.renewal_type === "Custom") {
                            // Advance by user-defined period and unit (years/months/weeks/days)
                            const period = parseInt(p.renewal_custom_period) || 1;
                            const unit = (p.renewal_custom_unit || 'Years').toLowerCase();
                            if (unit === 'years')       eventDate.setFullYear(eventDate.getFullYear() + period);
                            else if (unit === 'months') eventDate.setMonth(eventDate.getMonth() + period);
                            else if (unit === 'weeks')  eventDate.setDate(eventDate.getDate() + period * 7);
                            else if (unit === 'days')   eventDate.setDate(eventDate.getDate() + period);
                            else break;
                        }
                    }
                }
            });

            return Object.values(groupedAttributes);
        },

        calendarAttributes() {
            return [...this.baseCalendarAttributes, ...this.dynamicCalendarAttributes];
        },
    },

    methods: {
        formatDate(date) {
            return new Intl.DateTimeFormat('en-GB').format(date)
        },
        monthName(date) {
            const options = {month: 'long'};
            return new Intl.DateTimeFormat('en-US', options).format(date);
        },
        setName(host) {
            if (host === 'View All') {
                return this.names = [...new Set(this.namesHost)];
            } else {
                return this.names = [...new Set(this.hostName[host])];
            }
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
        sortNoSource() {
            this.hostSort = '';
            this.sourceText = '';
            this.closeChips();
        },
        sortNoSourceName() {
            this.hostNameSort = '';
            this.sourceName = '';
            this.closeChips();
        },
        sortNoDeadline() {
            this.dateStart = '';
            this.dateEnd = '';
            this.deadline = '';
            this.closeChips();
        },
        sortNoCost() {
            this.big = '';
            this.small = '';
            this.cost = '';
            this.closeChips();
        },
        closeChips() {
            this.sortField();
            this.isFilterOpen = !this.isFilterOpen;
        },
        sortField() {
            this.nameField = '';
            this.sortArr = [];
            this.arr = [];
            if (this.companySort && this.companySort !== '') {
                this.companyText = this.companySort;
                if (this.companySort === 'All Companies') {
                    this.arr = this.sites;
                } else {
                    this.nameField = ',Company';
                    this.arr = [];
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
            if (this.dateStart || this.dateEnd) {
                this.nameField = this.nameField + ',Dates';
                this.arr = [];
                let dateFormatStart = this.dateStart.toISOString().substring(0, 10);
                let dateFormatEnd = this.dateEnd.toISOString().substring(0, 10);
                this.deadline = dateFormatStart + ' - ' + dateFormatEnd;
                const [y, m, d] = dateFormatStart.split(/-|\//);
                const dateStart = new Date(y, m - 1, d, 0, 0, 0);
                const [y1, m1, d1] = dateFormatEnd.split(/-|\//);
                const dateEnd = new Date(y1, m1 - 1, d1, 0, 0, 0);

                // customPeriod/customUnit are used when type === 'Custom'
                function getRecurringDates(baseDate, type, rangeStart, rangeEnd, customPeriod = 1, customUnit = 'years') {
                    let result = [];
                    let current = new Date(baseDate);

                    switch (type) {
                        case 'Weekly':
                            while (current <= rangeEnd) {
                                if (current >= rangeStart) {
                                    result.push(new Date(current));
                                }
                                current.setDate(current.getDate() + 7);
                            }
                            break;
                        case 'Monthly':
                            while (current <= rangeEnd) {
                                if (current >= rangeStart) {
                                    result.push(new Date(current));
                                }
                                const day = current.getDate();
                                current.setMonth(current.getMonth() + 1);

                                // Якщо місяць "переповнився", зберігаємо останній день
                                if (current.getDate() < day) {
                                    current.setDate(0); // останній день попереднього місяця
                                }
                            }
                            break;
                        case 'Annual':
                            while (current <= rangeEnd) {
                                if (current >= rangeStart) {
                                    result.push(new Date(current));
                                }
                                current.setFullYear(current.getFullYear() + 1);
                            }
                            break;
                        // Handles odd renewal periods like "every 5 years" or "every 90 days"
                        case 'Custom': {
                            const period = parseInt(customPeriod) || 1;
                            const unit = (customUnit || 'years').toLowerCase();
                            while (current <= rangeEnd) {
                                if (current >= rangeStart) {
                                    result.push(new Date(current));
                                }
                                if (unit === 'years')       current.setFullYear(current.getFullYear() + period);
                                else if (unit === 'months') current.setMonth(current.getMonth() + period);
                                else if (unit === 'weeks')  current.setDate(current.getDate() + period * 7);
                                else if (unit === 'days')   current.setDate(current.getDate() + period);
                                else break;
                            }
                            break;
                        }
                        default:
                            return [];
                    }

                    return result;
                }

                // Pass custom period/unit so 'Custom' type is correctly expanded into recurring dates
                Object.values(this.sortArr).filter(item => {
                    const source = item.provider;
                    if (source && source.renewal_date) {
                        const [d, m, y] = source.renewal_date.split(/-|\//);
                        const baseDate = new Date(y, m - 1, d, 0, 0, 0);
                        const type = source.renewal_type || 'Annual'; // fallback

                        const recurringDates = getRecurringDates(
                            baseDate, type, dateStart, dateEnd,
                            source.renewal_custom_period,
                            source.renewal_custom_unit
                        );
                        const isInRange = recurringDates.some(date => date >= dateStart && date <= dateEnd);

                        if (isInRange) {
                            this.arr.push(item);
                        }
                    }
                });

                // Same as above for software entries
                Object.values(this.sortArr).filter(item => {
                    const source = item.software;
                    if (source && source.renewal_date) {
                        const [d, m, y] = source.renewal_date.split(/-|\//);
                        const baseDate = new Date(y, m - 1, d, 0, 0, 0);
                        const type = source.renewal_type || 'Annual';

                        const recurringDates = getRecurringDates(
                            baseDate, type, dateStart, dateEnd,
                            source.renewal_custom_period,
                            source.renewal_custom_unit
                        );
                        const isInRange = recurringDates.some(date => date >= dateStart && date <= dateEnd);

                        if (isInRange) {
                            this.arr.push(item);
                        }
                    }
                });

                this.sortArr = this.arr;

                if (this.dateStart && !this.dateEnd) {
                    this.deadline = dateFormatStart;
                }
                if (!this.dateStart && this.dateEnd) {
                    this.deadline = dateFormatEnd;
                }
            }
            if (this.sortColor) {
                this.nameField = this.nameField + ',Color';
                this.colorText = this.color;
                if (this.multi) {
                    this.arr = this.sites;
                } else {
                    this.arr = [];
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
            }
            if (this.hostSort) {
                this.nameField = this.nameField + ',Source Type';
                this.sourceText = this.hostSort;
                if (this.hostSort === 'View All') {
                    this.arr = this.sites;
                } else {
                    this.arr = [];
                    Object.values(this.sortArr).filter(item => {
                        if (item.provider.type) {
                            if (this.hostSort.toLowerCase() === item.provider.type.toLowerCase()) {
                                this.arr.push(item);
                            }
                        }
                    });
                }
                this.sortArr = this.arr;
            } else {
                this.sourceText = '';
            }
            if (this.hostNameSort) {
                this.nameField = this.nameField + ',Source Name';
                this.sourceName = this.hostNameSort;
                if (this.hostNameSort === 'View All') {
                    this.arr = this.sortArr;
                } else {
                    this.arr = [];
                    Object.values(this.sortArr).filter(item => {
                        if (item.provider.name) {
                            if (this.hostNameSort.toLowerCase() === item.provider.name.toLowerCase()) {
                                this.arr.push(item);
                            }
                        }
                    });
                }
                this.sortArr = this.arr;
            } else {
                this.sourceName = '';
            }
            if (this.big || this.small) {
                this.arr = [];
                this.nameField = this.nameField + ',Cost Range';
                Object.values(this.sortArr).filter(item => {
                    if (item.provider.cost) {
                        if (this.big && this.small) {
                            this.cost = this.small + ' - ' + this.big;
                            if (Number(item.provider.cost) >= Number(this.small) && Number(item.provider.cost) <= Number(this.big)) {
                                this.arr.push(item);
                            }
                            return false;
                        } else if (this.big && !this.small) {
                            this.cost = '<= ' + this.big;
                            if (Number(this.big) >= Number(item.provider.cost)) {
                                this.arr.push(item);
                            }
                        } else if (!this.big && this.small) {
                            this.cost = '>= ' + this.small;
                            if (Number(this.small) <= Number(item.provider.cost)) {
                                this.arr.push(item);
                            }
                        }
                    }
                });
            } else {
                this.cost = '';
            }
            this.isFilterOpen = !this.isFilterOpen;
            this.nameField = this.nameField.substring(1);
            return this.arr;
        },

        hostDetail(id, key) {
            window.location.href = 'hostDetail/' + key + '/' + id;
        },

        search() {
            if (!this.searchData.trim()) {
                this.arr = this.sites;
                return;
            }
            const query = this.searchData.toLowerCase();
            this.arr = Object.values(this.sites).filter(item => {
                return (
                    (item.name || '').toLowerCase().indexOf(query) !== -1 ||
                    (item.url || '').toLowerCase().indexOf(query) !== -1 ||
                    (item.provider?.renewal_type || '').toLowerCase().indexOf(query) !== -1 ||
                    (item.company || '').toLowerCase().indexOf(query) !== -1 ||
                    (item.business_unit || '').toLowerCase().indexOf(query) !== -1 ||
                    (item.tags || '').toLowerCase().indexOf(query) !== -1
                );
            });
        },

        showFilter() {
            this.isFilterOpen = !this.isFilterOpen;
        },

        showCalendar() {
            this.isCalendarOpen = !this.isCalendarOpen;
            if (this.isCalendarOpen) {
                document.getElementsByClassName("card-list")[0].style.top = '555px';
            } else {
                document.getElementsByClassName("card-list")[0].style.top = '0px';
            }
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

<style>

.billing-calendar {
    width: 100%;
    background: #D8D8D8;
    border-radius: 70px;
    box-shadow: 0 4px 9px 0 rgba(0, 0, 0, 0.5);
    border: none;
}

.billing-calendar .vc-header {
    height: auto;
    margin-top: 30px;
    margin-bottom: 30px;
}

.billing-calendar .vc-pane-header-wrapper {
    top: 20px;
    width: 550px;
    left: 50%;
    transform: translateX(-50%);
}

.billing-calendar .vc-header .vc-title-wrapper {
    padding: 20px 35px;
    border-radius: 50px;
    background: #fff;
}

.billing-calendar .vc-header .vc-arrow {
    width: auto;
    height: auto;
    color: rgba(21, 32, 46, 0.75);
}

.billing-calendar .vc-header .vc-arrow:hover {
    background: #ffffff;
    opacity: 0.8;
}

.billing-calendar .vc-header .vc-base-icon {
    width: 48px;
    height: 48px;
}

.billing-calendar .vc-header .vc-title {
    font-size: 45px;
    font-weight: normal;
    color: rgba(21, 32, 46, 0.75);
    display: block;
    line-height: 45px;
}

.billing-calendar .vc-day-content {
    background: #ffffff;
    font-size: 45px;
    font-weight: normal;
    width: 85px;
    height: 85px;
    line-height: 85px;
    color: rgba(21, 32, 46, 0.75);
}

.billing-calendar .is-today .vc-day-content {
    background: #3D5F58;
    color: white;
}

.billing-calendar .vc-weeks {
    padding: 5px 25px 30px;
}

.billing-calendar .vc-week,
.billing-calendar .vc-weekdays {
    margin-bottom: 20px;
}

.billing-calendar .vc-weekdays {
    margin-bottom: 25px;
}

.billing-calendar .vc-weekday {
    font-size: 45px;
    font-weight: normal;
    line-height: 45px;
    color: rgba(21, 32, 46, 0.75);
}

.billing-calendar .is-not-in-month * {
    opacity: 1;
    color: rgba(21, 32, 46, 0.3);
}

.billing-calendar .vc-dots .vc-dot {
    width: 30px;
    height: 30px;
}

.billing-calendar .vc-day .vc-day-box-center-bottom {
    top: -5px;
    left: auto;
    bottom: auto;
    right: 12px;
}

.calendar-container .vc-day-popover-container {
    font-size: 16px;
    font-weight: normal;
}

.calendar-container .vc-popover-content {
    padding: 7px;
}

.calendar-container .vc-day-popover-header,
.calendar-container .vc-day-popover-row-label {
    font-size: 16px;
}

.calendar-container .vc-popover-content {
    white-space: pre-line !important;
}
</style>
