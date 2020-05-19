<template>
    <section>
        <nav class="rounded-top d-flex col-12">
            <div class="col-4 text-center"><router-link></router-link></div>
            <div class="col-4 text-center"><router-link></router-link></div>
            <div class="col-4 text-center"><router-link></router-link></div>
        </nav>
        <div class="content">
            <h1>Helloca</h1>
        </div>
    </section>
</template>

<script>
    export default {
        name: "Dashboard"
    }
</script>

<style scoped>
    nav {
        border: 3px solid gray;
    }
</style>
