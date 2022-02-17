<template>
    <jet-form-section @submitted="updateProfileInformation">
        <template #title>
            Información del usuario
        </template>

        <template #description>
            Actualizar nombre y email.
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

            <!-- customer_id -->
            <div class="col-span-6 sm:col-span-4" v-if="form.role === 'Cliente'">
                <my-list-box2
                    id="customer_id"
                    v-model="form.customer_id"
                    @input="val => form.customer_id = val"
                    :options="main_customers"
                    @selected=""
                >
                    <template #header>
                        <jet-label for="type" value="Cliente" />
                    </template>
                    <template #footer>
                        <jet-input-error :message="form.errors.customer_id" class="mt-2" />
                    </template>
                </my-list-box2>
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
</template>

<script>
    import JetButton from '@/Jetstream/Button.vue'
    import JetFormSection from '@/Jetstream/FormSection.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetActionMessage from '@/Jetstream/ActionMessage.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import MyListBox from '@/CustomComponents/ListBox.vue'
    import MyListBox2 from '@/CustomComponents/ListBox2.vue'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
            MyListBox,
            MyListBox2,
        },

        props: {
            user_edit: Object,
            roles: Array,
            main_customers: Array,
        },

        data() {
            return {
                form: this.$inertia.form({
                    _method: 'PUT',
                    name: this.user_edit.name,
                    email: this.user_edit.email,
                    role: this.user_edit.role,
                    customer_id: this.user_edit.customer_id,
                }),
            }
        },

        methods: {
            updateProfileInformation() {
                this.form.put(route('users.update', {user: this.user_edit.id}), {
                    errorBag: 'updateProfileInformation',
                    preserveScroll: true
                });
            },
        },
    }
</script>
