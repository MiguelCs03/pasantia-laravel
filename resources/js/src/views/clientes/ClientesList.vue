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

        <!-- Botones de acciones múltiples -->
        <div v-if="clientesSeleccionados.length > 0" class="mb-3 p-3 bg-light border rounded">
          <div class="d-flex justify-content-between align-items-center">
            <span>
              <strong>{{ clientesSeleccionados.length }}</strong> cliente(s) seleccionado(s)
            </span>
            <div>
              <button class="btn btn-warning btn-sm mr-2" @click="cambiarEstadoMasivo('inactivo')" 
                      v-if="clientesSeleccionados.some(id => obtenerCliente(id).estado === 'activo')">
                <i class="fas fa-user-slash mr-1"></i>
                Desactivar Seleccionados
              </button>
              <button class="btn btn-success btn-sm mr-2" @click="cambiarEstadoMasivo('activo')" 
                      v-if="clientesSeleccionados.some(id => obtenerCliente(id).estado === 'inactivo')">
                <i class="fas fa-user-check mr-1"></i>
                Activar Seleccionados
              </button>
              <button class="btn btn-secondary btn-sm" @click="limpiarSeleccion">
                <i class="fas fa-times mr-1"></i>
                Limpiar Selección
              </button>
            </div>
          </div>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th width="40">
                  <input type="checkbox" v-model="seleccionarTodos" @change="toggleSeleccionTodos">
                </th>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="cliente in clientes.data" :key="cliente.id" :class="{'table-secondary': cliente.estado === 'inactivo'}">
                <td>
                  <input type="checkbox" :value="cliente.id" v-model="clientesSeleccionados">
                </td>
                <td>{{ cliente.id }}</td>
                <td>{{ cliente.nombre }}</td>
                <td>{{ cliente.apellido }}</td>
                <td>{{ cliente.email }}</td>
                <td>{{ cliente.telefono || 'N/A' }}</td>
                <td>{{ cliente.direccion }}</td>
                <td>
                  <span :class="getEstadoClass(cliente.estado)">
                    {{ cliente.estado.toUpperCase() }}
                  </span>
                </td>
                <td>
                  <div class="btn-group-actions">
                    <button class="btn btn-info btn-sm" @click="verCliente(cliente)" title="Ver detalles">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-warning btn-sm" @click="editarCliente(cliente.id)" title="Editar cliente">
                      <i class="fas fa-edit"></i>
                    </button>
                    <button v-if="cliente.estado === 'activo'" class="btn btn-danger btn-sm" 
                            @click="cambiarEstado(cliente.id, 'inactivo')" title="Desactivar cliente">
                      <i class="fas fa-user-slash"></i>
                    </button>
                    <button v-else class="btn btn-success btn-sm" 
                            @click="cambiarEstado(cliente.id, 'activo')" title="Activar cliente">
                      <i class="fas fa-user-check"></i>
                    </button>
                  </div>
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
      clienteSeleccionado: null,
      clientesSeleccionados: [],
      seleccionarTodos: false
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
    
    async cambiarEstado(id, nuevoEstado) {
      const accion = nuevoEstado === 'activo' ? 'activar' : 'desactivar'
      if (confirm(`¿Está seguro de ${accion} este cliente?`)) {
        try {
          await axios.patch(`/api/clientes/${id}/estado`, { estado: nuevoEstado })
          alert(`Cliente ${accion === 'activar' ? 'activado' : 'desactivado'} exitosamente`)
          this.cargarClientes()
        } catch (error) {
          console.error(`Error ${accion === 'activar' ? 'activando' : 'desactivando'} cliente:`, error)
          alert(`Error al ${accion} el cliente`)
        }
      }
    },

    async cambiarEstadoMasivo(nuevoEstado) {
      const accion = nuevoEstado === 'activo' ? 'activar' : 'desactivar'
      const cantidad = this.clientesSeleccionados.length
      
      if (confirm(`¿Está seguro de ${accion} ${cantidad} cliente(s)?`)) {
        try {
          await axios.patch('/api/clientes/estado-masivo', { 
            ids: this.clientesSeleccionados, 
            estado: nuevoEstado 
          })
          alert(`${cantidad} cliente(s) ${accion === 'activar' ? 'activados' : 'desactivados'} exitosamente`)
          this.limpiarSeleccion()
          this.cargarClientes()
        } catch (error) {
          console.error(`Error en ${accion} masivo:`, error)
          alert(`Error al ${accion} los clientes`)
        }
      }
    },

    toggleSeleccionTodos() {
      if (this.seleccionarTodos) {
        this.clientesSeleccionados = this.clientes.data.map(cliente => cliente.id)
      } else {
        this.clientesSeleccionados = []
      }
    },

    limpiarSeleccion() {
      this.clientesSeleccionados = []
      this.seleccionarTodos = false
    },

    obtenerCliente(id) {
      return this.clientes.data.find(cliente => cliente.id === id) || {}
    },

    getEstadoClass(estado) {
      return estado === 'activo' ? 'badge badge-success' : 'badge badge-secondary'
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

.btn-group-actions {
  display: flex;
  gap: 4px;
  align-items: center;
  justify-content: center;
}

.btn-group-actions .btn {
  margin: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 32px;
  height: 32px;
}

.table-secondary {
  background-color: #f8f9fa !important;
  opacity: 0.7;
}

.badge {
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem;
  border-radius: 0.25rem;
  font-weight: 600;
}

.badge-success {
  background-color: #28a745;
  color: white;
}

.badge-secondary {
  background-color: #6c757d;
  color: white;
}

.bg-light {
  background-color: #f8f9fa !important;
}

.border {
  border: 1px solid #dee2e6 !important;
}

.rounded {
  border-radius: 0.375rem !important;
}

.mr-1 {
  margin-right: 0.25rem;
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
