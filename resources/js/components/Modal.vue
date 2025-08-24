<template>
    <teleport to="body">
        <div v-if="open" class="fixed inset-0 z-50 flex items-center justify-center" @keydown.esc="$emit('close')">

            <div class="absolute inset-0 bg-black/50" @click="$emit('close')"></div>

            <div class="relative z-10 w-full max-w-lg rounded-lg bg-[#222831] p-5 shadow-lg">
                <header class="flex items-start justify-between gap-4">
                    <h2 class="text-lg font-semibold">{{ title }}</h2>
                    <button class="text-gray-500 hover:text-gray-700 cursor-pointer" @click="$emit('close')"
                        aria-label="Close">✕</button>
                </header>

                <div class="mt-4">
                    <slot />
                </div>

            </div>
        </div>
    </teleport>
</template>

<script setup>
defineProps({
    open: { type: Boolean, default: false },
    title: { type: String, default: '' },
})
defineEmits(['close'])
</script>
