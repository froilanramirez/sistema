<template>
    <main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Inicio</li>
          <li class="breadcrumb-item">
            <a href="#">Admin</a>
          </li>
          <li class="breadcrumb-item active">Escritorio</li>
          <!-- Breadcrumb Menu-->
          <li class="breadcrumb-menu d-md-down-none">
            <div class="btn-group" role="group" aria-label="Button group">
              <a class="btn" href="#">
                <i class="icon-speech"></i>
              </a>
              <a class="btn" href="./">
                <i class="icon-graph"></i>  Escritorio</a>
              <a class="btn" href="#">
                <i class="icon-settings"></i>  Configuración</a>
            </div>
          </li>
        </ol>
        
        <div class="container-fluid">
          <div class="card">
              <div class="card-header">
                  <i class="fa fa-align-justify"></i>Clientes
                  <button type="button" @click="abrirModal('persona','registrar')" class="btn btn-secondary">
                      <i class="icon-plus"></i>&nbsp;Nuevo
                  </button>
              </div>
              <div class="card-body">
                  <div class="form-group row">
                      <div class="col-md-6">
                          <div class="input-group">
                              <select class="form-control col-md-3" v-model="criterio">
                                  <option value="nombre">Nombre</option>
                                  <option value="numerodocumento">Documento</option>
                                  <option value="email">Email</option>
                                  <option value="telefono">Teléfono</option>
                              </select>
                              <input type="text" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                              <button type="submit" @click="listarPersona(1,buscar,criterio)" class="btn btn-primary">
                                  <i class="fa fa-search"></i>Buscar
                              </button>
                          </div>
                      </div>
                  </div>
              
              <table class="table table-bordered table-striped table-sm">
                  <thead>
                      <tr>
                          <th>Opciones</th>
                          <th>Nombre</th>
                          <th>Tipo documento</th>
                          <th>Número</th>
                          <th>Dirección</th>
                          <th>Teléfono</th>
                          <th>Email</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="persona in arrarPersona" :key="persona.id">
                          <td>
                              <button type="button" @click="abrirModal('persona','actualizar',persona)" class="btn btn-warning btn-sm">
                                  <i class="icon-pencil"></i>
                              </button>
                              <!-- <template v-if="categoria.categoriacondicion">
                                  <button type="button" class="btn btn-danger btn-sm" @click="desactivarCategoria(categoria.categoriasid)">
                                      <i class="icon-trash"></i>
                                  </button>
                              </template>
                              <template v-else>
                                  <button type="button" class="btn btn-info btn-sm" @click="activarCategoria(categoria.categoriasid)">
                                      <i class="icon-check"></i>
                                  </button>
                              </template> -->
                              <!-- <button type="button" class="btn btn-danger btn-sm">
                                  <i class="icon-trash"></i>
                              </button> -->
                          </td>
                          <td v-text="persona.nombre"></td>
                          <td v-text="persona.tipodocumento"></td>
                          <td v-text="persona.numerodocumento"></td>
                          <td v-text="persona.direccion"></td>
                          <td v-text="persona.telefono"></td>
                          <td v-text="persona.email"></td>
                          <!-- <td>
                              <div v-if="categoria.categoriacondicion">
                                  <span class="badge badge-success">Activo</span>
                              </div>
                              <div v-else>
                                  <span class="badge badge-danger">Inactivo</span>
                              </div>
                          </td> -->
                      </tr>
                  </tbody>
              </table>
              
              <nav>
                  <ul class="pagination">
                      <li class="page-item" v-if="pagination.current_page > 1">
                          <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                      </li>
                      <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                          <a class="page-link" href="#" @click.prevent = "cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                      </li>
                      <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                          <a class="page-link" href="#" @click="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                      </li>
                  </ul>
              </nav>
              </div>
          </div>
        </div>
        <div class="modal fade" tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" >
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-tittle" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label for="text-input" class="col-md-3 form-control-label">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de la persona">
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="text-input" class="col-md-3 form-control-label">Tipo documento</label>
                                <div class="col-md-9">
                                    <select v-model="tipodocumento" class="form-control">
                                        <option value="DNI">DNI</option>
                                        <option value="RUC">RUC</option>
                                        <option value="PASS">PASS</option>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="text-input" class="col-md-3 form-control-label">Número</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="numerodocumento" class="form-control" placeholder="Número del documento">
                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="text-input" class="col-md-3 form-control-label">Dirección</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="direccion" class="form-control" placeholder="Dirección">
                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tel-input" class="col-md-3 form-control-label">Teléfono</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="telefono" class="form-control" placeholder="Teléfono">
                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email-input" class="col-md-3 form-control-label">Email</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="email" class="form-control" placeholder="Email">
                                    
                                </div>
                            </div>

                            <div v-show="errorPersona" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </form>
                </div>
               
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona">Actualizar</button>
                </div>
                 </div>
            </div>
        </div>
      </main>
</template>

<script>
    export default {
        data(){
            return{
                personaid:0,
                nombre:'',
                tipodocumento:'',
                numerodocumento:'',
                direccion:'',
                telefono:'',
                email:'',
                arrarPersona : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorPersona : 0,
                errorMostrarMsjPersona : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : ''

            }
        },
        computed:{
            isActived:function(){
                return this.pagination.current_page;
            },

            pagesNumber:function(){
                if(!this.pagination.to){
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if(from< 1){
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
        },
        methods:{
            listarPersona(page,buscar,criterio){
                let me=this;
                var url = '/cliente?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta =response.data;
                    me.arrarPersona = respuesta.personas.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarPersona(page,buscar,criterio);
            },
            registrarPersona(){
                if(this.validarPersona()){
                    return;
                }
                let me = this;
                axios.post('/cliente/registrar',{
                    'nombre' : this.nombre,
                    'tipodocumento' : this.tipodocumento,
                    'numerodocumento' : this.numerodocumento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email
                }).then(function(response){
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                }).catch(function(error){
                    console.log(error);
                });
            },
            actualizarPersona(){
                if(this.validarPersona()){
                    return;
                }
                let me = this;
                axios.put('/cliente/actualizar',{
                    'nombre' : this.nombre,
                    'tipodocumento' : this.tipodocumento,
                    'numerodocumento' : this.numerodocumento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email,
                    'id' : this.personaid
                }).then(function(response){
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                }).catch(function(error){
                    console.log(error);
                });
            },
            validarPersona(){
                this.errorPersona = 0;
                this.errorMostrarMsjPersona = [];

                if(!this.nombre)this.errorMostrarMsjPersona.push("El nombre de la persona no puede estar vacio");

                if(this.errorMostrarMsjPersona.length) this.errorPersona = 1;

                return this.errorPersona;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "persona":
                    {
                        switch(accion)
                        {
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar cliente';
                                this.nombre = '';
                                this.tipodocumento = 'DNI';
                                this.numerodocumento = '';
                                this.direccion = '';
                                this.telefono = '';
                                this.email = '';
                                this.tipoAccion = 1;
                                break;                            
                            }
                            case 'actualizar':
                            {
                                this.modal = 1;
                                this.tituloModal = "Actualizar cliente";
                                this.tipoAccion = 2;
                                this.personaid = data['id'];
                                this.nombre = data['nombre'];
                                this.tipodocumento = data['tipodocumento'];
                                this.numerodocumento = data['numerodocumento'];
                                this.direccion = data['direccion'];
                                this.telefono = data['telefono'];
                                this.email = data['email'];
                                break;
                            }
                        }
                    }
                }
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.nombre = '';
                this.tipodocumento = 'DNI';
                this.numerodocumento = '';
                this.direccion = '';
                this.telefono = '';
                this.email = '';
                this.errorPersona = 0;

            },
        },
        mounted() {
            this.listarPersona(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display:list-item !important;
        opacity:1 !important;
        position:absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
