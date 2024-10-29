<script setup>
import { computed, ref, reactive } from 'vue';

const props = defineProps({
    colorOptions: { type: Array, required: true },
    label: { type: String, default: "Select a color" },
    emptyOption: { type: String, default: "" },
    inputId: { type: String, default: "color-input" },
});

const selectData = reactive({
    active: false,
    selectedColor: "",
    selectedColorName: "",
    colors: props.colorOptions,
    noSelection: true,
});

const selector = computed(() => {
    if (!selectData.selectedColor && !props.emptyOption) {
        return props.label;
    } else if (!selectData.selectedColor && props.emptyOption) {
        if (props.emptyOption === "true") {
            return props.label;
        } else if (props.emptyOption !== "true" && !selectData.noSelection) {
            return `<span class="noColor"></span> ${props.emptyOption}`;
        } else {
            return props.label;
        }
    } else {
        return `<span style="background: ${selectData.selectedColor}"></span> ${selectData.selectedColorName}`;
    }
});

const setColor = (color, colorName) => {
    selectData.selectedColor = color;
    selectData.selectedColorName = colorName;
    selectData.active = false;
    selectData.noSelection = false;
    this.$emit("update:modelValue", selectData.selectedColor);
}

const toggleDropdown = () => {
    selectData.active = !selectData.active;
}
</script>

<template>
    <div class="wrapper-dropdown">
        <span @click="toggleDropdown" v-html="selector"></span>
        <ul class="dropdown" v-show="selectData.active">
            <li v-if="props.emptyOption" @click="setColor()">
                <span class="noColor" v-if="props.emptyOption !== 'true'"></span>
                {{ props.emptyOption === 'true' ? '' : props.emptyOption }}
            </li>
            <li v-for="color in selectData.colors" :key="color.hex" @click="setColor(color.hex, color.name)">
                <span :style="{ background: color.hex }"></span> {{ color.name }}
            </li>
        </ul>
        <input type="hidden" :name="inputId" :id="inputId" v-model="selectedColor" />
    </div>
</template>

<style scoped>
.wrapper-dropdown {
    position: relative;
    width: 200px;
    background: #FFF;
    color: #2e2e2e;
    outline: none;
    cursor: pointer;
}
.wrapper-dropdown > span {
    width: 100%;
    display: block;
    border: 1px solid #ababab;
    padding: 5px;
}
.wrapper-dropdown > span > span {
    padding: 0 12px;
    margin-right: 5px;
}
.wrapper-dropdown > span > span.noColor {
    background: #CCC;
    position: relative;
}
.wrapper-dropdown > span > span.noColor:after {
    content: "";
    background: red;
    -webkit-transform: rotate(-32deg);
    transform: rotate(-32deg);
    display: inline-block;
    width: 28px;
    height: 2px;
    position: absolute;
    bottom: 7px;
    left: -2px;
}
.wrapper-dropdown > span:after {
    content: "";
    width: 0;
    height: 0;
    position: absolute;
    right: 16px;
    top: calc(50% + 4px);
    margin-top: -6px;
    border-width: 6px 6px 0 6px;
    border-style: solid;
    border-color: #2e2e2e transparent;
}

.wrapper-dropdown .dropdown {
    position: absolute;
    z-index: 10;
    top: 100%;
    left: 0;
    right: 0;
    background: #fff;
    font-weight: normal;
    list-style-type: none;
    padding-left: 0;
    margin: 0;
    border: 1px solid #ababab;
    border-top: 0;
}

.wrapper-dropdown .dropdown li {
    display: block;
    text-decoration: none;
    color: #2e2e2e;
    padding: 5px;
    cursor: pointer;
    min-height: 28px;
}

.wrapper-dropdown .dropdown li > span {
    padding: 0 12px;
    margin-right: 5px;
}
.wrapper-dropdown .dropdown li > span.noColor {
    background: #CCC;
    position: relative;
}
.wrapper-dropdown .dropdown li > span.noColor:after {
    content: "";
    background: red;
    -webkit-transform: rotate(-32deg);
    transform: rotate(-32deg);
    display: inline-block;
    width: 28px;
    height: 2px;
    position: absolute;
    bottom: 7px;
    left: -2px;
}

.wrapper-dropdown .dropdown li:hover {
    background: #eee;
    cursor: pointer;
}
</style>
