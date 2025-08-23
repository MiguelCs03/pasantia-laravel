<template>
  <div class="orden-form">
    <div class="card">
      <div class="card-header">
        <h4>{{ isEdit ? 'Editar Orden' : 'Nueva Orden' }}</h4>
      </div>
      <div class="card-body">
        <form @submit.prevent="submitForm">
          <!-- Datos Maestro -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="cliente_id">Cliente *</label>
                <select v-model="form.cliente_id" class="form-control" required>
                  <option value="">Seleccionar cliente</option>
                  <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">
                    {{ cliente.nombre }} {{ cliente.apellido }}
                  </option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="fecha">Fecha *</label>
                <input v-model="form.fecha" type="date" class="form-control" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="estado">Estado *</label>
                <select v-model="form.estado" class="form-control" required>
                  <option value="pendiente">Pendiente</option>
                  <option value="procesando">Procesando</option>
                  <option value="completado">Completado</option>
                  <option value="cancelado">Cancelado</option>
                </select>
              </div>
            </div>
          </div>
          
          <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea v-model="form.observaciones" class="form-control" rows="3"></textarea>
          </div>

          <!-- Detalles -->
          <div class="card mt-4">
            <div class="card-header d-flex justify-content-between">
              <h5>Items de la Orden</h5>
              <button type="button" class="btn btn-success btn-sm" @click="agregarDetalle">
                + Agregar Item
              </button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Producto</th>
                      <th>Cantidad</th>
                      <th>Precio Unitario</th>
                      <th>Subtotal</th>
                      <th>Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(detalle, index) in form.detalles" :key="index">
                      <td>
                        <input v-model="detalle.producto" type="text" class="form-control" 
                               placeholder="Nombre del producto" required>
                      </td>
                      <td>
                        <input v-model.number="detalle.cantidad" type="number" class="form-control" 
                               min="1" @input="calcularSubtotal(index)" required>
                      </td>
                      <td>
                        <input v-model.number="detalle.precio_unitario" type="number" 
                               class="form-control" step="0.01" min="0" 
                               @input="calcularSubtotal(index)" required>
                      </td>
                      <td>
                        <span class="font-weight-bold">${{ detalle.subtotal.toFixed(2) }}</span>
                      </td>
                      <td>
                        <button type="button" class="btn btn-danger btn-sm" 
                                @click="eliminarDetalle(index)">
                          Eliminar
                        </button>
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="3" class="text-right font-weight-bold">Total:</td>
                      <td class="font-weight-bold">${{ totalGeneral.toFixed(2) }}</td>
                      <td></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>

          <!-- Botones -->
          <div class="mt-4">
            <button type="submit" class="btn btn-primary">
              {{ isEdit ? 'Actualizar' : 'Crear' }} Orden
            </button>
            <button type="button" class="btn btn-secondary ml-2" @click="cancelar">
              Cancelar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from '@/libs/axios'

export default {
  name: 'OrdenForm',
  data() {
    return {
      form: {
        cliente_id: '',
        fecha: new Date().toISOString().split('T')[0],
        estado: 'pendiente',
        observaciones: '',
        detalles: [
          {
            producto: '',
            cantidad: 1,
            precio_unitario: 0,
            subtotal: 0
          }
        ]
      },
      clientes: [],
      isEdit: false,
      ordenId: null
    }
  },
  computed: {
    totalGeneral() {
      return this.form.detalles.reduce((total, detalle) => total + detalle.subtotal, 0)
    }
  },
  async mounted() {
    await this.cargarClientes()
    if (this.$route.params.id) {
      this.isEdit = true
      this.ordenId = this.$route.params.id
      await this.cargarOrden()
    }
  },
  methods: {
    async cargarClientes() {
      try {
        console.log('Intentando cargar clientes...')
        const response = await axios.get('/api/clientes')
        console.log('Respuesta de clientes:', response)
        this.clientes = response.data.data
        console.log('Clientes cargados:', this.clientes)
      } catch (error) {
        console.error('Error cargando clientes:', error)
        console.error('Detalles del error:', error.response)
      }
    },
    
    async cargarOrden() {
      try {
        const response = await axios.get(`/api/ordenes/${this.ordenId}`)
        const orden = response.data.data
        
        this.form = {
          cliente_id: orden.cliente_id,
          fecha: orden.fecha.split('T')[0],
          estado: orden.estado,
          observaciones: orden.observaciones || '',
          detalles: orden.detalles.map(detalle => ({
            id: detalle.id,
            producto: detalle.producto,
            cantidad: detalle.cantidad,
            precio_unitario: parseFloat(detalle.precio_unitario),
            subtotal: parseFloat(detalle.subtotal)
          }))
        }
      } catch (error) {
        console.error('Error cargando orden:', error)
      }
    },
    
    agregarDetalle() {
      this.form.detalles.push({
        producto: '',
        cantidad: 1,
        precio_unitario: 0,
        subtotal: 0
      })
    },
    
    eliminarDetalle(index) {
      if (this.form.detalles.length > 1) {
        this.form.detalles.splice(index, 1)
      }
    },
    
    calcularSubtotal(index) {
      const detalle = this.form.detalles[index]
      detalle.subtotal = detalle.cantidad * detalle.precio_unitario
    },
    
    async submitForm() {
      try {
        // Validar que hay al menos un detalle
        if (this.form.detalles.length === 0) {
          alert('Debe agregar al menos un item a la orden')
          return
        }
        
        // Validar detalles
        for (let detalle of this.form.detalles) {
          if (!detalle.producto || detalle.cantidad <= 0 || detalle.precio_unitario < 0) {
            alert('Todos los items deben tener producto, cantidad mayor a 0 y precio válido')
            return
          }
        }
        
        if (this.isEdit) {
          await axios.put(`/api/ordenes/${this.ordenId}`, this.form)
          alert('Orden actualizada exitosamente')
        } else {
          await axios.post('/api/ordenes', this.form)
          alert('Orden creada exitosamente')
        }
        
        this.$router.push('/ordenes')
        
      } catch (error) {
        console.error('Error guardando orden:', error)
        alert('Error al guardar la orden')
      }
    },
    
    cancelar() {
      this.$router.push('/ordenes')
    }
  }
}
</script>

<style scoped>
.orden-form {
  padding: 20px;
}

.card {
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.table th {
  background-color: #f8f9fa;
  font-weight: 600;
}

.font-weight-bold {
  font-weight: 600;
}

.text-right {
  text-align: right;
}

.ml-2 {
  margin-left: 0.5rem;
}

.mt-4 {
  margin-top: 1.5rem;
}

.d-flex {
  display: flex;
}

.justify-content-between {
  justify-content: space-between;
}
</style>
