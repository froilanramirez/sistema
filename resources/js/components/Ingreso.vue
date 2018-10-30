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
                    <i class="fa fa-align-justify"></i>Ingresos
                    <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <!-- Listado -->
                <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="tipocomprobante">Tipo comprobante</option>
                                        <option value="numerocomprobante">Número comprobante</option>
                                        <option value="fechahora">Fecha-Hora</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarIngreso(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarIngreso(1,buscar,criterio)" class="btn btn-primary">
                                        <i class="fa fa-search"></i>Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Usuario</th>
                                        <th>Proveedor</th>
                                        <th>Tipo comprobante</th>
                                        <th>Serie comprobante</th>
                                        <th>Número comprobantre</th>
                                        <th>Fecha hora</th>
                                        <th>Total</th>
                                        <th>Impuesto</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="ingreso in arrayIngreso" :key="ingreso.id">
                                        <td>
                                            <button type="button" @click="verIngreso(ingreso.id)" class="btn btn-success btn-sm">
                                                <i class="icon-eye"></i>
                                            </button>&nbsp;
                                            <template v-if="ingreso.estado=='Registrado'">
                                                <button type="button" class="btn btn-danger btn-sm" @click="desactivarIngreso(ingreso.id)">
                                                    <i class="icon-trash"></i>
                                                </button>
                                            </template>
                                        </td>
                                        <td v-text="ingreso.usuario"></td>
                                        <td v-text="ingreso.nombre"></td>
                                        <td v-text="ingreso.tipocomprobante"></td>
                                        <td v-text="ingreso.seriecomprobante"></td>
                                        <td v-text="ingreso.numerocomprobante"></td>
                                        <td v-text="ingreso.fechahora"></td>
                                        <td v-text="ingreso.total"></td>
                                        <td v-text="ingreso.impuesto"></td>
                                        <td>
                                            <div v-if="ingreso.estado=='Registrado'">
                                                <span class="badge badge-success">Activo</span>
                                            </div>
                                            <div v-else>
                                                <span class="badge badge-danger">Anulado</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
                </template>
                <!-- Fin listado -->
                <!-- Detalle -->
                <template v-else-if="listado==0">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="">Proveedor(*)</label>
                                    <v-select :on-search="selectProveedor" label="nombre" :options="arrayProveedor" placeholder="Buscar proveedores..." :onChange="getDatosProveedor"></v-select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">Impuesto(*)</label>
                                <input type="text" class="form-control" v-model="impuesto">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tipo comprobante(*)</label>
                                    <select class="form-control" v-model="tipocomprobante">
                                        <option value="0">Seleccione</option>
                                        <option value="BOLETA">Boleta</option>
                                        <option value="FACTURA">Factura</option>
                                        <option value="TICKET">Ticket</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Serie comprobante</label>
                                    <input type="text" class="form-control" v-model="seriecomprobante" placeholder="000x">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Número comprobante(*)</label>
                                    <input type="text" class="form-control" v-model="numerocomprobante" placeholder="000xx">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div v-show="errorIngreso" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjIngreso" :key="error" v-text="error"></div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Artículo <span style="color:red" v-show="articuloid==0">(*Seleccione)</span></label>
                                    <div class="form-inline">
                                        <input type="text" class="form-control" v-model="codigo" @keyup.enter="buscarArticulos()" placeholder="Ingrese artículo">
                                        <button @click="abrirModal()" class="btn btn-primary">...</button>
                                        <input type="text" readonly class="form-control" v-model="articulo">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Precio <span style="color:red" v-show="precio==0">(*Ingrese)</span></label>
                                    <input type="number" value="0" step="any" class="form-control" v-model="precio">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Cantidad <span style="color:red" v-show="cantidad==0">(*Ingrese)</span></label>
                                    <input type="number" value="0" class="form-control" v-model="cantidad">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar"><i class="icon-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Artículo</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                            <td>
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </td>
                                            <td v-text="detalle.articulo"></td>
                                            <td>
                                                <input v-model="detalle.precio" type="number" value="3" class="form-control">
                                            </td>
                                            <td>
                                                <input v-model="detalle.cantidad" type="number" value="2" class="form-control">
                                            </td>
                                            <td>
                                                {{detalle.precio*detalle.cantidad}}
                                            </td>
                                        </tr>
                                        <tr style="background-color:#CEECF5;">
                                            <td colspan="4" align="right"><strong>Total parcial:</strong></td>
                                            <td>$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color:#CEECF5;">
                                            <td colspan="4" align="right"><strong>Total impuesto:</strong></td>
                                            <td>$ {{totalImpuesto=((total*impuesto)/(1+impuesto)).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color:#CEECF5;">
                                            <td colspan="4" align="right"><strong>Total neto:</strong></td>
                                            <td>$ {{total=calcularTotal.toFixed(2)}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                No hay artículos agregados
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-secondary" @click="ocultarDetalle()">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="registrarIngreso()">Registrar compra</button>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- Fin detalle -->
                <!-- ver ingreso -->
                <template v-else-if="listado==2">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="">Proveedor</label>
                                    <p v-text="proveedor"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">Impuesto</label>
                                <p v-text="impuesto"></p>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tipo comprobante</label>
                                    <p v-text="tipocomprobante"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Serie comprobante</label>
                                    <p v-text="seriecomprobante"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Número comprobante</label>
                                    <p v-text="numerocomprobante"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Artículo</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                            <td v-text="detalle.articulo"></td>
                                            <td v-text="detalle.precio"></td>
                                            <td v-text="detalle.cantidad"></td>
                                            <td>
                                                $ {{(detalle.precio*detalle.cantidad).toFixed(2)}}
                                            </td>
                                        </tr>
                                        <tr style="background-color:#CEECF5;">
                                            <td colspan="3" align="right"><strong>Total parcial:</strong></td>
                                            <td>$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color:#CEECF5;">
                                            <td colspan="3" align="right"><strong>Total impuesto:</strong></td>
                                            <td>$ {{totalImpuesto=((total*impuesto)).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color:#CEECF5;">
                                            <td colspan="3" align="right"><strong>Total neto:</strong></td>
                                            <td>$ {{total}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="4">
                                                No hay artículos agregados
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-secondary" @click="ocultarDetalle()">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- fin de ver ingreso -->
            </div>
            <!-- Fin ejemplo de tabla listado -->
        </div>
        <!-- Inicio del modal agregar/actualizar -->
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
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterioArticulo">
                                        <option value="articulosnombre">Nombre</option>
                                        <option value="articulosdescripcion">Descripción</option>
                                        <option value="articuloscodigo">Código</option>
                                    </select>
                                    <input type="text" v-model="buscarArticulo" @keyup.enter="listarArticulo(buscarArticulo,criterioArticulo)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarArticulo(buscarArticulo,criterioArticulo)" class="btn btn-primary">
                                        <i class="fa fa-search"></i>Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Categoría</th>
                                        <th>Precio venta</th>
                                        <th>Stock</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="articulo in arrayArticulo" :key="articulo.articulosid">
                                        <td>
                                            <button type="button" @click="agregarDetalleModal(articulo)" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                            </button>
                                        </td>
                                        <td v-text="articulo.articuloscodigo"></td>
                                        <td v-text="articulo.articulosnombre"></td>
                                        <td v-text="articulo.categoriasnombre"></td>
                                        <td v-text="articulo.categoriasprecioventa"></td>
                                        <td v-text="articulo.articulosstock"></td>
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
                        </div>
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
    import vSelect from 'vue-select';
    export default {
        data(){
            return{
                ingresoid:0,
                proveedorid:0,
                proveedor:'',
                nombre:'',
                tipocomprobante:'BOLETA',
                seriecomprobante:'',
                numerocomprobante:'',
                fechahora:'',
                impuesto:0.16,
                total:0.0,
                totalImpuesto:0.0,
                totalParcial:0.0,
                arrayIngreso:[],
                arrayProveedor:[],
                arrayDetalle:[],
                listado:1,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorIngreso : 0,
                errorMostrarMsjIngreso : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'numerocomprobante',
                buscar : '',
                criterioArticulo:'articulosnombre',
                buscarArticulo:'',
                arrayArticulo:[],
                articuloid:0,
                codigo:'',
                articulo:'',
                precio:0,
                cantidad:0

            }
        },
        components:{
            vSelect
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
            calcularTotal:function(){
                var resultado=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)
                }
                return resultado;
            },
        },
        methods:{
            listarIngreso(page,buscar,criterio){
                let me=this;
                var url = '/ingreso?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta =response.data;
                    me.arrayIngreso = respuesta.ingresos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            selectProveedor(search,loading){
                 let me=this;
                 loading(true)
                var url = '/proveedor/selectProveedor?filtro='+search;
                axios.get(url).then(function (response) {
                    // handle success
                    let respuesta = response.data;
                    q: search
                    me.arrayProveedor = respuesta.proveedores;
                    loading(false)

                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            getDatosProveedor(val1){
                let me = this;
                me.loading = true;
                me.proveedorid = val1.id;
            },
            buscarArticulos(){
                let me = this;
                var url = '/articulo/buscarArticulo?filtro='+me.codigo;
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta = response.data;
                    me.arrayArticulo = respuesta.articulos;

                    if(me.arrayArticulo.length>0){
                        me.articulo = me.arrayArticulo[0]['articulosnombre'];
                        me.articuloid = me.arrayArticulo[0]['articulosid'];
                    }
                    else{
                        me.articulo = 'No existe artículo';
                        me.articuloid = 0;
                    }

                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                me.pagination.current_page = page;
                me.listarIngreso(page,buscar,criterio);
            },
            encuentra(id){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].articuloid==id){
                        sw = true;
                    }
                }
                return sw;
            },
            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index,1);
            },
            agregarDetalle(){
                let me = this;
                if(me.articuloid==0 || me.cantidad==0 || me.precio==0){
                }
                else{
                    if(me.encuentra(me.articuloid)){
                        swal({
                            type:'error',
                            title:'Error...',
                            text:'Ese artículo ya se encuentra agregado!',
                        })
                    }
                    else
                    {
                        me.arrayDetalle.push({
                        articuloid: me.articuloid,
                        articulo: me.articulo,
                        cantidad: me.cantidad,
                        precio: me.precio
                        });
                        me.codigo="";
                        me.articuloid=0;
                        me.articulo="";
                        me.cantidad=0;
                        me.precio=0;
                    }
                }
                
            },
            agregarDetalleModal(data = []){
                let me = this;
                if(me.encuentra(data['articulosid'])){
                        swal({
                            type:'error',
                            title:'Error...',
                            text:'Ese artículo ya se encuentra agregado!',
                        })
                    }
                    else
                    {
                        me.arrayDetalle.push({
                        articuloid: data['articulosid'],
                        articulo: data['articulosnombre'],
                        cantidad: 1,
                        precio: 1
                        });
                    }
            },
            listarArticulo(buscarArticulo,criterioArticulo){
                let me=this;
                var url = '/articulo/listarArticulo?buscar='+buscarArticulo+'&criterio='+criterioArticulo;
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta =response.data;
                    me.arrayArticulo = respuesta.articulos.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            registrarIngreso(){
                if(this.validarIngreso()){
                    return;
                }
                let me = this;
                axios.post('/ingreso/registrar',{
                    'proveedorid':this.proveedorid,
                    'tipocomprobante':this.tipocomprobante,
                    'seriecomprobante':this.seriecomprobante,
                    'numerocomprobante':this.numerocomprobante,
                    'impuesto':this.impuesto,
                    'total':this.total,
                    'data':this.arrayDetalle

                }).then(function(response){
                    me.listado = 1;
                    me.listarIngreso(1,'','numerocomprobante');
                    me.proveedorid = 0;
                    me.tipocomprobante = 'BOLETA';
                    me.seriecomprobante = '';
                    me.numerocomprobante = '';
                    me.total = 0.0;
                    me.articuloid = 0;
                    me.articulo = '';
                    me.cantidad = 0;
                    me.precio = 0;
                    me.arrayDetalle=[];
                }).catch(function(error){
                    console.log(error);
                });
            },
            validarIngreso(){
                this.errorIngreso = 0;
                this.errorMostrarMsjIngreso = [];

                if(this.proveedorid==0)this.errorMostrarMsjIngreso.push('Seleccione proveedor');
                if(this.tipocomprobante==0)this.errorMostrarMsjIngreso.push('Seleccione el comprobante'); 
                if(!this.numerocomprobante)this.errorMostrarMsjIngreso.push('Ingrese el número de comprobante');
                if(!this.impuesto)this.errorMostrarMsjIngreso.push('Ingrese el impuesto de compra');
                if(this.arrayDetalle.length<=0)this.errorMostrarMsjIngreso.push('Ingrese detalles');
                
                if(this.errorMostrarMsjIngreso.length) this.errorIngreso = 1;

                return this.errorIngreso;
            },
            mostrarDetalle(){
                let me = this;
                this.listado = 0;

                me.proveedorid = 0;
                me.tipocomprobante = 'BOLETA';
                me.seriecomprobante = '';
                me.numerocomprobante = '';
                me.total = 0.0;
                me.articuloid = 0;
                me.articulo = '';
                me.cantidad = 0;
                me.precio = 0;
                me.arrayDetalle=[];
            },
            ocultarDetalle(){
                this.listado = 1;
            },
            verIngreso(id){
                let me = this;
                this.listado = 2;
                //Obtener los datos del ingreso
                var arrayIngresoT=[];
                var url = '/ingreso/obtenerCabecera?id='+id;
                axios.get(url).then(function (response) {
                    // handle success
                    var respuesta =response.data;
                    me.arrayIngresoT = respuesta.ingresos;

                    me.proveedor = me.arrayIngresoT[0]['nombre'];
                    me.tipocomprobante = me.arrayIngresoT[0]['tipocomprobante'];
                    me.seriecomprobante = me.arrayIngresoT[0]['seriecomprobante'];
                    me.numerocomprobante = me.arrayIngresoT[0]['numerocomprobante'];
                    me.impuesto = me.arrayIngresoT[0]['impuesto'];
                    me.total = me.arrayIngresoT[0]['total'];

                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
                //obtener los datos de los detalles
                var urld = '/ingreso/obtenerDetalles?id='+id;
                axios.get(urld).then(function (response) {
                    // handle success
                    var respuesta =response.data;
                    me.arrayDetalle = respuesta.detalles;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            abrirModal(){
                this.arrayArticulo=[];
                this.modal = 1;
                this.tituloModal = 'Seleccione uno o varios artículos';
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal="";
            },
            desactivarIngreso(id){
                const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Esta seguro de desactivar este ingreso?',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/ingreso/desactivar',{
                        'id' : id
                    }).then(function(response){
                        me.listarIngreso(1,'','numerocomprobante');
                        swalWithBootstrapButtons(
                        'Anulado!',
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
        },
        mounted() {
            this.listarIngreso(1,this.buscar,this.criterio);
            this.listarArticulo(this.buscarArticulo,this.criterioArticulo);
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
    @media(min-width:600px){
        .btnagregar{
            margin-top:2rem;
        }
    }
</style>
