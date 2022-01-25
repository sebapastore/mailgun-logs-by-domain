<template>
    <div class="relative">
        <!-- header -->
        <slot name="header" />

        <span class="inline-block mt-1 w-full rounded-md shadow-sm">
      <button
          type="button"
          aria-haspopup="listbox"
          aria-expanded="true"
          aria-labelledby="listbox-label"
          class="cursor-default relative w-full rounded-md border border-gray-300 bg-white pl-3 pr-10 py-2 text-left focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition ease-in-out duration-150 sm:text-sm sm:leading-5"
          @click="open = !open"
      >
        <span v-if="selectedOption" class="block truncate">
          {{ selectedOption.name }}
        </span>
        <span v-else class="block truncate text-gray-400">
          {{ placeholder }}
        </span>
        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
          <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
            <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </span>
      </button>
    </span>

        <!-- footer -->
        <slot name="footer" />

        <!-- dropdown -->
        <transition
            enter-active-class="transition ease-out duration-200"
            enter-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-300"
            leave-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <div v-show="open" class="absolute mt-1 w-full rounded-md bg-white shadow-lg" style="z-index: 9999;">
                <ul tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-item-3" class="max-h-60 rounded-md py-1 text-base leading-6 shadow-xs overflow-auto focus:outline-none sm:text-sm sm:leading-5">
                    <li
                        v-for="(option, i) in options"
                        :key="i"
                        id="listbox-item-0"
                        role="option"
                        class="text-gray-900 cursor-default select-none relative py-2 pl-8 pr-4 hover:bg-gray-800 hover:text-white"
                        @click="select(option)"
                    >

            <span
                class="font-normal block truncate"
                :class="selectedOption && selectedOption.id === option.id ? 'font-semibold' : 'font-normal'"
            >
              {{ option.name }}
            </span>
                        <span
                            v-show="selectedOption && selectedOption.id === option.id"
                            class="absolute inset-y-0 left-0 flex items-center pl-1.5"
                        >
              <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
              </svg>
            </span>
                    </li>
                </ul>
            </div>
        </transition>

        <!-- fullscreen overlay -->
        <div v-show="open" class="fixed inset-0 z-40" @click="open = false"></div>
    </div>
</template>

<script>
import Input from "@/Jetstream/Input";
export default {
    components: {Input},
    props: {
        options: {
            type: Array,
            default() {
                return []
            },
        },
        placeholder: {
            type: String,
            default: 'Seleccionar'
        },
    },
    data() {
        return {
            open: false,
            selectedOption: null,
        }
    },
    created() {
        const closeOnEscape = (e) => {
            if (this.open && e.keyCode === 27) {
                this.open = false
            }
        }
        // this.$once('hook:destroyed', () => {
        //     document.removeEventListener('keydown', closeOnEscape)
        // })
        document.addEventListener('keydown', closeOnEscape)
    },
    mounted() {
        var option = this.options.find(option => option.id === this.$attrs.modelValue)

        if (option)
            this.select(option)
    },
    methods: {
        select($option) {
            this.selectedOption = $option
            this.open = false;
        },
    },
    watch: {
        selectedOption: function () {
            this.$emit('input', this.selectedOption.id)
        }
    }
}
</script>
