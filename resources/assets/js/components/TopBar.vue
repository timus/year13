<template>
    <div class="top-bar">
        This assignment is completed by: {{ name }}
    </div>
</template>

<script>
    export default {
        name: 'top-bar',
        props: {
            name: {
                default: '{ Sumit Banskota }'
            }
        }
    }
</script>

<style lang="scss" scoped>
    .top-bar {
        background-color: var(--brand-color);
        text-align: center;
        color: #fff;
        font-size: 0.8rem;
        padding: 3px 1rem;
    }
</style>