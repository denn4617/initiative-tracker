<template>
    <form class="space-y-3" @submit.prevent="submit">
        <div>
            <label class="block text-sm font-medium">Title</label>
            <input v-model.trim="form.title" type="text" maxlength="150" class="border rounded p-2 w-full" />
            <p v-if="errors.title" class="text-red-600 text-sm mt-1">{{ errors.title }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium">Category</label>
            <input v-model.trim="form.category" type="text" maxlength="100" class="border rounded p-2 w-full" />
            <p v-if="errors.category" class="text-red-600 text-sm mt-1">{{ errors.category }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium">Impact score (1–10)</label>
            <input v-model.number="form.impact_score" type="number" min="1" max="10"
                class="border rounded p-2 w-full" />
            <p v-if="errors.impact_score" class="text-red-600 text-sm mt-1">{{ errors.impact_score }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium">Description</label>
            <textarea v-model.trim="form.description" rows="3" class="border rounded p-2 w-full"></textarea>
            <p v-if="errors.description" class="text-red-600 text-sm mt-1">{{ errors.description }}</p>
        </div>

        <div class="flex items-center gap-2">
            <button :disabled="submitting"
                class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 cursor-pointer disabled:opacity-50">
                {{ submitting ? 'Saving…' : submitLabel }}
            </button>
            <button type="button"
                class="px-4 py-2 rounded border cursor-pointer hover:bg-black/20 hover:border-gray-400"
                @click="$emit('cancel')">Cancel</button>
        </div>
    </form>
</template>

<script setup>
import { reactive, ref, watch, toRaw } from 'vue'
import { createInitiative, updateInitiative } from '../services/api'

const props = defineProps({
    initiative: { type: Object, default: null },   // if present -> edit mode
    submitLabel: { type: String, default: 'Save' },
})
const emit = defineEmits(['saved', 'cancel'])

const form = reactive({
    title: '',
    category: '',
    impact_score: 5,
    description: ''
})

const errors = reactive({})
const submitting = ref(false)

function fillFrom(initi) {
    form.title = initi?.title ?? ''
    form.category = initi?.category ?? ''
    form.impact_score = initi?.impact_score ?? 5
    form.description = initi?.description ?? ''
}
watch(() => props.initiative, v => fillFrom(v), { immediate: true })

function clearErrors() { Object.keys(errors).forEach(k => delete errors[k]) }

async function submit() {
    submitting.value = true
    clearErrors()

    if (!form.title) errors.title = 'Title is required'
    if (!form.category) errors.category = 'Category is required'
    if (!(form.impact_score >= 1 && form.impact_score <= 10)) errors.impact_score = 'Must be 1–10'
    if (Object.keys(errors).length) { submitting.value = false; return }

    try {
        const payload = { ...toRaw(form) }
        let saved
        if (props.initiative?.id) {
            saved = await updateInitiative(props.initiative.id, payload)
        } else {
            saved = await createInitiative(payload)
        }
        emit('saved', saved?.data ?? saved)
    } catch (e) {
        const err = e?.errors || e
        if (err && typeof err === 'object') {
            for (const [k, v] of Object.entries(err)) errors[k] = Array.isArray(v) ? v[0] : String(v)
        } else {
            errors.title = 'Something went wrong. Please try again.'
        }
    } finally {
        submitting.value = false
    }
}
</script>
