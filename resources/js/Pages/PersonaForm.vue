<template>
  <div class="max-w-2xl mx-auto mt-10 space-y-4">
    <div class="bg-gray-100 p-4 rounded shadow">
      <p><strong>AI:</strong> Hi, please tell me the name of the person I should become to create your buyer persona.</p>
    </div>

    <input v-model="personaName" type="text" class="w-full border p-2 rounded" placeholder="Please become a person named..." />

    <button @click="confirmName" class="bg-blue-600 text-white px-4 py-2 rounded">
      Confirm Name
    </button>

    <div v-if="step >= 2" class="bg-gray-100 p-4 rounded shadow">
      <p><strong>AI:</strong> I am now {{ personaName }}, please paste the characteristics I should have.</p>
    </div>

    <textarea v-if="step >= 2" v-model="personaDetails" class="w-full border p-2 rounded" rows="8" placeholder="Paste Q&A about your persona here..."></textarea>

    <button v-if="step >= 2" @click="sendPersonaDetails" class="bg-green-600 text-white px-4 py-2 rounded">
      Submit Persona Info
    </button>

    <div v-if="step === 3" class="bg-gray-100 p-4 rounded shadow whitespace-pre-wrap">
      <p><strong>AI:</strong> Here are the characteristics I have:</p>
      <p>{{ formattedPersona }}</p>
      <p class="mt-4">What would you like to do next?</p>

      <div class="flex flex-wrap gap-2 mt-2">
        <button v-for="action in actions" :key="action" @click="selectAction(action)" class="px-3 py-1 bg-purple-600 text-white rounded">
          {{ action }}
        </button>
      </div>
    </div>

    <div v-if="step === 4" class="bg-yellow-100 p-4 rounded shadow whitespace-pre-wrap">
      <p><strong>AI:</strong> Great! Now I will generate <strong>{{ selectedAction }}</strong> based on the persona.</p>
      <p class="mt-2 font-mono text-sm text-gray-800">
        {{ actionResult }}
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const personaName = ref('')
const personaDetails = ref('')
const formattedPersona = ref('')
const selectedAction = ref('')
const step = ref(1)
const actionResult = ref('')

const actions = [
  'Create Ads',
  'Create Keywords',
  'Create Display URLs',
  'Create Callouts',
  'Create Extensions',
  'Create Sitelinks'
]

const confirmName = () => {
  if (personaName.value) step.value = 2
}

const sendPersonaDetails = async () => {
  try {
    const res = await axios.post('persona', {
      name: personaName.value,
      details: personaDetails.value
    })
    formattedPersona.value = res.data.formatted
    step.value = 3
  } catch (e) {
    alert('❌ Failed to send to AI:\n' + (e.response?.data?.error || e.message))
    console.error(e)
  }
}

const selectAction = async (action) => {
  selectedAction.value = action
  step.value = 4

  try {
    const res = await axios.post('generate', {
      action: action,
      persona_name: personaName.value,
      persona_details: personaDetails.value
    })
    actionResult.value = res.data.result
  } catch (e) {
    console.error(e)
    actionResult.value = '❌ Failed to generate content.'
  }
}
</script>
