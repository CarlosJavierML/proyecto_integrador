@extends('layouts.layouts')
 
@section('content')
    
    <!-- Bootstrap Table with Header - Dark -->
    <div class="card">
        <div class="container">
            <div class="row" style="align-items: center">
                <div class="col-12 col-md-8">
                    <h5 class="card-header">Registro Apartamentos</h5>
                </div>
                <div class="col-6 col-md-4">
                    <a class="btn btn-success" href="{{ route('apartamento.create') }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal">Add</a>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
        <table class="table" id='AptoTable'>
            <thead class="table-dark">
                    <tr>
                    <th>N°</th>
                    <th>Numero Apartamento</th>
                    <th>Numero Torre</th>
                    <th>Estado</th>
                    <th>Residente</th>
                    <th>Actions</th>
                    </tr>
                </thead>
                @php
                    $i = 0;
                @endphp
                <tbody class="table-border-bottom-0">
                    @foreach ($apartamentos as $apartamento)
                    
                    <td> {{ ++$i }}</td>
                    <td> {{$apartamento->numeroApto}} </td>
                    <td> {{$apartamento->numeroTorre}} </td>
                    <td> {{$apartamento->estado }} </td>
                    <td> 
                        @foreach ($usuarios as $usuario)
                            @if($usuario->id == $apartamento->idUsuario)
                                {{$usuario['primerNombre']}} {{$usuario['segundoNombre']}} {{$usuario['primerApellido']}} {{$usuario['segundoApellido']}}
                            @endif
                        @endforeach 
                    </td>
                    <td>
                        
                        <form action="{{ route('apartamento.destroy', $apartamento->id_apto) }}" method="POST">
                            <!--<button type="button" class='btn btn-info viewdetails' data-id='{{$apartamento->id_apto }}'>Show</button>-->
                            <button type="button" class="btn btn-warning btn-detail open_modal" value='{{$apartamento->id_apto }}'>Edit</button>
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
                {{$apartamentos->links('pagination::bootstrap-4') }}
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
                    <h5 class="modal-title" id="exampleModalLabel3">Registrar Apartamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="alert alert-danger d-none" id="errors-modal" >
                    <strong>Campos Obligatorios!</strong> Validar los siguientes Campos.<br>
                    <ul id="ul-errors">
                    </ul>
                </div>
                
                <form action="" id="AptoForm">
                        @csrf
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col mb-3">
                                <label for="numeroApto" class="form-label">Numero de Apartamento</label>
                                <input type="number" name="numeroApto" id="numeroApto" class="form-control" placeholder="Numero Apartamento" required/>
                            </div>
                            <div class="col mb-3">
                                <label for="numeroTorre" class="form-label">Numero de Torre</label>
                                <input type="number" name="numeroTorre" id="numeroTorre" class="form-control noFilt" placeholder="Numero Torre" />
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-control" id="estado" name="estado" aria-label="Seleccione el Estado">
                                <option value="">Seleccione</option>
                                <option value="Habitado">Habitado</option>
                                <option value="No Habitado">No Habitado</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="propietarioApartamento" class="form-label">Propietario Apartamento</label>
                                <select class="form-control" id="propietarioApartamento" name="propietarioApartamento" aria-label="Propietario Apartamento">
                                <option value="">Seleccione</option>
                                @foreach ($usuarios as $usuario)
                                    <option value="{{$usuario['id']}}">{{$usuario['tipoDoc']}}{{$usuario['numeroDoc']}} --- {{$usuario['primerNombre']}} {{$usuario['segundoNombre']}} {{$usuario['primerApellido']}} {{$usuario['segundoApellido']}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                        </button>
                        <button type="button" class="btn btn-success" id="btnAdd">Guardar</button>
                    </div>
                    {{-- <div class="modal-footer"><a data-dismiss="modal" class="btn btn-primary" id="btnAdd">Confirm</a></div>  --}}

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
                    <h5 class="modal-title" id="exampleModalLabel3">Actualizar Apartamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="alert alert-danger d-none" id="errors-modal-update" >
                    <strong>Campos Obligatorios!</strong> Validar los siguientes Campos.<br>
                    <ul id="ul-errors-update">
                    </ul>
                </div>
                <form method="post" action="{{ route('apartamento.update') }}" id="update-apto-form">
                    @method('POST')
                    @csrf
                    <input type="hidden" name="cid" id="id_editar">
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col mb-3">
                                <label for="numeroAptoNew" class="form-label">Numero de Apartamento</label>
                                <input type="number" name="numeroAptoNew" id="numeroAptoNew" class="form-control" value="" />
                            </div>
                            <div class="col mb-3">
                                <label for="numeroTorreNew" class="form-label">Numero de Torre</label>
                                <input type="number" name="numeroTorreNew" id="numeroTorreNew" class="form-control" />
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="estadoNew" class="form-label">Estado</label>
                                <select class="form-select" id="estadoNew" name="estadoNew">
                                <option>Seleccione</option>
                                <option value="Habitado">Habitado</option>
                                <option value="No Habitado">No Habitado</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="proAptoNew" class="form-label">Propietario Apartamento</label>
                                <select class="form-select" id="proAptoNew" name="proAptoNew" value="{{$usuario['id']}}">
                                <option>Seleccione</option>
                                @foreach ($usuarios as $usuario)
                                    
                                    <option value="{{$usuario['id']}}">{{$usuario['tipoDoc']}}{{$usuario['numeroDoc']}} --- {{$usuario['primerNombre']}} {{$usuario['segundoNombre']}} {{$usuario['primerApellido']}} {{$usuario['segundoApellido']}}</option>
                                    
                                @endforeach 
                                    
                                
                                </select>
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
@endsection

@section('content-js')
<script>
    let ruta = "{{ route('apartamento.store') }}";
</script>
<script src="{{ asset('js/apartamento.js') }}"></script>
@endsection