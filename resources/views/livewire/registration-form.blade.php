<div>

    <form wire:submit.prevent="guardar">

        {{-- Select de tema --}}
        <div class="form-group mb-4 pb-2">
            <label for="selectedTema" class="form-label">Tema</label>
            <select id="selectedTema" name="selectedTema" wire:model="selectedTema" class="form-control">
                <option value="">Selecciona un tema</option>
                @foreach ($temas as $tema)
                    <option value="{{ $tema->id }}">{{ $tema->titulo }}</option>
                @endforeach
            </select>
            @error('selectedTema') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        {{-- Select de regiones --}}
        <div class="form-group mb-4 pb-2">
            <label for="selectedRegion" class="form-label">Región</label>
            <select id="selectedRegion" name="selectedRegion" wire:model.live="selectedRegion" class="form-control">
                <option value="">Selecciona una región</option>
                @foreach ($regions as $region)
                    <option value="{{ $region->id }}">{{ $region->region }} - {{ $region->sede }}</option>
                @endforeach
            </select>
        </div>

        {{-- Select de delegaciones --}}
        <div class="form-group mb-4 pb-2">
            <label for="selectedDelegacion" class="form-label">Delegación</label>
            <select id="selectedDelegacion" name="selectedDelegacion" wire:model="selectedDelegacion" class="form-control">
                <option value="">Selecciona una delegación</option>
                @foreach ($delegacions as $delegacion)
                    <option value="{{ $delegacion->id }}">
                        {{ $delegacion->deleg_delegacional }} - {{ $delegacion->nivel_delegacional }} - {{ $delegacion->sede_delegacional }}
                    </option>
                @endforeach
            </select>
            @error('selectedDelegacion') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        {{-- Nombre --}}
        <div class="form-group mb-4 pb-2">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" id="nombre" name="nombre" wire:model.blur="nombre" class="form-control" placeholder="Ingresa el nombre" autocomplete="given-name">
            @error('nombre') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        {{-- Apellido paterno --}}
        <div class="form-group mb-4 pb-2">
            <label for="apaterno" class="form-label">Primer apellido</label>
            <input type="text" id="apaterno" name="apaterno" wire:model.blur="apaterno" class="form-control" placeholder="Ingresa tu apellido paterno" autocomplete="family-name">
            @error('apaterno') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        {{-- Apellido materno --}}
        <div class="form-group mb-4 pb-2">
            <label for="amaterno" class="form-label">Segundo apellido</label>
            <input type="text" id="amaterno" name="amaterno" wire:model="amaterno" class="form-control" placeholder="Ingresa tu apellido materno" autocomplete="additional-name">
        </div>

        {{-- RFC --}}
        <div class="form-group mb-4 pb-2">
            <label for="rfc" class="form-label">RFC</label>
            <input type="text" id="rfc" name="rfc" wire:model.blur="rfc" class="form-control" placeholder="Ingresa tu RFC con homoclave" autocomplete="off">
            @error('rfc') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        {{-- Género --}}
        <div class="form-group mb-4 pb-2">
            <label for="genero" class="form-label">Género</label>
            <select id="genero" name="genero" wire:model="genero" class="form-control">
                <option value="">Selecciona género</option>
                <option value="Hombre">Hombre</option>
                <option value="Mujer">Mujer</option>
            </select>
            @error('genero') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        {{-- Email --}}
        <div class="form-group mb-4 pb-2">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" wire:model.blur="email" class="form-control" placeholder="Ingresa tu email" autocomplete="email">
            @error('email') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        {{-- Número de personal --}}
        <div class="form-group mb-4 pb-2">
            <label for="npersonal" class="form-label">Número de personal</label>
            <input type="text" id="npersonal" name="npersonal" wire:model.blur="npersonal" class="form-control" placeholder="Ingresa tu número de personal" autocomplete="off">
            @error('npersonal') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        {{-- Teléfono --}}
        <div class="form-group mb-4 pb-2">
            <label for="telefono" class="form-label">Número telefónico</label>
            <input type="tel" id="telefono" name="telefono" wire:model.blur="telefono" class="form-control" maxlength="10" placeholder="Ej. 5512345678" autocomplete="tel">
            @error('telefono') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        {{-- Nivel educativo --}}
        <div class="form-group mb-4 pb-2">
            <label for="nivel" class="form-label">Nivel educativo</label>
            <select id="nivel" name="nivel" wire:model="nivel" class="form-control">
                <option value="">Selecciona nivel</option>
                <option value="Preescolar">Preescolar</option>
                <option value="Primaria">Primaria</option>
                <option value="Educación Especial">Educación Especial</option>
                <option value="Secundaria">Secundaria</option>
                <option value="Telesecundaria">Telesecundaria</option>
                <option value="Educación Física">Educación Física</option>
                <option value="Niveles Especiales">Niveles Especiales</option>
                <option value="Paae">Paae</option>
                <option value="Bachillerato">Bachillerato</option>
                <option value="Telebachillerato">Telebachillerato</option>
                <option value="Normales">Normales</option>
                <option value="UPV">UPV</option>
                <option value="Jubilados">Jubilados</option>
            </select>
            @error('nivel') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        {{-- Botón --}}
        <div class="form-group mb-4 pb-2">
            <button type="submit" class="btn btn-primary">Registrar</button>
        </div>

    </form>

</div>

@script

    <script type="text/javascript" >
        document.addEventListener("sweet.success", event => {
            let mensaje = event.detail.message;
            console.log(mensaje);


            Swal.fire({
                title: "Excelente...!",
                // text: "You clicked the button!",
                html: event.detail.message,
                icon: "success"
            });
        });
    </script>

@endscript