@extends(backpack_view('blank'))

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <form id="form" method="POST" action="#">
                <div class="mb-3">
                    <label for="selectEspecialidad" class="form-label">Seleccionar especialidad</label>
                    <select id="selectEspecialidad" class="form-select">
                        @foreach($especialidades as $especialidad)
                            <option value="{{ $especialidad->id }}">{{ $especialidad->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="selectDoctor" class="form-label">Seleccionar profesional</label>
                    <select id="selectDoctor" class="form-select">
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Confirmar</button>
            </form>
            <input type="hidden" id="filter-input" value="">
        </div>
    </div>
</div>
<div class="container mt-5">
    <input type="hidden" id="filter-input" value="">
    <div id='calendar'></div>
</div>

<div class="modal fade" id="modalAddEvent" tabindex="-1" aria-labelledby="modalAddEventLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddEventLabel">Nuevo agendamiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="modalAdd-body" class="modal-body">
                <form mothod="POST" id="form2" action="#">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Nombre" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Apellido" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Correo" required>
                    </div>
                    <div class="mb-3">
                        <select id="service_hash" class="form-select" aria-label="Default select example">
                            <option value="" selected>Seleccione un servicio</option>
                            @foreach($agendas as $agenda)
                            <option value="{{ $agenda->id }}">{{ $agenda->hora }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="datepicker" class="form-control" id="date" name="date">
                    </div>
                    <div class="mb-3">
                        <label for="time">Hora de inicio:</label>
                        <input type="time" class="form-control" id="start-time" name="start_time">
                    </div>
                    <div class="mb-3">
                        <label for="time">Hora de término:</label>
                        <input type="time" class="form-control" id="end-time" name="end_time">
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" id="comment" name="comment" placeholder="Comentario"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="save" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalShowEvent" tabindex="-1" aria-labelledby="modalShowEventLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalShow-title" class="modal-title" id="modalShowEventLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Nombre:</label>
                    <input type="text" class="form-control" id="firstName-label" readonly>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Apellido:</label>
                    <input type="text" class="form-control" id="lastName-label" readonly>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Email:</label>
                    <input type="text" class="form-control" id="email-label" readonly>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Fecha:</label>
                    <input type="text" class="form-control" id="date-label" readonly>
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Desde:</label>
                    <input type="text" class="form-control" id="start-label" readonly>
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Hasta:</label>
                    <input type="text" class="form-control" id="end-label" readonly>
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Comentario:</label>
                    <textarea class="form-control" id="comment-label" readonly></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filtrar por servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <select id="service-filter" class="form-select" aria-label="Default select example">
                        <option value="" selected>Sin filtro</option>
                        @foreach($agendas as $agenda)
                        <option value="{{ $agenda->id }}">{{ $agenda->hora }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button id="service-filter-button" type="button" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>

    $(document).ready(function() {
        
        var selectEspecialidad = $("#selectEspecialidad");
        var selectDoctor = $('#selectDoctor');
        var especialidadId = 1;

        selectEspecialidad.change(function(){
            especialidadId = selectEspecialidad.val();

            selectDoctor.find("option").each(function() {
                $(this).remove();
            });

            $.ajax({
            url: '{{ url("/admin/services/getDoctors/especialidadId") }}/'+ especialidadId,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                $.each(response.data, function (key, value) {
                    selectDoctor.append("<option value='" + value.id + "'>" + value.nombre + "</option>");
                });
            },
            error: function () {
                alert('Hubo un error obteniendo la información.');
            }
            });
        });

        $("#form").on('submit', function(e){
            e.preventDefault();
            var doctorId = selectDoctor.val();
            calendar();
        });
    });

    function calendar(hash){
        var today = new Date();
        console.log(today);
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
            locale: 'cl',
            slotMinTime: '09:00:00',
            slotMaxTime: '18:00:00',
            height: 'auto', 
            timeZone: 'UTC-3',
            firstDay: 1,
            displayEventTime: true,
            selectable: false,
            initialView: 'timeGridWeek',
            headerToolbar: {
                start: 'title',
                center: 'filterService list',
                end: 'today prev,next dayGridMonth timeGridWeek timeGridDay',
            },
            buttonText: {
                today: 'hoy',
                month:'mes',
                week: 'semana',
                day: 'día',
                list: 'lista',
            },
            events: [],

            dayRender: function(date, cell){
                console.log(date, cell);
                if (date > today){
                    $(cell).addClass('disabled');
                }
            },
         
            eventClick: function(info){
                $('#modalShowEvent').appendTo("body");

                var date = moment(info.event.extendedProps.start_at,'YYYY-MM-DDTHH:mm:ss').format('DD-MM-YYYY');
                var start = moment(info.event.extendedProps.start_at,'YYYY-MM-DDTHH:mm:ss').format('HH:mm');
                var end = moment(info.event.extendedProps.ends_at,'YYYY-MM-DDTHH:mm:ss').format('HH:mm');

                $('#modalShow-title').text(info.event.title);
                $('#firstName-label').val(info.event.extendedProps.customerFirstName);
                $('#lastName-label').val(info.event.extendedProps.customerLastName);
                $('#email-label').val(info.event.extendedProps.customerEmail);
                $('#date-label').val(date);
                $('#start-label').val(start);
                $('#end-label').val(end);
                $('#comment-label').text(info.event.extendedProps.comment);

                var modal = new bootstrap.Modal(document.getElementById('modalShowEvent'));
                modal.toggle();
            },

            dateClick: function(info){

                $('#modalAddEvent').appendTo("body");
               
                var modal = new bootstrap.Modal(document.getElementById('modalAddEvent'));
                modal.toggle();

                var date = moment(info.dateStr,'YYYY-MM-DDTHH:mm:ss').format('DD-MM-YYYY');
                var startTime = moment(info.dateStr,'YYYY-MM-DDTHH:mm:ss').format('HH:mm');

                $('#date').val(date);

                $('#start-time').val(startTime);
            },
            customButtons: {
                filterService: {
                    text: 'Filtrar por servicio',
                    click: function() {
                        $('#filterModal').appendTo("body");
                        var modal = new bootstrap.Modal(document.getElementById('filterModal'));
                        modal.toggle();
                    }
                }
            }
        });
        calendar.render();
    }
    
</script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.6.0/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

@endsection