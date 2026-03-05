<?php

namespace Database\Seeders;

use App\Models\Pregunta;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PreguntasSeeder extends Seeder
{
    public function run()
    {
        // crear un usuario
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@bebras.mx',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Crear algunos alumnos de ejemplo
        User::create([
            'name' => 'Alumno Ejemplo',
            'email' => 'alumno@bebras.mx',
            'password' => Hash::make('alumno123'),
            'role' => 'alumno',
        ]);

        $preguntas = [
            // PREGUNTA 01 - Libros Populares
            [
                'numero' => '01',
                'titulo' => 'Libros Populares',
                'descripcion' => 'Los niños piden libros en la Biblioteca. La maestra encargada hizo una tabla para saber qué libro pide cada niño.',
                'imagen_descripcion' => 'preguntas/01/tabla.png',
                'pregunta' => '¿Cuál libro es el que los niños piden más seguido de acuerdo a esta tabla?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'imagen', 'valor' => 'preguntas/01/caracol.png'],
                        ['id' => 'B', 'tipo' => 'imagen', 'valor' => 'preguntas/01/oruga.png'],
                        ['id' => 'C', 'tipo' => 'imagen', 'valor' => 'preguntas/01/mariposa.png'],
                        ['id' => 'D', 'tipo' => 'imagen', 'valor' => 'preguntas/01/catarina.png'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['B']),
                'explicacion' => 'En la tabla puedes contar cuántas veces aparece cada libro. El de la oruga se repite 3 veces, el caracol 1 vez, la mariposa 2 veces y la catarina 1 vez. Como el libro de la oruga es el que aparece más veces, esa es la opción correcta.',
                'imagen_respuesta' => null,
                'nivel' => 'I',
                'dificultad' => 'Baja',
                'pais_origen' => 'Alemania',
                'codigo_tarea' => '2022-DE-06',
            ],

            // PREGUNTA 02 - Tutorial de Dibujo
            [
                'numero' => '02',
                'titulo' => 'Tutorial de Dibujo',
                'descripcion' => 'Deepa está aprendiendo a hacer un tipo de pintura tradicional de la India, llamado Warli. Tiene 6 tarjetas que le muestran paso a paso cómo hacerlo, pero se le cayeron al piso y ¡ahora se han revuelto!',
                'imagen_descripcion' => 'preguntas/02/dibujo_final.png',
                'pregunta' => 'Coloca las tarjetas de nuevo en orden.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'ordenar',
                'configuracion' => json_encode([
                    'elementos' => [
                        ['id' => 'A', 'imagen' => 'preguntas/02/tarjeta_a.png'],
                        ['id' => 'B', 'imagen' => 'preguntas/02/tarjeta_b.png'],
                        ['id' => 'C', 'imagen' => 'preguntas/02/tarjeta_c.png'],
                        ['id' => 'D', 'imagen' => 'preguntas/02/tarjeta_d.png'],
                        ['id' => 'E', 'imagen' => 'preguntas/02/tarjeta_e.png'],
                        ['id' => 'F', 'imagen' => 'preguntas/02/tarjeta_f.png'],
                    ],
                    'mostrar_numeros' => true,
                ]),
                'respuesta_correcta' => json_encode(['E', 'F', 'A', 'B', 'C', 'D']),
                'explicacion' => 'Si observas con atención, en cada tarjeta se va agregando un detalle nuevo al dibujo. Primero se traza la figura base, luego se van añadiendo líneas y adornos hasta llegar a la imagen final. Ordenar las tarjetas de forma que el dibujo vaya creciendo paso a paso da como resultado la secuencia E, F, A, B, C, D.',
                'imagen_respuesta' => null,
                'nivel' => 'I',
                'dificultad' => 'Baja',
                'pais_origen' => 'India',
                'codigo_tarea' => '2022-IN-01',
            ],

            // PREGUNTA 03 - Receta de Hamburguesas
            [
                'numero' => '03',
                'titulo' => 'Receta de Hamburguesas',
                'descripcion' => 'Jessica está preparando hamburguesas de acuerdo a las siguientes reglas:
1. La salsa debe estar justo arriba de la carne
2. La carne y el queso deben estar debajo de los pepinillos, la lechuga y la cebolla
3. Las cebollas no deben tocar el pan
4. Todos los ingredientes tienen que estar entre los panes',
                'imagen_descripcion' => 'preguntas/03/ingredientes.png',
                'pregunta' => '¿Cuál de las siguientes hamburguesas es correcta con las reglas?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'imagen', 'valor' => 'preguntas/03/hamburguesa_a.png'],
                        ['id' => 'B', 'tipo' => 'imagen', 'valor' => 'preguntas/03/hamburguesa_b.png'],
                        ['id' => 'C', 'tipo' => 'imagen', 'valor' => 'preguntas/03/hamburguesa_c.png'],
                        ['id' => 'D', 'tipo' => 'imagen', 'valor' => 'preguntas/03/hamburguesa_d.png'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['D']),
                'explicacion' => 'Primero revisa si la salsa está justo encima de la carne. Luego verifica que la carne y el queso estén debajo de los vegetales (pepinillos, lechuga y cebolla). Por último, asegúrate de que las cebollas no toquen el pan y que todos los ingredientes estén dentro de los panes. Solo la hamburguesa de la opción D cumple con todas estas reglas al mismo tiempo.',
                'imagen_respuesta' => 'preguntas/03/respuesta.png',
                'nivel' => 'I',
                'dificultad' => 'Baja',
                'pais_origen' => 'Corea del Sur',
                'codigo_tarea' => '2022-KR-03',
            ],

            // PREGUNTA 04 - 5 Dulces
            [
                'numero' => '04',
                'titulo' => '5 Dulces',
                'descripcion' => 'Los dulces favoritos de Brian vienen en 5 sabores. Brian pone uno de cada sabor en un tubo que lleva a la escuela. Durante el día, Brian se come los dulces en el orden en el que salen de la parte superior del tubo.

Hoy quiere comerlos en este orden: Uva, Naranja, Limón, Fresa y Zarzamora.',
                'imagen_descripcion' => 'preguntas/04/orden_deseado.png',
                'pregunta' => 'Coloca los dulces en el tubo para que Brian los pueda comer en el orden que quiere.',
                'imagen_pregunta' => 'preguntas/04/tubo.png',
                'tipo_interaccion' => 'ordenar',
                'configuracion' => json_encode([
                    'elementos' => [
                        ['id' => 'uva', 'imagen' => 'preguntas/04/dulce_uva.png', 'nombre' => 'Uva'],
                        ['id' => 'naranja', 'imagen' => 'preguntas/04/dulce_naranja.png', 'nombre' => 'Naranja'],
                        ['id' => 'limon', 'imagen' => 'preguntas/04/dulce_limon.png', 'nombre' => 'Limón'],
                        ['id' => 'fresa', 'imagen' => 'preguntas/04/dulce_fresa.png', 'nombre' => 'Fresa'],
                        ['id' => 'zarzamora', 'imagen' => 'preguntas/04/dulce_zarzamora.png', 'nombre' => 'Zarzamora'],
                    ],
                    'tipo_contenedor' => 'vertical', // Los dulces se apilan verticalmente
                    'instruccion' => 'Arrastra los dulces al tubo. El primero que coloques será el último en salir.',
                ]),
                'respuesta_correcta' => json_encode(['zarzamora', 'fresa', 'limon', 'naranja', 'uva']),
                'explicacion' => 'El primer dulce que metes al tubo será el último en salir, como una pila de objetos. Si Brian quiere comer en este orden: Uva, Naranja, Limón, Fresa y Zarzamora, debes meterlos justo al revés: primero Zarzamora, luego Fresa, después Limón, luego Naranja y al final Uva. Así, al salir, el orden será el que él desea.',
                'imagen_respuesta' => 'preguntas/04/respuesta.png',
                'nivel' => 'I',
                'dificultad' => 'Baja',
                'pais_origen' => 'Reino Unido',
                'codigo_tarea' => '2022-UK-02',
            ],

            // PREGUNTA 05 - ¿Dónde quedó la bolita?
            [
                'numero' => '05',
                'titulo' => '¿Dónde quedó la bolita?',
                'descripcion' => 'Lila y sus amigas están jugando este juego. Al inicio Lila pone la canica en la Bolsa A, una gema en la Bolsa B y una bola de papel en la Bolsa C.

Luego, le pide a sus amigas que cierren los ojos. Y mientras tienen los ojos cerrados, mezcla el contenido de las bolsas:
1. Intercambia los objetos de la Bolsa A y B
2. Intercambia los objetos de las bolsas A y C
3. Intercambia los objetos de las bolsas B y C',
                'imagen_descripcion' => 'preguntas/05/estado_inicial.png',
                'pregunta' => '¿En dónde quedó cada uno de los objetos? Une cada objeto a su posición final.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'emparejar',
                'configuracion' => json_encode([
                    'objetos' => [
                        ['id' => 'canica', 'imagen' => 'preguntas/05/canica.png', 'nombre' => 'Canica'],
                        ['id' => 'gema', 'imagen' => 'preguntas/05/gema.png', 'nombre' => 'Gema'],
                        ['id' => 'papel', 'imagen' => 'preguntas/05/papel.png', 'nombre' => 'Papel'],
                    ],
                    'destinos' => [
                        ['id' => 'A', 'nombre' => 'Bolsa A'],
                        ['id' => 'B', 'nombre' => 'Bolsa B'],
                        ['id' => 'C', 'nombre' => 'Bolsa C'],
                    ],
                ]),
                'respuesta_correcta' => json_encode([
                    ['objeto' => 'canica', 'destino' => 'C'],
                    ['objeto' => 'gema', 'destino' => 'B'],
                    ['objeto' => 'papel', 'destino' => 'A'],
                ]),
                'explicacion' => 'Sigue los intercambios paso a paso. Después del intercambio A↔B, la canica pasa a B, la gema a A y el papel sigue en C. Luego, en A↔C, el papel pasa a A y la canica a C, mientras la gema queda en B. Por último, en B↔C, la gema y la canica se intercambian, pero el papel permanece en A. Al final, el papel está en la Bolsa A, la gema en la Bolsa B y la canica en la Bolsa C.',
                'imagen_respuesta' => 'preguntas/05/respuesta.png',
                'nivel' => 'I',
                'dificultad' => 'Media',
                'pais_origen' => 'Alemania',
                'codigo_tarea' => '2022-CH-14',
            ],

            // PREGUNTA 06 - Palillos Chinos
            [
                'numero' => '06',
                'titulo' => 'Palillos Chinos',
                'descripcion' => 'Ana está jugando el juego de Palillos Chinos. Tira algunos palillos en la mesa y luego los tiene que recoger de acuerdo a las siguientes reglas:
1. Solo se puede recoger un palillo a la vez
2. Se puede recoger un palillo si no hay ningún otro palillo que esté arriba de él.',
                'imagen_descripcion' => 'preguntas/06/palillos_inicial.png',
                'pregunta' => '¿En qué orden debe recogerlos?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'ordenar',
                'configuracion' => json_encode([
                    'elementos' => [
                        ['id' => 'gris_puntos', 'imagen' => 'preguntas/06/palillo_gris_puntos.png'],
                        ['id' => 'blanco', 'imagen' => 'preguntas/06/palillo_blanco.png'],
                        ['id' => 'negro_puntos', 'imagen' => 'preguntas/06/palillo_negro_puntos.png'],
                        ['id' => 'gris', 'imagen' => 'preguntas/06/palillo_gris.png'],
                        ['id' => 'negro', 'imagen' => 'preguntas/06/palillo_negro.png'],
                        ['id' => 'blanco_puntos', 'imagen' => 'preguntas/06/palillo_blanco_puntos.png'],
                    ],
                    'mostrar_numeros' => true,
                ]),
                'respuesta_correcta' => json_encode(['gris_puntos', 'blanco', 'negro_puntos', 'gris', 'negro', 'blanco_puntos']),
                'explicacion' => 'Para decidir el orden, siempre debes tomar el palillo que no tiene ningún otro palillo encima. Empieza con el que claramente está más arriba de todos. Cada vez que quitas uno, aparece un nuevo palillo que queda libre. Si sigues esta idea, el orden correcto es: gris con puntos negros, blanco, negro con puntos blancos, gris, negro y al final blanco con puntos negros.',
                'imagen_respuesta' => 'preguntas/06/respuesta.png',
                'nivel' => 'II',
                'dificultad' => 'Baja',
                'pais_origen' => 'Brasil',
                'codigo_tarea' => '2022-BR-01',
            ],

            // PREGUNTA 07 - Collares de Amistad
            [
                'numero' => '07',
                'titulo' => 'Collares de Amistad',
                'descripcion' => 'Monika y Veronika trajeron collares de recuerdo de sus vacaciones. Ahora quieren que su amiga Anastasia también tenga un collar, por lo que usaron 6 cuentas de sus collares para hacer uno nuevo.

Después de quitar las cuentas, los collares quedaron así:
- Monika: ahora tiene 3 cuentas amarillas menos
- Veronika: ahora tiene 3 cuentas rojas menos',
                'imagen_descripcion' => 'preguntas/07/collares_antes.png',
                'pregunta' => '¿Cuál de los siguientes es el collar de Anastasia?',
                'imagen_pregunta' => 'preguntas/07/collares_despues.png',
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'imagen', 'valor' => 'preguntas/07/collar_a.png'],
                        ['id' => 'B', 'tipo' => 'imagen', 'valor' => 'preguntas/07/collar_b.png'],
                        ['id' => 'C', 'tipo' => 'imagen', 'valor' => 'preguntas/07/collar_c.png'],
                        ['id' => 'D', 'tipo' => 'imagen', 'valor' => 'preguntas/07/collar_d.png'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['A']),
                'explicacion' => 'Sabemos que el collar de Anastasia se hizo usando exactamente 3 cuentas amarillas del collar de Monika y 3 cuentas rojas del collar de Veronika. Por eso, el collar correcto debe tener solo esos dos colores y exactamente 3 cuentas de cada uno. Al revisar las opciones, solo el collar de la opción A cumple con esta condición.',
                'imagen_respuesta' => null,
                'nivel' => 'II',
                'dificultad' => 'Media',
                'pais_origen' => 'Macedonia del Norte',
                'codigo_tarea' => '2022-MK-05B',
            ],

            // PREGUNTA 08 - Dividiendo el terreno
            [
                'numero' => '08',
                'titulo' => 'Dividiendo el terreno',
                'descripcion' => 'Los Castores y las Nutrias quieren dividirse el área del terreno en el que viven. De forma que todos los Castores queden de un lado y todas las Nutrias en el otro.',
                'imagen_descripcion' => 'preguntas/08/terreno.png',
                'pregunta' => '¿Cuál forma de dividir el terreno, logra que se tengan que mudar la menor cantidad de Castores y de Nutrias a otro lugar?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'imagen', 'valor' => 'preguntas/08/division_a.png'],
                        ['id' => 'B', 'tipo' => 'imagen', 'valor' => 'preguntas/08/division_b.png'],
                        ['id' => 'C', 'tipo' => 'imagen', 'valor' => 'preguntas/08/division_c.png'],
                        ['id' => 'D', 'tipo' => 'imagen', 'valor' => 'preguntas/08/division_d.png'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['A']),
                'explicacion' => 'La línea que elijas debe separar a todos los castores de un lado y a todas las nutrias del otro, moviendo la menor cantidad posible de animales. Si cuentas cuántos animales quedan en el “lado equivocado” en cada dibujo, verás que en la opción A solo hay que mover un castor, mientras que en las demás opciones hay que mover 2 o 3 animales. Por eso, la mejor división es la A.',
                'imagen_respuesta' => 'preguntas/08/respuesta.png',
                'nivel' => 'II',
                'dificultad' => 'Baja',
                'pais_origen' => 'Corea del Sur',
                'codigo_tarea' => '2023-KR-01',
            ],

            // PREGUNTA 09 - Rompecabezas
            [
                'numero' => '09',
                'titulo' => 'Rompecabezas',
                'descripcion' => 'Sam tiene un rompecabezas con hexágonos de 3 colores. Para colocar una pieza, debe asegurarse que en el triángulo que se forma (con las 2 piezas de abajo), todas sean del mismo color ó que todas sean de colores diferentes.',
                'imagen_descripcion' => 'preguntas/09/regla.png',
                'pregunta' => 'Coloca las piezas hexagonales en el rompecabezas siguiendo la regla del triángulo.',
                'imagen_pregunta' => 'preguntas/09/tarjetas.png',
                'tipo_interaccion' => 'rompecabezas_hexagonos',
                'configuracion' => json_encode([
                    'colores' => ['red', 'blue', 'green'],
                    'piezas_disponibles' => [
                        ['id' => 'A', 'color' => 'red',   'imagen' => 'preguntas/09/pieza_A.png'],
                        ['id' => 'B', 'color' => 'blue',  'imagen' => 'preguntas/09/pieza_B.png'],
                        ['id' => 'C', 'color' => 'green', 'imagen' => 'preguntas/09/pieza_C.png'],
                        ['id' => 'D', 'color' => 'red',   'imagen' => 'preguntas/09/pieza_D.png'],
                        ['id' => 'E', 'color' => 'blue',  'imagen' => 'preguntas/09/pieza_E.png'],
                    ],
                    'estructura' => [
                        // Fila 0 (arriba)
                        [
                            ['columna' => 0], // Celda vacía para colocar
                        ],
                        // Fila 1
                        [
                            ['columna' => 0, 'fija' => true, 'color' => 'red', 'id' => 'F1'], // Pieza fija
                            ['columna' => 1], // Celda vacía
                        ],
                        // Fila 2 (abajo)
                        [
                            ['columna' => 0, 'fija' => true, 'color' => 'blue', 'id' => 'F2'], // Pieza fija
                            ['columna' => 1, 'fija' => true, 'color' => 'green', 'id' => 'F3'], // Pieza fija
                        ],
                    ],
                ]),
                'respuesta_correcta' => json_encode([
                    ['fila' => 0, 'columna' => 0, 'pieza' => 'A', 'color' => 'red'],
                    ['fila' => 1, 'columna' => 1, 'pieza' => 'B', 'color' => 'blue'],
                ]),
                'explicacion' => 'Cada vez que colocas una pieza nueva, debes revisar el triángulo que forma con las dos piezas de abajo. Ese triángulo es válido solo si los tres hexágonos son del mismo color o si los tres son de colores distintos. Siguiendo esta regla desde abajo hacia arriba, se puede completar el rompecabezas colocando las piezas como en la solución dada.',
                'imagen_respuesta' => null,
                'nivel' => 'III',
                'dificultad' => 'Media',
                'pais_origen' => 'Bélgica',
                'codigo_tarea' => '2022-BE-02',
            ],

            // PREGUNTA 10 - Placas en el mundo
            [
                'numero' => '10',
                'titulo' => 'Placas en el mundo',
                'descripcion' => 'En cada país, los autos utilizan diferentes diseños y formatos para sus placas. Generalmente, se utilizan las letras del alfabeto en inglés (que tiene solo 26 letras) y los dígitos del 0 al 9.',
                'imagen_descripcion' => null,
                'pregunta' => '¿En cuál de las siguientes placas se podrían llegar a registrar la mayor cantidad de automóviles?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'imagen', 'valor' => 'preguntas/10/placa_a.png', 'descripcion' => '3 letras y 3 números'],
                        ['id' => 'B', 'tipo' => 'imagen', 'valor' => 'preguntas/10/placa_b.png', 'descripcion' => '4 letras y 3 números'],
                        ['id' => 'C', 'tipo' => 'imagen', 'valor' => 'preguntas/10/placa_c.png', 'descripcion' => '5 letras y 2 números'],
                        ['id' => 'D', 'tipo' => 'imagen', 'valor' => 'preguntas/10/placa_d.png', 'descripcion' => '2 letras y 6 números'],
                        ['id' => 'E', 'tipo' => 'imagen', 'valor' => 'preguntas/10/placa_e.png', 'descripcion' => '4 letras y 4 números'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['E']),
                'explicacion' => 'Cada lugar de la placa puede tomar varios valores: cada letra puede ser una de 26 letras y cada número uno de 10 dígitos. Para comparar, imagina multiplicar: por ejemplo, con 4 letras y 4 números hay 26×26×26×26×10×10×10×10 combinaciones posibles. Esa cantidad es mayor que la de las otras opciones, por lo que la placa con 4 letras y 4 números (opción E) permite registrar más autos.',
                'imagen_respuesta' => null,
                'nivel' => 'III',
                'dificultad' => 'Media',
                'pais_origen' => 'Lituania',
                'codigo_tarea' => '2023-LT-07',
            ],

            // PREGUNTA 11 - Corazón
            [
                'numero' => '11',
                'titulo' => 'Corazón',
                'descripcion' => 'Tina inicia con una imagen de un círculo y un cuadrado en una computadora. Con estas dos figuras quiere lograr formar un corazón. Para hacerlo, las va a modificar con un programa, pero solo puede usar estas 3 instrucciones:
- Rotar o Girar alguna de las figuras
- Mover alguna de las figuras
- Duplicar la figura en su mismo lugar',
                'imagen_descripcion' => 'preguntas/11/figuras_iniciales.png',
                'pregunta' => '¿Qué instrucciones realizó y en qué orden para lograrlo?',
                'imagen_pregunta' => 'preguntas/11/corazon_final.png',
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'texto', 'valor' => 'Duplicar-círculo, Rotar-círculo, Mover-círculo, Mover-cuadrado'],
                        ['id' => 'B', 'tipo' => 'texto', 'valor' => 'Duplicar-círculo, Rotar-cuadrado, Mover-círculo, Mover-círculo'],
                        ['id' => 'C', 'tipo' => 'texto', 'valor' => 'Duplicar-cuadrado, Rotar-cuadrado, Mover-cuadrado, Mover-círculo'],
                        ['id' => 'D', 'tipo' => 'texto', 'valor' => 'Mover-círculo, Mover-círculo, Duplicar-círculo, Mover-cuadrado'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['B']),
                'explicacion' => 'Primero se duplica el círculo para tener dos círculos iguales. Luego se rota el cuadrado 45° para que parezca un rombo. Finalmente se mueve un círculo a la izquierda y el otro a la derecha, acomodándolos sobre el rombo hasta que juntos formen la figura de un corazón. Esa es precisamente la secuencia descrita en la opción B.',
                'imagen_respuesta' => 'preguntas/11/respuesta.png',
                'nivel' => 'II',
                'dificultad' => 'Baja',
                'pais_origen' => 'Alemania',
                'codigo_tarea' => '2022-DE-02',
            ],

            // PREGUNTA 12 - Prende la Luz
            [
                'numero' => '12',
                'titulo' => 'Prende la Luz',
                'descripcion' => 'Este juego se llama "Prende la Luz". Tienes 8 switches o interruptores que se pueden activar o desactivar. Además, hay cables que salen de cada uno de esos interruptores y que pasan por algunos componentes:

- La salida del componente AND está PRENDIDA solo si los DOS cables que llegan están PRENDIDOS
- La salida del componente XOR está PRENDIDA cuando exactamente UNO de los cables que entra está PRENDIDO',
                'imagen_descripcion' => 'preguntas/12/circuito.png',
                'pregunta' => '¿Cuáles interruptores deben prenderse para que se prenda el foco?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_multiple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => '1', 'tipo' => 'texto', 'valor' => 'Interruptor A'],
                        ['id' => '2', 'tipo' => 'texto', 'valor' => 'Interruptor B'],
                        ['id' => '3', 'tipo' => 'texto', 'valor' => 'Interruptor C'],
                        ['id' => '4', 'tipo' => 'texto', 'valor' => 'Interruptor D'],
                        ['id' => '5', 'tipo' => 'texto', 'valor' => 'Interruptor E'],
                        ['id' => '6', 'tipo' => 'texto', 'valor' => 'Interruptor F'],
                        ['id' => '7', 'tipo' => 'texto', 'valor' => 'Interruptor G'],
                        ['id' => '8', 'tipo' => 'texto', 'valor' => 'Interruptor H'],
                    ],
                    'nota' => 'Hay 16 posibles combinaciones correctas',
                ]),
                'respuesta_correcta' => json_encode([
                    ['1', '2', '4', '5', '6', '7', '8'],
                    ['1', '2', '3', '5', '6'],
                    ['1', '2', '4', '5', '6'],
                    ['1', '2', '3', '7'],
                    ['1', '4', '5', '8'],
                    ['1', '2', '3', '5', '6', '7', '8'],
                    ['1', '2', '3', '5', '7'],
                    ['1', '2', '4', '6', '8'],
                    ['1', '2', '4', '6', '7'],
                    ['1', '2', '4', '7'],
                    ['1', '2', '3', '8'],
                    ['1', '2', '4', '5', '7'],
                    ['1', '2', '4', '5', '8'],
                    ['1', '2', '3', '6'],
                    ['1', '2', '3', '6', '7'],

                ]),
                'explicacion' => 'Para prender el foco, la salida final del circuito debe estar encendida. Si sigues los cables desde el foco hacia atrás, puedes decidir qué entradas de cada AND y XOR deben estar prendidas. Cualquier combinación de interruptores que cumpla que en cada AND sus dos entradas estén encendidas y que en cada XOR exactamente una entrada esté encendida prenderá el foco. Por eso hay muchas soluciones posibles; una de ellas, por ejemplo, es prender los interruptores 1, 2, 3 y 5 (además de otros según la configuración elegida en el sistema).',
                'imagen_respuesta' => 'preguntas/12/Respuesta.png',
                'nivel' => 'III',
                'dificultad' => 'Media',
                'pais_origen' => 'Australia',
                'codigo_tarea' => '2022-AU-03',
            ],

            // PREGUNTA 13 - Espía de Cartas
            [
                'numero' => '13',
                'titulo' => 'Espía de Cartas',
                'descripcion' => 'La República de Bebraria mantiene un archivo lleno de cartas ultra secretas. Las cartas están numeradas del 1 al 16 y tan solo 10 de ellas se habían abierto. Las otras 6 seguían en sus sobres sellados.

Un día, un espía enemigo entró al archivo y abrió una de las cartas selladas. El vigilante recuerda que antes las cartas cumplían con lo siguiente:
- El número de cartas abiertas en las columnas de C2 y C4 juntas, era un número par
- El número de cartas abiertas en las columnas C3 y C4 juntas era también par
- El número de cartas abiertas en la fila R2 y R4 juntas era también par
- Y el número de cartas abiertas en la fila R3 y R4 juntas también era par',
                'imagen_descripcion' => 'preguntas/13/cartas_grid.png',
                'pregunta' => '¿Puedes saber cuál fue la carta sellada que abrió el espía?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'texto', 'valor' => '5'],
                        ['id' => 'B', 'tipo' => 'texto', 'valor' => '9'],
                        ['id' => 'C', 'tipo' => 'texto', 'valor' => '10'],
                        ['id' => 'D', 'tipo' => 'texto', 'valor' => '13'],
                        ['id' => 'E', 'tipo' => 'texto', 'valor' => 'No hay información suficiente para saberlo'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['D']),
                'explicacion' => 'Antes de que el espía actuara, las cantidades de cartas abiertas en ciertas combinaciones de filas y columnas eran siempre pares. Al abrir una carta sellada, en la fila y en la columna de esa carta el conteo cambia de par a impar. Usando esta idea de paridad (par/impar) en filas y columnas, se puede localizar exactamente la casilla donde hubo un cambio y obtener que la carta abierta por el espía es la 13.',
                'imagen_respuesta' => null,
                'nivel' => 'IV',
                'dificultad' => 'Media',
                'pais_origen' => 'Filipinas',
                'codigo_tarea' => '2023-PH-04',
            ],

            // PREGUNTA 14 - Colorear
            [
                'numero' => '14',
                'titulo' => 'Colorear',
                'descripcion' => 'Colorea la imagen con los colores verde, amarillo y azul, de forma que ninguna parte toque otra parte con el mismo color.',
                'imagen_descripcion' => 'preguntas/14/flor_sin_colorear.png',
                'pregunta' => 'Dibuja cada área con uno de los 3 colores siguiendo la regla.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'rellenar',
                'configuracion' => json_encode([
                    'colores_disponibles' => ['green', 'yellow', 'blue'],
                    'areas' => [
                        ['id' => 'fondo', 'nombre' => 'Fondo/Marco'],
                        ['id' => 'petalo1', 'nombre' => 'Pétalo 1'],
                        ['id' => 'petalo2', 'nombre' => 'Pétalo 2'],
                        ['id' => 'petalo3', 'nombre' => 'Pétalo 3'],
                        ['id' => 'petalo4', 'nombre' => 'Pétalo 4'],
                        ['id' => 'petalo5', 'nombre' => 'Pétalo 5'],
                        ['id' => 'centro', 'nombre' => 'Centro'],
                    ],
                    'tipo_validacion' => 'flexible', // Hay múltiples soluciones
                    'adyacencias' => [
                        'fondo' => ['petalo1', 'petalo2', 'petalo3', 'petalo4', 'petalo5', 'centro'],
                        'petalo1' => ['fondo', 'centro'],
                        'petalo2' => ['fondo', 'centro'],
                        'petalo3' => ['fondo', 'centro'],
                        'petalo4' => ['fondo', 'centro'],
                        'petalo5' => ['fondo', 'centro'],
                        'centro' => ['fondo', 'petalo1', 'petalo2', 'petalo3', 'petalo4', 'petalo5'],
                    ],
                ]),
                'respuesta_correcta' => json_encode([
                    // Una de las 6 soluciones posibles
                    ['area' => 'fondo', 'color' => 'amarillo'],
                    ['area' => 'petalo1', 'color' => 'verde'],
                    ['area' => 'petalo2', 'color' => 'azul'],
                    ['area' => 'petalo3', 'color' => 'verde'],
                    ['area' => 'petalo4', 'color' => 'azul'],
                    ['area' => 'petalo5', 'color' => 'verde'],
                    ['area' => 'centro', 'color' => 'amarillo'],
                ]),
                'explicacion' => 'La regla dice que dos áreas que se toquen no pueden tener el mismo color. Una buena estrategia es empezar por el área que toca a más regiones (el fondo o marco) y darle un color. Luego, en cada área vecina eliges un color distinto al del área con la que toca. Si sigues alternando de esa forma, puedes construir una solución válida. Existen varias formas correctas de colorear la flor; una de ellas es la que se muestra en la solución de ejemplo.',
                'imagen_respuesta' => 'preguntas/14/respuesta.png',
                'nivel' => 'III',
                'dificultad' => 'Alta',
                'pais_origen' => 'Austria',
                'codigo_tarea' => '2022-AT-01a',
            ],

            // PREGUNTA 15 - Panal de Abejas
            [
                'numero' => '15',
                'titulo' => 'Panal de Abejas',
                'descripcion' => 'Bebras necesita de tu ayuda para colocar las abejas en el panal. Se muestra una regla abajo de cada abeja: La abeja debe colocarse de esta forma en la celda gris. Y otras abejas deberán estar en las celdas en blanco.',
                'imagen_descripcion' => 'preguntas/15/panal_vacio.png',
                'pregunta' => 'Coloca las diferentes abejas en el panal de forma que sigan sus reglas.',
                'imagen_pregunta' => 'preguntas/15/abejas_reglas.png',
                'tipo_interaccion' => 'colocar_piezas',
                'configuracion' => json_encode([
                    'celdas_hexagonales' => 7, // Un espacio por abeja en el panal interactivo
                    'abejas' => [
                        ['id' => '3', 'imagen' => 'preguntas/15/abeja1.png', 'regla' => 'preguntas/15/regla3.png'],
                        ['id' => '5', 'imagen' => 'preguntas/15/abeja2.png', 'regla' => 'preguntas/15/regla5.png'],
                        ['id' => '1', 'imagen' => 'preguntas/15/abeja3.png', 'regla' => 'preguntas/15/regla1.png'],
                        ['id' => '6', 'imagen' => 'preguntas/15/abeja4.png', 'regla' => 'preguntas/15/regla6.png'],
                        ['id' => '2', 'imagen' => 'preguntas/15/abeja5.png', 'regla' => 'preguntas/15/regla2.png'],
                        ['id' => '4', 'imagen' => 'preguntas/15/abeja6.png', 'regla' => 'preguntas/15/regla4.png'],
                        ['id' => '7', 'imagen' => 'preguntas/15/abeja7.png', 'regla' => 'preguntas/15/regla7.png'],
                    ],
                ]),
                // En la interfaz final se muestran 7 celdas hexagonales (una por abeja),
                // por lo que la solución se expresa como la celda que ocupa cada abeja.
                'respuesta_correcta' => json_encode([
                    ['abeja' => '1', 'celda' => 4],
                    ['abeja' => '2', 'celda' => 5],
                    ['abeja' => '3', 'celda' => 7],
                    ['abeja' => '4', 'celda' => 2],
                    ['abeja' => '5', 'celda' => 6],
                    ['abeja' => '6', 'celda' => 3],
                    ['abeja' => '7', 'celda' => 1],
                ]),
                'explicacion' => 'Cada abeja muestra en su tarjeta un patrón que indica en qué celdas del panal debe haber abejas alrededor de la celda gris. Empieza colocando las abejas cuya regla solo se puede cumplir en una posición del panal; eso reduce mucho las posibilidades. Una vez puestas esas abejas “forzadas”, las reglas de las demás se acomodan casi automáticamente hasta obtener la configuración final mostrada en la solución.',
                'imagen_respuesta' => 'preguntas/15/panal_resuelto.png',
                'nivel' => 'IV',
                'dificultad' => 'Media',
                'pais_origen' => 'Francia',
                'codigo_tarea' => '2022-FR-02a',
            ],

            // PREGUNTA 16 - La Liebre y la Tortuga
            [
                'numero' => '16',
                'titulo' => 'La Liebre y la Tortuga',
                'descripcion' => 'La liebre y la tortuga decidieron hacer una nueva carrera. Ambas inician en el mismo lugar (corazón) y siguen la dirección de las flechas en la pista.
- La tortuga avanza un lugar cada minuto
- La liebre se mueve dos lugares cada minuto',
                'imagen_descripcion' => 'preguntas/16/pista.png',
                'pregunta' => '¿En qué lugar se van a encontrar la liebre y la tortuga nuevamente después del inicio?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'sandia', 'tipo' => 'imagen', 'valor' => 'preguntas/16/sandia.png'],
                        ['id' => 'manzana', 'tipo' => 'imagen', 'valor' => 'preguntas/16/manzana.png'],
                        ['id' => 'naranja', 'tipo' => 'imagen', 'valor' => 'preguntas/16/naranja.png'],
                        ['id' => 'platano', 'tipo' => 'imagen', 'valor' => 'preguntas/16/platano.png'],
                        ['id' => 'Elote', 'tipo' => 'imagen', 'valor' => 'preguntas/16/elote.png'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['naranja']),
                'explicacion' => 'Cada minuto, la tortuga avanza un espacio siguiendo las flechas y la liebre avanza dos. Aunque la liebre se mueve más rápido, ambos siguen la misma pista, que tiene forma de ciclo. Si sigues sus recorridos minuto a minuto, verás que después de 6 minutos la tortuga habrá avanzado 6 lugares y la liebre 12, y ambos estarán nuevamente en la casilla de la naranja. Ese es el primer punto donde se vuelven a encontrar.',
                'imagen_respuesta' => null,
                'nivel' => 'IV',
                'dificultad' => 'Alta',
                'pais_origen' => 'Filipinas',
                'codigo_tarea' => '2022-PH-03',
            ],

            // PREGUNTA 17 - Juego en la Playa
            [
                'numero' => '17',
                'titulo' => 'Juego en la Playa',
                'descripcion' => 'Ana y Bob inventaron un juego en la playa. Ana juntó conchas color blanco y Bob juntó piedritas negras. Hicieron hoyos en la arena y los conectaron con surcos. Reglas:
- Van a jugar por turnos
- En cada turno, el jugador coloca una de sus piezas en un hoyo vacío
- Ana inicia el juego
- Pierde el jugador que coloque dos de sus piezas en dos hoyos conectados por un surco',
                'imagen_descripcion' => 'preguntas/17/tablero_inicial.png',
                'pregunta' => 'Es el turno de Ana, ¿en qué lugar debe colocar la concha para asegurar la victoria?',
                'imagen_pregunta' => 'preguntas/17/pista.png',
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => '2', 'tipo' => 'texto', 'valor' => 'Posición 2'],
                        ['id' => '3', 'tipo' => 'texto', 'valor' => 'Posición 3'],
                        ['id' => '5', 'tipo' => 'texto', 'valor' => 'Posición 5'],
                        ['id' => '7', 'tipo' => 'texto', 'valor' => 'Posición 7'],
                        ['id' => '1', 'tipo' => 'texto', 'valor' => 'Posición 1'],
                        ['id' => '4', 'tipo' => 'texto', 'valor' => 'Posición 4'],
                        ['id' => '6', 'tipo' => 'texto', 'valor' => 'Posición 6'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['7']),
                'explicacion' => 'Ana pierde si llega a tener dos conchas blancas en hoyos que estén conectados por un surco. Para asegurar su victoria, debe jugar en un hoyo donde, sin importar cómo juegue Bob después, ella siempre pueda responder sin quedar con dos piezas conectadas. Analizando las conexiones del tablero y probando las posibles jugadas siguientes, se ve que colocar la concha en la posición 7 deja a Bob sin forma de forzar que Ana pierda, por lo que esa jugada garantiza la victoria de Ana.',
                'imagen_respuesta' => null,
                'nivel' => 'V',
                'dificultad' => 'Media',
                'pais_origen' => 'Italia',
                'codigo_tarea' => '2022-IT-02',
            ],

            // PREGUNTA 18 - Bitácora de fotos
            [
                'numero' => '18',
                'titulo' => 'Bitácora de fotos',
                'descripcion' => 'Bebras toma una caminata todas las mañanas por el bosque y siempre lleva una cámara. Durante la caminata, Bebras escribe una bitácora en donde registra todos los pasos que siguió. Cada fotografía muestra todos los objetos que se pueden ver desde ese lugar en una cuadrícula de 3x3 frente a la cámara.',
                'imagen_descripcion' => 'preguntas/18/bitacora.png',
                'pregunta' => 'Selecciona cuáles fueron las 3 fotografías que sacó Bebras ese día, 
                Cada fotografía muestra todos los objetos que se pueden ver desde ese lugar en una cuadrícula de 3x3 frente a la cámara.
                ',
                'imagen_pregunta' => 'preguntas/18/grid_mundo.png',
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'imagen', 'valor' => 'preguntas/18/foto_a.png'],
                        ['id' => 'B', 'tipo' => 'imagen', 'valor' => 'preguntas/18/foto_b.png'],
                        ['id' => 'C', 'tipo' => 'imagen', 'valor' => 'preguntas/18/foto_c.png'],
                        ['id' => 'D', 'tipo' => 'imagen', 'valor' => 'preguntas/18/foto_d.png'],
                    ],
                    'instruccion' => 'Elige el set de 3 fotos que corresponde a la bitácora',
                ]),
                'respuesta_correcta' => json_encode(['C']),
                'explicacion' => 'Cada fotografía muestra exactamente lo que se ve en una cuadrícula de 3×3 frente a la cámara, según la posición y orientación anotadas en la bitácora. Para resolverla, hay que seguir paso a paso los movimientos de Bebras (avanzar, girar, tomar foto) sobre el mapa grande, y en cada punto imaginar qué quedaría dentro de la ventana 3×3. Al comparar esos “recortes” con las opciones de fotos, el único conjunto que coincide con las tres posiciones registradas es el de la opción C.',
                'imagen_respuesta' => 'preguntas/18/respuesta.png',
                'nivel' => 'V',
                'dificultad' => 'Media',
                'pais_origen' => 'Japón',
                'codigo_tarea' => '2023-JP-03b',
            ],

            // PREGUNTA 19 - Caja Fuerte
            [
                'numero' => '19',
                'titulo' => 'Caja Fuerte',
                'descripcion' => 'Bebras tiene que abrir una caja fuerte utilizando la combinación de números correcta. En cada movimiento, Bebras puede rotar la flecha en sentido de las manecillas del reloj ya sea 3 o 4 pasos. La flecha hace que se cambie la luz del número en donde aterriza. Si el número estaba apagado, lo prende. Si estaba prendido, lo apaga.',
                'imagen_descripcion' => 'preguntas/19/caja_fuerte.png',
                'pregunta' => '¿Cuál es el mínimo número de movimientos que debe hacer para lograr prender solamente los números 7 y 8?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'texto_libre',
                'configuracion' => json_encode([
                    'tipo_respuesta' => 'numero',
                    'min' => 1,
                    'max' => 10,
                ]),
                'respuesta_correcta' => json_encode(['4']),
                'explicacion' => 'Cada vez que la flecha llega a un número, cambia su estado: si estaba apagado, se prende; si estaba prendido, se apaga. Como solo se pueden hacer giros de 3 o 4 pasos, hay que buscar una secuencia corta de movimientos que termine con solo los números 7 y 8 encendidos. Una forma mínima de lograrlo en 4 movimientos es: girar 3 pasos (se prende el 4), luego 4 pasos (se prende el 8), luego otros 4 pasos (se apaga el 4) y por último 3 pasos (se prende el 7). Ahora solo 7 y 8 quedan encendidos.',
                'imagen_respuesta' => null,
                'nivel' => 'V',
                'dificultad' => 'Alta',
                'pais_origen' => 'Hungría',
                'codigo_tarea' => '2023-HU-05',
            ],

            // PREGUNTA 20 - Mapa en Clave
            [
                'numero' => '20',
                'titulo' => 'Mapa en Clave',
                'descripcion' => 'Castorus encontró dos buenos lugares para esconder su comida. Para recordarlos, quiere marcar los lugares en un mapa con una "X". Para confundir a Biberina, Castorus agrega de forma aleatoria "X"s en otros cuadros del mapa, asegurándose de que el número total de "X"s en cada fila y cada columna sea par. Luego, borra las dos "X"s originales.',
                'imagen_descripcion' => 'preguntas/20/mapa_final.png',
                'pregunta' => '¿Cuáles son los lugares en que Castorus escondió su comida? Marca los cuadros.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'grid_seleccion',
                'configuracion' => json_encode([
                    'filas' => 4,
                    'columnas' => 7,
                    'labels_filas' => ['R1', 'R2', 'R3', 'R4', 'R5', 'R6', 'R7'],
                    'labels_columnas' => ['C1', 'C2', 'C3', 'C4', 'C5', 'C6', 'C7'],
                    'estado_inicial' => [
                        [0, 1, 0, 1, 0, 0, 0],
                        [1, 0, 1, 1, 0, 0, 1],
                        [0, 1, 1, 1, 0, 0, 0],
                        [1, 1, 0, 1, 0, 1, 0],
                        [0, 0, 1, 0, 1, 1, 0],
                        [1, 0, 0, 1, 1, 0, 1],
                        [0, 1, 0, 0, 1, 0, 1],
                    ],
                    'numeros_celdas' => [
                        [1, 2, 3, 4, 5, 6, 7],
                        [8, 9, 10, 11, 12, 13, 14],
                        [15, 16, 17, 18, 19, 20, 21],
                        [22, 23, 24, 25, 26, 27, 28],
                        [29, 30, 31, 32, 33, 34, 35],
                        [36, 37, 38, 39, 40, 41, 42],
                        [43, 44, 45, 46, 47, 48, 49],
                    ],
                ]),
                'respuesta_correcta' => json_encode([
                    ['fila' => 3, 'columna' => 3],
                    ['fila' => 6, 'columna' => 5],
                ]),
                'explicacion' => 'En el mapa, Castorus agregó y borró “X” de forma que en cada fila y en cada columna el número total de “X” fuera par. Cuando borra las dos “X” originales, las filas y columnas donde estaban esas marcas pasan de tener una cantidad par de “X” a una cantidad impar. Por eso, para encontrar los escondites hay que buscar exactamente las filas y columnas con número impar de “X” y marcar las casillas en las intersecciones correspondientes.',
                'imagen_respuesta' => 'preguntas/20/respuesta.png',
                'nivel' => 'V',
                'dificultad' => 'Alta',
                'pais_origen' => 'Suiza',
                'codigo_tarea' => '2022-CH-08',
            ],

            // PREGUNTA 21 - Hexágonos de Colores
            [
                'numero' => '21',
                'titulo' => 'Hexágonos de Colores',
                'descripcion' => 'Sam tiene un rompecabezas con hexágonos de 3 colores. Para colocar una pieza, debe asegurarse que en el triángulo que se forma cuando coloca esa pieza (con las 2 piezas de abajo), todas sean del mismo color ó que todas sean de colores diferentes.',
                'imagen_descripcion' => 'preguntas/21/regla_hexagonos.png',
                'pregunta' => 'Sam comienza colocando las piezas como se muestran. Colorea los hexágonos vacíos para que sigan la regla hasta terminar el rompecabezas.',
                'imagen_pregunta' => 'preguntas/21/hexagonos_inicial.png',
                'tipo_interaccion' => 'colorear_hexagonos',
                'configuracion' => json_encode([
                    'colores_disponibles' => ['verde', 'amarillo', 'azul'],
                    'estructura' => 'piramide',
                    'filas' => 6,
                    'hexagonos_iniciales' => [
                        // Fila inferior (6 hexágonos)
                        ['posicion' => [5, 0], 'color' => 'verde'],
                        ['posicion' => [5, 1], 'color' => 'verde'],
                        ['posicion' => [5, 2], 'color' => 'amarillo'],
                        ['posicion' => [5, 3], 'color' => 'azul'],
                        ['posicion' => [5, 4], 'color' => 'verde'],
                        ['posicion' => [5, 5], 'color' => 'azul'],
                    ],
                ]),
                'respuesta_correcta' => json_encode([
                    // Hexágonos a colorear (solución correcta)
                    ['posicion' => [0, 0], 'color' => 'amarillo'],
                    ['posicion' => [1, 0], 'color' => 'azul'],
                    ['posicion' => [1, 1], 'color' => 'verde'],
                    ['posicion' => [2, 0], 'color' => 'amarillo'],
                    ['posicion' => [2, 1], 'color' => 'verde'],
                    ['posicion' => [2, 2], 'color' => 'verde'],
                    ['posicion' => [3, 0], 'color' => 'amarillo'],
                    ['posicion' => [3, 1], 'color' => 'amarillo'],
                    ['posicion' => [3, 2], 'color' => 'azul'],
                    ['posicion' => [3, 3], 'color' => 'amarillo'],
                    ['posicion' => [4, 0], 'color' => 'verde'],
                    ['posicion' => [4, 1], 'color' => 'azul'],
                    ['posicion' => [4, 2], 'color' => 'verde'],
                    ['posicion' => [4, 3], 'color' => 'amarillo'],
                    ['posicion' => [4, 4], 'color' => 'amarillo'],
                ]),
                'explicacion' => 'La regla es siempre la misma: si las dos piezas de abajo son del mismo color, la de arriba debe ser de ese mismo color; si son de colores diferentes, la de arriba debe ser del tercer color. Esto funciona como un pequeño “algoritmo”: empezando desde la fila inferior y subiendo, cada nuevo hexágono se decide solo observando los dos de abajo. Siguiendo sistemáticamente esta regla, se obtiene exactamente la combinación de colores que se muestra en la solución.',
                'imagen_respuesta' => null,
                'nivel' => 'V',
                'dificultad' => 'Alta',
                'pais_origen' => 'Vietnam',
                'codigo_tarea' => '2022-VN-05a',
            ],

            // PREGUNTA 22 - Auto Autónomo
            [
                'numero' => '22',
                'titulo' => 'Auto Autónomo',
                'descripcion' => 'Tim está probando un auto autónomo. Una reciente actualización del software del auto, generó un gran error, que provoca que una vez que realiza un tipo de vuelta por primera vez, al llegar a una intersección, tendrá que hacer ese mismo tipo de vuelta cada vez que llegue a ese mismo tipo de intersección.',
                'imagen_descripcion' => 'preguntas/22/ciudad.png',
                'pregunta' => '¿Cuál será la letra en la que va a terminar Tim al final de su prueba?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'texto', 'valor' => 'Salida A'],
                        ['id' => 'B', 'tipo' => 'texto', 'valor' => 'Salida B'],
                        ['id' => 'C', 'tipo' => 'texto', 'valor' => 'Salida C'],
                        ['id' => 'D', 'tipo' => 'texto', 'valor' => 'Salida D'],
                        ['id' => 'E', 'tipo' => 'texto', 'valor' => 'Salida E'],
                        ['id' => 'F', 'tipo' => 'texto', 'valor' => 'Salida F'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['F']),
                'explicacion' => 'Debido al error del software, la primera vez que el auto se encuentra con un cierto tipo de intersección “aprende” un giro para ese tipo y, a partir de entonces, repite siempre esa misma acción cuando se encuentra una intersección igual. Si sigues el recorrido desde el inicio, anotando qué decisión toma el auto la primera vez en cada tipo de cruce y repitiéndola después, verás que el camino se va “fijando” y finalmente siempre lleva a la salida F.',
                'imagen_respuesta' => 'preguntas/22/respuesta.png',
                'nivel' => 'V',
                'dificultad' => 'Alta',
                'pais_origen' => 'Estados Unidos',
                'codigo_tarea' => '2023-US-03',
            ],

            // PREGUNTA 23 - Virus de computadora
            [
                'numero' => '23',
                'titulo' => 'Virus de computadora',
                'descripcion' => 'Dos computadoras en una red se infectaron de virus: La computadora A con el Virus Azul y la computadora B con el Virus Rojo. Ambos virus se empiezan a propagar: cada hora, cada computadora que está conectada directamente a una infectada también se va a infectar con el mismo virus. Si una computadora se infecta con ambos virus, entonces se desconecta de la red y ya no seguirá propagando ningún virus.',
                'imagen_descripcion' => 'preguntas/23/red_inicial.png',
                'pregunta' => '¿Cómo quedarán al final cuando la propagación del virus se haya detenido? Marca el estatus final de cada computadora.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_multiple',
                'configuracion' => json_encode([
                    'computadoras' => 12,
                    'opciones_por_computadora' => ['virus_rojo', 'virus_azul', 'desconectada'],
                    'nota' => 'Debes marcar el estado de cada una de las 12 computadoras',
                ]),
                'respuesta_correcta' => json_encode([
                    ['computadora' => 1, 'estado' => 'desconectada'],
                    ['computadora' => 2, 'estado' => 'virus_azul'],
                    ['computadora' => 3, 'estado' => 'desconectada'],
                    ['computadora' => 4, 'estado' => 'virus_rojo'],
                    ['computadora' => 5, 'estado' => 'desconectada'],
                    ['computadora' => 6, 'estado' => 'virus_azul'],
                    ['computadora' => 7, 'estado' => 'desconectada'],
                    ['computadora' => 8, 'estado' => 'virus_rojo'],
                    ['computadora' => 9, 'estado' => 'desconectada'],
                    ['computadora' => 10, 'estado' => 'virus_azul'],
                    ['computadora' => 11, 'estado' => 'virus_rojo'],
                    ['computadora' => 12, 'estado' => 'virus_azul'],
                ]),
                'explicacion' => 'Cada hora, los virus se expanden desde las computadoras infectadas a todas las computadoras conectadas directamente a ellas. Si una computadora llega a recibir los dos virus, se desconecta y deja de contagiar a otras, lo que actúa como una barrera. Al simular la propagación paso a paso sobre el diagrama de la red, se ve cuáles computadoras terminan solo con virus azul, solo con virus rojo o desconectadas, como en el estado final mostrado en la solución.',
                'imagen_respuesta' => 'preguntas/23/red_final.png',
                'nivel' => 'VI',
                'dificultad' => 'Alta',
                'pais_origen' => 'Nueva Zelanda',
                'codigo_tarea' => '2022-NZ-01',
            ],

            // PREGUNTA 24 - Collar Marinero
            [
                'numero' => '24',
                'titulo' => 'Collar Marinero',
                'descripcion' => 'Cami está aprendiendo a fabricar collares marineros con dos tipos de cuentas. Todos los collares marineros deben comenzar colocando una cuenta con ondas roja y una azul. Luego, el collar se puede hacer mas largo usando:
- Agregando una cuenta azul a ambos extremos del collar (acción tipo B)
- Agregando dos cuentas de ondas en el extremo de la derecha (acción tipo W)',
                'imagen_descripcion' => 'preguntas/24/reglas_collar.png',
                'pregunta' => '¿Cuál de los siguientes collares NO es un collar marinero?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'imagen', 'valor' => 'preguntas/24/collar_a.png'],
                        ['id' => 'B', 'tipo' => 'imagen', 'valor' => 'preguntas/24/collar_b.png'],
                        ['id' => 'C', 'tipo' => 'imagen', 'valor' => 'preguntas/24/collar_c.png'],
                        ['id' => 'D', 'tipo' => 'imagen', 'valor' => 'preguntas/24/collar_d.png'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['D']),
                'explicacion' => 'Todos los collares marineros empiezan igual y luego solo se pueden aplicar dos tipos de acciones: agregar cuentas azules a ambos extremos (B) o agregar dos cuentas de ondas al extremo derecho (W). Si sigues cualquier secuencia posible de las acciones B y W, siempre obtendrás un patrón en el que el número de cuentas azules y de ondas rojas se mantiene impar. El collar D tiene un número par de cuentas de cada tipo, por lo que no puede haberse formado con estas reglas y no es un collar marinero.',
                'imagen_respuesta' => null,
                'nivel' => 'VI',
                'dificultad' => 'Alta',
                'pais_origen' => 'Eslovaquia',
                'codigo_tarea' => '2022-SK-03',
            ],

            // PREGUNTA 25 - Hangar tipo Carusel
            [
                'numero' => '25',
                'titulo' => 'Hangar tipo Carusel',
                'descripcion' => 'En el aeropuerto de Bebraston, hay 6 aviones estacionados en un hangar circular, que gira como un carrusel. El carrusel se puede girar a la izquierda o a la derecha utilizando el panel de control que tiene dos flechas	. Al apretar el botón, el carrusel gira
exactamente un lugar de estacionamiento a la
derecha o izquierda.

La puerta del hangar es suficientemente ancha para que el avión pueda salir por ahí, si es que es su turno de salir. Este carrusel gira muy lento, por lo que se busca siempre girar la menor cantidad de veces para así, evitar retrasos en las salidas de los aviones.
 
En las mañanas, cuando los pilotos llegan a sacar sus aviones, la posición 1 siempre está frente a la puerta.
',
                'imagen_descripcion' => 'preguntas/25/hangar.png',
                'pregunta' => '¿Cuál sería el peor de los casos? Esto es, ¿en qué orden se tendrían que sacar los aviones para que se requiera la mayor cantidad de movimientos? Proporciona un peor caso para que los pilotos puedan sacar todos los aviones de las posiciones 1 a la 6.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'ordenar',
                'configuracion' => json_encode([
                    'elementos' => [
                        ['id' => '1', 'tipo' => 'texto', 'valor' => 'Avión 1'],
                        ['id' => '2', 'tipo' => 'texto', 'valor' => 'Avión 2'],
                        ['id' => '3', 'tipo' => 'texto', 'valor' => 'Avión 3'],
                        ['id' => '4', 'tipo' => 'texto', 'valor' => 'Avión 4'],
                        ['id' => '5', 'tipo' => 'texto', 'valor' => 'Avión 5'],
                        ['id' => '6', 'tipo' => 'texto', 'valor' => 'Avión 6'],
                    ],
                    'instruccion' => 'Ingresa los números en el orden que tendrían que salir',
                    'nota' => 'Hay 2 respuestas correctas posibles',
                ]),
                'respuesta_correcta' => json_encode([
                    ['4', '1', '3', '6', '2', '5'], // Opción 1
                    ['4', '1', '5', '2', '6', '3'], // Opción 2
                ]),
                'explicacion' => 'Cada avión tiene una posición fija en el carrusel, y cada vez que se gira a la izquierda o a la derecha se avanza exactamente un lugar. Para encontrar el peor caso, hay que elegir un orden de salida en el que, antes de cada avión, sea necesario girar muchos pasos hasta alinearlo con la puerta, sin desperdiciar movimientos. Analizando todas las posibilidades, se obtiene que secuencias como 4-1-3-6-2-5 o 4-1-5-2-6-3 obligan a hacer el máximo número de giros (16 presiones de botón) para poder sacar todos los aviones.',
                'imagen_respuesta' => null,
                'nivel' => 'VI',
                'dificultad' => 'Alta',
                'pais_origen' => 'Alemania',
                'codigo_tarea' => '2022-DE-05',
            ],

            // PREGUNTA 26 - Tejiendo Alfombras
            [
                'numero' => '26',
                'titulo' => 'Tejiendo Alfombras',
                'descripcion' => 'Hale es una artista de Turquía que fabrica alfombras. Ella quiere hacer una alfombra cuadrada con 6 filas y 6 columnas. Está experimentando en hacer el diseño siguiendo siempre las instrucciones que se muestran en el diagrama de decisiones.',
                'imagen_descripcion' => 'preguntas/26/diagrama_decisiones.png',
                'pregunta' => '¿Cómo quedará la alfombra al final? Dibuja el símbolo que corresponde en cada celda.',
                'imagen_pregunta' => 'preguntas/26/alfombra.png',
                'tipo_interaccion' => 'tejer_alfombra',
                'configuracion' => json_encode([
                    'filas' => 6,
                    'columnas' => 6,
                    'simbolos_disponibles' => ['purple', 'red', 'yellow', 'green'],
                    'reglas' => [
                        '¿Fila o columna es 1 o 6? → Morado',
                        '¿Fila = Columna? → Rojo',
                        '¿Fila > Columna? → Amarillo',
                        'De lo contrario → Verde',
                    ],
                ]),
                'respuesta_correcta' => json_encode([
                    // Grid 6x6 con la solución
                    ['M', 'M', 'M', 'M', 'M', 'M'],
                    ['M', 'R', 'V', 'V', 'V', 'M'],
                    ['M', 'A', 'R', 'V', 'V', 'M'],
                    ['M', 'A', 'A', 'R', 'V', 'M'],
                    ['M', 'A', 'A', 'A', 'R', 'M'],
                    ['M', 'M', 'M', 'M', 'M', 'M'],
                ]),
                'explicacion' => 'El diagrama de decisiones funciona como un programa que, para cada celda (fila, columna), decide el color. Primero se revisa si la fila o columna es 1 o 6; si sí, esa celda es morada (borde). Si no, se revisa si fila = columna; en ese caso es roja (diagonal). Si tampoco, se pregunta si fila > columna; si es verdad, se pinta de amarillo, y en cualquier otro caso se pinta de verde. Aplicando estas reglas, una a una, para las 36 celdas, se obtiene el patrón de alfombra mostrado.',
                'nivel' => 'VI',
                'dificultad' => 'Alta',
                'pais_origen' => 'Turquía',
                'codigo_tarea' => '2022-TR-02',
            ],

            // PREGUNTA 27 - Película favorita
            [
                'numero' => '27',
                'titulo' => 'Película favorita',
                'descripcion' => 'Un grupo de amigos, quiere ver una película juntos. Cada persona califica las 7 películas posibles con su opinión: Buena, Regular o Mala. Una película es "favorita" si todas las personas le dieron su mejor calificación. Desgraciadamente, en este momento no hay ninguna película favorita. Así que Ada quiere convencer a la menor cantidad de amigos para que cambien su calificación.',
                'imagen_descripcion' => 'preguntas/27/tabla_calificaciones.png',
                'pregunta' => 'Ayuda a Ada a cambiar la menor cantidad posible de calificaciones para lograrlo. Marca las evaluaciones que habría que cambiar.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'grid_seleccion',
                'configuracion' => json_encode([
                    'tipo' => 'tabla_calificaciones',
                    'personas' => ['Nancy', 'Niklaus', 'Grace', 'Eder', 'Rosa'],
                    'peliculas' => ['1', '2', '3', '4', '5', '6', '7'],
                    'labels_filas' => ['Nancy', 'Niklaus', 'Grace', 'Eder', 'Rosa'],
                    'labels_columnas' => ['1', '2', '3', '4', '5', '6', '7'],
                    'calificaciones_iniciales' => [
                        ['B', 'B', 'B', 'M', 'M', 'B', 'B'],
                        ['M', 'M', 'M', 'B', 'R', 'R', 'M'],
                        ['M', 'R', 'R', 'R', 'M', 'B', 'M'],
                        ['R', 'M', 'M', 'M', 'M', 'B', 'R'],
                        ['M', 'M', 'M', 'M', 'B', 'R', 'M'],
                    ],
                    'estado_inicial' => [
                        [0, 0, 0, 0, 0, 0, 0],
                        [0, 0, 0, 0, 0, 0, 0],
                        [0, 0, 0, 0, 0, 0, 0],
                        [0, 0, 0, 0, 0, 0, 0],
                        [0, 0, 0, 0, 0, 0, 0],
                    ],
                    'numeros_celdas' => [
                        ['B', 'B', 'B', 'M', 'M', 'B', 'B'],
                        ['M', 'M', 'M', 'B', 'R', 'R', 'M'],
                        ['M', 'R', 'R', 'R', 'M', 'B', 'M'],
                        ['R', 'M', 'M', 'M', 'M', 'B', 'R'],
                        ['M', 'M', 'M', 'M', 'B', 'R', 'M'],
                    ],
                    'instruccion' => 'Haz clic en las celdas que deben cambiar',
                ]),
                'respuesta_correcta' => json_encode([
                    ['persona' => 'Niklaus', 'pelicula' => '6', 'cambio' => 'R→B o 4:B→M'],
                    ['persona' => 'Rosa', 'pelicula' => '6', 'cambio' => 'R→B o 5:B→R'],
                ]),
                'explicacion' => 'Una película es favorita si todas las personas la califican con su mejor opción (“Buena”). Como al inicio ninguna película cumple esto, buscamos la que está más cerca: la que ya tiene más “Buenas” y menos calificaciones que cambiar. La película 6 requiere solo 2 cambios para que todos la marquen como “Buena”. Por eso, basta con que Niklaus y Rosa cambien su calificación de la película 6 para que se convierta en la película favorita.',
                'imagen_respuesta' => null,
                'nivel' => 'VI',
                'dificultad' => 'Alta',
                'pais_origen' => 'Alemania',
                'codigo_tarea' => '2022-DE-07',
            ],

            // ========== GUÍA SOLUCIONES OTOÑO 2025 (Tareas 1-30 del PDF) ==========

            // Tarea 1 - La hora del lunch
            [
                'numero' => '28',
                'titulo' => 'La hora del lunch',
                'descripcion' => 'Lala siempre lleva lunch a la escuela. Su mamá le permite llevar 4 tipos de alimento: Manzanas, peras, mangos o dulces. Lala está planeando qué llevar de lunch los siguientes 5 días. Lala puede escoger qué llevar, siempre y cuando siga dos reglas: No puede comer mango dos días seguidos. Si hoy lleva dulces, mañana debe llevar manzana o pera. Lala ya tiene definidos el lunes, jueves y viernes (días 1, 4 y 5).',
                'imagen_descripcion' => 'preguntas/28/semana.png',
                'pregunta' => 'Llena los cuadros para completar la semana siguiendo las reglas de su mamá. Puede haber más de una opción correcta.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'completar',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'manzana', 'valor' => 'Manzana'],
                        ['id' => 'pera', 'valor' => 'Pera'],
                        ['id' => 'mango', 'valor' => 'Mango'],
                        ['id' => 'dulces', 'valor' => 'Dulces'],
                    ],
                ]),
                'respuesta_correcta' => json_encode([['martes' => 'manzana', 'miercoles' => 'pera']]),
                'explicacion' => 'Lala quiere comer mango el lunes y jueves, así que para cumplir la primera regla no puede volver a comer mango ninguno de los días que faltan. El martes puede comer manzana, dulce o pera. El miércoles puede comer manzana o pera, pero no puede comer dulce, ya que rompería la segunda regla. Hay varias posibles soluciones válidas.',
                'imagen_respuesta' => null,
                'nivel' => 'I',
                'dificultad' => 'Baja',
                'pais_origen' => 'Indonesia',
                'codigo_tarea' => '2025-ID-01',
            ],

            // Tarea 2 - Dibujos "arreglados"
            [
                'numero' => '29',
                'titulo' => 'Dibujos "arreglados"',
                'descripcion' => 'Lars hizo unos dibujos de plantas y Carlota, su hermana bebé, arregló los dibujos usando pintura de dedos encima (derecha).',
                'imagen_descripcion' => 'preguntas/29/dibujos_arreglados.png',
                'pregunta' => '¿Puedes reconocer cuál dibujo era cuál? Arrastra (relaciona) el dibujo original, debajo del dibujo arreglado que corresponde.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'completar',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'planta_recta', 'imagen' => 'preguntas/29/planta_recta.png'],
                        ['id' => 'tallo_curvo', 'imagen' => 'preguntas/29/tallo_curvo.png'],
                        ['id' => 'flor', 'imagen' => 'preguntas/29/flor.png'],
                        ['id' => 'trazos', 'imagen' => 'preguntas/29/trazos.png'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['planta_recta', 'tallo_curvo', 'flor', 'trazos']),
                'explicacion' => 'En la mancha roja se ve una línea sola abajo y solo hay un dibujo que está así en la parte inferior. En la mancha azul claro se ve un tallo curvado hacia la derecha. En la mancha morada se ve un tallo curvado hacia la derecha tapando el que va a la izquierda. En la azul oscura el centro está sin imagen: el único dibujo que podría ser así es el de la flor.',
                'imagen_respuesta' => null,
                'nivel' => 'I',
                'dificultad' => 'Baja',
                'pais_origen' => 'Alemania',
                'codigo_tarea' => '2025-DE-05',
            ],

            // Tarea 3 - Regresando a casa / Los árboles pintados
            [
                'numero' => '30',
                'titulo' => 'Regresando a casa / Los árboles pintados',
                'descripcion' => 'El castor Bastian está perdido en el bosque y no puede encontrar el camino de regreso a su casa. Ha notado que muchos árboles del bosque tienen símbolos pintados en 4 colores diferentes. Ahora, Bastian está parado en el punto negro, donde el camino se divide en 4 senderos. Este punto está marcado en el mapa abajo. Bastián recuerda que, desde su casa hasta ese punto: 1. Vio 3 árboles pintados con X, 2. 3 árboles pintados con Y y 3. 3 árboles pintados con Z. 4. Pero no recuerda cuántos árboles pintados con el cuarto símbolo vio.',
                'imagen_descripcion' => 'preguntas/30/mapa.png',
                'pregunta' => 'Según el siguiente mapa: ¿Cuál es la letra de la casa de Bastián?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'valor' => 'Casa A'],
                        ['id' => 'B', 'valor' => 'Casa B'],
                        ['id' => 'C', 'valor' => 'Casa C'],
                        ['id' => 'D', 'valor' => 'Casa D'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['D']),
                'explicacion' => 'Si sigues el camino de cada casa al punto negro y cuentas la cantidad de símbolos que encuentras de cada uno, los caminos de la casa A, B o C tienen sólo 2 de alguno de los símbolos X, Y y Z, pero se necesitan 3 de cada uno. Solo el camino de la casa D pasa exactamente por 3 X rojas, 3 Y azules y 3 Z verdes. ¡Ese es el camino correcto!',
                'imagen_respuesta' => null,
                'nivel' => 'I',
                'dificultad' => 'Baja',
                'pais_origen' => 'Dinamarca',
                'codigo_tarea' => '2025-DK-01',
            ],

            // Tarea 4 - Armando robots
            [
                'numero' => '31',
                'titulo' => 'Armando robots',
                'descripcion' => 'Seis animales trabajan armando robots. Cada animal es responsable de una parte del proceso en el siguiente orden: Oso, Canguro, Mono, Zorrillo. Uno de los robots quedó como se muestra en la siguiente figura.',
                'imagen_descripcion' => 'preguntas/31/robot_mal.png',
                'pregunta' => '¿Quién de los animales hizo mal su trabajo?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'Oso', 'valor' => 'Oso'],
                        ['id' => 'Canguro', 'valor' => 'Canguro'],
                        ['id' => 'Mono', 'valor' => 'Mono'],
                        ['id' => 'Zorrillo', 'valor' => 'Zorrillo'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['Mono']),
                'explicacion' => 'Si miras el robot que salió mal, tiene todo casi bien, pero el modelo original debía tener las luces en el pecho. Esa tarea le toca al Mono. ¡El Mono le puso los focos en la pierna!',
                'imagen_respuesta' => null,
                'nivel' => 'I',
                'dificultad' => 'Baja',
                'pais_origen' => 'Canadá',
                'codigo_tarea' => '2025-CA-01',
            ],

            // Tarea 5 - Luces y palos
            [
                'numero' => '32',
                'titulo' => 'Luces y palos',
                'descripcion' => 'Bi-taro carga palos de madera. Una secuencia de tres focos le indica cuántos palos va a cargar. Si el foco de la derecha está encendido, Bi-taro cargará 1 palo. Si el foco del centro está encendido, Bi-taro cargará 2 palos. Si el foco de la izquierda está encendido, cargará 4 palos. Si hay más de un foco encendido, los números se suman.',
                'imagen_descripcion' => 'preguntas/32/focos.png',
                'pregunta' => 'Si los focos están encendidos como se muestra en la imagen ¿Cuántos palos cargará Bi-taro?',
                'imagen_pregunta' => 'preguntas/32/focos2.png',
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => '4', 'valor' => '4'],
                        ['id' => '5', 'valor' => '5'],
                        ['id' => '6', 'valor' => '6'],
                        ['id' => '7', 'valor' => '7'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['6']),
                'explicacion' => 'El foco de la izquierda está prendido (vale 4). El foco de en medio está prendido (vale 2). El foco de la derecha está apagado (no cuenta). Suma: 4 + 2 = 6. ¡Bi-taro cargará 6 palos!',
                'imagen_respuesta' => null,
                'nivel' => 'II',
                'dificultad' => 'Baja',
                'pais_origen' => 'Japón',
                'codigo_tarea' => '2025-JP-05',
            ],

            // Tarea 6 - Aviones en fila
            [
                'numero' => '33',
                'titulo' => 'Aviones en fila',
                'descripcion' => 'Siete aviones están esperando para despegar. Hay una sola pista, por lo que tienen que salir uno por uno, ¡No pueden saltarse la fila! Tienen una lista de horarios de salida, pero se borró y es necesario llenarla de nuevo.',
                'imagen_descripcion' => 'preguntas/33/aviones_horario.png',
                'pregunta' => 'Llena los espacios vacíos del horario poniendo los aviones en el orden correcto. Arrastra cada avión a su lugar según la hora en que debe despegar.',
                'imagen_pregunta' => 'preguntas/33/horario.png',
                'tipo_interaccion' => 'ordenar',
                'configuracion' => json_encode([
                    'elementos' => [
                        ['id' => 'verde', 'nombre' => 'Avión Verde'],
                        ['id' => 'azul', 'nombre' => 'Avión Azul'],
                        ['id' => 'rojo_triangulos', 'nombre' => 'Avión Rojo con triángulos'],
                        ['id' => 'amarillo_verde_rayado', 'nombre' => 'Avión Amarillo y Verde rayado'],
                        ['id' => 'amarillo_bolitas', 'nombre' => 'Avión Amarillo con bolitas azules'],
                        ['id' => 'rosa_azul', 'nombre' => 'Avión Rosa con Azul'],
                        ['id' => 'amarillo_morado', 'nombre' => 'Avión Amarillo con Morado'],
                    ],
                    'horarios' => ['10:45', '10:52', '10:55', '10:59', '11:00', '11:10', '11:11'],
                ]),
                'respuesta_correcta' => json_encode(['verde', 'azul', 'rojo_triangulos', 'amarillo_verde_rayado', 'amarillo_bolitas', 'rosa_azul', 'amarillo_morado']),
                'explicacion' => 'El avión verde que está al frente debe salir primero (10:45). El segundo (10:52) es el avión Azul. Para que el Amarillo y Verde rayado despegue a las 10:59, el avión Rojo con triángulos debe haber despegado a las 10:55. Antes del avión Rosa con Azul (11:10) debe despegar el Amarillo con bolitas azules (11:00). El último (11:11) es el Amarillo con Morado.',
                'imagen_respuesta' => null,
                'nivel' => 'II',
                'dificultad' => 'Media',
                'pais_origen' => 'Lituania',
                'codigo_tarea' => '2025-LT-03',
            ],

            // Tarea 7 - La Puerta Mágica
            [
                'numero' => '34',
                'titulo' => 'La Puerta Mágica',
                'descripcion' => 'La castora Josie quedó atrapada en una casa mágica y necesita salir. Para hacerlo, tiene que pasar por una puerta que sea muy diferente a la última por la que pasó. Dos puertas son muy diferentes si tienen distinta: 1. forma, 2. color o diseño, 3. forma de la ventana, 4. y forma de la manija (donde se agarra para abrir).',
                'imagen_descripcion' => 'preguntas/34/puertas.png',
                'pregunta' => 'Si ésta es la última puerta por la que pasó, ¿Cuál es la puerta que le ayudará a salir?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'valor' => 'Puerta Amarilla (A)'],
                        ['id' => 'B', 'valor' => 'Puerta Verde (B)'],
                        ['id' => 'C', 'valor' => 'Puerta Roja (C)'],
                        ['id' => 'D', 'valor' => 'Puerta Azul (D)'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['C']),
                'explicacion' => 'La Puerta Amarilla (A) tiene la misma forma de arco que la última puerta. No sirve. La Puerta Verde (B) es de color verde, igual a la última de Josie. No sirve. La Puerta Azul (D) tiene forma de arco, misma forma de ventana y manija de media luna; tiene 3 cosas iguales. La Puerta Roja (C) es cuadrada, roja, ventana redonda y manija de rectángulo: no tiene nada igual. Es la correcta.',
                'imagen_respuesta' => null,
                'nivel' => 'II',
                'dificultad' => 'Media',
                'pais_origen' => 'Lituania',
                'codigo_tarea' => '2025-LT-06',
            ],

            // Tarea 8 - Castores Educados
            [
                'numero' => '35',
                'titulo' => 'Castores Educados',
                'descripcion' => 'Hay carros entrando a una calle principal. Van entrando uno y uno, de manera intercalada (alternando) de la siguiente forma: El carro viene de la Calle Corazón, luego entra un carro de la Calle Sol, luego un carro de la Calle Corazón, luego uno de la Calle Sol, y así siguen.',
                'imagen_descripcion' => 'preguntas/35/carros.png',
                'pregunta' => '¿Qué carro entra después del carro naranja con estrella que ves en la imagen?',
                'imagen_pregunta' => 'preguntas/35/carros2.png',
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'valor' => 'A'],
                        ['id' => 'B', 'valor' => 'B'],
                        ['id' => 'C', 'valor' => 'C'],
                        ['id' => 'D', 'valor' => 'D'],
                        ['id' => 'E', 'valor' => 'E'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['A']),
                'explicacion' => 'Pasa un auto de la Calle Corazón y luego uno de la Calle Sol, así van por turnos. El carro naranja con estrella viene de la Calle Corazón (derecha). Antes del auto naranja con estrella hay 3 carros en la Calle Corazón, por lo que tuvieron que pasar ya 3 carros también de la Calle Sol. El siguiente (el cuarto) en la fila de la izquierda es el carro A.',
                'imagen_respuesta' => null,
                'nivel' => 'II',
                'dificultad' => 'Alta',
                'pais_origen' => 'Montenegro',
                'codigo_tarea' => '2025-ME-05',
            ],

            // Tarea 9 - La fruta favorita de la Reina
            [
                'numero' => '36',
                'titulo' => 'La fruta favorita de la Reina',
                'descripcion' => 'Cinco personas del pueblo vienen a darle a la Reina canastas con fruta. Las frutas son: manzanas, plátanos y peras. Cada canasta tiene 8 frutas en total. Las manzanas son la fruta favorita de la reina. Ella verá primero al que traiga más manzanas y al final al que traiga menos manzanas. Si dos personas traen el mismo número de manzanas, la Reina verá primero al que tenga más plátanos.',
                'imagen_descripcion' => 'preguntas/36/canastas.png',
                'pregunta' => 'Aquí están las cinco canastas. ¿En qué orden verá la Reina a cada uno? Acomoda las canastas en el orden correcto. Pon la primera canasta a la izquierda y la última a la derecha.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'ordenar',
                'configuracion' => json_encode([
                    'elementos' => [
                        ['id' => 'A', 'nombre' => 'Canasta A'],
                        ['id' => 'B', 'nombre' => 'Canasta B'],
                        ['id' => 'C', 'nombre' => 'Canasta C'],
                        ['id' => 'D', 'nombre' => 'Canasta D'],
                        ['id' => 'E', 'nombre' => 'Canasta E'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['B', 'D', 'A', 'C', 'E']),
                'explicacion' => 'La cesta B tiene 5 manzanas (la que más tiene), va primero. Las cestas A y D tienen 3 manzanas cada una; como empatan, la D tiene 3 plátanos y la A solo 2, así que va primero la D y luego la A. La cesta C tiene 2 manzanas. La cesta E solo tiene 1 manzana, va al último. Orden correcto: B, D, A, C, E.',
                'imagen_respuesta' => null,
                'nivel' => 'II',
                'dificultad' => 'Alta',
                'pais_origen' => 'Australia',
                'codigo_tarea' => '2025-AU-04',
            ],

            // Tarea 10 - Zancos
            [
                'numero' => '37',
                'titulo' => 'Zancos',
                'descripcion' => '¡Caminar con zancos es muy divertido! Un grupo de amigos castores llevan sombrero y caminan con zancos en un desfile. Quieren acomodarse para estar todos a la misma altura, contando sombrero y zancos. Para que todos queden igual de altos, al castor más chaparrito le tocan zancos más altos; al castor más alto le tocan zancos más bajos.',
                'imagen_descripcion' => 'preguntas/37/zancos_regla.png',
                'pregunta' => 'Arrastra los castores a los zancos para que todos queden de la misma altura al final. ¡Haz parejas que sumen 13!',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'completar',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'castor_sombrero_rojo', 'valor' => 'Castor sombrero rojo (12)'],
                        ['id' => 'castor_gorra_verde', 'valor' => 'Castor gorra verde (4)'],
                    ],
                    'zancos' => [1, 2, 3, 4, 5, 6, 7, 8, 9],
                ]),
                'respuesta_correcta' => json_encode(['castor_sombrero_rojo' => 1, 'castor_gorra_verde' => 9]),
                'explicacion' => 'El castor más alto (sombrero rojo, llega al 12) en zancos más bajos (palito en 1): 12 + 1 = 13. El más bajo (gorra verde, llega al 4) en zancos más altos (palito en 9): 4 + 9 = 13. Hay que formar parejas que sumen 13.',
                'imagen_respuesta' => null,
                'nivel' => 'II',
                'dificultad' => 'Media',
                'pais_origen' => 'Montenegro',
                'codigo_tarea' => '2025-ME-02',
            ],

            // Tarea 11 - Evitando las nubes
            [
                'numero' => '38',
                'titulo' => 'Evitando las nubes',
                'descripcion' => 'Un piloto está por entrar a una zona de nubes. Debe volar a través de un espacio que es una cuadrícula de 3x3 cuadros y que tiene 3 capas distintas en las que irá avanzando. El piloto desea evitar las nubes y volar solo por cielo despejado. Cada vez que avanza, el avión puede moverse hacia arriba, abajo, izquierda, derecha o en diagonal, avanzando un paso y una capa a la vez. Las nubes blancas están más cerca, las grises están un poco más lejos y las nubes oscuras están al fondo en la última capa. El avión está por entrar al espacio. Si no gira, va a chocar con la nube blanca que está en medio de la fila de arriba, frente a él.',
                'imagen_descripcion' => 'preguntas/38/nubes_capas.png',
                'pregunta' => 'Dale al piloto las indicaciones correctas para que pueda evitar las nubes en las 3 capas. Coloca las instrucciones en orden.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'ordenar',
                'configuracion' => json_encode([
                    'elementos' => [
                        ['id' => 'diagonal', 'nombre' => 'Moverse en diagonal'],
                        ['id' => 'centro_abajo', 'nombre' => 'Fila de abajo en el centro'],
                        ['id' => 'derecha', 'nombre' => 'Segunda fila, a la derecha'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['diagonal', 'centro_abajo', 'derecha']),
                'explicacion' => 'Paso 1: En la primera capa de nubes blancas, frente al avión hay un solo lugar sin nube, hay que moverse ahí (diagonal). Paso 2: En las nubes grises (Capa 2) el único hueco es la fila de abajo en el centro. Paso 3: En las nubes oscuras hay dos espacios vacíos, pero solo a uno puede llegar el avión: el de la segunda fila a la derecha.',
                'imagen_respuesta' => null,
                'nivel' => 'II',
                'dificultad' => 'Alta',
                'pais_origen' => 'Irlanda',
                'codigo_tarea' => '2025-IE-04',
            ],

            // Tarea 12 - Hojas Frutos y Madera
            [
                'numero' => '39',
                'titulo' => 'Hojas Frutos y Madera',
                'descripcion' => 'A Emil y sus amigos les gusta caminar por el bosque. Durante su caminata, los amigos de Emil recolectan información sobre los árboles que ven y la escriben en tablas. Severin anota información sobre la forma de las hojas y a qué especie de árbol pertenece cada una. Quirina anota información sobre los frutos de cada árbol y si tienen piñas o no. Ladina anota información sobre la especie de árbol, el color de su madera y si es buena madera para construcción o no.',
                'imagen_descripcion' => 'preguntas/39/tablas.png',
                'pregunta' => 'Emil encontró una hoja en el bosque y sabe qué forma tiene. Él quiere saber si la madera de ese árbol es buena para construir. ¿A cuál de sus amigos tiene que preguntar y en qué orden para saber la respuesta correcta?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'valor' => 'A) Primero a Quirina, luego a Severin, al final a Ladina.'],
                        ['id' => 'B', 'valor' => 'B) Sólo a Ladina.'],
                        ['id' => 'C', 'valor' => 'C) Primero a Severin, luego a Ladina.'],
                        ['id' => 'D', 'valor' => 'D) Primero a Severin, luego a Quirina.'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['C']),
                'explicacion' => 'Emil tiene una hoja, así que conoce la forma. Debe buscar quién relaciona forma con madera. La tabla de Ladina requiere la especie del árbol. La tabla de Severin relaciona forma de hoja con especie. Así que primero pregunta a Severin (forma → especie). Una vez con la especie, pregunta a Ladina (especie → calidad de madera). Quirina no es útil porque su tabla requiere el fruto y Emil solo tiene la hoja.',
                'imagen_respuesta' => null,
                'nivel' => 'II',
                'dificultad' => 'Media',
                'pais_origen' => 'Suiza',
                'codigo_tarea' => '2025-CH-04',
            ],

            // Tarea 13 - Construyendo una presa
            [
                'numero' => '40',
                'titulo' => 'Construyendo una presa',
                'descripcion' => 'Los castores necesitan cortar algunos árboles para construir su presa. Para cortar árboles, los castores siguen siempre tres reglas: 1. Eligen un árbol para cortar primero. 2. Luego de cortar un árbol, el siguiente árbol que corten debe estar más a la derecha del que acaban de cortar. 3. El siguiente árbol que corten debe ser más bajito que el anterior. Por ejemplo, en la imagen anterior, si eligen cortar primero el segundo árbol (que mide 6 metros), el único otro árbol que pueden cortar después es el último árbol (que mide 5 metros). En este caso, la cantidad total de madera que tendrían sería de 11m.',
                'imagen_descripcion' => 'preguntas/40/arboles.png',
                'pregunta' => 'Si observas los árboles de la imagen anterior, ¿cuál es la mayor cantidad de madera que los castores pueden cortar siguiendo las reglas?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => '15', 'valor' => '15 metros (árbol 10m y 5m)'],
                        ['id' => '20', 'valor' => '20 metros (árbol 8m, 7m y 5m)'],
                        ['id' => '21', 'valor' => '21 metros (árbol 9m, 7m y 5m)'],
                        ['id' => '11', 'valor' => '11 metros'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['21']),
                'explicacion' => 'Si empiezas con el árbol de 10m, el único a su derecha y menor es el de 5m (suma 15). Si empiezas con el de 8m, puedes seguir con 7m y luego 5m (suma 20). Si empiezas con el árbol de 9m, puedes seguir con el de 7m y luego el de 5m (suma 9 + 7 + 5 = 21). ¡Esta es la cantidad máxima! La respuesta correcta es cortar los árboles de 9 metros, 7 metros y 5 metros.',
                'imagen_respuesta' => null,
                'nivel' => 'III',
                'dificultad' => 'Alta',
                'pais_origen' => 'Chipre',
                'codigo_tarea' => '2025-CY-01',
            ],

            // Tarea 14 - Robot agrícola
            [
                'numero' => '41',
                'titulo' => 'Robot agrícola',
                'descripcion' => 'Un robot agrícola está plantando flores en una línea. El robot debe seguir estas instrucciones: 1. Ve al punto marcado con X. 2. Si donde estás hay un letrero con una flor, haz clic para plantar esa flor en su lugar. 3. Recuerda la flor que acabas de plantar. 4. Muévete a la derecha hasta encontrar un lugar vacío. 5. Coloca una flor igual a la que acabas de plantar a ese lugar. 6. Si la línea está llena, terminaste. Si no, muévete hacia la izquierda hasta llegar a otro letrero. 7. Repite las instrucciones a partir del paso 2.',
                'imagen_descripcion' => 'preguntas/41/robot_linea.png',
                'pregunta' => '¿Cómo quedará la línea cuando el robot haya terminado?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'imagen', 'valor' => 'preguntas/41/resultado_a.png'],
                        ['id' => 'B', 'tipo' => 'imagen', 'valor' => 'preguntas/41/resultado_b.png'],
                        ['id' => 'C', 'tipo' => 'imagen', 'valor' => 'preguntas/41/resultado_c.png'],
                        ['id' => 'D', 'tipo' => 'imagen', 'valor' => 'preguntas/41/resultado_d.png'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['D']),
                'explicacion' => 'El robot inicia en el 5. Hay un letrero de violeta, lo cambia por una flor, lo recuerda y se va a la derecha al primer espacio vacío (6) y coloca una violeta. Regresa a la izquierda al letrero del espacio 4 (tulipán) y repite. La línea final será un espejo a partir de la X de las flores que había en los letreros.',
                'imagen_respuesta' => null,
                'nivel' => 'IV',
                'dificultad' => 'Alta',
                'pais_origen' => 'Eslovaquia',
                'codigo_tarea' => '2025-SK-03',
            ],

            // Tarea 15 - Tobogán cambiante
            [
                'numero' => '42',
                'titulo' => 'Tobogán cambiante',
                'descripcion' => 'El parque acuático tiene un nuevo tobogán. Este tobogán tiene cruces donde se puede ir por distintos caminos. La regla es que cada vez que pasa un castor por el cruce, el camino cambia para el siguiente. Mira los dibujos para ver cómo cambia el camino. El pequeño Dan quiere lanzarse por el nuevo tobogán. Su mamá quiere saber por cuál salida va a salir para tomarle una buena foto. Ya pasaron dos castores antes que Dan: 1. El primer castor salió por la salida B. 2. El segundo castor salió por la salida C.',
                'imagen_descripcion' => 'preguntas/42/tobogan.png',
                'pregunta' => 'Ahora va a lanzarse otro castor y después le toca a Dan. ¿Por qué salida va a salir el pequeño Dan?',
                'imagen_pregunta' => 'preguntas/42/tobogan2.png',
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'valor' => 'Salida A'],
                        ['id' => 'B', 'valor' => 'Salida B'],
                        ['id' => 'C', 'valor' => 'Salida C'],
                        ['id' => 'D', 'valor' => 'Salida D'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['D']),
                'explicacion' => 'Si el primer castor salió por B, eso deja los cruces en cierto estado; el segundo salió por C y vuelve a cambiar el cruce de arriba y el de la derecha. El tercer castor (antes de Dan) bajará por la izquierda y saldrá por la A, dejando los cruces listos para Dan. Dan bajará, el cruce de arriba lo mandará a la derecha y el siguiente cruce también a la derecha. ¡Saldrá por la D!',
                'imagen_respuesta' => null,
                'nivel' => 'II',
                'dificultad' => 'Baja',
                'pais_origen' => 'Taiwan',
                'codigo_tarea' => '2025-TW-02',
            ],

            // Tarea 16 - Razonamiento espacial
            [
                'numero' => '43',
                'titulo' => 'Razonamiento espacial',
                'descripcion' => 'El castor Xavier quiere programar su primer videojuego y está aprendiendo a transformar una imagen. Por ahora, solo puede usar dos operaciones para cambiar la imagen: (E) Espejo - Refleja una imagen horizontalmente. (R) Rotación - Rota una imagen 90° a la derecha. Xavier empieza con una imagen y quiere que al final se vea de cierta manera.',
                'imagen_descripcion' => 'preguntas/43/operaciones.png',
                'pregunta' => '¿Cuál de las siguientes opciones NO da el resultado que Xavier desea? la imagen empieza asi termina asi',
                'imagen_pregunta' => 'preguntas/43/operaciones2.png',
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'valor' => 'A) R R R E'],
                        ['id' => 'B', 'valor' => 'B) E R'],
                        ['id' => 'C', 'valor' => 'C) E R E R E R'],
                        ['id' => 'D', 'valor' => 'D) R E'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['D']),
                'explicacion' => 'En la opción A (R R R E), B (E R) y C (E R E R E R) se llega al resultado deseado. Pero para la opción D (R E): primero giras y luego volteas. Si haces esto mentalmente, el castor queda mirando hacia el lado contrario o en una posición diferente. Como la pregunta pide la que NO funciona, la D es la correcta.',
                'imagen_respuesta' => null,
                'nivel' => 'III',
                'dificultad' => 'Alta',
                'pais_origen' => 'Suiza',
                'codigo_tarea' => '2025-CH-10B',
            ],

            // Tarea 17 - El Mensaje del Castor
            [
                'numero' => '44',
                'titulo' => 'El Mensaje del Castor',
                'descripcion' => 'En la Isla del Castor hay 18 pueblos, como se ve en el mapa. Cada pueblo tiene carteros. Cuando un pueblo manda o recibe un mensaje, sus carteros lo entregan al día siguiente a todos los pueblos vecinos (los que están unidos con líneas). Por ejemplo, si el pueblo A manda un mensaje: Al día siguiente, el mensaje le llegará a los pueblos B, C y Q. Dos días después, llega a D, E y F. Y así sigue, cada día avanzando a más pueblos, hasta que todos lo reciban.',
                'imagen_descripcion' => 'preguntas/44/mapa.png',
                'pregunta' => 'Si un mensaje empieza desde el pueblo J, ¿cuántos días tarda en llegar a todos los pueblos?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => '2', 'valor' => '2 días'],
                        ['id' => '3', 'valor' => '3 días'],
                        ['id' => '4', 'valor' => '4 días'],
                        ['id' => '5', 'valor' => '5 días'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['4']),
                'explicacion' => 'Día 0: el mensaje está en J. Día 1: llega a E, G, H, M. Día 2: avanza a B, C (desde E), D, I (desde G), K, N (desde H), O, L (desde M). Día 3: avanza a A (desde B), F (desde C/E), P (desde K), R (desde L). Día 4: finalmente el mensaje llega al pueblo Q (viniendo desde A o F). Como Q fue el último en recibirlo en el cuarto día, la respuesta es 4.',
                'imagen_respuesta' => 'preguntas/44/mapaRespuesta.png',
                'nivel' => 'IV',
                'dificultad' => 'Alta',
                'pais_origen' => 'Taiwan',
                'codigo_tarea' => '2025-TW-04',
            ],

            // Tarea 18 - Llantas de tobogán
            [
                'numero' => '45',
                'titulo' => 'Llantas de tobogán',
                'descripcion' => 'Después de usarse en un tobogán de agua, las llantas bajan flotando por un río lento y se forman en fila, una detrás de otra. Cuando se saca una llanta de la fila, todas las que están detrás se mueven una posición hacia adelante (→) para llenar ese espacio. Por ejemplo, en las imágenes 2 y 3, primero se saca la llanta F y luego la llanta A. Si contamos cuántas veces se mueve cualquier llanta una posición hacia adelante, en total hay 8 movimientos. Ahora mira este nuevo caso. Las llantas están en esta fila: A, B, C, D, E, F, G, H. Y se van a sacar, en este orden: B, G, E, D y H.',
                'imagen_descripcion' => 'preguntas/45/llantas.png',
                'pregunta' => '¿Cuántas veces en total cualquier llanta avanza una posición hacia adelante?',
                'imagen_pregunta' => 'preguntas/45/llantas2.png',
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => '8', 'valor' => '8'],
                        ['id' => '9', 'valor' => '9'],
                        ['id' => '10', 'valor' => '10'],
                        ['id' => '11', 'valor' => '11'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['11']),
                'explicacion' => 'Sacamos B: detrás hay 6 llantas (C,D,E,F,G,H). Se mueven 6. Nueva fila: A,C,D,E,F,G,H. Sacamos G: detrás solo H. Se mueve 1. Sacamos E: detrás F y H. Se mueven 2. Sacamos D: detrás F y H. Se mueven 2. Sacamos H: es la última. Se mueven 0. Total: 6+1+2+2+0=11 movimientos.',
                'imagen_respuesta' => null,
                'nivel' => 'IV',
                'dificultad' => 'Alta',
                'pais_origen' => 'Canadá',
                'codigo_tarea' => '2025-CA-04',
            ],

            // Tarea 19 - Líneas de decisión
            [
                'numero' => '46',
                'titulo' => 'Líneas de decisión',
                'descripcion' => 'Una técnica muy utilizada para el aprendizaje automático (machine learning) es encontrar una línea de decisión. El objetivo de esta línea es separar dos grupos de puntos de la forma más clara posible. La línea debe colocarse de manera que todos los puntos de un grupo queden de un lado y todos los del otro grupo queden del otro lado. Cuando hay un valor nuevo, como el marcado con (?) y no sabemos a qué grupo pertenece, se puede usar esta línea para adivinar a qué grupo podría pertenecer. El dato se asigna al grupo que está del mismo lado de la línea. Ahora tenemos un conjunto nuevo de puntos y queremos decidir a qué grupo podría pertenecer el que está marcado con (?). Los otros cuatro puntos aún no tienen color, así que no sabemos de qué grupo son.',
                'imagen_descripcion' => 'preguntas/46/lineas_decision.png',
                'pregunta' => 'Pensando en utilizar una línea de decisión, el punto con (?) solo se puede asignar con seguridad a un grupo en una de las opciones de abajo. ¿En cuál opción puedes asegurar que el punto (?) queda asignado correctamente con su grupo al usar una línea de decisión?',
                'imagen_pregunta' => 'preguntas/46/lineas_decision2.png',
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'valor' => 'Opción A'],
                        ['id' => 'B', 'valor' => 'Opción B'],
                        ['id' => 'C', 'valor' => 'Opción C'],
                        ['id' => 'D', 'valor' => 'Opción D'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['C']),
                'explicacion' => 'En las opciones A, B y D el punto (?) está justo en medio del pasillo entre los dos grupos: hay una línea válida a la izquierda del (?) y una a la derecha, por eso no es seguro a qué grupo pertenece. En la Opción C, el punto (?) está claramente fuera del pasillo central, muy pegado al grupo de abajo. No importa cómo dibujes la línea recta para separar los grupos, el punto (?) siempre quedará del mismo lado que ese grupo.',
                'imagen_respuesta' => 'preguntas/46/respuesta.png',
                'nivel' => 'II',
                'dificultad' => 'Baja',
                'pais_origen' => 'Austria',
                'codigo_tarea' => '2025-AT-02',
            ],

            // Tarea 20 - Escritura Hibovu
            [
                'numero' => '47',
                'titulo' => 'Escritura Hibovu',
                'descripcion' => 'En la escritura Hibovu, cada forma tiene un sonido y se leen de acuerdo al orden en el que están colocados, pero además, al poner dos formas juntas, una encima (sobrepuestas) o una arriba de la otra, tiene un significado especial, que agrega otro sonido. Por ejemplo estas formas se leerían así: OH RAH CO, RAH OH CO, OH RAH DU, RAH OH DU.',
                'imagen_descripcion' => 'preguntas/47/hibovu_ejemplos.png',
                'pregunta' => '¿Cómo se escribiría TEH OH CO en escritura Hibovu?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'tipo' => 'imagen', 'valor' => 'preguntas/47/opcion_a.png'],
                        ['id' => 'B', 'tipo' => 'imagen', 'valor' => 'preguntas/47/opcion_b.png'],
                        ['id' => 'C', 'tipo' => 'imagen', 'valor' => 'preguntas/47/opcion_c.png'],
                        ['id' => 'D', 'tipo' => 'imagen', 'valor' => 'preguntas/47/opcion_d.png'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['B']),
                'explicacion' => 'Rectángulo = RAH, Círculo = OH, Triángulo = TEH. Las que están una tapando a la otra terminan con CO; las que están una arriba de la otra en vertical terminan con DU. Para TEH OH CO: primero triángulo (TEH), luego círculo (OH), y deben estar sobrepuestas (CO). La opción B se lee TEH OH CO. La A es OH TEH CO; la C es OH TEH DU; la D es OH TEH CO pero con otro orden visual.',
                'imagen_respuesta' => null,
                'nivel' => 'IV',
                'dificultad' => 'Baja',
                'pais_origen' => 'Irlanda',
                'codigo_tarea' => '2025-IE-02C',
            ],

            // Tarea 21 - Velas de adviento
            [
                'numero' => '48',
                'titulo' => 'Velas de adviento',
                'descripcion' => 'A Chris le encanta la tradición de encender velas los domingos antes de Navidad. Cada domingo se prende una o más velas: 1. El primer domingo, se prende 1 vela. 2. El segundo domingo, se prenden 2 velas. 3. El tercer domingo, se prenden 3 velas. 4. Y así continúa... Pero Chris quiere que todas las velas duren lo mismo (que se gasten igual). Eso significa que cada vela debe prenderse el mismo número de veces. Recuerda que debe prender 1 vela el primer domingo, 2 el segundo, 3 el tercero, etc.',
                'imagen_descripcion' => 'preguntas/48/velas.png',
                'pregunta' => 'Si la tradición durará 5 domingos, ¿crees que Chris puede prender 1, 2, 3, 4 y 5 velas cada domingo para lograr que todas las velas se prendan el mismo número de veces? Ilumina las velas que se encenderían cada día para encontrar una solución para Chris.',
                'imagen_pregunta' => 'preguntas/48/velas2.png',
                'tipo_interaccion' => 'completar',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'valor' => 'Vela A'],
                        ['id' => 'B', 'valor' => 'Vela B'],
                        ['id' => 'C', 'valor' => 'Vela C'],
                        ['id' => 'D', 'valor' => 'Vela D'],
                        ['id' => 'E', 'valor' => 'Vela E'],
                    ],
                    'dias' => ['Domingo 1', 'Domingo 2', 'Domingo 3', 'Domingo 4', 'Domingo 5'],
                ]),
                'respuesta_correcta' => json_encode(['domingo1' => ['A'], 'domingo2' => ['B','C'], 'domingo3' => ['A','D','E'], 'domingo4' => ['B','C','D','E'], 'domingo5' => ['A','B','C','D','E']]),
                'explicacion' => 'Suma total de encendidas: 1+2+3+4+5=15. Con 5 velas, 15/5=3: cada vela debe prenderse exactamente 3 veces. Una estrategia: Domingo 1 prendes A y Domingo 4 prendes B,C,D,E (todas usadas 1 vez). Domingo 2 prendes B y C; Domingo 3 prendes A, D y E (todas usadas otra vez). Domingo 5 prendes todas. No es la única solución.',
                'imagen_respuesta' => 'preguntas/48/respuesta.png',
                'nivel' => 'III',
                'dificultad' => 'Alta',
                'pais_origen' => 'Alemania',
                'codigo_tarea' => '2025-DE-08',
            ],

            // Tarea 22 - Árbol genealógico
            [
                'numero' => '49',
                'titulo' => 'Árbol genealógico',
                'descripcion' => 'Los castores Annika y Daniel están en una reunión familiar. Alguien les pregunta: Exactamente, ¿qué parentesco tienen ustedes dos? Annika toma una hoja y dibuja el árbol genealógico de la familia. En su dibujo, las mujeres usan un listón y los hombres una gorra. A Annika le gusta explicar los parentescos de la siguiente manera: 1. padre(x): Representa al padre de la persona x. 2. madre(x): Representa a la madre de la persona x. Por ejemplo: padre(Annika)=Bernd o madre(Bernd)=Christina. Estos parentescos se pueden anidar (poner uno adentro de otro). Por ejemplo: madre(padre(Annika))=Christina que también se puede leer: Christina es la madre del padre de Annika.',
                'imagen_descripcion' => 'preguntas/49/arbol.png',
                'pregunta' => 'Con el árbol genealógico que dibujó Annika, escribe las palabras padre y madre en las casillas correctas para completar el parentesco que tienen entre Annika y Daniel: padre(madre(Annika)) = ___ ( ___ ( ___ ( Daniel ) ) )',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'completar',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'padre', 'valor' => 'padre'],
                        ['id' => 'madre', 'valor' => 'madre'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['padre', 'madre', 'madre']),
                'explicacion' => 'Lado izquierdo: la madre de Annika es la castora con moño rosa; el padre de ella es Emil. La ecuación busca igualar todo a Emil. Lado derecho: desde Daniel subimos a madre(Daniel), luego madre(madre(Daniel)) (abuela de Daniel), luego padre de esa abuela, que es Emil. Por tanto: padre(madre(madre(Daniel))). La respuesta es padre(madre(madre(Daniel))).',
                'imagen_respuesta' => null,
                'nivel' => 'IV',
                'dificultad' => 'Alta',
                'pais_origen' => 'Alemania',
                'codigo_tarea' => '2025-DE-07',
            ],

            // Tarea 23 - Du-re
            [
                'numero' => '50',
                'titulo' => 'Du-re',
                'descripcion' => 'En el pueblo de Hannah siguen una tradición llamada Du-re. El Du-re es una forma de trabajo en equipo en Corea, en el que los vecinos trabajan juntos en la misma granja. En su pueblo, necesitan elegir 3 días de la semana para hacer el Du-re, siguiendo estas reglas: 1. Al menos 4 personas deben participar cada día de Du-re. 2. Cada persona debe participar en al menos un día de Du-re. 3. Nadie puede trabajar los 3 días de Du-re. En la tabla puedes ver en qué días cada persona está disponible. La O significa que la persona sí puede ese día.',
                'imagen_descripcion' => 'preguntas/50/tabla_dias.png',
                'pregunta' => 'Elige tres días de la semana en los que se puede hacer el Du-re.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'completar',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'Lunes', 'valor' => 'Lunes'],
                        ['id' => 'Martes', 'valor' => 'Martes'],
                        ['id' => 'Miercoles', 'valor' => 'Miércoles'],
                        ['id' => 'Jueves', 'valor' => 'Jueves'],
                        ['id' => 'Viernes', 'valor' => 'Viernes'],
                        ['id' => 'Sabado', 'valor' => 'Sábado'],
                        ['id' => 'Domingo', 'valor' => 'Domingo'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['Lunes', 'Martes', 'Sabado']),
                'explicacion' => 'Jueves, Viernes y Domingo tienen menos de 4 personas; quedan descartados. Solo quedan Lunes, Martes, Miércoles y Sábado (todos con 4 personas). Eunwoo solo puede el Lunes (obligatorio). Chaewon solo puede el Martes (obligatorio). Para el tercer día: si elegimos Miércoles, Boa podría tener que trabajar los tres días y se rompe la regla 3. Por tanto se elige el Sábado. Respuesta: Lunes, Martes y Sábado.',
                'imagen_respuesta' => null,
                'nivel' => 'IV',
                'dificultad' => 'Alta',
                'pais_origen' => 'Corea del Sur',
                'codigo_tarea' => '2025-KR-04',
            ],

            // Tarea 24 - Figuras booleanas
            [
                'numero' => '51',
                'titulo' => 'Figuras booleanas',
                'descripcion' => 'Las computadoras utilizan operaciones booleanas para crear figuras nuevas combinando otras más simples. Hay tres operaciones básicas: Y (AND): deja solo la parte donde las dos figuras se sobreponen/traslapan. O (OR): une las dos figuras en una sola. NO (NOT): recorta una figura con otra (quita la parte que se cruza). Se pueden hacer varias operaciones seguidas para crear figuras complejas.',
                'imagen_descripcion' => 'preguntas/51/figuras_operaciones.png',
                'pregunta' => 'Usa las 4 figuras que se muestran y combínalas con las operaciones que se indican para obtener la figura que se muestra. Coloca las figuras en los espacios vacíos en el orden correcto.',
                'imagen_pregunta' => 'preguntas/51/figuras_operaciones2.png',
                'tipo_interaccion' => 'ordenar',
                'configuracion' => json_encode([
                    'elementos' => [
                        ['id' => 'A', 'nombre' => 'Cuadrado (A)'],
                        ['id' => 'B', 'nombre' => 'Triángulo (B)'],
                        ['id' => 'C', 'nombre' => 'Círculo (C)'],
                        ['id' => 'D', 'nombre' => 'Círculo (D)'],
                    ],
                    'operaciones' => ['NOT', 'AND', 'NOT', 'AND'],
                ]),
                'respuesta_correcta' => json_encode(['A', 'B', 'C', 'D']),
                'explicacion' => 'El orden correcto es: Cuadrado (A) y Triángulo (B) con NOT para formar la base; luego Círculo (C) con NOT para recortar; y al final Círculo (D) con AND que encierra todo. Las líneas rectas indican el cuadrado y triángulo; las curvas indican los círculos. El círculo que quita una parte va después del NOT; el que encierra todo va al final después del AND.',
                'imagen_respuesta' => 'preguntas/51/respuesta.png',
                'nivel' => 'VI',
                'dificultad' => 'Alta',
                'pais_origen' => 'Irlanda',
                'codigo_tarea' => '2025-IE-03',
            ],

            // Tarea 25 - Intercambios de piedra papel o tijeras
            [
                'numero' => '52',
                'titulo' => 'Intercambios de piedra papel o tijeras',
                'descripcion' => 'Anna, Bert y Corry están jugando una versión diferente de piedra, papel y tijeras. Recuerda las reglas del juego: Piedra vence a tijeras. Tijeras vence a papel. Papel vence a piedra. Anna, Bert y Corry se sientan en sus sillas y sostiene cada quien una tarjeta con uno de los tres símbolos, de modo que todos puedan verla. En su variante del juego, los jugadores realizan los siguientes pasos: Primero deciden cuántos intercambios realizarán. En un intercambio, dos jugadores cambian, entre ellos, sus tarjetas. Una vez decidida la cantidad, deciden qué par de jugadores participa en cada intercambio. El único objetivo de Bert es derrotar a Corry.',
                'imagen_descripcion' => 'preguntas/52/jugadores.png',
                'pregunta' => '¿Cuál de las estrategias de abajo le asegura a Bert lograr su objetivo? A. Sin importar la cantidad de intercambios que decidan hacer, Bert siempre debe intercambiar con Corry. B. Sin importar la cantidad de intercambios que decidan hacer, Bert nunca debe intercambiar con Corry. C. Bert simplemente necesita asegurar una cantidad impar de intercambios entre él y Corry. D. Bert sólo requiere asegurar que se hagan un número par de intercambios, no importa entre quienes sucedan.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'valor' => 'A) Bert siempre debe intercambiar con Corry'],
                        ['id' => 'B', 'valor' => 'B) Bert nunca debe intercambiar con Corry'],
                        ['id' => 'C', 'valor' => 'C) Bert necesita asegurar cantidad impar de intercambios con Corry'],
                        ['id' => 'D', 'valor' => 'D) Bert requiere que se hagan un número par de intercambios en total'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['D']),
                'explicacion' => 'Siempre se forma un ciclo en el que alguien gana a otro y pierde con otro. Actualmente Bert (Tijeras) gana a Corry (Papel). Un solo intercambio entre cualquier par invierte completamente la configuración del ciclo. Si se hace un número par de intercambios, se restaura la relación original. Como Bert ya está ganando a Corry, necesita asegurar un número par de intercambios totales para seguir ganando.',
                'imagen_respuesta' => 'preguntas/52/respuesta.png',
                'nivel' => 'V',
                'dificultad' => 'Alta',
                'pais_origen' => 'Brasil',
                'codigo_tarea' => '2025-BR-02',
            ],

            // Tarea 26 - Investigación en las Islas
            [
                'numero' => '53',
                'titulo' => 'Investigación en las Islas',
                'descripcion' => 'Un equipo de investigación necesita visitar todas las islas de un archipiélago. Pueden usar un helicóptero para aterrizar en cualquier isla. También hay barcos que viajan entre las islas, pero solo en las direcciones que muestra el mapa. En cada día hacen un viaje de investigación completo, esto es: Aterrizan con el helicóptero en cualquier isla. Pueden tomar todos los barcos que quieran, siguiendo las flechas. Al final, deben regresar al helicóptero para irse.',
                'imagen_descripcion' => 'preguntas/53/mapa_islas.png',
                'pregunta' => '¿Cuál es el número mínimo de viajes (días) necesarios para visitar todas las islas?',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => '1', 'valor' => '1 viaje'],
                        ['id' => '2', 'valor' => '2 viajes'],
                        ['id' => '3', 'valor' => '3 viajes'],
                        ['id' => '4', 'valor' => '4 viajes'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['3']),
                'explicacion' => 'Deben comenzar y terminar en la misma isla (donde queda el helicóptero). El archipiélago se divide en grupos de accesibilidad mutua: {A, B, C, D}, {E, F} y {G}. Una vez que sales de un grupo no puedes volver. Por ejemplo {G} solo tiene flechas que salen pero ninguna que regresa. No se pueden combinar en un solo viaje. Por tanto se necesitan al menos 3 viajes.',
                'imagen_respuesta' => 'preguntas/53/respuesta.png',
                'nivel' => 'V',
                'dificultad' => 'Alta',
                'pais_origen' => 'Austria',
                'codigo_tarea' => '2025-AT-01',
            ],

            // Tarea 27 - El laberinto de Momo
            [
                'numero' => '54',
                'titulo' => 'El laberinto de Momo',
                'descripcion' => 'A Momo le gusta jugar videojuegos de laberintos. En este juego hay un tablero con obstáculos y Momo debe llevar al robot desde su posición inicial hasta la meta. Para hacerlo, escribe instrucciones usando un lenguaje de programación muy simple. El robot sigue las instrucciones una por una, en el orden en que se le dan. Las instrucciones permitidas son: Avanza hasta llegar a la meta. Avanza hasta chocar con un obstáculo. Gira 90 grados a la izquierda. Gira 90 grados a la derecha. Como resolver los laberintos es muy sencillo para Momo, se ha puesto un nuevo reto. Quiere hacer el programa más corto posible que resuelva los tres laberintos siguientes.',
                'imagen_descripcion' => 'preguntas/54/laberintos.png',
                'pregunta' => 'Arrastra y ordena las instrucciones para hacer un solo programa más corto que pueda resolver los 3 laberintos.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'ordenar',
                'configuracion' => json_encode([
                    'elementos' => [
                        ['id' => 'avanza_obstaculo', 'valor' => 'Avanza hasta obstáculo'],
                        ['id' => 'avanza_obstaculo_de_nuevo', 'valor' => 'Avanza hasta el obstáculo de nuevo'],
                        ['id' => 'gira_90_derecha', 'valor' => 'Gira 90 derecha'],
                        ['id' => 'gira_90_izquierda', 'valor' => 'Gira 90 izquierda'],
                        ['id' => 'avanza_meta', 'valor' => 'Avanza hasta meta'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['avanza_obstaculo', 'gira_90_derecha', 'avanza_obstaculo_de_nuevo', 'gira_90_izquierda', 'avanza_meta']),
                'explicacion' => 'La secuencia correcta es: Avanza hasta obstáculo. Gira 90 derecha. Avanza hasta obstáculo. Gira 90 izquierda. Avanza hasta meta. En el Nivel 1, si elegimos primero avanzar, el robot sube hasta topar con obstáculo, gira a la derecha, avanza hasta obstáculo, gira a la izquierda y avanza hasta la meta. Los niveles 2 y 3 se resuelven con los mismos pasos.',
                'imagen_respuesta' => null,
                'nivel' => 'IV',
                'dificultad' => 'Alta',
                'pais_origen' => 'Hungría',
                'codigo_tarea' => '2025-HU-01A',
            ],

            // Tarea 28 - Blanco negro... ¿o X?
            [
                'numero' => '55',
                'titulo' => 'Blanco negro... ¿o X?',
                'descripcion' => 'Sarah está jugando un juego. Tiene una fila de cuadros que pueden ser Blancos (B) o Negros (N) y quiere representarlos de una forma especial siguiendo estas reglas: 1. Si todos los cuadros de la fila actual son Blancos, escribe B. 2. Si todos los cuadros de la fila actual son Negros, escribe N. 3. Si hay una mezcla de blancos y negros, escribe X, 4. seguido del resultado de aplicar las mismas reglas a la mitad izquierda de la fila 5. y después, el resultado de aplicar las mismas reglas a la mitad derecha de la fila.',
                'imagen_descripcion' => 'preguntas/55/ejemplos.png',
                'pregunta' => '¿Cómo escribiría Sarah la siguiente fila de cuadros?',
                'imagen_pregunta' => 'preguntas/55/fila.png',
                'tipo_interaccion' => 'completar',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'B', 'valor' => 'B'],
                        ['id' => 'N', 'valor' => 'N'],
                        ['id' => 'X', 'valor' => 'X'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['XXXBNBXNXNB']),
                'explicacion' => 'La tira completa no es de un solo color: escribes X y divides en dos mitades. Mitad izquierda: no es de un solo color, escribes X, divides. Cuarto izquierdo: no, escribes X, divides en octavos. Octavo izq: Blanco (B). Octavo der: Negro (N). Cuarto derecho: todo Blanco (B). Mitad derecha: no, escribes X. Cuarto izq: Negro (N). Cuarto der: no, X. Octavo izq: Negro (N). Octavo der: Blanco (B). Resultado: XXXBNBXNXNB.',
                'imagen_respuesta' => null,
                'nivel' => 'VI',
                'dificultad' => 'Alta',
                'pais_origen' => 'Portugal',
                'codigo_tarea' => '2025-PT-01',
            ],

            // Tarea 29 - Cargando Costales
            [
                'numero' => '56',
                'titulo' => 'Cargando Costales',
                'descripcion' => 'Dos castores, Albert y Mario, forman un equipo para transportar harina. Albert lleva 13 kg de harina por viaje y tarda 1 hora en ir y volver entre el molino y la panadería. Mario solo puede llevar 5 kg, pero es más rápido; tarda 30 minutos en hacer el mismo recorrido. Importante: Solo uno puede salir por harina cada vez, porque el otro debe quedarse en la panadería para atender a los clientes. Como todos, Albert y Mario necesitan descansar. Después de hacer 3 viajes seguidos, cada castor debe descansar al menos 30 minutos antes de salir otra vez. Durante ese descanso, pueden seguir atendiendo a clientes en la panadería. Albert y Mario quieren transportar la mayor cantidad de harina posible en 8 horas.',
                'imagen_descripcion' => 'preguntas/56/transporte.png',
                'pregunta' => '¿Cuál de estas afirmaciones es correcta? A. Mario debe hacer un viaje. B. Mario debe hacer el primer viaje. C. Mario debe hacer el último viaje. D. Albert debe hacer el primer viaje. E. Albert no debe hacer el último viaje.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'seleccion_simple',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'valor' => 'A) Mario debe hacer un viaje'],
                        ['id' => 'B', 'valor' => 'B) Mario debe hacer el primer viaje'],
                        ['id' => 'C', 'valor' => 'C) Mario debe hacer el último viaje'],
                        ['id' => 'D', 'valor' => 'D) Albert debe hacer el primer viaje'],
                        ['id' => 'E', 'valor' => 'E) Albert no debe hacer el último viaje'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['D']),
                'explicacion' => 'Albert transporta 13 kg/h; Mario 5 kg/30 min = 10 kg/h. Albert es el recurso más eficiente. El ciclo óptimo: Albert hace 3 viajes (3 h = 39 kg), luego descansa 30 min; en ese descanso Mario hace 1 viaje (5 kg). Ciclo 3.5 h produce 44 kg. En 8 h: dos ciclos (44+44) y en la última hora Albert hace 1 viaje más (13 kg). Total máximo 101 kg. Si Mario empieza primero, el ciclo se desplaza y se pierde tiempo. Albert debe hacer el primer viaje.',
                'imagen_respuesta' => null,
                'nivel' => 'IV',
                'dificultad' => 'Media',
                'pais_origen' => 'Tailandia',
                'codigo_tarea' => '2025-TH-02',
            ],

            // Tarea 30 - Transporte Público
            [
                'numero' => '57',
                'titulo' => 'Transporte Público',
                'descripcion' => 'Marcus quiere ir desde su casa al teatro usando el autobús. En su ciudad, hay 4 líneas de autobuses de un solo sentido. Las paradas están marcadas con círculos con borde negro. Las líneas de autobús tienen colores diferentes. Las paradas de color son los puntos donde empieza cada línea. El primer autobús de todas las líneas sale al mismo tiempo desde su parada de inicio. Después, cada línea manda un autobús cada cierto número de minutos. Por ejemplo: La línea naranja manda un autobús cada 3 minutos (en el minuto 0, 3, 6, 9, etc). Los números entre paradas indican cuántos minutos tarda el autobús en recorrer esa parte del camino. Subir y bajar del autobús no toma tiempo. Cuando dos o más líneas pasan por la misma parada, Marcus puede cambiarse de autobús. Puede hacerlo si llega al mismo tiempo o antes que el siguiente autobús.',
                'imagen_descripcion' => 'preguntas/57/mapa_paradas.png',
                'pregunta' => 'Si Marcus sale en el primer autobús naranja, ¿qué paradas (incluyendo la de inicio y la del teatro) visitará para llegar en el menor tiempo posible? Marca las paradas correctas en el mapa.',
                'imagen_pregunta' => null,
                'tipo_interaccion' => 'completar',
                'configuracion' => json_encode([
                    'opciones' => [
                        ['id' => 'A', 'valor' => 'Parada A'],
                        ['id' => 'C', 'valor' => 'Parada C'],
                        ['id' => 'F', 'valor' => 'Parada F'],
                        ['id' => 'I', 'valor' => 'Parada I'],
                        ['id' => 'B', 'valor' => 'Parada B (teatro)'],
                    ],
                ]),
                'respuesta_correcta' => json_encode(['A', 'C', 'F', 'I', 'B']),
                'explicacion' => 'La ruta más corta pasa por las paradas A, C, F, I y B. Marcus llega al teatro en el minuto 20 saliendo en el minuto 0. Parada A: sale minuto 0. Parada C: llega desde A en minuto 1. Parada F: desde C en minuto 5. En F cambia; autobuses morados llegan en 2, 6, 10... espera 1 min, llega a I en 11 min y a B (teatro) en 20 min. Es la forma más rápida de llegar.',
                'imagen_respuesta' => null,
                'nivel' => 'VI',
                'dificultad' => 'Alta',
                'pais_origen' => 'Lituania',
                'codigo_tarea' => '2025-LT-05B',
            ],

        ];

        foreach ($preguntas as $pregunta) {
            // Asegurar que todas las preguntas estén activas por defecto
            $pregunta['activa'] = true;
            DB::table('preguntas')->insert($pregunta);
        }
    }
}
