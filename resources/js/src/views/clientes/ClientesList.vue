<template>
  <div class="clientes-list">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Gestión de Clientes</h4>
        <button class="btn btn-primary" @click="nuevoCliente">
          + Nuevo Cliente
        </button>
      </div>
      <div class="card-body">
        <!-- Filtros -->
        <div class="row mb-3">
          <div class="col-md-6">
            <input v-model="search" type="text" class="form-control" 
                   placeholder="Buscar por nombre, apellido o email..." @input="buscar">
          </div>
          <div class="col-md-3">
            <select v-model="perPage" class="form-control" @change="cargarClientes">
              <option value="10">10 por página</option>
              <option value="25">25 por página</option>
              <option value="50">50 por página</option>
            </select>
          </div>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="cliente in clientes.data" :key="cliente.id">
                <td>{{ cliente.id }}</td>
                <td>{{ cliente.nombre }}</td>
                <td>{{ cliente.apellido }}</td>
                <td>{{ cliente.email }}</td>
                <td>{{ cliente.telefono || 'N/A' }}</td>
                <td>{{ cliente.direccion }}</td>
                <td>
                  <button class="btn btn-info btn-sm" @click="verCliente(cliente)">
                    Ver
                  </button>
                  <button class="btn btn-warning btn-sm ml-1" @click="editarCliente(cliente.id)">
                    Editar
                  </button>
                  <button class="btn btn-danger btn-sm ml-1" @click="eliminarCliente(cliente.id)">
                    Eliminar
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Paginación -->
        <div v-if="clientes.total > 0" class="d-flex justify-content-between align-items-center">
          <div>
            Mostrando {{ clientes.from }} a {{ clientes.to }} de {{ clientes.total }} resultados
          </div>
          <nav>
            <ul class="pagination">
              <li class="page-item" :class="{ disabled: clientes.current_page === 1 }">
                <a class="page-link" @click="cambiarPagina(clientes.current_page - 1)">Anterior</a>
              </li>
              <li v-for="page in pages" :key="page" class="page-item" 
                  :class="{ active: page === clientes.current_page }">
                <a class="page-link" @click="cambiarPagina(page)">{{ page }}</a>
              </li>
              <li class="page-item" :class="{ disabled: clientes.current_page === clientes.last_page }">
                <a class="page-link" @click="cambiarPagina(clientes.current_page + 1)">Siguiente</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>

    <!-- Modal de detalles -->
    <div v-if="clienteSeleccionado" class="modal fade show" style="display: block;" 
         @click="cerrarModal">
      <div class="modal-dialog" @click.stop>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Detalles del Cliente</h5>
            <button type="button" class="close" @click="cerrarModal">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <strong>Nombre:</strong> {{ clienteSeleccionado.nombre }}
              </div>
              <div class="col-md-6">
                <strong>Apellido:</strong> {{ clienteSeleccionado.apellido }}
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-12">
                <strong>Email:</strong> {{ clienteSeleccionado.email }}
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-6">
                <strong>Teléfono:</strong> {{ clienteSeleccionado.telefono || 'No especificado' }}
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-12">
                <strong>Dirección:</strong> {{ clienteSeleccionado.direccion }}
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-6">
                <strong>Creado:</strong> {{ formatearFecha(clienteSeleccionado.created_at) }}
              </div>
              <div class="col-md-6">
                <strong>Actualizado:</strong> {{ formatearFecha(clienteSeleccionado.updated_at) }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from '@/libs/axios'

export default {
  name: 'ClientesList',
  data() {
    return {
      clientes: {
        data: [],
        current_page: 1,
        last_page: 1,
        total: 0,
        from: 0,
        to: 0
      },
      search: '',
      perPage: 10,
      clienteSeleccionado: null
    }
  },
  computed: {
    pages() {
      const pages = []
      const start = Math.max(1, this.clientes.current_page - 2)
      const end = Math.min(this.clientes.last_page, this.clientes.current_page + 2)
      
      for (let i = start; i <= end; i++) {
        pages.push(i)
      }
      
      return pages
    }
  },
  async mounted() {
    await this.cargarClientes()
  },
  methods: {
    async cargarClientes() {
      try {
        const params = {
          per_page: this.perPage,
          page: this.clientes.current_page
        }
        
        if (this.search) {
          params.search = this.search
        }
        
        const response = await axios.get('/api/clientes', { params })
        this.clientes = response.data
      } catch (error) {
        console.error('Error cargando clientes:', error)
      }
    },
    
    buscar() {
      this.clientes.current_page = 1
      this.cargarClientes()
    },
    
    cambiarPagina(page) {
      if (page >= 1 && page <= this.clientes.last_page) {
        this.clientes.current_page = page
        this.cargarClientes()
      }
    },
    
    nuevoCliente() {
      this.$router.push('/clientes/crear')
    },
    
    verCliente(cliente) {
      this.clienteSeleccionado = cliente
    },
    
    editarCliente(id) {
      this.$router.push(`/clientes/editar/${id}`)
    },
    
    async eliminarCliente(id) {
      if (confirm('¿Está seguro de eliminar este cliente?')) {
        try {
          await axios.delete(`/api/clientes/${id}`)
          alert('Cliente eliminado exitosamente')
          this.cargarClientes()
        } catch (error) {
          console.error('Error eliminando cliente:', error)
          alert('Error al eliminar el cliente')
        }
      }
    },
    
    cerrarModal() {
      this.clienteSeleccionado = null
    },
    
    formatearFecha(fecha) {
      return new Date(fecha).toLocaleDateString('es-ES')
    }
  }
}
</script>

<style scoped>
.clientes-list {
  padding: 20px;
}

.card {
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.modal {
  background-color: rgba(0,0,0,0.5);
}

.d-flex {
  display: flex;
}

.justify-content-between {
  justify-content: space-between;
}

.align-items-center {
  align-items: center;
}

.ml-1 {
  margin-left: 0.25rem;
}

.mb-3 {
  margin-bottom: 1rem;
}

.mt-2 {
  margin-top: 0.5rem;
}

.pagination .page-link {
  cursor: pointer;
}
</style>
