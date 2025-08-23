<template>
    <div class="navbar-container d-flex content align-items-center">

      <!-- Nav Menu Toggler -->
      <ul class="nav navbar-nav d-xl-none">
        <li class="nav-item">
          <b-link
            class="nav-link"
            @click="toggleVerticalMenuActive"
          >
            <feather-icon
              icon="MenuIcon"
              size="21"
            />
          </b-link>
        </li>
      </ul>

      <!-- Left Col -->
      <div class="bookmark-wrapper align-items-center flex-grow-1 d-none d-lg-flex">
        <dark-Toggler class="d-none d-lg-block" />

      </div>

      <b-navbar-nav class="nav align-items-center ml-auto">
        <b-nav-item-dropdown
        toggle-class="d-flex align-items-center dropdown-help-link"
        class="dropdown-help mr-2"
      >
      </b-nav-item-dropdown>
        <b-nav-item-dropdown
          right
          toggle-class="d-flex align-items-center dropdown-user-link"
          class="dropdown-user"
        >
          <template #button-content>
            <div class="d-sm-flex d-none user-nav">
              <p class="user-name font-weight-bolder mb-0">
                {{ usuario }}
              </p>
              <span class="user-status"> {{ perfil }} </span>
            </div>
            <b-avatar size="40" variant="light-primary" badge :src="src" class="badge-minimal" badge-variant="success"/>
          </template>

          <!-- <b-dropdown-divider /> -->

          <b-dropdown-item link-class="d-flex align-items-center" @click="showImage = true">
            <feather-icon size="16" icon="ImageIcon" class="mr-50"/>
            <span>Foto de Perfil</span>
          </b-dropdown-item>

          <b-dropdown-item link-class="d-flex align-items-center" @click="logout()">
            <feather-icon size="16" icon="LogOutIcon" class="mr-50"/>
            <span>Logout</span>
          </b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    </div>
  </template>

  <script>
  import {
    BLink, BNavbarNav, BNavItemDropdown, BDropdownItem, BDropdownDivider, BAvatar,
  } from 'bootstrap-vue'
  import DarkToggler from '@core/layouts/components/app-navbar/components/DarkToggler.vue'

  export default {
    data() {
      return {
        // variables para el perfil
        overlayImage: false,
        showImage: false,
        imageEnviar: '',
        image: '',
        src: ''
      }
    },
    components: {
      BLink,
      BNavbarNav,
      BNavItemDropdown,
      BDropdownItem,
      BDropdownDivider,
      BAvatar,

      // Navbar Components
      DarkToggler,
    },
    props: {
      toggleVerticalMenuActive: {
        type: Function,
        default: () => {},
      },
    },

    mounted() {
      this.loadPerfil()
    },

    computed: {
      perfil(){
        return localStorage.getItem('perfil')
      },
      usuario(){
        return localStorage.getItem('user')
      },
      imagen(){
        return this.image
      }
    },

    methods: {
      openManual() {
        const manualURL = "https://view.genially.com/675cb8c6e22b7536ffb0dd05/"; // URL del manual
        window.open(manualURL, "_blank"); // Abre el enlace en una nueva pestaña
      },
      openPreguntasFrecuentes() {
        const manualURL = "https://view.genially.com/6761798d73bc9bca1520290b/"; // URL del preguntas
        window.open(manualURL, "_blank"); // Abre el enlace en una nueva pestaña
      },
      loadPerfil(){
        let src = location.protocol+"//"+location.host+"/FotoPerfil"+"/"+localStorage.getItem('id')+".jpg"
        console.log(src)
        this.src = src ? src : "require('@/assets/intecruz/user.png')"
      },
      obtenerImagen(e) {
        let file = e.target.files[0]
        this.imageEnviar = file

        this.cargarImagen(file)
      },
      cargarImagen(file){
        let reader = new FileReader()
        reader.onload = (e) => {
          this.image = e.target.result
        }
        reader.readAsDataURL(file)
      },
      imagenStore(){
        this.overlayImage = true
        let formData = new FormData();
        formData.append('imageEnviar[]', this.imageEnviar)
        formData.append('persona', 0)
        formData.append('tipo', 1)

        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
        this.axios.post('/photoStore', formData)
        .then(res => {

            this.popup('Éxito', 'Imagen guardada correctamente', 'success')
            window.location.reload()
        })
        .catch(err => {
            console.log(err.response)
            this.overlayImage = false
            this.popup('Error', 'Ocurrio un error al guardar imagen', 'error')
        })
      },
      cerrar(){
        this.showImage = false
        this.imageEnviar = ''
        this.image = ''
      },
      logout(){
          axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
          this.axios.get('/logout')
          .then(res => {

              localStorage.removeItem('perfil')
              localStorage.removeItem('inicio')
              localStorage.removeItem('token')
              localStorage.removeItem('user')
              localStorage.removeItem('menu')
              localStorage.removeItem('id')
              this.popup('Éxito', 'Sessión cerrada correctamente', 'success')
              // this.$router.push('/')
              window.location.href = '/'
          })
          .catch(err => {
              console.log(err.response)
              this.popup('Error', 'Ocurrio un error al cerrar sessión', 'error')
          })
      },
      popup(titulo, texto, icono) {
        this.$swal({
                title: titulo, //'Éxito',
                text: texto, //'Guardado correctamente',
                icon: icono, //'success',
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                    confirmButton: 'btn btn-primary',
                },
                buttonsStyling: false,
            })
      }
    }
  }
  </script>
  <style lang="scss">
    @import '~@resources/scss/vue/libs/vue-sweetalert.scss';
</style>
