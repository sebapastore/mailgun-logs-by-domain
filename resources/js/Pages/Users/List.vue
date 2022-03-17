<template>
    <app-layout title="Usuarios">
        <template #header>
            <div class="lg:flex lg:items-center lg:justify-between">
                <div class="flex-1 min-w-0">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Usuarios
                    </h2>
                </div>
                <div class="mt-5 flex lg:mt-0 lg:ml-4">
                    <my-button-link :href="route('users.create')">
                        Crear Usuario
                    </my-button-link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!--Filtros-->
                <div>
                    <div class="mb-2 text-gray-900">
                        Filtros
                    </div>
                    <div class="mb-6 grid grid-cols-12 gap-x-4 gap-y-2">

                        <!-- search -->
                        <div class="md:col-span-3 col-span-6">
                            <jet-label value="Buscar" />
                            <jet-input type="text" class="mt-1 block w-full" v-model="search"/>
                        </div>

                        <!-- role -->
                        <div class="md:col-span-3 col-span-6">
                            <my-list-box
                                id="role"
                                v-model="role"
                                @input="val => role = val"
                                :options="roles"
                                @selected=""
                            >
                                <template #header>
                                    <jet-label for="type" value="Rol" />
                                </template>
                            </my-list-box>
                        </div>
                    </div>
                </div>

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
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Estado
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Rol
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Editar</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="user in users.data">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ user.name}}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ user.email}}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                  Activo
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div class="text-sm text-gray-900">{{ user.role}}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <Link v-if="user.role === 'Customer'" :href="route('user-domain.index', {user: user.id})" class="font-bold text-indigo-600 hover:text-indigo-900">Gestionar Dominios</Link>
                                                <Link :href="route('users.edit', {user: user.id})" class="ml-4 text-indigo-600 hover:text-indigo-900">Editar</Link>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap" colspan="5" v-if="users.data.length === 0">
                                                <div class="text-sm text-gray-900 text-center">No se encontraron registros. Revise los filtros.</div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <Pagination :links="users.links" />

            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3';
import MyButtonLink from '@/CustomComponents/ButtonLink.vue'
import JetNavLink from '@/Jetstream/NavLink.vue'
import Pagination from "@/CustomComponents/Pagination";
import MyListBox from "@/CustomComponents/ListBox";
import JetInput from "@/Jetstream/Input";
import JetLabel from "@/Jetstream/Label";
import {Inertia} from "@inertiajs/inertia";


export default {
    props: {
        users: Object,
        filters: Object,
        roles: Array,
    },

    components: {
        AppLayout,
        MyButtonLink,
        JetNavLink,
        Link,
        Pagination,
        JetLabel,
        JetInput,
        MyListBox,
    },

    data() {
        return {
            confirmingDeletion: false,
            form: this.$inertia.form({
                id: null,
                name: '',
            }),
            search: this.filters.search,
            role: this.filters.role,
        }
    },

    methods: {
        filter() {
            Inertia.get(
                route('users.index'), {role: this.role, search: this.search},
                {
                    preserveState: true,
                    replace: true,
                },
            )
        },
    },

    watch: {
        search: function() { this.filter() },
        role: function() { this.filter() },
    },
}
</script>
