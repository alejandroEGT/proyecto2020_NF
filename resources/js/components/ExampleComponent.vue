<template >

    <div >
                   
        <transition name>
           <div> <router-view></router-view></div>
        </transition>
           
    </div>
</template>

<style >
    
</style>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
