<template>
    <app-layout title="Domains">
        <template #header>
            <h2>
                Domains
            </h2>
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
    export default {
        props: ['domains'],
        components: {
            AppLayout,
        },
    }
</script>