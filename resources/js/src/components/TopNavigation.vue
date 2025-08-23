<template>
  <div class="top-navigation">
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
      <div class="container-fluid">
        <div class="navbar-nav">
          <router-link 
            to="/inicio" 
            class="nav-item nav-link"
            :class="{ active: $route.path === '/inicio' }"
          >
            <feather-icon icon="HomeIcon" size="16" class="mr-1" />
            Dashboard
          </router-link>
          
          <router-link 
            to="/clientes" 
            class="nav-item nav-link"
            :class="{ active: $route.path.startsWith('/clientes') }"
          >
            <feather-icon icon="UsersIcon" size="16" class="mr-1" />
            Clientes
          </router-link>
          
          <router-link 
            to="/ordenes" 
            class="nav-item nav-link"
            :class="{ active: $route.path.startsWith('/ordenes') }"
          >
            <feather-icon icon="FileTextIcon" size="16" class="mr-1" />
            Órdenes
          </router-link>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  name: 'TopNavigation'
}
</script>

<style scoped>
.top-navigation {
  width: 100%;
  z-index: 1000;
}

.navbar {
  padding: 0.5rem 1rem;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.nav-link {
  color: #6c757d !important;
  font-weight: 500;
  padding: 0.5rem 1rem !important;
  display: flex;
  align-items: center;
  text-decoration: none;
  border-radius: 4px;
  margin: 0 0.25rem;
  transition: all 0.2s ease;
}

.nav-link:hover {
  background-color: #f8f9fa;
  color: #495057 !important;
}

.nav-link.active {
  background-color: #007bff;
  color: white !important;
}

.dropdown {
  position: relative;
}

.dropdown-menu {
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1000;
  display: none;
  float: left;
  min-width: 10rem;
  padding: 0.5rem 0;
  margin: 0.125rem 0 0;
  font-size: 0.875rem;
  color: #212529;
  text-align: left;
  list-style: none;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid rgba(0,0,0,.15);
  border-radius: 0.25rem;
  box-shadow: 0 0.5rem 1rem rgba(0,0,0,.175);
}

.dropdown-menu.show {
  display: block;
}

.dropdown-item {
  display: flex;
  align-items: center;
  width: 100%;
  padding: 0.5rem 1rem;
  clear: both;
  font-weight: 400;
  color: #212529;
  text-decoration: none;
  white-space: nowrap;
  background-color: transparent;
  border: 0;
}

.dropdown-item:hover {
  background-color: #f8f9fa;
  text-decoration: none;
  color: #495057;
}

.mr-1 {
  margin-right: 0.25rem;
}

.mr-2 {
  margin-right: 0.5rem;
}

.router-link-active {
  background-color: #007bff !important;
  color: white !important;
}
</style>
