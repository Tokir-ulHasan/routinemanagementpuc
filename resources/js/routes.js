import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Default from './components/Default.vue'
import CreateRoutine from './components/routine/CreateRoutine.vue'
import SessionLogin from './components/SessionLogin.vue'
import Department from './components/other/Department.vue'
import CreateTeacher from './components/teacher/CreateTeacher.vue'
import Room from './components/other/Room.vue'
import Session from './components/other/User.vue'
import CreateCourse from './components/course/CreateCourse.vue'
import Section from './components/semister/CreateSection.vue'
import Time from './components/other/Time.vue'
import Day from './components/other/Day.vue'
import ListTeachers from "./components/teacher/ListTeacters.vue"
import ListCourses from "./components/course/ListCourses.vue"
import Assigned from "./components/teacher/assignedCourse.vue"

export default new VueRouter({
    routes:[
        {
          path: '/login',
          component: SessionLogin,
          name:'SessionLogin',
        },
        {
            path:'',
            component:Default,
            name:'Default',
            redirect: { name: 'CreateRoutine' },
            children: [
                {
                  path: '',
                  component: CreateRoutine,
                  name:'CreateRoutine',
                  beforeEnter: (to, from, next) => {
                    let user;
                    axios.get('/api/user').then((res)=>{
                      user = res.data;
                      if(user.type != 1){
                        next();
                      }
                      else{
                        next('/session');
                      }
                    }).catch(()=>{
                        next('/login')
                    });
                  },
                },
                {
                  path: '/department',
                  component: Department,
                }, 

                {
                  path: '/list/teachers',
                  component: ListTeachers,
                }, 

                {
                  path: '/room',
                  component: Room,
                  beforeEnter: (to, from, next) => {
                    let user;
                    axios.get('/api/user').then((res)=>{
                      user = res.data;
                      if(user.type == 1){
                        next();
                      }
                      else{
                        next('/');
                      }
                    }).catch(()=>{
                        next('/login')
                    });
                  },
                }, 
                {
                  path: '/teacher/create',
                  component: CreateTeacher,
                  beforeEnter: (to, from, next) => {
                    let user;
                    axios.get('/api/user').then((res)=>{
                      user = res.data;
                      if(user.type == 1){
                        next();
                      }
                      else{
                        next('/');
                      }
                    }).catch(()=>{
                        next('/login')
                    });
                  },
                }, 
                {
                  path: '/list/courses',
                  component: ListCourses,
                },
                {
                  path: '/course/create',
                  component: CreateCourse,
                  beforeEnter: (to, from, next) => {
                    let user;
                    axios.get('/api/user').then((res)=>{
                      user = res.data;
                      if(user.type == 1){
                        next();
                      }
                      else{
                        next('/');
                      }
                    }).catch(()=>{
                        next('/login')
                    });
                  },
                }, 
                {
                  path: '/session',
                  component: Session,
                  beforeEnter: (to, from, next) => {
                    let user;
                    axios.get('/api/user').then((res)=>{
                      user = res.data;
                      if(user.type == 1){
                        next();
                      }
                      else{
                        next('/');
                      }
                    }).catch(()=>{
                        next('/login')
                    });
                  },
                }, 
                {
                  path: '/section',
                  component: Section,
                }, 
                {
                  path: '/time',
                  component: Time,
                }, 
                {
                  path: '/day',
                  component: Day,
                  beforeEnter: (to, from, next) => {
                      let user;
                      axios.get('/api/user').then((res)=>{
                        user = res.data;
                        if(user.type == 1){
                          next();
                        }
                        else{
                          next('/');
                        }
                      }).catch(()=>{
                          next('/login')
                      });
                  },
                },
                {
                  path: '/assigne/course/:teacher_id',
                  component: Assigned,
                }, 
 
              ],
              

            
        },
        
             
     
    
    ],
    mode:'history',
    
    
});
