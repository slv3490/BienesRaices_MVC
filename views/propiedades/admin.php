<main class="contenedor seccion">
    <h1>Admin de Bienes Raices</h1>

    <?php 
        if($resultado) {
            $mensaje = mostrarAlerta(intval($resultado));
            if($mensaje) { ?>
                <p class="alerta exito"><?php echo $mensaje; ?></p>
            <?php }
        } ?>
    
    <a href="/propiedades/crear" class="boton boton-verde">Nueva Propiedad</a>
    <a href="/vendedores/crear" class="boton boton-amarillo">Nuevo(a) Vendedor(a)</a>

    <h2>Propiedades</h2>

    <div id="tabla">
        <table class="propiedades" >
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($propiedades as $registro) : ?>
                    <tr>
                        <td><?php echo $registro->id; ?></td>
                        <td><?php echo $registro->titulo; ?></td>
                        <td> <img src="../imagenes/<?php echo $registro->imagen?>" class="imagen-tabla"></td>
                        <td>$ <?php echo $registro->precio; ?></td>
                        <td>
                            <form method="POST" action="/propiedades/eliminar">
                                <input type="hidden" name="id" value="<?php echo $registro->id; ?>">
                                <input type="hidden" name="tipo" value="propiedad">
                                <input type="submit" value="Eliminar" class="boton-rojo-block">
                            </form>
                            <a href="/propiedades/actualizar?id=<?php echo $registro->id; ?>" class="boton-amarillo-block">Actualizar</a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <h2>Vendedores</h2>

    <div id="tabla">
        <table class="propiedades" >
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($vendedores as $vendedor) : ?>
                    <tr>
                        <td><?php echo $vendedor->id; ?></td>
                        <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
                        <td><?php echo $vendedor->telefono; ?></td>
                        <td>
                            <form method="POST" action="/vendedores/eliminar">
                                <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                                <input type="hidden" name="tipo" value="vendedor">
                                <input type="submit" value="Eliminar" class="boton-rojo-block">
                            </form>
                            <a href="vendedores/actualizar?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
                    
</main>