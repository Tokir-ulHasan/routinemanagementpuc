<template>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <li class="nav-item ">
            <li class="nav-item" v-if="user_type != 1">
                <router-link class="nav-link" to="/" >         
                    <i class="fas fa-th menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </router-link>
            </li>
            <li class="nav-item" v-if="user_type == 1">
                 <router-link class="nav-link" to="/teacher/create">                    
                    <i class="fas fa-user menu-icon"></i>
                    <span class="menu-title">Add Teacher</span>
                </router-link>
            </li>
            <li class="nav-item">
                 <router-link class="nav-link" to="/list/teachers">                    
                     <i class="fas fa-users menu-icon"></i>
                    <span class="menu-title">Teacher's List</span>
                </router-link>
            </li>
            <li class="nav-item" v-if="user_type == 1">
                 <router-link class="nav-link" to="/course/create">                    
                     <i class="fas fa-book-open menu-icon"></i>
                    <span class="menu-title">Add Course</span>
                </router-link>
            </li>
            <li class="nav-item">
                 <router-link class="nav-link" to="/list/courses">                    
                    <i class="fas fa-swatchbook menu-icon"></i>
                    <span class="menu-title">Courses List</span>
                </router-link>
            </li>
            <li class="nav-item" v-if="user_type == 1">
                <router-link class="nav-link" to="/room">
                    <i class="fas fa-person-booth menu-icon"></i>
                    <span class="menu-title">Room</span>
                </router-link>
            </li>
            <li class="nav-item">
            <li class="nav-item" v-if="user_type != 1">
                <router-link class="nav-link" to="/section" >
                    <i class="fas fa-layer-group menu-icon"></i>
                    <span class="menu-title">Sections</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/session"  v-if="user_type == 1"> 
                    <i class="fas fa-calendar-alt menu-icon"></i>
                    <span class="menu-title">Session</span>
                </router-link>
            </li>
            <li class="nav-item" v-if="user_type == 1">
                <router-link class="nav-link" to="/day"> 
                    <i class="fas fa-calendar-week menu-icon"></i>
                    <span class="menu-title">Day</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/time"  v-if="user_type != 1"> 
                    <i class="fas fa-calendar-day menu-icon"></i>
                    <span class="menu-title">Time</span>
                </router-link>
            </li>
        </ul>
    </nav>
</template>
<style scoped>

</style>

<script>

    export default {

        data(){
             return {
                user : null,
                user_type:null
             }
        },
     
            mounted() {
                axios.get('/api/user').then((res)=>{
                this.user = res.data;
                this.user_type = this.user.type;
                }).catch(()=>{
                    this.user = null;
            });
        }
    }
</script>
