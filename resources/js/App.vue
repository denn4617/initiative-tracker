<template>
    <main class="p-10">
        <header class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">Initiative Tracker</h1>
        </header>

        <InitiativesList ref="listRef" @edit="startEdit" @add="showCreate = true" />

        <Modal :open="showCreate" title="New initiative" @close="showCreate = false">
            <InitiativeForm submit-label="Create" @saved="afterSave" @cancel="showCreate = false" />
        </Modal>

        <Modal :open="!!editing" title="Edit initiative" @close="editing = null">
            <InitiativeForm :key="editing?.id || 'new'" :initiative="editing" submit-label="Update" @saved="afterSave"
                @cancel="editing = null" />
        </Modal>
    </main>
</template>

<script setup>
import { ref } from 'vue'
import Modal from './components/Modal.vue'
import InitiativesList from './components/InitiativesList.vue'
import InitiativeForm from './components/InitiativeForm.vue'

const listRef = ref(null)
const showCreate = ref(false)
const editing = ref(null)

function afterSave(item) {
    showCreate.value = false
    editing.value = null
    listRef.value?.applySaved(item) // update locally
}

function startEdit(item) {
    editing.value = item
}
</script>
