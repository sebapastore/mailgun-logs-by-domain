<template>
    <div class="mt-4">
        <div class="flex justify-center items-center">
            <nav class="relative z-0 inline-flex rounded-md shadow-sm" aria-label="Pagination">
                <template v-for="link in links">
                    <a
                        v-if="link.label.includes('Previous')"
                        :href="link.url"
                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                    >
                        <span class="sr-only">Anterior</span>
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>

                    <a
                        v-else-if="link.label.includes('Next')"
                        :href="link.url"
                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                    >
                        <span class="sr-only">Siguiente</span>
                        <!-- Heroicon name: solid/chevron-right -->
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>

                    <a v-else
                       :href="link.url"
                       class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                       :class="link.active ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : ''"
                    >
                        {{ link.label }}
                    </a>

                </template>

            </nav>
        </div>

    </div>

<!--Ejemplo de Laracast    -->
<!--    <div>-->
<!--        <Component-->
<!--            v-for="link in links"-->
<!--            :is="link.url ? 'a' : 'span'"-->
<!--            :href="link.url"-->
<!--            v-html="link.label"-->
<!--            class="px-1"-->
<!--            :class="link.url ? '' : 'text-gray-500'"-->
<!--        />-->
<!--    </div>-->

</template>

<script>
export default {
    props: {
        links: Array,
    }
}
</script>
