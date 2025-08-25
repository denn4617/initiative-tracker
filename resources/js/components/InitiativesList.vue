<template>
    <section>
        <div v-if="loading" class="text-gray-500 p-2">Loading...</div>

        <div v-else>
            <!-- Sorting controls -->
            <div class="flex items-center gap-3 mb-3">
                <label class="text-sm font-bold">Sort by:</label>

                <select v-model="sortBy" class="border rounded p-1 text-sm">
                    <option value="created" class="text-black">Created</option>
                    <option value="updated" class="text-black">Updated</option>
                    <option value="impact_score" class="text-black">Impact Score</option>
                </select>

                <div role="radiogroup" aria-label="Sort direction"
                    class="inline-flex rounded-md border overflow-hidden">
                    <button type="button" role="radio" :aria-checked="isAsc"
                        class="px-3 py-1 text-sm rounded-l-md flex items-center gap-1 transition-colors"
                        :class="isAsc ? 'bg-[#00ADB5] text-white' : 'hover:bg-[#11151a]'" @click="setDir('asc')">
                        <span class="material-symbols-outlined !text-sm">arrow_upward</span>
                        Ascending
                    </button>
                    <button type="button" role="radio" :aria-checked="!isAsc"
                        class="px-3 py-1 text-sm rounded-r-md flex items-center gap-1 border-l transition-colors"
                        :class="!isAsc ? 'bg-[#00ADB5] text-white' : 'hover:bg-[#11151a]'" @click="setDir('desc')">
                        <span class="material-symbols-outlined !text-sm">arrow_downward</span>
                        Descending
                    </button>
                </div>
            </div>


            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Initiative cards -->
                <template v-if="sortedItems.length">
                    <InitiativeCard v-for="i in sortedItems" :key="i.id" :initiative="i" @edit="$emit('edit', i)"
                        @delete="onDelete(i)" />
                </template>

                <!-- Add card -->
                <button type="button"
                    class="h-[190px] flex items-center justify-center border rounded-lg p-4 hover:bg-[#11151a] hover:text-green-700 cursor-pointer"
                    @click="$emit('add')" aria-label="Add initiative">
                    <span class="material-symbols-outlined !text-6xl">add_circle</span>
                </button>
            </div>

            <p v-if="!sortedItems.length" class="text-gray-500 p-2">
                No initiatives yet — click the plus to add one.
            </p>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import InitiativeCard from './InitiativeCard.vue'
import { getInitiatives, deleteInitiative } from '../services/api'

const items = ref([])
const loading = ref(true)

// --- sorting state ---
const sortBy = ref('created') // 'created' | 'updated' | 'impact_score'
const sortDir = ref('asc')     // 'asc' | 'desc'
const isAsc = computed(() => sortDir.value === 'asc')

function setDir(dir) {
    sortDir.value = dir
}


const sortedItems = computed(() => {
    const arr = [...items.value]
    return arr.sort((a, b) => {
        let vA, vB
        switch (sortBy.value) {
            case 'updated':
                vA = new Date(a.updated_at).getTime()
                vB = new Date(b.updated_at).getTime()
                break
            case 'impact_score':
                vA = a.impact_score
                vB = b.impact_score
                break
            case 'created':
            default:
                vA = new Date(a.created_at).getTime()
                vB = new Date(b.created_at).getTime()
                break
        }
        return sortDir.value === 'asc' ? vA - vB : vB - vA
    })
})

async function load() {
    loading.value = true
    try {
        items.value = await getInitiatives()
    } finally {
        loading.value = false
    }
}

async function onDelete(item) {
    if (!confirm(`Delete "${item.title}"?`)) return
    await deleteInitiative(item.id)
    const idx = items.value.findIndex(x => x.id === item.id)
    if (idx !== -1) items.value.splice(idx, 1)
}

// exposed so parent can update list after save
function applySaved(saved) {
    const idx = items.value.findIndex(x => x.id === saved.id)
    if (idx === -1) {
        // created: append so it appears at the end when sorting by Created Asc
        items.value.push(saved)
    } else {
        // edited: replace in place
        items.value[idx] = saved
    }
}

onMounted(load)
defineExpose({ load, applySaved })
defineEmits(['edit', 'add'])
</script>
