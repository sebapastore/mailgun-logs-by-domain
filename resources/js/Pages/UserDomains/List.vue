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
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 stroke-red-600" fill="none" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
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
        <jet-dialog-modal :show="showModal" @close="closeModal">
            <template #title>
                Agregar Dominio
            </template>

            <template #content>
                <div class="grid grid-cols-6 gap-6 h-48">

                    <!-- domain_id -->
                    <div class="col-span-6 sm:col-span-6">
                        <my-list-box2
                            id="domain"
                            v-model="domainForm.domain_id"
                            @input="val => domainForm.domain_id = val"
                            :options="domains"
                            @selected=""
                        >
                            <template #header>
                                <jet-label for="type" value="Agregar Dominio" />
                            </template>
                            <template #footer>
                                <jet-input-error :message="domainForm.errors.domain_id" class="mt-2" />
                            </template>
                        </my-list-box2>
                    </div>


                </div>
            </template>

            <template #footer>
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <jet-secondary-button class="ml-2" @click="closeModal">
                            Cancelar
                        </jet-secondary-button>

                        <jet-button class="ml-2" @click="submitAddDomain" :class="{ 'opacity-25': domainForm.processing }" :disabled="domainForm.processing">
                            Guardar
                        </jet-button>
                    </div>
                </div>
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
    },

    props: {
        user_edit: Object,
        user_domains: Array,
        domains: Array,
    },

    data() {
        return {
            domainForm: this.$inertia.form({
                user_id: this.user_edit.id,
                domain_id: null,
            }),
            showModal: false,
        }
    },

    methods: {
        submitAddDomain() {
            this.domainForm.post(this.route('user-domain.store', {
                user: this.domainForm.user_id,
                domain: this.domainForm.domain_id
            }), {
                preserveScroll: true,
                onSuccess: () => this.showModal = false,
            })
        },
        submitDeleteDomain() {
            // this.addressForm._method = 'DELETE'
            // this.addressForm.delete(route('customer-addresses.delete', {address: this.addressForm.id}), {
            //     errorBag: 'deleteAddress',
            //     preserveScroll: true,
            //     onSuccess: () => this.showModal = false,
            // });
        },
        closeModal() {
            this.showModal = false
        },
        addDomain() {
            this.domainForm.domain_id = null
            this.showModal = true
        },
    }
}
</script>
