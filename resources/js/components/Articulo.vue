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
                  <i class="fa fa-align-justify"></i>Artículos
                  <button type="button" @click="abrirModal('articulo','registrar')" class="btn btn-secondary">
                      <i class="icon-plus"></i>&nbsp;Nuevo
                  </button>
              </div>
              <div class="card-body">
                  <div class="form-group row">
                      <div class="col-md-6">
                          <div class="input-group">
                              <select class="form-control col-md-3" v-model="criterio">
                                  <option value="categoriasnombre">Nombre</option>
                                  <option value="categoriasdescripcion">Descripción</option>
                              </select>
                              <input type="text" v-model="buscar" @keyup.enter="listarArticulo(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                              <button type="submit" @click="listarArticulo(1,buscar,criterio)" class="btn btn-primary">
                                  <i class="fa fa-search"></i>Buscar
                              </button>
                          </div>
                      </div>
                  </div>
              
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio venta</th>
                            <th>Stock</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="articulo in arrarArticulo" :key="articulo.articulosid">
                            <td>
                                <button type="button" @click="abrirModal('articulo','actualizar',articulo)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                </button>
                                <template v-if="articulo.articuloscondicion">
                                    <button type="button" class="btn btn-danger btn-sm" @click="desactivarArticulo(articulo.articulosid)">
                                        <i class="icon-trash"></i>
                                    </button>
                                </template>
                                <template v-else>
                                    <button type="button" class="btn btn-info btn-sm" @click="activarArticulo(articulo.articulosid)">
                                        <i class="icon-check"></i>
                                    </button>
                                </template>
                                <!-- <button type="button" class="btn btn-danger btn-sm">
                                    <i class="icon-trash"></i>
                                </button> -->
                            </td>
                            <td v-text="articulo.articuloscodigo"></td>
                            <td v-text="articulo.articulosnombre"></td>
                            <td v-text="articulo.categoriasnombre"></td>
                            <td v-text="articulo.categoriasprecioventa"></td>
                            <td v-text="articulo.articulosstock"></td>
                            <td v-text="articulo.articulosdescripcion"></td>
                            <td>
                                <div v-if="articulo.articuloscondicion">
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
                                <label for="text-input" class="col-md-3 form-control-label">Categoría</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="categoriasid">
                                        <option value = "0" disabled>Seleccione</option>
                                        <option v-for="categoria in arrayCategoria" :key="categoria.categoriasid" :value="categoria.categoriasid" v-text="categoria.categoriasnombre"></option>
                                    </select>
                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="text-input" class="col-md-3 form-control-label">Código</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="articuloscodigo" class="form-control" placeholder="Código de barras">
                                    <barcode :value="articuloscodigo" :options="{format:'EAN-13'}">
                                        Generando código de barras.
                                    </barcode>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="text-input" class="col-md-3 form-control-label">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="articulosnombre" class="form-control" placeholder="Nombre del artículo">
                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="text-input" class="col-md-3 form-control-label">Precio venta</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="articulosprecioventa" class="form-control" placeholder="Precio venta">
                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="text-input" class="col-md-3 form-control-label">Stock</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="articulosstock" class="form-control" placeholder="Stock">
                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="text-input" class="col-md-3 form-control-label">Descripción</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="articulosdescripcion" class="form-control" placeholder="Descripción del artículo">
                                    
                                </div>
                            </div>
                            <div v-show="errorArticulo" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </form>
                </div>
               
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarArticulo">Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarArticulo">Actualizar</button>
                </div>
                 </div>
            </div>
        </div>
      </main>
</template>

<script>
    import VueBarCode from 'vue-barcode';
    export default {
        data(){
            return{
                artculosid:0,
                categoriasid:0,
                categoriasnombre:'',
                articuloscodigo:'',
                articulosnombre:'',
                articulosprecioventa:0,
                articulosstock:0,
                articulosdescripcion:'',
                arrarArticulo : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorArticulo : 0,
                errorMostrarMsjArticulo : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'articulosnombre',
                buscar : '',
                arrayCategoria:[]

            }
        },
        components:{
            'barcode' : VueBarCode
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
            listarArticulo(page,buscar,criterio){
                let me=this;
                var url = '/articulo?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta =response.data;
                    me.arrarArticulo = respuesta.articulos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            selectCategoria(){
                let me=this;
                var url = '/categoria/selectCategoria';
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta =response.data;
                    me.arrayCategoria = respuesta.categorias;

                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarArticulo(page,buscar,criterio);
            },
            registrarArticulo(){
                if(this.validarArticulo()){
                    return;
                }
                let me = this;
                axios.post('/articulo/registrar',{
                    'categoriasid':this.categoriasid,
                    'articuloscodigo':this.articuloscodigo,
                    'articulosnombre' : this.articulosnombre,
                    'articulosprecioventa':this.articulosprecioventa,
                    'articulosstock':this.articulosstock,
                    'articulosdescripcion' : this.articulosdescripcion
                }).then(function(response){
                    me.cerrarModal();
                    me.listarArticulo(1,'','articulosnombre');
                }).catch(function(error){
                    console.log(error);
                });
            },
            actualizarArticulo(){
                if(this.validarArticulo()){
                    return;
                }
                let me = this;
                axios.put('/articulo/actualizar',{
                    'categoriasid':this.categoriasid,
                    'articuloscodigo':this.articuloscodigo,
                    'articulosnombre' : this.articulosnombre,
                    'articulosprecioventa':this.articulosprecioventa,
                    'articulosstock':this.articulosstock,
                    'articulosdescripcion' : this.articulosdescripcion,
                    'articulosid' : this.articulosid
                }).then(function(response){
                    me.cerrarModal();
                    me.listarArticulo(1,'','articulosnombre');
                }).catch(function(error){
                    console.log(error);
                });
            },
            desactivarArticulo(articulosid){
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Esta seguro de desactivar este artículo?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/articulo/desactivar',{
                        articulosid : articulosid
                    }).then(function(response){
                        me.listarArticulo(1,'','articulosnombre');
                        swalWithBootstrapButtons(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function(error){
                        console.log(error);
                    });
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                    )
                }
                })
            },
            activarArticulo(articulosid){
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: '¿ Esta seguro de activar este artículo ?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/articulo/activar',{
                        articulosid : articulosid
                    }).then(function(response){
                        me.listarArticulo(1,'','articulosnombre');
                        swalWithBootstrapButtons(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function(error){
                        console.log(error);
                    });
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                    )
                }
                })
            },
            validarArticulo(){
                this.errorArticulo = 0;
                this.errorMostrarMsjArticulo = [];

                if(this.categoriasid == 0)this.errorMostrarMsjArticulo.push("Seleccione una categoría.");
                if(!this.articulosnombre)this.errorMostrarMsjArticulo.push("El nombre del artículo no puede estar vacío.");
                if(!this.articulosstock)this.errorMostrarMsjArticulo.push("El stock del artículo debe ser un n'umero y no puede estar vacío. ");
                if(!this.articulosprecioventa)this.errorMostrarMsjArticulo.push("El precio de venta del artículo debe ser un número y no puede estar vacío.");
                
                if(this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;

                return this.errorArticulo;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "articulo":
                    {
                        switch(accion)
                        {
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar artículo';
                                this.categoriasid = 0;
                                this.categoriasnombre = '';
                                this.articuloscodigo = '';
                                this.articulosnombre = '';
                                this.articulosprecioventa = 0;
                                this.articulosstock = 0;
                                this.articulosdescripcion = '';
                                this.tipoAccion = 1;
                                break;                            
                            }
                            case 'actualizar':
                            {
                                this.modal = 1;
                                this.tituloModal = "Actualizar artículo";
                                this.tipoAccion = 2;
                                this.articulosid = data['articulosid'];
                                this.categoriasid = data['categoriasid'];
                                this.articuloscodigo = data['articuloscodigo'];
                                this.articulosnombre = data['articulosnombre'];
                                this.articulosprecioventa = data['articulosprecioventa'];
                                this.articulosstock = data['articulosstock'];
                                this.articulosdescripcion = data['articulosdescripcion'];
                                break;
                            }
                        }
                    }
                }
                this.selectCategoria();
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.categoriasid = 0;
                this.categoriasnombre = '';
                this.articuloscodigo = '';
                this.articulosnombre = '';
                this.articulosprecioventa = 0;
                this.articulosstock = 0;
                this.articulosdescripcion = '';
                this.errorArticulo = 0;

            },
        },
        mounted() {
            this.listarArticulo(1,this.buscar,this.criterio);
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