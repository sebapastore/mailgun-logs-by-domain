<template>
    <app-layout title="Gestionar Dominios">
        <template #header>
            <div class="lg:flex lg:items-center lg:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Gestionar Dominios del usuario {{ user_edit.name }} - {{ user_edit.email }}
                    </h2>
                </div>
                <div class="mt-5 flex lg:mt-0 lg:ml-4">
                    <my-button-link :href="route('users.index')">
                        Volver a lista de Usuarios
                    </my-button-link>
                </div>
            </div>
        </template>

        <div>
            <!-- Dominios -->
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1 flex justify-between">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium text-gray-900">
                                Dominios
                            </h3>

                            <p class="mt-1 text-sm text-gray-600">
                                Agregue los dominios asociados al usuario
                            </p>
                            <div class='mt-3'>
                                <span class='inline-flex rounded-md shadow-sm'>
                                    <jet-button @click="addDomain()">Agregar</jet-button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class='overflow-hidden shadow sm:rounded-md'>
                            <div class='bg-white'>
                                <ul>
                                    <li v-for="(domain, index) in user_domains">
                                        <div class='flex items-center px-4 py-4 sm:px-6 border-b'>
                                            <div class='flex items-center flex-1 min-w-0 text-sm leading-5 text-gray-500'>
                                                <div class='flex-1 min-w-0 pr-4 md:grid md:grid-cols-2 md:gap-4'>
                                                    <div>
                                                        <div class='font-medium text-indigo-600 truncate'>{{ domain.name }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <button @click="confirmDeletion(domain.pivot.domain_id, domain.name)" class="ml-2" title="Eliminar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 hover:text-red-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Domain Modal -->
        <jet-dialog-modal :show="showAddModal" @close="closeAddModal">
            <template #title>
                Agregar Dominio
            </template>

            <template #content>
                <div class="grid grid-cols-6 gap-6 h-48">

                    <!-- domain_id -->
                    <div class="col-span-6 sm:col-span-6">
                        <my-list-box2
                            id="domain"
                            v-model="form.domain_id"
                            @input="val => form.domain_id = val"
                            :options="domains"
                            @selected=""
                        >
                            <template #header>
                                <jet-label for="type" value="Agregar Dominio" />
                            </template>
                            <template #footer>
                                <jet-input-error :message="form.errors.domain_id" class="mt-2" />
                            </template>
                        </my-list-box2>
                    </div>

                </div>
            </template>

            <template #footer>
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <jet-secondary-button class="ml-2" @click="closeAddModal">
                            Cancelar
                        </jet-secondary-button>

                        <jet-button class="ml-2" @click="submitAdd" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Guardar
                        </jet-button>
                    </div>
                </div>
            </template>
        </jet-dialog-modal>

        <!-- Delete Modal -->
        <jet-dialog-modal :show="showDeleteModal" @close="closeDeleteModal">
            <template #title>
                Desvincular Dominio
            </template>

            <template #content>
                Está seguro que desea desvincular el dominio <span class="font-bold">{{ form.name }}</span> del usuario <span class="font-bold">{{ user_edit.email }}</span>?
            </template>

            <template #footer>
                <jet-secondary-button @click="closeDeleteModal">
                    Cancelar
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click="submitDelete" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Eliminar
                </jet-danger-button>
            </template>
        </jet-dialog-modal>


    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetCheckBox from '@/Jetstream/Checkbox'
import MyListBox from '@/CustomComponents/ListBox.vue'
import MyDangerButton from '@/CustomComponents/DangerButton'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetDangerButton from '@/Jetstream/DangerButton'
import MyButtonLink from '@/CustomComponents/ButtonLink.vue'
import MyListBox2 from '@/CustomComponents/ListBox2'


export default {
    components: {
        AppLayout,
        JetSectionBorder,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
        MyListBox,
        JetCheckBox,
        JetDialogModal,
        MyDangerButton,
        MyButtonLink,
        MyListBox2,
        JetDangerButton,
    },

    props: {
        user_edit: Object,
        user_domains: Array,
        domains: Array,
    },

    data() {
        return {
            form: this.$inertia.form({
                user_id: this.user_edit.id,
                domain_id: null,
                name: null,
            }),
            showAddModal: false,
            showDeleteModal: false,
        }
    },

    methods: {

        submitAdd() {
            this.form.post(this.route('user-domain.store', {
                user: this.form.user_id,
                domain: this.form.domain_id
            }), {
                preserveScroll: true,
                onSuccess: () => this.showAddModal = false,
            })
        },

        submitDelete() {
            this.form.delete(route('user-domain.destroy', {
                user: this.form.user_id,
                domain: this.form.domain_id,
            }), {
                preserveScroll: false,
                onSuccess: () => this.closeDeleteModal(),
                onError: () => this.closeDeleteModal(),
            })
        },

        closeAddModal() {
            this.showAddModal = false
        },

        closeDeleteModal() {
            this.showDeleteModal = false
        },

        addDomain() {
            this.form.domain_id = null
            this.form.name = null
            this.showAddModal = true
        },

        confirmDeletion(id, name) {
            this.showDeleteModal = true
            this.form.domain_id = id
            this.form.name = name
        },

    }
}
</script>
