<template>
    <div class="profile">
        <ProgressBar />
        <Kalio />
    </div>
</template>

<script>
definePageMeta({
  middleware: 'auth',
})

export default {
    name: "Profile",
    data() {
        return {
            // Add your component data here
        };
    },
    methods: {
        // Add your component methods here
    },
};
</script>

<style scoped>
.profile {
    /* Add your styles here */
}
</style>