* Reemplazar variables dentro de un parrafo de word.
ejemplo


Plantilla=> Se presento {TIPO} {nombres} {Apellidos} con {tipoDoc} N° {numero}.
Resultado=> Se presento DON fernando con Documento de Identidad N° 54545454.

Uso de Imagen Qr a partir del envio de un texo ejemplo

Nombres: Jose Manuel
Factura: F001-3265
Servicio: Permiso de Viaje

=>Mostrar en Imagen en Qr
use PhpOffice\PhpWord\PhpWord;
$phpWord = new PhpWord();
$section = $phpWord->addSection();
$user = User::limit(5)->get();
foreach ($user as $key => $value) {
$section->addText($value->s_nombres);
}
$section->addImage('storage/logo/63c22e849741e.png', ['width' => 25, 'height' => 25]);
$phpWord->save('users.docx');
return response()->download('users.docx');