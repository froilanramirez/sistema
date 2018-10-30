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
                  <i class="fa fa-align-justify"></i>Roles
                  <!-- <button type="button" @click="abrirModal('rol','registrar')" class="btn btn-secondary">
                      <i class="icon-plus"></i>&nbsp;Nuevo
                  </button> -->
              </div>
              <div class="card-body">
                  <div class="form-group row">
                      <div class="col-md-6">
                          <div class="input-group">
                              <select class="form-control col-md-3" v-model="criterio">
                                  <option value="nombre">Nombre</option>
                                  <option value="descripcion">Descripción</option>
                              </select>
                              <input type="text" v-model="buscar" @keyup.enter="listarRol(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                              <button type="submit" @click="listarRol(1,buscar,criterio)" class="btn btn-primary">
                                  <i class="fa fa-search"></i>Buscar
                              </button>
                          </div>
                      </div>
                  </div>
              
              <table class="table table-bordered table-striped table-sm">
                  <thead>
                      <tr>
                          <!-- <th></th> -->
                          <th>Nombre</th>
                          <th>Descripción</th>
                          <th>Estatus</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="rol in arrayRol" :key="rol.id">
                          <!-- <td>
                              <button type="button" @click="abrirModal('rol','actualizar',rol)" class="btn btn-warning btn-sm">
                                  <i class="icon-pencil"></i>
                              </button>
                              <template v-if="categoria.categoriacondicion">
                                  <button type="button" class="btn btn-danger btn-sm" @click="desactivarCategoria(categoria.categoriasid)">
                                      <i class="icon-trash"></i>
                                  </button>
                              </template>
                              <template v-else>
                                  <button type="button" class="btn btn-info btn-sm" @click="activarCategoria(categoria.categoriasid)">
                                      <i class="icon-check"></i>
                                  </button>
                              </template>
                              <button type="button" class="btn btn-danger btn-sm">
                                  <i class="icon-trash"></i>
                              </button> 
                          </td> -->
                          <td v-text="rol.nombre"></td>
                          <td v-text="rol.descripcion"></td>
                          <td>
                              <div v-if="rol.condicion">
                                  <span class="badge badge-success">Activo</span>
                              </div>
                              <div v-else>
                                  <span class="badge badge-danger">Inactivo</span>
                              </div>
                          </td>
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
        <!-- <div class="modal fade" tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" >
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
                                    <input type="text" v-model="categoriasnombre" class="form-control" placeholder="Nombre de la categoría">
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="text-input" class="col-md-3 form-control-label">Descripción</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="categoriasdescripcion" class="form-control" placeholder="Descripción de la categoría">
                                    
                                </div>
                            </div>
                            <div v-show="errorCategoria" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjCategoria" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </form>
                </div>
               
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarCategoria">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarCategoria">Actualizar</button>
                </div>
                 </div>
            </div>
        </div> -->
      </main>
</template>

<script>
    export default {
        data(){
            return{
                rolid:0,
                nombre:'',
                descripcion:'',
                arrayRol : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
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
            listarRol(page,buscar,criterio){
                let me=this;
                var url = '/rol?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta =response.data;
                    me.arrayRol = respuesta.roles.data;
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
                me.listarRol(page,buscar,criterio);
            },
            // registrarCategoria(){
            //     if(this.validarCategoria()){
            //         return;
            //     }
            //     let me = this;
            //     axios.post('/categoria/registrar',{
            //         categoriasnombre : this.categoriasnombre,
            //         categoriasdescripcion : this.categoriasdescripcion
            //     }).then(function(response){
            //         me.cerrarModal();
            //         me.listarcategoria(1,'','categoriasnombre');
            //     }).catch(function(error){
            //         console.log(error);
            //     });
            // },
            // actualizarCategoria(){
            //     if(this.validarCategoria()){
            //         return;
            //     }
            //     let me = this;
            //     axios.put('/categoria/actualizar',{
            //         categoriasnombre : this.categoriasnombre,
            //         categoriasdescripcion : this.categoriasdescripcion,
            //         categoriasid : this.categoriasid
            //     }).then(function(response){
            //         me.cerrarModal();
            //         me.listarCategoria(1,'','categoriasnombre');
            //     }).catch(function(error){
            //         console.log(error);
            //     });
            // },
            // desactivarCategoria(categoriasid){
            //     const swalWithBootstrapButtons = swal.mixin({
            //     confirmButtonClass: 'btn btn-success',
            //     cancelButtonClass: 'btn btn-danger',
            //     buttonsStyling: false,
            //     })

            //     swalWithBootstrapButtons({
            //     title: 'Esta seguro de desactivar esta categoría?',
            //     text: "",
            //     type: 'warning',
            //     showCancelButton: true,
            //     confirmButtonText: 'Aceptar',
            //     cancelButtonText: 'Cancelar!',
            //     reverseButtons: true
            //     }).then((result) => {
            //     if (result.value) {
            //         let me = this;
            //         axios.put('/categoria/desactivar',{
            //             categoriasid : categoriasid
            //         }).then(function(response){
            //             me.listarCategoria(1,'','categoriasnombre');
            //             swalWithBootstrapButtons(
            //             'Desactivado!',
            //             'El registro ha sido desactivado con éxito.',
            //             'success'
            //             )
            //         }).catch(function(error){
            //             console.log(error);
            //         });
                    
            //     } else if (
            //         // Read more about handling dismissals
            //         result.dismiss === swal.DismissReason.cancel
            //     ) {
            //         swalWithBootstrapButtons(
            //         'Cancelled',
            //         'Your imaginary file is safe :)',
            //         'error'
            //         )
            //     }
            //     })
            // },
            // activarCategoria(categoriasid){
            //     const swalWithBootstrapButtons = swal.mixin({
            //     confirmButtonClass: 'btn btn-success',
            //     cancelButtonClass: 'btn btn-danger',
            //     buttonsStyling: false,
            //     })

            //     swalWithBootstrapButtons({
            //     title: 'Esta seguro de activar esta categoría?',
            //     text: "",
            //     type: 'warning',
            //     showCancelButton: true,
            //     confirmButtonText: 'Aceptar',
            //     cancelButtonText: 'Cancelar!',
            //     reverseButtons: true
            //     }).then((result) => {
            //     if (result.value) {
            //         let me = this;
            //         axios.put('/categoria/activar',{
            //             categoriasid : categoriasid
            //         }).then(function(response){
            //             me.listarCategoria(1,'','categoriasnombre');
            //             swalWithBootstrapButtons(
            //             'Activado!',
            //             'El registro ha sido activado con éxito.',
            //             'success'
            //             )
            //         }).catch(function(error){
            //             console.log(error);
            //         });
                    
            //     } else if (
            //         // Read more about handling dismissals
            //         result.dismiss === swal.DismissReason.cancel
            //     ) {
            //         swalWithBootstrapButtons(
            //         'Cancelled',
            //         'Your imaginary file is safe :)',
            //         'error'
            //         )
            //     }
            //     })
            // },
            // validarCategoria(){
            //     this.errorCategoria = 0;
            //     this.errorMostrarMsjCategoria = [];

            //     if(!this.categoriasnombre)this.errorMostrarMsjCategoria.push("El nombre de la categoria no puede estar vacio");
            //     if(!this.categoriasdescripcion)this.errorMostrarMsjCategoria.push("La descripción de la categoria no puede estar vacio");

            //     if(this.errorMostrarMsjCategoria.length) this.errorCategoria = 1;

            //     return this.errorCategoria;
            // },
            // abrirModal(modelo, accion, data = []){
            //     switch(modelo){
            //         case "categoria":
            //         {
            //             switch(accion)
            //             {
            //                 case 'registrar':
            //                 {
            //                     this.modal = 1;
            //                     this.tituloModal = 'Registrar categoría';
            //                     this.categoriasnombre = '';
            //                     this.categoriasdescripcion = '';
            //                     this.tipoAccion = 1;
            //                     break;                            
            //                 }
            //                 case 'actualizar':
            //                 {
            //                     this.modal = 1;
            //                     this.tituloModal = "Actualizar categoría";
            //                     this.tipoAccion = 2;
            //                     this.categoriasid = data['categoriasid'];
            //                     this.categoriasnombre = data['categoriasnombre'];
            //                     this.categoriasdescripcion = data['categoriasdescripcion'];
            //                     break;
            //                 }
            //             }
            //         }
            //     }
            // },
            // cerrarModal(){
            //     this.modal = 0;
            //     this.tituloModal = '';
            //     this.categoriasnombre = '';
            //     this.categoriasdescripcion = '';

            // },
        },
        mounted() {
            this.listarRol(1,this.buscar,this.criterio);
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
