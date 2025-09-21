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
    .code-box { 
      display: inline-block;
      margin-top: 1.5rem;
      font-size: 1.75rem;
      font-weight: bold;
      letter-spacing: 0.2em;
      color: #1a202c;
      background-color: #edf2f7;
      border: 2px dashed #a0aec0;
      padding: 0.75rem 1.5rem;
      border-radius: 0.5rem;
    }
    .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
  </style>
</head>
<body class="bg-gray-100 text-gray-800">
  <div class="w-full max-w-md mx-auto bg-white rounded-xl shadow-lg p-8">
    <div class="text-center">
      <h1 class="text-3xl font-bold text-gray-800">Tu código OTP</h1>
      <p class="mt-4 text-gray-600">Usa el siguiente código para continuar de manera segura:</p>
      
      <div class="code-box">
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
