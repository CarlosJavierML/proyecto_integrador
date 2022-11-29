@extends('layouts.layouts')

@section('content')


<!-- Bootstrap Table with Header - Dark -->
<div class="card">
    <div class="container">
        <div class="row" style="align-items: center">
            <div class="col-12 col-md-8">
                <h5 class="card-header">Residentes</h5>
            </div>
            <div class="col-6 col-md-4">
                <a class="btn btn-success" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userCreateModal">Registro</a>
                <a href="{{url ('pdfresidente')}}" class="btn btn-info">Generar Reporte</a>
            </div>
        </div>
    </div>

    @if (\Session::has('destroy'))
    <div class="alert alert-danger">
        <p>
            {{\Session::get('destroy')}}
        </p>
    </div>
    @endif


    <div class="table-responsive text-nowrap">
        <table class="table" id='UsuarioTable'>
            <thead class="table-dark">
                <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Tipo Doc</th>
                    <th>N Documento</th>
                    <th>Actions</th>
                    <th>Habilitar Residente</th>
                </tr>
            </thead>

            <tbody class="table-border-bottom-0">
                @foreach ($usuarios as $usuario)
                <tr>
                    <td> {{$usuario->id}} </td>
                    <td> {{$usuario->primerNombre}} </td>
                    <td> {{$usuario->primerApellido}} </td>
                    <td> {{$usuario->tipoDoc }} </td>
                    <td> {{$usuario->numeroDoc }} </td>
                  
                    <!--
                    <td>
                        <option value="{{$usuario['idEstado']}}"> {{$usuario['tipo']}}</option>
                    </td>-->
                    <td>

                        <form action="{{ route('usuario.destroy', $usuario->id) }}" method="POST">
                            <button type="button" class='btn btn-info viewdetails' data-id='{{$usuario->id }}'>Show</button>
                            <button type="button" class="btn btn-warning btn-detail open_modal" value="{{$usuario->id}}">Edit</button>
                            @csrf @method('DELETE')
                            <!-- <button type="submit" class="btn btn-danger">Eliminar</button>-->
                        
                        </form>
                    </td>
                    <td>
                        @switch($usuario->idEstado)
                            @case(null)
                            <a class="btn btn-secondary" href="{{ url('usuarios/'. $usuario->id . "/habilitar") }}">
                                Asignar estado
                            </a>
                            @break
                            @case(1)
                            <strong class="text-success">Residente hablilitado</strong>
                            <a class="btn btn-secondary" href="{{ url('usuarios/'. $usuario->id . "/habilitar") }}">
                                Deshabilitar
                            </a>
                            @break
                            @case(2)
                            <strong class="text-danger">Residente deshabilitado</strong>
                            <a class="btn btn-secondary" href="{{ url('usuarios/'. $usuario->id . "/habilitar") }}">
                                Habilitar
                            </a>
                            @break
                        @endswitch
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <!-- TO DO: PONER EL PAGINADOR -->
            {{$usuarios->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
<!--/ Bootstrap Table with Header Dark -->

<!-- Passing BASE URL to AJAX -->
<input id="url" type="hidden" value="{{ \Request::url() }}">

<!-- modal crear -->
<div class="modal fade" id="userCreateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Registrar Residente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="alert alert-danger d-none" id="errors-modal">
                <strong>Campos Obligatorios!</strong> Validar los siguientes Campos.<br>
                <ul id="ul-errors">
                </ul>
            </div>

            <form action="#" id="userForm" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="primerNombre" class="form-label">Nombre Residente: </label>
                            <input type="text" name="primerNombre" id="primerNombre" class="form-control" placeholder="Insertar Nombre" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="primerApellido" class="form-label">Apellido Residente: </label>
                            <input type="text" name="primerApellido" id="primerApellido" class="form-control" placeholder="Insertar Apellido" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="tipoDoc" class="form-label">Tipo Documento: </label>
                            <select class="form-control" id="tipoDoc" name="tipoDoc" aria-label="Seleccione Tipo de Documento">
                                <option value="">Seleccione</option>
                                <option value="TI">TI</option>
                                <option value="CC">CC</option>
                            </select>
                        </div>
                        <div class="col mb-0">
                            <label for="numeroIdentidad" class="form-label">N° Identidad: </label>
                            <input type="text" id="numeroIdentidad" name="numeroIdentidad" class="form-control" placeholder="N° Identidad" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="fechaNacimiento" class="form-label">Fecha De Nacimiento: </label>
                            <input type="date" id="fechaNacimiento" name="fechaNacimiento" class="form-control" placeholder="Fecha Nacimiento" />
                        </div>
                    </div>

                    <div class="col mb-0">
                        <label for="sexo" class="form-label">Sexo: </label>
                        <select class="form-control" id="sexo" name="sexo" aria-label="Seleccione Tipo de Documento">
                            <option value="">Seleccione</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="celular" class="form-label">N° de Celular: </label>
                            <input type="text" id="celular" name="celular" class="form-control" placeholder="N° de Celular" />
                        </div>
                        <div class="col mb-0">
                            <label for="correo" class="form-label">Correo: </label>
                            <input type="email" id="correo" name="correo" class="form-control" placeholder="Ingrese su correo" />
                        </div>
                    </div>
                    <div class="col mb-0">
                        <label for="estado" class="form-label">Estado: </label>
                        <select class="form-control" id="estado" name="estado" aria-label="">
                            <option value="">Seleccione</option>
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col mb-3">
                            <label for="rol" class="form-label">Rol: </label>
                            <select name="rol" id="rol" class="form-control">
                                <option value="">Seleccione</option>
                                @foreach ($roles as $rol)
                                <option value="{{$rol['id_rol']}}">{{ $rol->tipo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="password" class="form-label">Contraseña: </label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="" />
                        </div>
                        <div class="col mb-0">
                            <label for="password_confirmation" class="form-label">Comfirmar Contraseña: </label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close </button>
                    <button type="button" class="btn btn-success" id="btnAdd">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- fin modal crear -->

<!-- actualizar modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Actualizar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="alert alert-danger d-none" id="errors-modal-update">
                <strong>Campos Obligatorios!</strong> Validar los siguientes Campos.<br>
                <ul id="ul-errors-update">
                </ul>
            </div>
            <form method="post" action="{{ route('usuario.update') }}" id="update-usuario-form">
                @method('POST')
                @csrf
                <input type="hidden" name="cid" id="id_editar">
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="primNomUpdate" class="form-label">Primer Nombre</label>
                            <input type="text" name="primNomUpdate" id="primNomUpdate" class="form-control" value="" />
                        </div>
                        <div class="col mb-3">
                            <label for="segNomUpdate" class="form-label">Segundo Nombre</label>
                            <input type="text" name="segNomUpdate" id="segNomUpdate" class="form-control noFilt" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-3">
                            <label for="priApeUpdate" class="form-label">Primer Apellido</label>
                            <input type="text" name="priApeUpdate" id="priApeUpdate" class="form-control" />
                        </div>
                        <div class="col mb-3">
                            <label for="segApeUpdate" class="form-label">Segundo Apellido</label>
                            <input type="text" name="segApeUpdate" id="segApeUpdate" class="form-control noFilt" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="tipoDocUpdate" class="form-label">Tipo Documento</label>
                            <select class="form-select" id="tipoDocUpdate" name="tipoDocUpdate" disabled="true">
                                <option selected>Seleccione</option>
                                <option value="TI">TI</option>
                                <option value="CC">CC</option>
                            </select>
                        </div>
                        <div class="col mb-0">
                            <label for="identidadUpdate" class="form-label">N° Identidad</label>
                            <input type="text" id="identidadUpdate" name="identidadUpdate" class="form-control noFilt" readonly />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="fecNacUpdate" class="form-label">Fecha Nacimiento</label>
                            <input type="date" id="fecNacUpdate" name="fecNacUpdate" class="form-control noFilt" readonly />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="sexUpdate" class="form-label">Sexo</label>
                            <input type="text" id="sexUpdate" name="sexUpdate" class="form-control noFilt" value="" readonly />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0">
                            <label for="telUpdate" class="form-label">Telefono</label>
                            <input type="text" id="telUpdate" name="telUpdate" class="form-control" value="" />
                        </div>
                        <div class="col mb-0">
                            <label for="emailUpdate" class="form-label">Correo</label>
                            <input type="email" id="emailUpdate" name="emailUpdate" class="form-control" value="" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col mb-0" id="contenedor1">
                            <label for="estadoUpdate" class="form-label">Estado:</label>
                            <select name="estadoUpdate" id="estadoUpdate" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="1">ACTIVO</option>
                                <option value="2">INACTIVO</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin actualizar modal -->

<!-- show modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Visualizar Residente {{ $usuario->primerNombre }}</h5>
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
<!-- fin show modal -->


@endsection
@section('content-js')
<script>
    let ruta = "{{ route('usuario.store') }}";
    let ruta2 = "{{ route('usuario.show',[':usuid']) }}";
</script>
<script src="{{ asset('js/usuarios.js') }}"></script>
@endsection