<template>
    <app-layout title="Domains">
        <template #header>
            <div class="lg:flex lg:items-center lg:justify-between">
                <h2>
                    Domains
                </h2>
                <div class="mt-5 flex lg:mt-0 lg:ml-4">
                    <my-button-link :href="route('domains.create')">
                        Crear Dominio
                    </my-button-link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div v-for="domain in domains" :key="domain.id">
                    {{ domain.name }}
                </div>
            </div>
        </div>
    </app-layout>
    
</template>
<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import MyButtonLink from '@/CustomComponents/ButtonLink.vue'
    export default {
        props: ['domains'],
        components: {
            AppLayout,
            MyButtonLink,
        },
    }
</script>