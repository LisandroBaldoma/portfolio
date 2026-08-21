<div style="font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; color: #111827;">
    <h2>Nuevo mensaje desde el formulario de contacto</h2>

    <p><strong>Nombre:</strong> {{ $data['name'] ?? '-' }}</p>
    <p><strong>Email:</strong> {{ $data['email'] ?? '-' }}</p>
    <p><strong>Teléfono:</strong> {{ $data['phone'] ?? '-' }}</p>
    <p><strong>Compañía:</strong> {{ $data['company'] ?? '-' }}</p>

    <p><strong>Servicios solicitados:</strong>
        @if(!empty($data['services']) && is_array($data['services']))
            {{ implode(', ', $data['services']) }}
        @else
            -
        @endif
    </p>

    <hr />

    <p><strong>Mensaje:</strong></p>
    <div>{!! nl2br(e($data['message'] ?? '')) !!}</div>

</div>
