<main>
    <section class="section">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6">
                    <div class="section-title text-center">
                        <p class="text-primary text-uppercase fw-bold mb-3">Buscador</p>
                        <h2>Ingresa la información solicitada</h2>
                        <p>Busca por número personal, correo electrónico, folio completo o los últimos 4 caracteres del folio.</p>
                    </div>
                </div>



                <div class="col-lg-10">
                    <div class="shadow rounded p-5 bg-white">
                        <form wire:submit.prevent="buscar">
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <h4>Buscar Participante</h4>
                                </div>
                                <div class="col-lg-9 col-md-8 mb-4">
                                    <input type="text" class="form-control"
                                           placeholder="Buscar por correo electrónico, número personal o folio"
                                           wire:model.defer="query">
                                </div>
                                <div class="col-lg-3 col-md-4 mb-4">
                                    <button type="submit" class="btn btn-primary w-100">
                                        Buscar
                                    </button>
                                </div>
                            </div>  
                        </form>


                        @if (!empty($resultados))
                            <div class="mt-4">
                                <div class="table-responsive" >
                                    <div class="table table-bordered">
                                        <table class="tabla-personalizada table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 200px;">Nombre</th>
                                                    <th style="width: 300px;">Folio</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($resultados) && count($resultados) > 0)
                                                    @foreach ($resultados as $participante)
                                                        <tr>
                                                            <td>{{ $participante->nombre }} {{ $participante->apaterno }} {{ $participante->amaterno }}</td>
                                                            <td>{{ $participante->folio }}</td>
                                                        </tr>
                                                    @endforeach
                                                @elseif(strlen($query) >= 3)
                                                    <tr>
                                                        <td colspan="2" class="text-center text-muted">No hay datos que mostrar.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @elseif(strlen($query) >= 3)
                            <div class="mt-4">
                                <p class="text-muted">No se encontraron resultados.</p>
                            </div>
                        @endif
                    </div>
                </div>                
            </div>
        </div>
    </section>
    
    
    <style>
        .tabla-personalizada {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
            color: black;
            border-radius: 8px;
            overflow: hidden;
        }
    
        .tabla-personalizada th,
        .tabla-personalizada td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
    
        .tabla-personalizada th {
            background-color: #e9ecef; /* color de fondo como Bootstrap */
            font-weight: bold;
        }
    
        .tabla-personalizada tbody tr:nth-child(even) {
            background-color: #f8f9fa; /* efecto striped */
        }
    
        .tabla-wrapper {
            overflow-x: auto;
            border-radius: 8px;
        }
    </style>

</main>
