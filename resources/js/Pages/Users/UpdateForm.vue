<template>
    <app-layout title="Profile">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Usuario
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div>
                    <update-profile-information-form :user_edit="user_edit" :roles="roles" :main_customers="main_customers" />

                    <jet-section-border />
                </div>

                <div>
                    <update-password-form class="mt-10 sm:mt-0" :user_edit="user_edit" />

                    <jet-section-border />
                </div>

            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
import UpdatePasswordForm from '@/Pages/Users/Partials/UpdatePasswordForm.vue'
import UpdateProfileInformationForm from '@/Pages/Users/Partials/UpdateProfileInformationForm.vue'

export default {
    props: {
        user_edit: Object,
        roles: Array,
        main_customers: Array,
    },

    components: {
        AppLayout,
        JetSectionBorder,
        UpdatePasswordForm,
        UpdateProfileInformationForm,
    },
}
</script>
