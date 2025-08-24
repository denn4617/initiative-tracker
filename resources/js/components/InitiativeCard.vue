<template>
    <article class="h-[190px] rounded-lg border shadow-sm p-4 transition-colors group" :class="{
        'border-red-700 bg-red-700/5': isDeleteHovered,
        'border-blue-700 bg-blue-700/5': isEditHovered
    }">
        <div class="flex flex-col h-full justify-between">
            <header class="flex justify-between gap-3">
                <h3 class="font-semibold text-lg">{{ initiative.title }}</h3>
                <span class="text-xs px-2 py-1 rounded-full border">
                    {{ initiative.category || '—' }}
                </span>
            </header>

            <p class="text-sm text-gray-400 mt-1">
                {{ initiative.description || 'No description provided.' }}
            </p>

            <div class="flex items-center justify-between">
                <div class="mt-2 text-sm">
                    <span class="font-medium">Impact:</span> {{ initiative.impact_score }}/10
                </div>
                <div class="mt-3 flex gap-3 text-sm">
                    <button class="text-blue-600 cursor-pointer hover:text-blue-700" @mouseenter="isEditHovered = true"
                        @mouseleave="isEditHovered = false" @click="$emit('edit', initiative)">
                        <span class="material-symbols-outlined">edit</span>
                    </button>

                    <!-- track hover state -->
                    <button class="text-red-600 cursor-pointer hover:text-red-700" @mouseenter="isDeleteHovered = true"
                        @mouseleave="isDeleteHovered = false" @click="$emit('delete', initiative)">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </div>
            </div>
        </div>
    </article>
</template>

<script setup>
import { ref } from 'vue'

defineProps({ initiative: { type: Object, required: true } })
defineEmits(['edit', 'delete'])

const isDeleteHovered = ref(false)
const isEditHovered = ref(false)
</script>
