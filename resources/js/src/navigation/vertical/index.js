export default [
  {
    title: 'Dashboard',
    route: 'Inicio',
    icon: 'HomeIcon',
  },
  {
    title: 'Clientes',
    icon: 'UsersIcon',
    children: [
      {
        title: 'Lista de Clientes',
        route: 'ClientesList',
      },
      {
        title: 'Nuevo Cliente',
        route: 'ClienteCreate',
      },
    ],
  },
  {
    title: 'Órdenes',
    icon: 'FileTextIcon',
    children: [
      {
        title: 'Lista de Órdenes',
        route: 'OrdenesList',
      },
      {
        title: 'Nueva Orden',
        route: 'OrdenCreate',
      },
    ],
  },
  // {
  //   title: 'Inicio',
  //   route: 'Inicio',
  //   icon: 'HomeIcon',
  // },
  // {
  //   title: 'Publicaciones',
  //   route: 'Publicaciones',
  //   icon: 'ClipboardIcon',
  // },
  // {
  //   title: 'Postulaciones',
  //   route: 'Postulacion',
  //   icon: 'ClipboardIcon',
  // },  
  // {
  //   title: 'Encuesta',
  //   route: 'Encuesta',
  //   icon: 'ClipboardIcon',
  // },
  // {
  //   title: 'Logout',
  //   route: 'Portal',
  //   icon: 'ClipboardIcon',
  // },
  // {
  //   title: 'Portal',
  //   route: 'Portal',
  //   icon: 'TrelloIcon',
  // },
]
