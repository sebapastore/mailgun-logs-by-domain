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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nombre
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Editar</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="domain in domains" :key="domain.id">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ domain.name}}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <Link :href="route('domains.edit', {domain: domain.id})" class="ml-4 text-indigo-600 hover:text-indigo-900">
                                                    Editar
                                                </Link>
                                            </td>
                                            <td>
                                                <button v-on:click="show_logs(domain.id)">Ver logs</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap" colspan="5" v-if="domains.length === 0">
                                                <div class="text-sm text-gray-900 text-center">No se encontraron registros.</div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
    
</template>
<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import MyButtonLink from '@/CustomComponents/ButtonLink.vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        props: ['domains'],
        components: {
            AppLayout,
            MyButtonLink,
            Link,
        },
        methods:{
            show_logs(domain_id){
                let url = route('mail-log.index');
                axios.get(url,{
                    headers:{ "Content-Type":"application/JSON" },
                    params :{ 'domain_id':domain_id }
                })
                .then((response) => {
                    console.log(response.items)
                }).catch(()=>{
                    alert("Ocurrió un error");
                })
            },
        }
    }
</script>