<x-tenant-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fa-solid fa-form"></i> {{ __('Formulario Dinamico') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <form action="{{ route('submit.form') }}" method="POST">
            @csrf

           
            @foreach ($fields as $category => $categoryFields)
                <h3 class="text-lg font-semibold mt-4">{{ ucfirst($category) }}</h3>

                @foreach ($categoryFields as $field)
                    <div class="form-group mb-4">
                        <label for="{{ $field->label }}">{{ $field->label }}</label>
                        
                        @if ($field->type == 'text')
                            <input type="text" name="{{ $field->label }}" class="form-control" id="{{ $field->label }}">

                        @elseif ($field->type == 'number')
                            <input type="number" name="{{ $field->label }}" class="form-control" id="{{ $field->label }}">

                        @elseif ($field->type == 'textarea')
                            <textarea name="{{ $field->label }}" class="form-control" id="{{ $field->label }}"></textarea>

                        @elseif ($field->type == 'date')
                            <input type="date" name="{{ $field->label }}" class="form-control" id="{{ $field->label }}">

                        @elseif ($field->type == 'email')
                            <input type="email" name="{{ $field->label }}" class="form-control" id="{{ $field->label }}">
                        
                        @endif
                    </div>
                @endforeach

                <hr> 
            @endforeach

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        <!-- Esta es el render solo de prueba luego lo mueves -->
        <h3 class="mt-8 text-lg font-semibold">Envios del Formulario</h3>
        <div class="bg-white p-4 rounded shadow mt-4">
            @foreach ($formSubmissions as $submission)
                @php
                    $data = json_decode($submission->data, true);
                @endphp
                <div class="mb-2">
                    <strong>ID de Envío:</strong> {{ $submission->id }} <br>
                    @foreach ($data as $key => $value)
                        <strong>{{ ucfirst($key) }}:</strong> {{ $value }} <br>
                    @endforeach
                </div>
                <hr>
            @endforeach
        </div>
    </div>
</x-tenant-app-layout>
