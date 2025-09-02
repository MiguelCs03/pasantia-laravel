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
                <v-select
                  v-model="form.cliente_id"
                  :options="clientesOptions"
                  label="text"
                  :reduce="option => option.value"
                  placeholder="Escriba para buscar clientes..."
                  required>
                </v-select>
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

          <!-- Formulario para añadir productos -->
          <div class="card mt-4 border-success">
            <div class="card-header bg-light">
              <h5 class="text-success mb-0">
                <i class="fas fa-plus-circle mr-2"></i>
                Añadir Producto a la Orden
              </h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label>Producto *</label>
                    <v-select
                      v-model="nuevoItem.producto_id"
                      :options="productosOptions"
                      label="text"
                      :reduce="option => option.value"
                      placeholder="Escriba para buscar productos..."
                      @input="seleccionarProductoNuevo">
                    </v-select>
                    <small class="text-muted">{{ productos.length }} productos disponibles</small>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Cantidad *</label>
                    <input v-model.number="nuevoItem.cantidad" type="number" class="form-control" min="1"
                      @input="calcularSubtotalNuevo">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Precio Unit. *</label>
                    <input v-model.number="nuevoItem.precio_unitario" type="number" class="form-control" step="0.01"
                      min="0" @input="calcularSubtotalNuevo">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <label>Subtotal</label>
                    <input :value="nuevoItem.subtotal.toFixed(2)" type="text" class="form-control" readonly>
                  </div>
                </div>
                <div class="col-md-1">
                  <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-success btn-block" @click="agregarItem"
                      :disabled="!nuevoItem.producto_id || nuevoItem.cantidad <= 0">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Lista de productos añadidos -->
          <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">
                <i class="fas fa-list mr-2"></i>
                Items de la Orden ({{ form.detalles.length }})
              </h5>
              <span class="badge badge-primary badge-pill">Total: ${{ totalGeneral.toFixed(2) }}</span>
            </div>
            <div class="card-body">
              <div v-if="form.detalles.length === 0" class="text-center text-muted py-4">
                <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                <p>No hay productos añadidos aún.</p>
                <p>Utiliza el formulario de arriba para añadir productos a la orden.</p>
              </div>

              <div v-else class="table-responsive">
                <table class="table table-hover">
                  <thead class="thead-light">
                    <tr>
                      <th>Producto</th>
                      <th>Cantidad</th>
                      <th>Precio Unitario</th>
                      <th>Subtotal</th>
                      <th width="80">Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(detalle, index) in form.detalles" :key="index">
                      <td>
                        <span class="font-weight-bold">{{ obtenerNombreProducto(detalle.producto_id) }}</span>
                      </td>
                      <td>{{ detalle.cantidad }}</td>
                      <td>${{ detalle.precio_unitario.toFixed(2) }}</td>
                      <td class="font-weight-bold">${{ detalle.subtotal.toFixed(2) }}</td>
                      <td>
                        <button type="button" class="btn btn-danger btn-sm" @click="eliminarDetalle(index)"
                          title="Eliminar item">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                  <tfoot class="bg-light">
                    <tr>
                      <td colspan="3" class="text-right font-weight-bold">Total General:</td>
                      <td class="font-weight-bold text-success">${{ totalGeneral.toFixed(2) }}</td>
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

    <!-- Modal de Métodos de Pago -->
    <div v-if="mostrarModalPago" class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5)">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title">
              <i class="fas fa-credit-card mr-2"></i>
              Métodos de Pago
            </h5>
            <button type="button" class="close text-white" @click="cerrarModalPago">
              <span>&times;</span>
            </button>
          </div>
          
          <div class="modal-body">
            <div class="alert alert-info">
              <strong>Total a pagar: ${{ totalGeneral.toFixed(2) }}</strong>
            </div>

            <!-- Lista de métodos de pago añadidos -->
            <div v-if="metodosPago.length > 0" class="mb-4">
              <h6>Métodos de pago añadidos:</h6>
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <tr>
                      <th>Método</th>
                      <th>Monto</th>
                      <th>Detalles</th>
                      <th>Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(metodo, index) in metodosPago" :key="index">
                      <td>{{ metodo.metodo_pago }}</td>
                      <td>${{ metodo.monto.toFixed(2) }}</td>
                      <td>{{ metodo.detalles || '-' }}</td>
                      <td>
                        <button class="btn btn-danger btn-sm" @click="eliminarMetodoPago(index)">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr class="bg-light">
                      <td><strong>Total pagado:</strong></td>
                      <td><strong>${{ totalPagado.toFixed(2) }}</strong></td>
                      <td><strong>Restante:</strong></td>
                      <td><strong>${{ (totalGeneral - totalPagado).toFixed(2) }}</strong></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>

            <!-- Formulario para añadir método de pago -->
            <div class="card">
              <div class="card-header">
                <h6 class="mb-0">Añadir método de pago</h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Método *</label>
                      <select v-model="nuevoMetodoPago.metodo_pago" class="form-control">
                        <option value="">Seleccione...</option>
                        <option value="efectivo">Efectivo</option>
                        <option value="qr">QR</option>
                        <option value="tarjeta">Tarjeta</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Monto *</label>
                      <input 
                        v-model.number="nuevoMetodoPago.monto" 
                        type="number" 
                        class="form-control" 
                        step="0.01" 
                        min="0"
                        :max="totalGeneral - totalPagado">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Detalles</label>
                      <input 
                        v-model="nuevoMetodoPago.detalles" 
                        type="text" 
                        class="form-control" 
                        placeholder="Referencia, últimos 4 dígitos, etc.">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>&nbsp;</label>
                      <button 
                        type="button" 
                        class="btn btn-success btn-block" 
                        @click="agregarMetodoPago"
                        :disabled="!nuevoMetodoPago.metodo_pago || nuevoMetodoPago.monto <= 0">
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="cerrarModalPago">
              Cancelar
            </button>
            <button 
              type="button" 
              class="btn btn-success" 
              @click="confirmarOrden"
              :disabled="totalPagado < totalGeneral">
              <i class="fas fa-check mr-2"></i>
              Confirmar Orden
            </button>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import axios from '@/libs/axios'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'

export default {
  name: 'OrdenForm',
  components: {
    'v-select': vSelect
  },
  data() {
    return {
      form: {
        cliente_id: '',
        fecha: new Date().toISOString().split('T')[0],
        estado: 'pendiente',
        observaciones: '',
        detalles: []
      },
      nuevoItem: {
        producto_id: '',
        cantidad: 1,
        precio_unitario: 0,
        subtotal: 0
      },
      // Modal de métodos de pago
      mostrarModalPago: false,
      metodosPago: [],
      nuevoMetodoPago: {
        metodo_pago: '',
        monto: 0,
        detalles: ''
      },
      clientes: [],
      productos: [],
      isEdit: false,
      ordenId: null
    }
  },
  computed: {
    totalGeneral() {
      return this.form.detalles.reduce((total, detalle) => total + detalle.subtotal, 0)
    },
    
    totalPagado() {
      return this.metodosPago.reduce((total, metodo) => total + metodo.monto, 0)
    },
    
    productosOptions() {
      return this.productos.map(p => ({
        value: p.id,
        text: `${p.nombre} - $${p.precio} (Stock: ${p.stock})`
      }))
    },
    
    clientesOptions() {
      return this.clientes.map(c => ({
        value: c.id,
        text: `${c.nombre} ${c.apellido} - ${c.email}`
      }))
    }
  },
  async mounted() {
    await this.cargarClientes()
    await this.cargarProductos()
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

    async cargarProductos() {
      try {
        console.log('Cargando productos...')
        const response = await axios.get('/api/productos-activos')
        console.log('Respuesta de productos:', response)
        this.productos = response.data.data
        console.log('Productos cargados:', this.productos)
      } catch (error) {
        console.error('Error cargando productos:', error)
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
            producto_id: detalle.producto_id,
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
        producto_id: '',
        cantidad: 1,
        precio_unitario: 0,
        subtotal: 0
      })
    },

    agregarItem() {
      console.log('🔥 BOTÓN + CLICKEADO')
      console.log('📦 nuevoItem completo:', JSON.stringify(this.nuevoItem, null, 2))

      // Validación paso a paso
      if (!this.nuevoItem.producto_id) {
        console.log('❌ Error: No hay producto seleccionado')
        alert('Debe seleccionar un producto')
        return
      }

      if (this.nuevoItem.cantidad <= 0) {
        console.log('❌ Error: Cantidad inválida:', this.nuevoItem.cantidad)
        alert('La cantidad debe ser mayor a 0')
        return
      }

      console.log('✅ Validaciones pasaron, agregando item...')

      // Crear el nuevo detalle
      const nuevoDetalle = {
        producto_id: this.nuevoItem.producto_id,
        cantidad: this.nuevoItem.cantidad,
        precio_unitario: this.nuevoItem.precio_unitario,
        subtotal: this.nuevoItem.subtotal
      }

      console.log('🆕 Nuevo detalle a agregar:', JSON.stringify(nuevoDetalle, null, 2))
      console.log('📋 Detalles antes de agregar:', JSON.stringify(this.form.detalles, null, 2))

      // Agregar a la lista
      this.form.detalles.push(nuevoDetalle)

      console.log('📋 Detalles después de agregar:', JSON.stringify(this.form.detalles, null, 2))
      console.log('🧮 Total calculado:', this.totalGeneral)

      // Limpiar formulario
      this.nuevoItem = {
        producto_id: '',
        cantidad: 1,
        precio_unitario: 0,
        subtotal: 0
      }

      console.log('🧹 Formulario limpiado, nuevoItem:', JSON.stringify(this.nuevoItem, null, 2))
    },

    limpiarNuevoItem() {
      this.nuevoItem = {
        producto_id: '',
        cantidad: 1,
        precio_unitario: 0,
        subtotal: 0
      }
    },

    calcularSubtotalNuevo() {
      this.nuevoItem.subtotal = this.nuevoItem.cantidad * this.nuevoItem.precio_unitario
    },

    seleccionarProductoNuevo() {
      const productoId = this.nuevoItem.producto_id
      if (productoId) {
        const producto = this.productos.find(p => p.id == productoId)
        if (producto) {
          this.nuevoItem.precio_unitario = parseFloat(producto.precio)
          this.calcularSubtotalNuevo()
        }
      }
    },

    obtenerNombreProducto(productoId) {
      const producto = this.productos.find(p => p.id == productoId)
      return producto ? producto.nombre : 'Producto no encontrado'
    },

    seleccionarProducto(index) {
      const productoId = this.form.detalles[index].producto_id
      if (productoId) {
        const producto = this.productos.find(p => p.id == productoId)
        if (producto) {
          // Autocompletado de precio según el producto 
          this.form.detalles[index].precio_unitario = parseFloat(producto.precio)
          this.calcularSubtotal(index)
          console.log('Producto seleccionado:', producto)
        }
      }
    },

    eliminarDetalle(index) {
      this.form.detalles.splice(index, 1)
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
          if (!detalle.producto_id || detalle.cantidad <= 0 || detalle.precio_unitario < 0) {
            alert('Todos los items deben tener producto, cantidad mayor a 0 y precio válido')
            return
          }
        }

        console.log('Validaciones pasaron, mostrando modal de pago...')
        
        // En lugar de guardar directamente, mostrar modal de métodos de pago
        this.mostrarModalPago = true

      } catch (error) {
        console.error('Error en validaciones:', error)
      }
    },

    cancelar() {
      this.$router.push('/ordenes')
    },

    // Métodos para el modal de pago
    cerrarModalPago() {
      this.mostrarModalPago = false
      this.metodosPago = []
      this.limpiarNuevoMetodoPago()
    },

    agregarMetodoPago() {
      console.log('🔥 MÉTODO DE PAGO - botón clickeado')
      console.log('💳 nuevoMetodoPago:', JSON.stringify(this.nuevoMetodoPago, null, 2))
      
      if (!this.nuevoMetodoPago.metodo_pago || this.nuevoMetodoPago.monto <= 0) {
        console.log('❌ Validación falló - método o monto inválido')
        alert('Debe seleccionar un método y un monto válido')
        return
      }
      
      if (this.totalPagado + this.nuevoMetodoPago.monto > this.totalGeneral) {
        console.log('❌ Validación falló - monto excede total')
        alert('El monto total no puede exceder el total de la orden')
        return
      }
      
      console.log('✅ Validaciones pasaron, agregando método de pago')
      
      this.metodosPago.push({
        metodo_pago: this.nuevoMetodoPago.metodo_pago,
        monto: this.nuevoMetodoPago.monto,
        detalles: this.nuevoMetodoPago.detalles
      })
      
      console.log('💰 Métodos de pago actualizados:', JSON.stringify(this.metodosPago, null, 2))
      console.log('💵 Total pagado:', this.totalPagado)
      
      this.limpiarNuevoMetodoPago()
    },

    limpiarNuevoMetodoPago() {
      this.nuevoMetodoPago = {
        metodo_pago: '',
        monto: 0,
        detalles: ''
      }
    },

    eliminarMetodoPago(index) {
      this.metodosPago.splice(index, 1)
    },

    async confirmarOrden() {
      try {
        console.log('Confirmando orden con métodos de pago...')
        console.log('Form data:', this.form)
        console.log('Métodos de pago:', this.metodosPago)
        
        // Aquí guardaremos la orden con los métodos de pago
        const datosOrden = {
          ...this.form,
          metodos_pago: this.metodosPago
        }
        
        if (this.isEdit) {
          await axios.put(`/api/ordenes/${this.ordenId}`, datosOrden)
          alert('Orden actualizada exitosamente')
        } else {
          await axios.post('/api/ordenes', datosOrden)
          alert('Orden creada exitosamente')
        }

        this.$router.push('/ordenes')

      } catch (error) {
        console.error('Error guardando orden:', error)
        alert('Error al guardar la orden')
      }
    }
  }
}
</script>

<style scoped>
.orden-form {
  padding: 20px;
}

.card {
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.border-success {
  border-color: #28a745 !important;
}

.bg-light {
  background-color: #f8f9fa !important;
}

.text-success {
  color: #28a745 !important;
}

.thead-light th {
  background-color: #f8f9fa;
  font-weight: 600;
}

.table th {
  background-color: #f8f9fa;
  font-weight: 600;
}

.table-hover tbody tr:hover {
  background-color: rgba(0, 0, 0, .05);
}

.font-weight-bold {
  font-weight: 600;
}

.text-right {
  text-align: right;
}

.mr-2 {
  margin-right: 0.5rem;
}

.mb-0 {
  margin-bottom: 0;
}

.mb-3 {
  margin-bottom: 1rem;
}

.py-4 {
  padding-top: 1.5rem;
  padding-bottom: 1.5rem;
}

.fa-3x {
  font-size: 3em;
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
