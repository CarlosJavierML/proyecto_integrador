@extends('layouts.layouts')

@section('content-css')
{{-- agenda --}}
<!--begin::Global Stylesheets Bundle(used by all pages)-->
<script src="{{ asset('js/app.js') }}" defer></script>
<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
{{-- <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" /> --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/locales-all.js"></script>

<script type="text/javascript">
    var baseURL = {!! json_encode(url('/')) !!}
</script> 
<!--end::Global Stylesheets Bundle-->

{{-- datatable --}}
	<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/> 

@section('content')

<div class="container col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="card">    
    <div class="card-header border-0">
        <h3 class="card-title fw-bolder text-dark">Agendar Espacio Club House</h3>
    </div>
    
    <div class="card-body pt-2">
        <div>Para agregar un espacio solo debes hacer click en una fecha.</div><br>
        <div id="agenda" name="agenda">
        </div>
    <!-- Modal -->
    <div class="modal fade" id="evento" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Datos del Evento</h5>
                </div>
                <div class="modal-body">
                   <form action="" id="formularioEventos" name="formularioEventos">
                    {{ csrf_field() }}
                       <div class="form-group d-none">
                         <label for="id">ID</label>
                         <input type="text" class="form-control" name="id" id="id" aria-describedby="helpId" placeholder="">
                         <small id="helpId" class="form-text text-muted">&nbsp;</small>
                       </div>
                       <div class="form-group">
                         {{-- <label for="title">Título</label> --}}
                         <input type="text" class="form-control" name="title" id="title" aria-describedby="helpId" placeholder="" required="required">
                         <small id="helpId" class="form-text text-muted">Título</small>
                       </div>
                       <div class="form-group">
                         {{-- <label for="descripcion">Descripción</label> --}}
                         <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
                         <small id="helpId" class="form-text text-muted">Descripción</small>
                       </div>
                       <div class="row">
                            <div class="form-group col-md-6">
                                <input type="date" class="form-control" name="start" id="start" aria-describedby="helpId" placeholder="">
                                <small id="helpId" class="form-text text-muted">Fecha Inicio</small>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="time" class="form-control" name="startH" id="startH" aria-describedby="helpId" placeholder="">
                                <small id="helpId" class="form-text text-muted">Hora Inicio</small>
                            </div>
                       </div>
                       <div class="row">
                            <div class="form-group col-md-6">
                                <input type="date" class="form-control" name="end" id="end" aria-describedby="helpId" placeholder="">
                                <small id="helpId" class="form-text text-muted">Fecha Fin</small>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="time" class="form-control" name="endH" id="endH" aria-describedby="helpId" placeholder="">
                                <small id="helpId" class="form-text text-muted">Hora Fin</small>
                            </div>
                       </div>
                       @if(Session::get('roleuser') == 1)
                            <div class="row">
                                    <div class="col mb-0">
                                        <input type="text" class="form-control" id="solicitante" aria-describedby="solicitante" placeholder="" readonly>
                                        <small id="solicitante" class="form-text text-muted">Solicitante</small>
                                    </div>
                            </div>
                        @endif
                       <div class="row">
                            <div class="col mb-0">
                                <select class="form-control" id="estado" name="estado">
                                        @if(Session::get('roleuser') == 4){
                                            <option value="1">Solicitar</option>
                                        }
                                        @elseif (Session::get('roleuser') == 1 || Session::get('roleuser') ==  2 || Session::get('roleuser') == 3)
                                        <option value="">seleccione</option>
                                        <option value="1">Solicitar</option>
                                        <option value="2">Aceptar</option>
                                        <option value="3">Rechazar</option>
                                        @endif
                                </select>
                                <small for="estado" class="form-text text-muted">Estado</small>
                            </div>
                       </div>
                   </form>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="" id="rol" value="{{Session::get('roleuser')}}">
                    @if(Session::get('roleuser') != 4)
                        <button type="button" class="btn btn-success" id="btnGuardar">Guardar</button>
                        <button type="button" class="btn btn-primary" id="btnModificar">Modificar</button>
                        <button type="button" class="btn btn-danger" id="btnEliminar">Eliminar</button>
                        <button type="button" class="btn btn-secondary" id="btnCerrar">Cerrar</button>
                    @else
                        <button type="button" class="btn btn-success" id="btnGuardar">Guardar</button>
                        <button type="button" class="btn btn-secondary" id="btnCerrar">Cerrar</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
            </div>

</div>
</div>
</div>

@endsection

@section('content-js')
{{-- agenda --}}

{{-- <script src="assets/plugins/global/plugins.bundle.js"></script> --}}
<script src="assets/js/scripts.bundle.js"></script>

<script src="assets/js/custom/widgets.js"></script>
<script src="assets/js/custom/modals/create-app.js"></script>
<script src="assets/js/custom/modals/upgrade-plan.js"></script>
<script src="{{ asset('js/agenda.js') }}" defer></script>
@endsection
