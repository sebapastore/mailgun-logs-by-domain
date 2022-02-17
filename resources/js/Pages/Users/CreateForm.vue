<template>
    <app-layout title="Crear Usuario">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear Usuario
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <jet-form-section @submitted="submit">
                    <template #title>
                        Datos del usuario
                    </template>

                    <template #description>
                        La contraseña debe tener al menos 8 caracteres.
                    </template>

                    <template #form>
                        <!-- Name -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="name" value="Nombre" />
                            <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name"  />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="email" value="Email" />
                            <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                            <jet-input-error :message="form.errors.email" class="mt-2" />
                        </div>

                        <!-- role -->
                        <div class="col-span-6 sm:col-span-4">
                            <my-list-box
                                id="role"
                                v-model="form.role"
                                @input="val => form.role = val"
                                :options="roles"
                                @selected=""
                            >
                                <template #header>
                                    <jet-label for="type" value="Rol" />
                                </template>
                                <template #footer>
                                    <jet-input-error :message="form.errors.role" class="mt-2" />
                                </template>
                            </my-list-box>
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="password" value="Contraseña" />
                            <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" ref="password" autocomplete="new-password" />
                            <jet-input-error :message="form.errors.password" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="password_confirmation" value="Confirmar Contraseña" />
                            <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" autocomplete="new-password" />
                            <jet-input-error :message="form.errors.password_confirmation" class="mt-2" />
                        </div>

                    </template>

                    <template #actions>
                        <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                            Guardado.
                        </jet-action-message>

                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Guardar
                        </jet-button>
                    </template>
                </jet-form-section>

            </div>
        </div>
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
    import MyListBox from '@/CustomComponents/ListBox.vue'

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
        },

        props: {
            roles: Array,
        },

        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    email: '',
                    role: '',
                    password: '',
                    password_confirmation: '',
                    terms: false,
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('users.store'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>
