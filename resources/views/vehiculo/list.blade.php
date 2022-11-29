

@extends('layouts.layouts')
 
@section('content')
    
    <!-- Bootstrap Table with Header - Dark -->
    <div class="card">
        <div class="container">
            <div class="row" style="align-items: center">
                <div class="col-12 col-md-8">
                    <h5 class="card-header">Registro Vehiculos</h5>
                </div>
                <div class="col-6 col-md-4">
                    <a class="btn btn-success" href="{{ route('vehiculo.create') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal">Add</a>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table "  id='VehiTable'>
                <thead class="table-dark">
                    <tr>
                    <th>N°</th>
                    <th>N° Placa</>
                    <th>Tipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Color</th>
                    <th>N° Parqueadero</th>
                    <th>Nombre Dueño vehiculo</th>
                    <th>Actions</th>
                    </tr>
                </thead>
                @php
                    $i = 0;
                @endphp
                <tbody class="table-border-bottom-0">
                    @foreach ($vehiculos as $vehiculo)
                    
                    <td> {{ ++$i }}</td>
                    <td> {{$vehiculo->id_placa}} </td>
                    <td> {{$vehiculo->tipo}} </td>
                    <td> {{$vehiculo->marca}} </td>
                    <td> {{$vehiculo->modelo }} </td>
                    <td> {{$vehiculo->color}} </td>
                    <td> {{$vehiculo->numParqueadero }} </td>
                    <td> 
                        @foreach ($usuarios as $usuario)
                            @if($usuario->id == $vehiculo->idUsuario)
                                {{$usuario['primerNombre']}} {{$usuario['segundoNombre']}} {{$usuario['primerApellido']}} {{$usuario['segundoApellido']}}
                            @endif
                        @endforeach 
                    </td>
                    <td>  
                        <form action="{{ route('vehiculo.destroy', $vehiculo->id_placa) }}" method="POST">
                            <!--<a class="btn btn-info" href="{{ route('vehiculo.show',$vehiculo->idUsuario) }}" data-bs-toggle="modal" data-bs-target="#viewModal">Show</a>-->
                            <button type="button" class="btn btn-warning btn-detail open_modal" value='{{$vehiculo->id_placa }}'>Edit</button>
                           
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                    </tr>
                </tbody>
                @endforeach
            </table>
            <div>
                <!-- TO DO: PONER EL PAGINADOR -->
                {{$vehiculos->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
    <!--/ Bootstrap Table with Header Dark -->



    <!-- Passing BASE URL to AJAX -->
    <input id="url" type="hidden" value="{{ \Request::url() }}">

    <!-- modal crear -->
    <div class="modal fade" id="largeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">Registrar  Vehiculos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="alert alert-danger d-none" id="errors-modal" >
                    <strong>Campos Obligatorios!</strong> Validar los siguientes Campos.<br>
                    <ul id="ul-errors">
                    </ul>
                </div>

                <form action="" id="VehiForm" >
                    @csrf
                    <div class="modal-body">
                       
                        <div class="row g-2">
                            <div class="col mb-3">
                                <label for="id_placa" class="form-label">Placa</label>
                                <input type="text" name="id_placa" id="id_placa" class="form-control" placeholder="Insertar Placa Vehiculo"  />
                            </div>
                            <div class="col mb-3">
                                <label for="marca" class="form-label">Marca</label>
                                <input type="text" name="marca" id="marca" class="form-control" placeholder="Insertar Marca Vehiculo" />
                            </div>
                        </div>


                        <div class="row g-2">
                            <div class="col mb-3">
                                <label for="modelo" class="form-label">Modelo</label>
                                <input type="number" id="modelo" name="modelo" class="form-control" placeholder="Insertar Modelo Vehiculo" />
                            </div>
                            <div class="col mb-3">
                                <label for="color" class="form-label">Color</label>
                                <input type="text" id="color" name="color" class="form-control" placeholder="Insertar Color Vehiculo" />
                            </div>

                        </div>


                        <div class="row g-2" >
                            <div class="col mb-3">
                             <label for="tipo" class="form-label">Tipo</label>
                                <select name="tipo" id="tipo" class="form-control">
                                    <option>Seleccione</option>
                                    <option value="Carro">Carro</option>
                                    <option value="Moto">Moto</option>
                                </select>
                            </div>
                        </div>
                        

                        <div class="row g-2" >
                            <div class="col mb-3">
                                <label for="idUsuario" class="form-label">Propietario Vehiculo</label>
                                <select name="idUsuario" id="idUsuario" class="form-control">
                                    <option>Seleccione</option>
                                    @foreach ($usuarios as $usuario)
                                    <option value="{{$usuario['id']}}">{{$usuario['tipoDoc']}}{{$usuario['numeroDoc']}} --- {{$usuario['primerNombre']}} {{$usuario['segundoNombre']}} {{$usuario['primerApellido']}} {{$usuario['segundoApellido']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col mb-3">
                                <label for="numParqueadero" class="form-label">N° Parqueadero</label>
                                <input type="text" id="numParqueadero" name="numParqueadero" class="form-control" placeholder="Insertar N° Parqueadero del Vehiculo" />
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="btnAdd">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- fin modal crear -->

    <!-- editar modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">Actualizar Vehiculo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="alert alert-danger d-none" id="errors-modal-update" >
                    <strong>Campos Obligatorios!</strong> Validar los siguientes Campos.<br>
                    <ul id="ul-errors-update">
                    </ul>
                </div>
               
                
                <form method="post" action="{{ route('vehiculo.update') }}" id="update-apto-form">
                    @method('POST')
                    @csrf
                    <input type="hidden" name="cid" id="id_editar">

                    <div class="modal-body">
                        
                        <div class="row g-2">
                            
                            <div class="col mb-3">

                                <label for="marcaNew" class="form-label">marca:</label>
                                <input type="text" name="marcaNew" id="marcaNew" class="form-control noFilt" readonly />
                            </div>
                            <div class="col mb-3">
                                <label for="modeloNew" class="form-label">Modelo:</label>
                                <input type="number" name="modeloNew" id="modeloNew" class="form-control noFilt"  readonly/>
                            </div>
                            <div class="col mb-3">
                                <label for="colorNew" class="form-label">Color:</label>
                                <input type="text" name="colorNew" id="colorNew" class="form-control"  />
                            </div>

                        </div>
                       

                        <div class="row g-2" >
                            <div class="col mb-0">
                                <label for="tipoNew" class="form-label">Tipo</label>
                                <select class="form-control noFilt" name="tipoNew" id="tipoNew" disabled="true" >
                                    <option value="">Seleccione</option>
                                    <option value="Carro">Carro</option>
                                    <option value="Moto">Moto</option>
                                </select>
                            </div>
                        </div>



                        <div class="row g-2" >
                            <div class="col mb-0">
                                <label for="idUsuarioNew" class="form-label">Propietario Vehiculo</label>
                                <select name="idUsuarioNew" id="idUsuarioNew" class="form-select" value="{{$usuario['id']}}">
                                    <option>Seleccione</option>
                                    @foreach ($usuarios as $usuario)
                                    <option value="{{$usuario['id']}}">{{$usuario['primerNombre']}}{{$usuario['segundoNombre']}} {{$usuario['primerApellido']}} {{$usuario['segundoApellido']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="numParqueaderoNew" class="form-label">N° Parqueadero:</label>
                                <input type="text" name="numParqueaderoNew" id="numParqueaderoNew" class="form-control" placeholder="Insertar N° Parqeuadero" value="{{ $vehiculo->numParqueadero }} " maxlength="4"/>
                            </div>
                        </div>

                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- fin editar modal -->

    <!-- ver modal -->
    
    
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">Visualizar Vehiculo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                    <div class="modal-body">
                            <table class="table table-bordered table table-striped table table-hover" id="tblempinfo">
                                <tbody></tbody>                                   
                            </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

            </div>
        </div>
    </div>
    
    <!-- fin editar modal -->
    @endsection

    @section('content-js')
    <script>
        let ruta = "{{ route('vehiculo.store') }}";
        let ruta2 = "{{ route('vehiculo.show',[':vehid']) }}";
    </script>
    <script src="{{ asset('js/vehiculo.js') }}"></script>
    @endsection




