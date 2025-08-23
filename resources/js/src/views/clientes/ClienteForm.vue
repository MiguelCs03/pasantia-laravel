<template>
  <div class="cliente-form">
    <div class="card">
      <div class="card-header">
        <h4>{{ isEdit ? 'Editar Cliente' : 'Nuevo Cliente' }}</h4>
      </div>
      <div class="card-body">
        <form @submit.prevent="submitForm">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="nombre">Nombre *</label>
                <input 
                  v-model="form.nombre" 
                  type="text" 
                  class="form-control"
                  :class="{ 'is-invalid': errors.nombre }"
                  placeholder="Ingrese el nombre"
                  required
                >
                <div v-if="errors.nombre" class="invalid-feedback">
                  {{ errors.nombre[0] }}
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="apellido">Apellido *</label>
                <input 
                  v-model="form.apellido" 
                  type="text" 
                  class="form-control"
                  :class="{ 'is-invalid': errors.apellido }"
                  placeholder="Ingrese el apellido"
                  required
                >
                <div v-if="errors.apellido" class="invalid-feedback">
                  {{ errors.apellido[0] }}
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="email">Email *</label>
            <input 
              v-model="form.email" 
              type="email" 
              class="form-control"
              :class="{ 'is-invalid': errors.email }"
              placeholder="correo@ejemplo.com"
              required
            >
            <div v-if="errors.email" class="invalid-feedback">
              {{ errors.email[0] }}
            </div>
          </div>

          <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input 
              v-model="form.telefono" 
              type="tel" 
              class="form-control"
              :class="{ 'is-invalid': errors.telefono }"
              placeholder="12345678"
              pattern="[0-9]{8}"
              maxlength="8"
            >
            <div v-if="errors.telefono" class="invalid-feedback">
              {{ errors.telefono[0] }}
            </div>
          </div>

          <div class="form-group">
            <label for="direccion">Dirección *</label>
            <textarea 
              v-model="form.direccion" 
              class="form-control"
              :class="{ 'is-invalid': errors.direccion }"
              rows="3"
              placeholder="Ingrese la dirección completa"
              required
            ></textarea>
            <div v-if="errors.direccion" class="invalid-feedback">
              {{ errors.direccion[0] }}
            </div>
          </div>

          <!-- Botones -->
          <div class="mt-4">
            <button type="submit" class="btn btn-primary" :disabled="loading">
              <span v-if="loading" class="spinner-border spinner-border-sm mr-2"></span>
              {{ isEdit ? 'Actualizar' : 'Crear' }} Cliente
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
  name: 'ClienteForm',
  data() {
    return {
      form: {
        nombre: '',
        apellido: '',
        email: '',
        telefono: '',
        direccion: ''
      },
      errors: {},
      loading: false,
      isEdit: false,
      clienteId: null
    }
  },
  async mounted() {
    if (this.$route.params.id) {
      this.isEdit = true
      this.clienteId = this.$route.params.id
      await this.cargarCliente()
    }
  },
  methods: {
    async cargarCliente() {
      try {
        this.loading = true
        const response = await axios.get(`/api/clientes/${this.clienteId}`)
        const cliente = response.data.data
        
        this.form = {
          nombre: cliente.nombre,
          apellido: cliente.apellido,
          email: cliente.email,
          telefono: cliente.telefono || '',
          direccion: cliente.direccion
        }
      } catch (error) {
        console.error('Error cargando cliente:', error)
        alert('Error al cargar los datos del cliente')
        this.$router.push('/clientes')
      } finally {
        this.loading = false
      }
    },
    
    async submitForm() {
      try {
        this.loading = true
        this.errors = {}
        
        // Validación frontend
        if (!this.validateForm()) {
          return
        }
        
        if (this.isEdit) {
          await axios.put(`/api/clientes/${this.clienteId}`, this.form)
          alert('Cliente actualizado exitosamente')
        } else {
          await axios.post('/api/clientes', this.form)
          alert('Cliente creado exitosamente')
        }
        
        this.$router.push('/clientes')
        
      } catch (error) {
        console.error('Error guardando cliente:', error)
        
        if (error.response && error.response.status === 422) {
          // Errores de validación del backend
          this.errors = error.response.data.errors
        } else {
          alert('Error al guardar el cliente')
        }
      } finally {
        this.loading = false
      }
    },
    
    validateForm() {
      const errors = {}
      
      // Validar nombre
      if (!this.form.nombre.trim()) {
        errors.nombre = ['El nombre es obligatorio']
      } else if (this.form.nombre.length < 2) {
        errors.nombre = ['El nombre debe tener al menos 2 caracteres']
      }
      
      // Validar apellido
      if (!this.form.apellido.trim()) {
        errors.apellido = ['El apellido es obligatorio']
      } else if (this.form.apellido.length < 2) {
        errors.apellido = ['El apellido debe tener al menos 2 caracteres']
      }
      
      // Validar email
      if (!this.form.email.trim()) {
        errors.email = ['El email es obligatorio']
      } else if (!this.isValidEmail(this.form.email)) {
        errors.email = ['El email no tiene un formato válido']
      }
      
      // Validar teléfono (opcional pero si se ingresa debe tener 8 dígitos)
      if (this.form.telefono && !/^[0-9]{8}$/.test(this.form.telefono)) {
        errors.telefono = ['El teléfono debe contener exactamente 8 dígitos']
      }
      
      // Validar dirección
      if (!this.form.direccion.trim()) {
        errors.direccion = ['La dirección es obligatoria']
      } else if (this.form.direccion.length < 10) {
        errors.direccion = ['La dirección debe ser más descriptiva (mín. 10 caracteres)']
      }
      
      this.errors = errors
      return Object.keys(errors).length === 0
    },
    
    isValidEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
      return emailRegex.test(email)
    },
    
    cancelar() {
      this.$router.push('/clientes')
    }
  }
}
</script>

<style scoped>
.cliente-form {
  padding: 20px;
}

.card {
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-group {
  margin-bottom: 1rem;
}

.is-invalid {
  border-color: #dc3545;
}

.invalid-feedback {
  display: block;
  color: #dc3545;
  font-size: 0.875rem;
  margin-top: 0.25rem;
}

.spinner-border-sm {
  width: 1rem;
  height: 1rem;
}

.ml-2 {
  margin-left: 0.5rem;
}

.mr-2 {
  margin-right: 0.5rem;
}

.mt-4 {
  margin-top: 1.5rem;
}
</style>
