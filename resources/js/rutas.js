import Outer from './components/outer.vue';
import HomeComponent from './components/Home.vue';
import NotFound from './components/404.vue';

const routes = [
  {
    path: '/kkck',
    component: Outer,
    name: 'Admin',
    redirect: 'home',
    iconCls: 'el-icon-message',
    meta: { auth: false },

    children: [
      {
        name: 'home',
        path: '/',
        component: HomeComponent
      },
     
    ]
  },

  // {
  //   path: '/home',
  //   component: Auth,
  //   name: 'Administration',
  //   redirect: 'index',
  //   iconCls: 'el-icon-message',
  //   meta: { auth: true },
  //   children: [

  //       { path: '/index', component: Index, name: 'Index' },
  //       { path: '/mi-perfil', component: MiPerfil, name: 'miPerfil' },

  //   ]
  // },

  {
    path: '/404',
    component: NotFound,
    name: '',
    hidden: true
  },
  {
      path: '*',
      hidden: true,
      redirect: { path: '/' }
  } 

];

export default routes;