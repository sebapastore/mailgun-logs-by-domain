<template>
    <a :href="href" class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring focus:ring-green-300 disabled:opacity-25 transition">
        <slot />
    </a>
</template>

<script>

    export default {
        props: {
            type: {
                href: String,
            },
        },
    }
</script>
