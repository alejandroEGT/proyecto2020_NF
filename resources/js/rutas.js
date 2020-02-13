import Outer from './components/outer.vue';
import HomeComponent from './components/Home.vue';
import Login from './components/login.vue';
import NotFound from './components/404.vue';
import NotFound_auth from './components/auth/404.vue';
import Registro from './components/registro_empresa.vue';

import Disponibilidad from './components/disponibilidad.vue';
import Solicitarreserva from './components/auth/solicitar_reserva.vue';


import Auth from './components/auth/auth.vue';
import Index from './components/auth/index.vue';
import CrearEntorno from './components/auth/crear_entorno.vue';
import Hotel from './components/auth/hotel.vue';
import Hotel_niveles from './components/auth/hotel/niveles.vue';
import Hotel_reservas from './components/auth/hotel/reservas.vue';
import Hotel_nivel from './components/auth/hotel/nivel.vue';
import Hotel_reservando from './components/auth/hotel/reservando.vue';
import Hotel_historial_reserva from './components/auth/hotel/historial_reservas.vue';

import Hotel_servicios_huesped from './components/auth/hotel/servicios.vue';

import Hotel_solicitud_reserva from './components/auth/hotel/solicitud_reserva_admin.vue';

import Clientes from './components/auth/clientes/clientes.vue';


const routes = [
  {
    path: '/',
    component: Outer,
    name: 'Admin',
    redirect: 'home',
    iconCls: 'el-icon-message',
    meta: { auth: false },

    children: [
      {
        name: 'home',
        path: '/home',
        component: HomeComponent
      },
      {
        name: 'login',
        path: '/login',
        component: Login
      },
      {
        name: 'registro',
        path: '/registro',
        component: Registro
      },

      {
        name: 'disponibilidad',
        path: '/disponibilidad/:fecha_desde/:fecha_hasta/:tipo',
        component: Disponibilidad
      },
      {
        name: 'solicitar_reserva',
        path: '/solicitar_reserva/:id',
        component: Solicitarreserva
      },
      
     
    ]
  },

  {
    path: '/home',
    component: Auth,
    name: 'Administration',
    redirect: 'index',
    iconCls: 'el-icon-message',
    meta: { auth: true },
    children: [

        { path: '/index', component: Index, name: 'Index' },
        { path: '/crear_entorno', component: CrearEntorno, name: 'miEntorno' },
        { 
          path: '/hotel', 
          component: Hotel, 
          name: 'hotel',
          redirect:'/hotel/niveles',
          children: [
            { path: '/hotel/niveles', component: Hotel_niveles, name: 'niveles' },
            { path: '/hotel/niveles/:id', component: Hotel_nivel, name: 'nivel' },
            

            { path: '/hotel/reservas', component: Hotel_reservas, name: 'reservas' },
            { path: '/hotel/reservas/:id', component: Hotel_reservando, name: 'reservando' },
            { path: '/hotel/reservas/historial/:id', component: Hotel_historial_reserva, name: 'historial_reserva' },

            {name: 'clientes',path: '/clientes', component: Clientes},
            {name: 'solicitud_reserva', path: '/solicitud_reserva', component: Hotel_solicitud_reserva },

            { path: '/hotel/servicios/:id', component: Hotel_servicios_huesped, name: 'servicios' },




            {
              path: '/404',
              component: NotFound_auth,
              name: '',
              hidden: true
            },
            
          ] 
        },
      

    ]
  },

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