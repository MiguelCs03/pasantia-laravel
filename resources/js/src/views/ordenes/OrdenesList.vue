<template>
  <div class="ordenes-list">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Gestión de Órdenes</h4>
        <button class="btn btn-primary" @click="nuevaOrden">
          + Nueva Orden
        </button>
      </div>
      <div class="card-body">
        <!-- Filtros -->
        <div class="row mb-3">
          <div class="col-md-6">
            <input v-model="search" type="text" class="form-control" 
                   placeholder="Buscar por cliente o estado..." @input="buscar">
          </div>
          <div class="col-md-3">
            <select v-model="perPage" class="form-control" @change="cargarOrdenes">
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
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Items</th>
                <th>Total</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="orden in ordenes.data" :key="orden.id">
                <td>{{ orden.id }}</td>
                <td>{{ orden.cliente.nombre }} {{ orden.cliente.apellido }}</td>
                <td>{{ formatearFecha(orden.fecha) }}</td>
                <td>
                  <span :class="getEstadoClass(orden.estado)">
                    {{ orden.estado }}
                  </span>
                </td>
                <td>{{ orden.detalles.length }}</td>
                <td>${{ parseFloat(orden.total).toFixed(2) }}</td>
                <td>
                  <button class="btn btn-info btn-sm" @click="verOrden(orden.id)">
                    Ver
                  </button>
                  <button class="btn btn-warning btn-sm ml-1" @click="editarOrden(orden.id)">
                    Editar
                  </button>
                  <button class="btn btn-danger btn-sm ml-1" @click="eliminarOrden(orden.id)">
                    Eliminar
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Paginación -->
        <div v-if="ordenes.total > 0" class="d-flex justify-content-between align-items-center">
          <div>
            Mostrando {{ ordenes.from }} a {{ ordenes.to }} de {{ ordenes.total }} resultados
          </div>
          <nav>
            <ul class="pagination">
              <li class="page-item" :class="{ disabled: ordenes.current_page === 1 }">
                <a class="page-link" @click="cambiarPagina(ordenes.current_page - 1)">Anterior</a>
              </li>
              <li v-for="page in pages" :key="page" class="page-item" 
                  :class="{ active: page === ordenes.current_page }">
                <a class="page-link" @click="cambiarPagina(page)">{{ page }}</a>
              </li>
              <li class="page-item" :class="{ disabled: ordenes.current_page === ordenes.last_page }">
                <a class="page-link" @click="cambiarPagina(ordenes.current_page + 1)">Siguiente</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>

    <!-- Modal de detalles -->
    <div v-if="ordenSeleccionada" class="modal fade show" style="display: block;" 
         @click="cerrarModal">
      <div class="modal-dialog modal-lg" @click.stop>
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Detalles de Orden #{{ ordenSeleccionada.id }}</h5>
            <button type="button" class="close" @click="cerrarModal">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <strong>Cliente:</strong> {{ ordenSeleccionada.cliente.nombre }} {{ ordenSeleccionada.cliente.apellido }}
              </div>
              <div class="col-md-6">
                <strong>Fecha:</strong> {{ formatearFecha(ordenSeleccionada.fecha) }}
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-6">
                <strong>Estado:</strong> 
                <span :class="getEstadoClass(ordenSeleccionada.estado)">
                  {{ ordenSeleccionada.estado }}
                </span>
              </div>
              <div class="col-md-6">
                <strong>Total:</strong> ${{ parseFloat(ordenSeleccionada.total).toFixed(2) }}
              </div>
            </div>
            <div v-if="ordenSeleccionada.observaciones" class="row mt-2">
              <div class="col-12">
                <strong>Observaciones:</strong> {{ ordenSeleccionada.observaciones }}
              </div>
            </div>
            
            <h6 class="mt-4">Items de la Orden:</h6>
            <table class="table table-sm">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <th>Precio Unit.</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="detalle in ordenSeleccionada.detalles" :key="detalle.id">
                  <td>{{ detalle.producto }}</td>
                  <td>{{ detalle.cantidad }}</td>
                  <td>${{ parseFloat(detalle.precio_unitario).toFixed(2) }}</td>
                  <td>${{ parseFloat(detalle.subtotal).toFixed(2) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from '@/libs/axios'

export default {
  name: 'OrdenesList',
  data() {
    return {
      ordenes: {
        data: [],
        current_page: 1,
        last_page: 1,
        total: 0,
        from: 0,
        to: 0
      },
      search: '',
      perPage: 10,
      ordenSeleccionada: null
    }
  },
  computed: {
    pages() {
      const pages = []
      const start = Math.max(1, this.ordenes.current_page - 2)
      const end = Math.min(this.ordenes.last_page, this.ordenes.current_page + 2)
      
      for (let i = start; i <= end; i++) {
        pages.push(i)
      }
      
      return pages
    }
  },
  async mounted() {
    await this.cargarOrdenes()
  },
  methods: {
    async cargarOrdenes() {
      try {
        const params = {
          per_page: this.perPage,
          page: this.ordenes.current_page
        }
        
        if (this.search) {
          params.search = this.search
        }
        
        const response = await axios.get('/api/ordenes', { params })
        this.ordenes = response.data
      } catch (error) {
        console.error('Error cargando órdenes:', error)
      }
    },
    
    buscar() {
      this.ordenes.current_page = 1
      this.cargarOrdenes()
    },
    
    cambiarPagina(page) {
      if (page >= 1 && page <= this.ordenes.last_page) {
        this.ordenes.current_page = page
        this.cargarOrdenes()
      }
    },
    
    nuevaOrden() {
      this.$router.push('/ordenes/crear')
    },
    
    async verOrden(id) {
      try {
        const response = await axios.get(`/api/ordenes/${id}`)
        this.ordenSeleccionada = response.data.data
      } catch (error) {
        console.error('Error cargando orden:', error)
      }
    },
    
    editarOrden(id) {
      this.$router.push(`/ordenes/editar/${id}`)
    },
    
    async eliminarOrden(id) {
      if (confirm('¿Está seguro de eliminar esta orden?')) {
        try {
          const response = await axios.delete(`/api/ordenes/${id}`)
          console.log('Respuesta eliminación:', response.data)
          alert('Orden eliminada exitosamente')
          // Recargar la lista completa
          await this.cargarOrdenes()
        } catch (error) {
          console.error('Error eliminando orden:', error)
          alert('Error al eliminar la orden')
        }
      }
    },
    
    cerrarModal() {
      this.ordenSeleccionada = null
    },
    
    formatearFecha(fecha) {
      return new Date(fecha).toLocaleDateString('es-ES')
    },
    
    getEstadoClass(estado) {
      const clases = {
        'pendiente': 'badge badge-warning',
        'procesando': 'badge badge-info',
        'completado': 'badge badge-success',
        'cancelado': 'badge badge-danger'
      }
      return clases[estado] || 'badge badge-secondary'
    }
  }
}
</script>

<style scoped>
.ordenes-list {
  padding: 20px;
}

.card {
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.badge {
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem;
  border-radius: 0.25rem;
}

.badge-warning {
  background-color: #ffc107;
  color: #212529;
}

.badge-info {
  background-color: #17a2b8;
  color: white;
}

.badge-success {
  background-color: #28a745;
  color: white;
}

.badge-danger {
  background-color: #dc3545;
  color: white;
}

.badge-secondary {
  background-color: #6c757d;
  color: white;
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

.mt-4 {
  margin-top: 1.5rem;
}

.pagination .page-link {
  cursor: pointer;
}
</style>
