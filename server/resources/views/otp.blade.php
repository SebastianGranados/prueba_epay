<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Correo</title>
  <style>
    /* Estilos basados en Tailwind precompilado en línea */
    .bg-gray-100 { background-color: #f7fafc; }
    .bg-white { background-color: #ffffff; }
    .text-gray-800 { color: #2d3748; }
    .text-gray-600 { color: #718096; }
    .font-bold { font-weight: 700; }
    .rounded-xl { border-radius: 0.75rem; }
    .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1),0 4px 6px -2px rgba(0,0,0,0.05); }
    .p-8 { padding: 2rem; }
    .text-center { text-align: center; }
    .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
    .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
    .mt-4 { margin-top: 1rem; }
    .mt-6 { margin-top: 1.5rem; }
    .mx-auto { margin-left: auto; margin-right: auto; }
    .w-full { width: 100%; }
    .max-w-md { max-width: 28rem; }
    .bg-indigo-600 { background-color: #4f46e5; }
    .text-white { color: #ffffff; }
    .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
    .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
    .rounded-lg { border-radius: 0.5rem; }
    .uppercase { text-transform: uppercase; }
    .tracking-wide { letter-spacing: 0.05em; }
    .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
  </style>
</head>
<body class="bg-gray-100 text-gray-800">
  <div class="w-full max-w-md mx-auto bg-white rounded-xl shadow-lg p-8">
    <div class="text-center">
      <h1 class="text-3xl font-bold text-gray-800">Tu código OTP</h1>
      <p class="mt-4 text-gray-600">Usa el siguiente código para continuar de manera segura:</p>
      <div class="mt-6 bg-indigo-600 text-white py-3 px-6 rounded-lg text-xl font-bold tracking-wide">
        {{ $otp }}
      </div>
      <p class="mt-6 text-gray-600 text-sm">
        Este código expirará en <strong>5 minutos</strong>.  
        Por favor, no lo compartas con nadie.
      </p>
    </div>
  </div>
</body>
</html>
